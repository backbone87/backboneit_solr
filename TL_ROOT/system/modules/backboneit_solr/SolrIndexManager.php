<?php

final class SolrIndexManager extends SolrAbstractIndexFactory {
	
	public static function findIndex($strName, $blnException = true) {
		try {
			return self::getInstance()->getIndex($strName);
		} catch(SolrException $e) {
			if($blnException) {
				throw $e;
			}
			return null;
		}
	}
	
	protected $arrFactories = array();
	
	public function add(SolrIndexFactory $objFactory) {
		$this->arrFactories[spl_object_hash($objFactory)] = $objFactory;
	}
	
	public function remove(SolrIndexFactory $objFactory) {
		unset($this->arrFactories[spl_object_hash($objFactory)]);
	}
	
	public function runUpdates($blnScheduled = true) {
		SolrUtils::getInstance()->executeCallbacks('beforeRunUpdates', $this, $blnScheduled);
		
		foreach($this as $objIndex) {
			$objIndex->update($blnScheduled);
		}
		
		SolrUtils::getInstance()->executeCallbacks('afterRunUpdates', $this, $blnScheduled);
	}
	
	public function getIndexNames() {
		$arrNames = array();
		foreach($this->arrFactories as $objFactory) {
			$arrNames[] = $objFactory->getIndexNames();
		}
		return $arrNames ? call_user_func_array('array_merge', $arrNames) : $arrNames;
	}
	
	public function getIndexes() {
		$arrIndexes = array();
		foreach($this->arrFactories as $objFactory) {
			$arrIndexes[] = $objFactory->getIndexes();
		}
		return $arrIndexes ? call_user_func_array('array_merge', $arrIndexes) : $arrIndexes;
	}
	
	public function getIndex($strName) {
		foreach($this->arrFactories as $objFactory) if($objFactory->hasIndex($strName)) {
			return $objFactory->getIndex($strName);
		}
		throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
	}
	
	public function hasIndex($strName) {
		foreach($this->arrFactories as $objFactory) if($objFactory->hasIndex($strName)) {
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
