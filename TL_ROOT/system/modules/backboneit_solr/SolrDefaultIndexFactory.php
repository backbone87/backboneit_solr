<?php

class SolrDefaultIndexFactory extends SolrAbstractIndexFactory {
	
	public function getIndexNames() {
		return array(SolrDefaultIndex::NAME);
	}
	
	public function getIndex($strName) {
		if($strName == SolrDefaultIndex::NAME) {
			return SolrDefaultIndex::getInstance();
		}
		throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
	}
	
	public function hasIndex($strName) {
		return $strName == SolrDefaultIndex::NAME;
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
