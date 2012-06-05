<?php

abstract class SolrAbstractIndex implements SolrIndex {
	
	protected $strName;
	
	protected function __construct($strName) {
		$this->strName = $strName;
	}
	
	abstract public function getSourceNames();
	
	abstract protected function runUpdateFor(SolrSource $objSource);
	
	public function getName() {
		return $this->strName;
	}
	
	public function getDisplayName() {
		$strName = $this->getName();
		SolrUtils::getInstance()->loadLanguageFile('bbit_solr');
		$strDisplayName = $GLOBALS['TL_LANG']['bbit_solr']['index'][$strName];
		return $strDisplayName ? $strDisplayName : $strName;
	}
	
	public function getRequestHandler($strName) {
		$arrHandlers = $this->getRequestHandlers();
		$strName = '/' . trim($strName, ' /');
		return $arrHandlers[$strName];
	}
	
	public function getRequestHandlersByQueryClass($varQueryClass) {
		if(is_object($varQueryClass) && $varQueryClass instanceof ReflectionClass) {
			$varQueryClass = $varQueryClass->getName();
		}
		
		$arrHandlers = array();
		if(is_string($varQueryClass)) foreach($this->getRequestHandlers() as $objHandler) {
			if($objHandler->getQueryClass()->getName() == $varQueryClass) {
				$arrHandlers[$objHandler->getName()] = $objHandler;
			}
		}
		return $arrHandlers;
	}
	
	public function getRequestHandlersByType($varType) {
		$arrArgs = func_get_args();
		$arrTypes = array();
		SolrUtils::unnestStringsAsSet($arrTypes, $arrArgs);
		
		$arrHandlers = array();
		foreach($this->getRequestHandlers() as $objHandler) {
			if(isset($arrTypes[$objHandler->getType()])) {
				$arrHandlers[$objHandler->getName()] = $objHandler;
			}
		}
		return $arrHandlers;
	}
	
	public function getSources() {
		$objMgr = SolrSourceManager::getInstance();
		$arrSources = array();
		foreach($this->getSourceNames() as $strName) {
			$objSource = $objMgr->getSource($strName);
			$objSource !== null && $arrSources[$objSource->getName()] = $objSource;
		}
		return $arrSources;
	}
	
	public final function update($blnScheduled = true) {
		foreach($this->getSources() as $objSource) {
			if(!$blnScheduled || $this->isUpdateScheduledFor($objSource)) {
				SolrUtils::getInstance()->executeCallbacks('beforeUpdate', $this, $objSource);
				
				var_dump($this->getName(), 'runUpdateFor', $objSource->getName());
				exit;
				$this->runUpdateFor($objSource);
				SolrUtils::getInstance()->executeCallbacks('afterUpdate', $this, $objSource);
			}
		}
	}
	
	protected function isUpdateScheduledFor(SolrSource $objSource) {
		return true;
	}
	
}
