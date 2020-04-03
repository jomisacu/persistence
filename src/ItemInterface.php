<?php
/**
 * User: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/16/20
 * Time: 2:11 p. m.
 */

namespace Jomisacu\Persistence;


interface ItemInterface
{
    public function getModifications ();
    
    public function setRelation ($name, $default, LoadCallback &$callback);
}