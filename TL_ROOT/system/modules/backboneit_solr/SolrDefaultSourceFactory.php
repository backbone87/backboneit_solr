<?php

final class SolrDefaultSourceFactory extends SolrAbstractSourceFactory {
	
	
	protected $arrSources = array();
	
	protected function __construct() {
		parent::__construct();
	}
	
	protected function __clone() {
	}
		
	public function getSourceNames() {
		return array_keys($GLOBALS['SOLR_DEFAULT_SEARCH_SOURCES']);
	}
	
	public function getSource($strName) {
		if(isset($this->arrSources[$strName])) {
			return $this->arrSources[$strName];
		}
		
		$arrSource = $GLOBALS['SOLR_DEFAULT_SEARCH_SOURCES'][$strName];
		if(is_array($arrSource)) {
			try {
				$objClass = new ReflectionClass($arrSource['class']);
				
				if($objClass->isSubclassOf('SolrSource')) {
					$objSource = $objClass->newInstance($strName);
					$this->configSource($objClass, $objSource, $arrSource['config']);
					$this->arrSources[$strName] = $objSource;
					return $objSource;
				}
				
			} catch (LogicException $e) {
	// 			throw $e; // TODO correct exception handling
			} catch (ReflectionException $e) {
	// 			throw $e; // TODO correct exception handling
			}
		}
		
		throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
	}
	
	public function cleanCache() {
		$this->arrSources = array();
	}
	
	protected function configSource(ReflectionClass $objClass, SolrSource $objSource, array $arrConfig) {
		foreach($arrConfig as $arrCall) {
			$objMethod = $objClass->getMethod($arrCall[0]);
			if($objMethod->isPublic()) {
				$arrCall[0] = $objSource;
				call_user_func_array(array($objMethod, 'invoke'), $arrCall);
			}
		}
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance)) {
			self::$objInstance = new self();
		}
		return self::$objInstance;
	}
		
}
