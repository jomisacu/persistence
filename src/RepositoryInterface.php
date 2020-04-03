<?php
/**
 * User: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/16/20
 * Time: 1:24 p. m.
 */

namespace Jomisacu\Persistence;


use Jomisacu\Persistence\Criteria\Criteria;

interface RepositoryInterface
{
    public function save (ItemInterface $item);
    
    public function remove (ItemInterface $item);
    
    public function search (Criteria $criteria);
}