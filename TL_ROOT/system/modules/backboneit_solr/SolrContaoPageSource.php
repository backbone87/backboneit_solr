<?php

class SolrContaoPageSource extends SolrAbstractSource {
	
	protected $arrRoots;
	
	protected $blnExtract;
	
	public function __construct($strName) {
		parent::__construct($strName);
	}
	
	public function getDocumentTypes() {
		return array('SolrContaoPageDocument', 'SolrImageDocument');
	}
	
	public function getFields() {
		return array();
	}
	
	public function index(SolrRequestHandler $objHandler) {
		if(!$this->isCompatibleRequestHandler($objHandler)) {
			return false;
		}
		
		$objQuery = $objHandler->createQuery();
		$objQuery->setCommand(SolrDIHQuery::COM_ABORT);
		if(!$objQuery->execute()) {
			return false;
		}
		
		$this->generatePagesFile();
		
		$objQuery->reset();
		$objQuery->setParam('source', $this->getName());
		$objQuery->setParam('pages', Environment::getInstance()->base . $this->getPagesFile());
		return $objQuery->execute();
	}
	
	public function unindex(SolrRequestHandler $objHandler) {
		if(!$this->isCompatibleRequestHandler($objHandler)) {
			return false;
		}
		
		$objQuery = $objHandler->createQuery();
		$objQuery->setCommand(SolrDIHQuery::COM_ABORT);
		if(!$objQuery->execute()) {
			return false;
		}
		
		$objQuery->reset();
		$objQuery->setParam('source', $this->getName());
		$objQuery->setParam('unindex', 1);
		return $objQuery->execute();
	}
	
	public function isCompatibleRequestHandler(SolrRequestHandler $objHandler) {
		return $objHandler->hasQueryClass('SolrDIHQuery');
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
	
	protected function generatePagesFile() {
		$arrRoots = $this->arrRoots ? $this->arrRoots : array(0);
		$arrPages = SolrUtils::getInstance()->getChildRecords($arrRoots, 'tl_page');
		
		$objFile = new File($this->getPagesFile());
		$objFile->write(implode(',', $arrPages));
		$objFile->close();
		unset($objFile);
	}
	
	protected function getPagesFile() {
		return 'system/html/bbit_solr/' . str_replace('/', '_', $this->getName()) . '.txt';
	}
	
}
