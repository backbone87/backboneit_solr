<?php

final class SolrSearchSourceManager extends SolrAbstractSearchSourceFactory {
	
	public static function findSource($strName) {
		return self::getInstance()->getSource($strName);
	}
	
	protected $arrFactories = array();
	
	public function add(SolrSearchSourceFactory $objFactory) {
		$this->arrFactories[spl_object_hash($objFactory)] = $objFactory;
	}
	
	public function remove(SolrSearchSourceFactory $objFactory) {
		unset($this->arrFactories[spl_object_hash($objFactory)]);
	}
	
	public function getSourceNames() {
		$arrNames = array();
	
		foreach($this->arrFactories as $objFactory) {
			$arrNames[] = $objFactory->getSourceNames();
		}
	
		return $arrNames ? call_user_func_array('array_merge', $arrNames) : array();;
	}
	
	public function getSources() {
		$arrSources = array();
	
		foreach($this->arrFactories as $objFactory) {
			$arrSources[] = $objFactory->getSources();
		}
	
		return $arrSources ? call_user_func_array('array_merge', $arrSources) : array();
	}
	
	public function getSource($strName) {
		foreach($this->arrFactories as $objFactory) if($objFactory->hasSource($strName)) {
			return $objFactory->getSource($strName);
		}
		return null;
	}
	
	public function hasSource($strName) {
		foreach($this->arrFactories as $objFactory) if($objFactory->hasSource($strName)) {
			return true;
		}
		return false;
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
