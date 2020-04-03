<?php
/**
 * User: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/16/20
 * Time: 12:47 p. m.
 */

namespace Jomisacu\Persistence;


final class LoadCallback
{
    private $called   = false;
    private $callable = null;
    
    public function __construct (Callable $callable)
    {
        $this->callable = $callable;
    }
    
    public function __invoke ()
    {
        if ($this->called == false) {
            call_user_func($this->callable);
            
            $this->called = true;
        }
    }
}