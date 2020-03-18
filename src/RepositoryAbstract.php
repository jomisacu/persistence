<?php
/**
 * User: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/16/20
 * Time: 2:34 p. m.
 */

namespace Jomisacu\Persistence;


abstract class RepositoryAbstract implements RepositoryInterface {
	
	public function save (ItemInterface $item) {
		// TODO: Implement save() method.
	}
	
	public function remove (ItemInterface $item) {
		// TODO: Implement remove() method.
	}
	
	public function search (array $wheres = [], $limit = null, $offset = 0, $orderByProperty = null, $orderByType = null) {
		// TODO: Implement search() method.
	}
}