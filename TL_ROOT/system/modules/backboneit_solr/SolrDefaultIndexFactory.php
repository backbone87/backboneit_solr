<?php

class SolrDefaultIndexFactory extends SolrAbstractIndexFactory {
	
	const DEFAULT_INDEX_NAME = 'default';
	
	public function getIndexNames() {
		return array(self::DEFAULT_INDEX_NAME);
	}
	
	public function getIndex($strName) {
		if($strName == self::DEFAULT_INDEX_NAME) {
			return SolrDefaultIndex::getInstance();
		}
		throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
	}
	
	public function hasIndex($strName) {
		return $strName == self::DEFAULT_INDEX_NAME;
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
