<?php

class SolrContaoPageSource extends SolrAbstractSource {
	
	protected $arrRoots;
	
	protected $blnExtract;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index(SolrRequestHandler $objHandler) {
		if(!$this->isCompatibleRequestHandler($objHandler)) {
			return;
		}
		
		$objQuery = $objHandler->createQuery();
		$objQuery->setParam('command', 'full-import');
		$objQuery->setParam('clean', 'false');
		$objQuery->setParam('source', $this->getName());
		$objQuery->setContent($this->compileContent(), 'text/plain');
		return $objQuery->execute();
	}
	
	public function unindex(SolrRequestHandler $objHandler) {
		// TODO implement unindexing
	}
	
	public function isCompatibleRequestHandler($objHandler) {
		return $objHandler->getQueryClass() == 'SolrDIHQuery';
	}
	
	public function getRoots() {
		return $this->arrRoots;
	}
	
	public function setRoots($varRoots) {
		$this->arrRoots = array_filter((array) $varRoots, 'is_int');
	}
	
	public function isExtractImages() {
		return $this->blnExtract;
	}
	
	public function setExtractImages($blnExtract) {
		$this->blnExtract = $blnExtract;
	}
	
	protected function compileContent() {
		$arrRoots = $this->arrRoots ? $this->arrRoots : array(0);
		$arrPages = SolrUtils::getInstance()->getChildRecords($arrRoots, 'tl_page');
		return implode(',', $arrPages);
	}
	
}
