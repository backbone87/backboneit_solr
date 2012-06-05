<?php

final class SolrIndexManager extends SolrAbstractIndexFactory {
	
	public static function findIndex($strName) {
		return self::getInstance()->getIndex($strName);
	}
	
	protected $arrFactories = array();
	
	protected $arrIndexes = array();
	
	public function add($varIndex) {
		if(is_callable($varIndex)) {
			$varIndex = call_user_func($varIndex);
			
		} elseif(is_string($varIndex)) {
			try {
				$objClass = new ReflectionClass($varIndex);
				if($objClass->isSubclassOf('SolrIndexFactory')) {
					if($objClass->hasMethod('getInstance')) {
						$varIndex = $objClass->getMethod('getInstance')->invoke(null);
					} else {
						$varIndex = $objClass->newInstance();
					}
					
				} elseif($objClass->isSubclassOf('SolrIndex')) {
					if($objClass->hasMethod('getInstance')) {
						$varIndex = $objClass->getMethod('getInstance')->invoke(null);
					} else {
						$varIndex = $objClass->newInstance();
					}
				}
			} catch (LogicException $e) {
				throw $e; // TODO correct exception handling
			} catch (ReflectionException $e) {
				throw $e; // TODO correct exception handling
			}
		}
		
		if(is_object($varIndex)) {
			if($varIndex instanceof SolrIndexFactory) {
				$this->arrFactories[spl_object_hash($objFactory)] = $objFactory;
				return true;
			} elseif($varIndex instanceof SolrIndex) {
				$this->arrIndexes[spl_object_hash($objIndex)] = $objIndex;
				return true;
			}
		}
		
		return false;
	}
	
	public function remove($varIndex) {
		if(is_object($varIndex)) {
			$strHash = spl_object_hash($varIndex);
			unset($this->arrFactories[$strHash], $this->arrIndexes[$strHash]);
		}
	}
	
	public function runUpdates($blnScheduled = true) {
		SolrUtils::getInstance()->executeCallbacks('beforeRunUpdates', $this, $blnScheduled);
		
		foreach($this as $objIndex) {
			$objIndex->update($blnScheduled);
		}
		
		SolrUtils::getInstance()->executeCallbacks('afterRunUpdates', $this, $blnScheduled);
	}
	
	public function getIndexNames() {
		$arrNames = array(array_keys($this->arrIndexes));
		
		foreach($this->arrFactories as $objFactory) {
			$arrNames[] = $objFactory->getIndexNames();
		}
		
		return $arrNames ? call_user_func_array('array_merge', $arrNames) : array();
	}
	
	public function getIndexes() {
		$arrIndexes = array($this->arrIndexes);
		
		foreach($this->arrFactories as $objFactory) {
			$arrIndexes[] = $objFactory->getIndexes();
		}
		
		return $arrIndexes ? call_user_func_array('array_merge', $arrIndexes) : $arrIndexes;
	}
	
	public function getIndex($strName) {
		if(isset($this->arrIndexes[$strName])) {
			return $this->arrIndexes[$strName];
		}
		
		foreach($this->arrFactories as $objFactory) if($objFactory->hasIndex($strName)) {
			return $objFactory->getIndex($strName);
		}
		
		return null;
	}
	
	public function hasIndex($strName) {
		if(isset($this->arrIndexes[$strName])) {
			return true;
		}
		
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
