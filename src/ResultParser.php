<?php

/**
 * @author Jorge Sanchez <jomisacu.software@gmail.com>
 */

namespace Jomisacu\Persistence;


final class ResultParser
{
    protected const ROOT_DEPENDENCY = "68387b39-45cf-4a49-9db6-ddca80b61648";
    protected $dependencies = [];
    
    public function __construct ($mainClass, array $properties)
    {
        $this->addDependency(self::ROOT_DEPENDENCY, $mainClass, $properties);
    }
    
    public function addDependency ($propertyPath, $class, array $properties)
    {
        $this->dependencies[ $propertyPath ] = [
            'class' => $class,
            'properties' => $properties,
            'property_path' => $propertyPath,
        ];
    }
    
    public function parse (array $result)
    {
        $rootDependency = $this->dependencies[ self::ROOT_DEPENDENCY ];
        
        $item = new $rootDependency['class']($this->only($rootDependency['properties'], $result));
        
        $relations = array_slice($this->dependencies, 1, count($this->dependencies), true);
        
        // sort by property path
        ksort($relations, SORT_NATURAL);
        
        foreach ($relations as $propertyPath => $relation) {
            $propertyPathExploded = explode(".", $propertyPath);
            $relationName         = array_pop($propertyPathExploded);
            $relationOwnerPath    = implode("->", $propertyPathExploded);
            
            if ($relationOwnerPath) {
                $toEval = sprintf('$item->%s->setRelation("%s", new %s($this->only($relation["properties"], $result)));', $relationOwnerPath, $relationName, $relation['class']);
            } else {
                $toEval = sprintf('$item->setRelation("%s", new %s($this->only($relation["properties"], $result)));', $relationName, $relation['class']);
            }
            
            eval($toEval);
        }
        
        return $item;
    }
    
    private function only ($only, $from)
    {
        $result = [];
        
        foreach ($only as $property) {
            if (array_key_exists($property, $from)) {
                $result[ $property ] = $from[ $property ];
            }
        }
        
        return $result;
    }
}