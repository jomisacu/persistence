<?php
/**
 * User: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/16/20
 * Time: 3:07 p. m.
 */

namespace Jomisacu\Persistence;


use ArrayAccess;
use Countable;
use Iterator;

class Collection implements Iterator, Countable, ArrayAccess
{
    protected $_index = 0;
    protected $_keys  = [];
    protected $_items = [];
    
    public function add ($item, $key = null)
    {
        if ($key) {
            $this->_items[ $key ] = $item;
        } else {
            $this->_items[] = $item;
        }
        
        $this->_keys = array_keys($this->_items);
    }
    
    public function get ($key)
    {
        if (isset($this->_items[ $key ])) {
            return $this->_items[ $key ];
        }
        
        return null;
    }
    
    public function first ()
    {
        foreach ($this as $item) {
            return $item;
        }
        
        return null;
    }
    
    public function last ()
    {
        if (count($this)) {
            $copy = $this->_items;
            
            return array_pop($copy);
        }
        
        return null;
    }
    
    public function shift ()
    {
        $first       = array_shift($this->_items);
        $this->_keys = array_keys($this->_items);
        
        return $first;
    }
    
    public function pop ()
    {
        $last        = array_pop($this->_items);
        $this->_keys = array_keys($this->_items);
        
        return $last;
    }
    
    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current ()
    {
        return isset($this->_keys[ $this->_index ]) ? $this->_items[ $this->_keys[ $this->_index ] ] : null;
    }
    
    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next ()
    {
        $this->_index++;
    }
    
    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key ()
    {
        return $this->_keys[ $this->_index ];
    }
    
    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then
     *                 evaluated. Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid ()
    {
        return isset($this->_keys[ $this->_index ]);
    }
    
    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind ()
    {
        $this->_index = 0;
    }
    
    /**
     * Count elements of an object
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count ()
    {
        return count($this->_items);
    }
    
    /**
     * Whether a offset exists
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists ($offset)
    {
        return array_key_exists($offset, $this->_items);
    }
    
    
    /**
     * Offset to retrieve
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet ($offset)
    {
        return $this->_items[ $offset ];
    }
    
    /**
     * Offset to set
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet ($offset, $value)
    {
        $this->add($value, $offset);
    }
    
    /**
     * Offset to unset
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset ($offset)
    {
        unset($this->_items[ $offset ]);
        $this->_keys = array_keys($this->_items);
    }
}
