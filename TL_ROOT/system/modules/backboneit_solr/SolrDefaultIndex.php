<?php

final class SolrDefaultIndex extends SolrAbstractIndex {
	
	protected $strEndpoint;
	
	protected $arrHandler;
	
	protected $arrSources;
	
	protected function __construct() {
		parent::__construct('default');
		$this->initialize();
	}
	
	protected function __clone() {
	}
	
	public function getEndpoint() {
		return $this->strEndpoint;
	}
	
	public function getRequestHandlers() {
		return $this->arrHandlers;
	}
	
	public function getSourceNames() {
		return array_keys($this->arrSources);
	}
	
	protected function runUpdateFor(SolrSource $objSource) {
		$objSource->index($this, $this->getRequestHandler($this->arrSources[$objSource->getName()]['handler']));
	}
	
	public function initialize() {
		$arrConfig = $GLOBALS['SOLR_DEFAULT_INDEX'];
		
		$this->arrHandlers = array();
		foreach($arrConfig['handlers'] as $arrHandler) {
			$objHandler = new SolrGenericRequestHandler($arrHandler['name'], $arrHandler['type'], $this, $arrHandler['query']);
			$this->arrHandlers[$objHandler->getName()] = $objHandler;
		}
		
		$this->strEndpoint = rtrim($arrConfig['url'], ' /');
		if(isset($arrConfig['core'])) {
			$strCore = trim($arrConfig['core'], ' /');
			strlen($strCore) && $this->strEndpoint .= '/' . $strCore;
		}
		
		$this->arrSources = array();
		foreach($arrConfig['sources'] as $arrSource) {
			$this->arrSources[$arrSource['name']] = $arrSource;
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
