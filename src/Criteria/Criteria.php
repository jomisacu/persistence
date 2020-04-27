<?php
/**
 * @author: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/20/20
 * Time: 10:22 a. m.
 */

namespace Jomisacu\Persistence\Criteria;

final class Criteria
{
    protected $filters = [];
    protected $orderBy;
    protected $offset;
    protected $options = [];
    
    public function __construct ()
    {
    }
    
    public function addFilter (Filter $filter)
    {
        $this->filters[] = $filter;
    }
    
    public function getFilers ()
    {
        return $this->filters;
    }
    
    public function getOrderBy ()
    {
        return $this->orderBy;
    }
    
    public function setOrderBy (OrderBy $orderBy)
    {
        $this->orderBy = $orderBy;
    }
    
    public function getOffset ()
    {
        return $this->offset;
    }
    
    public function setOffset (Offset $offset)
    {
        $this->offset = $offset;
    }
    
    /**
     * @param string $option
     *
     * @return Criteria
     */
    public function setOption ($option)
    {
        $this->options[$option] = $option;
        
        return $this;
    }
    
    public function hasOption ($option)
    {
        return array_key_exists($option, $this->options);
    }
}