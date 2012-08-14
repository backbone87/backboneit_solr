<?php

class SolrDBIndexFactory extends SolrAbstractIndexFactory {
	
	const NAME_PREFIX = 'tl_bbit_solr_index_';
	
	private $arrIndexNames;
	
	public function fetchIndexNames() {
		$objIndex = Database::getInstance()->query(
			'SELECT id FROM tl_bbit_solr_index'
		);
		
		$this->arrIndexNames = array();
		while($objIndex->next()) {
			$this->arrIndexNames[self::NAME_PREFIX . $objIndex->id] = $objIndex->id;
		}
	}
	
	public function getIndexNames() {
		if(!isset($this->arrIndexNames)) {
			$this->fetchIndexNames();
		}
		return array_keys($arrIndex);
	}
	
	public function getIndex($strName) {
		if(!$this->hasIndex($strName)) {
			throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
		}
		$this->arrIndex[$strName] = new SolrDBIndex($this->arrIndexNames[$strName]);
	}
	
	public function hasIndex($strName) {
		return isset($this->arrIndexNames[$strName]);
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
