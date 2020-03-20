<?php
/**
 * @author: Jorge Sanchez <jomisacu.software@gmail.com>
 * Date: 3/20/20
 * Time: 10:23 a. m.
 */

namespace Jomisacu\Persistence\Criteria;

class Filter {
	
	const OPERATOR_EQUAL = '=';
	const OPERATOR_GREATER_THAN = '>';
	const OPERATOR_GREATER_THAN_OR_EQUAL = '>=';
	const OPERATOR_LESS_THAN = '<';
	const OPERATOR_LESS_THAN_OR_EQUAL = '<=';
	const OPERATOR_LIKE = 'LIKE';
	const OPERATOR_IN = 'IN';
	
	public $operator;
	public $expression;
	public $value;
	
	public function __construct ($expression, $operator, $value) {
		
		$this->operator   = $operator;
		$this->expression = $expression;
		$this->value      = $value;
	}
}