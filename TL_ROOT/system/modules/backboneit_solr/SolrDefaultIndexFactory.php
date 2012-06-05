<?php

class SolrDefaultIndexFactory extends SolrAbstractIndexFactory {
	
	public function getIndexNames() {
		return array('default');
	}
	
	public function getIndex($strName) {
		if($strName == 'default') {
			return SolrDefaultIndex::getInstance();
		}
	}
	
	protected function __construct() {
		parent::__construct();
	}
	
	protected function __clone() {
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance)) {
			self::$objInstance = new self();
		}
		return self::$objInstance;
	}
	
}
