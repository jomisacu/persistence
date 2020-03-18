<?php
/**
 * User: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/16/20
 * Time: 12:31 p. m.
 */

namespace Jomisacu\Persistence;

class ItemAbstract implements ItemInterface {
	
	private $_modified;
	private $_data;
	private $_relations;
	private $_loadCallbacks;
	
	public function __construct (array $data = []) {
		
		$this->_data = $data;
	}
	
	public function __get ($name) {
		
		$value = null;
		
		if (array_key_exists($name, $this->_data)) {
			
			$value = $this->_data[$name];
		} // retrieve a relation?
		elseif (isset($this->_relations[$name])) {
			
			if ($this->_loadCallbacks[$name]['loaded'] == false) {
				
				if (is_callable($this->_loadCallbacks[$name]['callback'])) {
					
					call_user_func($this->_loadCallbacks[$name]['callback']);
				}
				
				$this->_loadCallbacks[$name]['loaded'] = true;
			}
			
			return $this->_relations[$name];
		}
		
		return $value;
	}
	
	public function __set ($name, $value) {
		
		$this->_data[$name]     = $value;
		$this->_modified[$name] = $name;
		
		return $this;
	}
	
	/**
	 * The callback will be called to load relations.
	 *
	 * @param string       $name
	 * @param LoadCallback $callback
	 * @param array        $default
	 *
	 * @return $this
	 */
	public function setRelation ($name, $default = [], LoadCallback &$callback = null) {
		
		$this->_loadCallbacks[$name] = [
			'name'     => $name,
			'callback' => $callback,
			'loaded'   => !isset($callback),
		];
		
		$this->_relations[$name] = $default;
		
		return $this;
	}
	
	public function getModifications () {
		
		return $this->_modified;
	}
}