<?php

class SolrFileSource extends SolrAbstractSource {
	
	protected $arrRoots;
	
	protected $arrExtension;
	
	protected $strBase;
	
	public function __construct($strName) {
		parent::__construct($strName);
		$this->strBase = Environment::getInstance()->base;
	}
	
	public function getDocumentTypes() {
		return array('SolrFileDocument', 'SolrImageDocument');
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
		
		$this->generateFilesFile();
		
		$objQuery->reset();
		$objQuery->setParam('source', $this->getName());
		$objQuery->setParam('base', $this->strBase);
		$objQuery->setParam('files', Environment::getInstance()->base . $this->getFilesFile());
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
		return $objHandler->getQueryClass()->getName() == 'SolrDIHQuery'
			|| $objHandler->getQueryClass()->isSubclassOf('SolrDIHQuery');
	}
	
	public function getRoots() {
		return $this->arrRoots;
	}
	
	public function setRoots($varRoots) {
		$arrArgs = func_get_args();
		$varRoots = array();
		SolrUtils::unnestStringsAsSet($varRoots, $arrArgs);
		$this->arrRoots = array();
		foreach($varRoots as $strRoot => $dummy) {
			$this->arrRoots[] = trim($strRoot, ' ' . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
		}
	}
	
	public function getExtension() {
		return $this->arrExtension;
	}
	
	public function setExtension($varExtension) {
		$arrArgs = func_get_args();
		$varExtension = array();
		SolrUtils::unnestStringsAsSet($varExtension, $arrArgs);
		$this->arrExtension = $varExtension;
	}
	
	public function getBase() {
		return $this->strBase;
	}
	
	public function setBase($strBase) {
		$this->strBase = trim($strBase, ' /') . '/';
	}
	
	protected function generateFilesFile() {
		$arrRoots = $this->arrRoots ? $this->arrRoots : array('tl_files' . DIRECTORY_SEPARATOR);
		$arrFiles = array();
		
		foreach($arrRoots as $strRoot) {
			$this->collectFiles($arrFiles, $strRoot);
		}
		
		$objFile = new File($this->getFilesFile());
		$objFile->write(implode("\n", array_keys($arrFiles)));
		$objFile->close();
		unset($objFile);
	}
	
	protected function collectFiles(&$arrFiles, $strDir) {
		$strPath = TL_ROOT . DIRECTORY_SEPARATOR . $strDir;
		foreach(scan($strPath) as $strFile) {
			if(is_file($strPath . $strFile)) {
				$this->addFile($arrFiles, $strDir . $strFile);
			} elseif(is_dir($strPath . $strFile)) {
				$this->collectFiles($arrFiles, $strDir . $strFile . DIRECTORY_SEPARATOR);
			}
		}
	}
	
	protected function addFile(&$arrFiles, $strFile) {
		$arrInfo = pathinfo(TL_ROOT . DIRECTORY_SEPARATOR . $strFile);
		if($this->arrExtension && !isset($this->arrExtension[$arrInfo['extension']])) {
			return;
		}
		if(DIRECTORY_SEPARATOR != '/') {
			$strFile = str_replace(DIRECTORY_SEPARATOR, '/', $strFile);
		}
		$arrFiles['SolrFileDocument,' . $strFile] = true;
	}
	
	protected function getFilesFile() {
		return 'system/html/bbit_solr/' . str_replace('/', '_', $this->getName()) . '.txt';
	}
	
}
