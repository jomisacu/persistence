<?php
/**
 * @author: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/16/20
 * Time: 3:52 p. m.
 */

class RowParser
{
    protected $sql               = "";
    protected $loaded            = false;
    protected $prefixes          = [];
    protected $prefixesByColumns = [];
    protected $mainItemPrefix    = "";
    
    public function __construct ($sql)
    {
        $this->sql = $sql;
    }
    
    public function addPrefix ($prefix, $itemClass, $propertyPath = null)
    {
        if ( ! $prefix || ! is_string($prefix)) {
            throw new Exception("The prefix must be a not empty string");
        }
        
        if ( ! $itemClass || ! is_string($itemClass)) {
            throw new Exception("The item class must be a not empty string");
        }
        
        $this->prefixes[ $prefix ] = [
            'prefix' => $prefix,
            'item_class' => $itemClass,
            'property_path' => $propertyPath,
        ];
        
        if ( ! $propertyPath) {
            $this->mainItemPrefix = $prefix;
        }
        
        $this->sortPrefixesByPropertyPath();
    }
    
    /**
     * To ensure that at the time to populate an object in the target property
     * path, we need to process the precedents path before. So, the prefixes
     * are sorted by property path length from the minor to the major.
     */
    protected function sortPrefixesByPropertyPath ()
    {
        uasort($this->prefixes, function ($p1, $p2) {
            if (strlen($p1['property_path']) < strlen($p2['property_path'])) {
                return -1;
            }
            
            if (strlen($p1['property_path']) > strlen($p2['property_path'])) {
                return 1;
            }
            
            return 0;
        });
    }
    
    public function parseRow (array $row)
    {
        if ( ! $this->loaded) {
            $this->load($this->sql);
        }
        
        $mainItem = $this->extractItem($this->mainItemPrefix, $row);
        
        // relations
        foreach ($this->prefixes as $prefix) {
            if ($prefix['property_path']) {
                $properties = explode(".", $prefix['property_path']);
                
                if (count($properties) === 1) {
                    $extractedItem = $this->extractItem($prefix['prefix'], $row);
                    $mainItem->setRelation($prefix['property_path'], $extractedItem);
                } else {
                    $propertyPath  = array_pop($properties);
                    $extractedItem = $this->extractItem($prefix['prefix'], $row);
                    
                    $toEval = sprintf('$mainItem->%s->setRelation($propertyPath, $extractedItem);', implode("->", $properties));
                    eval($toEval);
                }
            }
        }
        
        return $mainItem;
    }
    
    protected function load ($query)
    {
        if ( ! $this->prefixesByColumns) {
            $query   = strtolower($query);
            $selects = strstr($query, 'from', true);
            
            $expressions = explode(",", $selects);
            $expressions = array_map('trim', $expressions);
            
            foreach ($expressions as $expresion) {
                $matches = [];
                if (preg_match('/([a-z0-9_]+)\.([a-z0-9_]+)(?: as ([a-z0-9_]+))?/', $expresion, $matches)) {
                    $prefix = $matches[1];
                    $column = $matches[2];
                    
                    if (isset($matches[3])) {
                        $column = $matches[3];
                    }
                    
                    $this->prefixes[ $prefix ]['columns'][ $column ] = $column;
                    $this->prefixesByColumns[ $column ]              = $prefix;
                }
            }
        }
    }
    
    protected function extractItem ($prefix, $row)
    {
        if ( ! $prefix) {
            throw new Exception("The prefix '{$prefix}' is not registered");
        }
        
        if (
            ! isset($this->prefixes[ $prefix ]['columns'])
            || ! $this->prefixes[ $prefix ]['columns']
            || ! is_array($this->prefixes[ $prefix ]['columns'])
        ) {
            throw new Exception("There are no columns for the prefix '{$prefix}'. Is possible that you forget to register this prefix?");
        }
        
        if (
            ! isset($this->prefixes[ $prefix ]['item_class'])
            || ! $this->prefixes[ $prefix ]['item_class']
        ) {
            throw new Exception("Missing class for the main object in the row");
        }
        
        $itemData = [];
        
        foreach ($this->prefixes[ $prefix ]['columns'] as $column) {
            if (array_key_exists($column, $row)) {
                $itemData[ $column ] = $row[ $column ];
            }
        }
        
        $class = $this->prefixes[ $prefix ]['item_class'];
        
        return new $class($itemData);
    }
}