<?php
/**
 * @author: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/20/20
 * Time: 10:30 a. m.
 */

namespace Jomisacu\Persistence\Criteria;

class OrderBy
{
    const ASC  = 'ASC';
    const DESC = 'DESC';
    protected $field;
    protected $orientation;
    
    public function __construct ($field, $orientation = OrderBy::ASC)
    {
        $this->field       = $field;
        $this->orientation = $orientation;
    }
    
    public function getField ()
    {
        return $this->field;
    }
    
    public function getOrientation ()
    {
        return $this->orientation;
    }
}