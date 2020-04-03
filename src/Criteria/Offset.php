<?php
/**
 * @author: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/20/20
 * Time: 10:33 a. m.
 */

namespace Jomisacu\Persistence\Criteria;

final class Offset
{
    protected $offset;
    protected $limit;
    
    public function __construct ($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit  = $limit;
    }
    
    public static function createByPage ($page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        
        return new self($offset, $pageSize);
    }
    
    /**
     * @return mixed
     */
    public function getOffset ()
    {
        return $this->offset;
    }
    
    /**
     * @return mixed
     */
    public function getLimit ()
    {
        return $this->limit;
    }
}