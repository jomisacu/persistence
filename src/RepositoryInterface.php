<?php
/**
 * User: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/16/20
 * Time: 1:24 p. m.
 */

namespace Jomisacu\Persistence;


interface RepositoryInterface {
	
	public function save (ItemInterface $item);
	
	public function remove (ItemInterface $item);
	
	public function search (array $wheres = [], $limit = null, $offset = 0, $orderByProperty = null, $orderByType = null);
}