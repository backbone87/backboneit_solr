<?php

class SolrSearchResult extends SolrJSONResult implements Iterator, Countable {
	
	protected $arrDocuments;
	
	protected $arrDocTpls;
	
	protected $intPointer = 0;
	
	public function __construct($strContent) {
		parent::__construct($strContent);
	}
	
	public function getDocumentTypes() {
		$arrTypes = array();
		foreach($this->arrContent['response']['docs'] as $arrDoc) {
			$arrTypes[$arrDoc['m_doctype_s']] = true;
		}
		return array_keys($arrTypes);
	}
	
	public function getFields() {
		return array();
	}
	
	public function isEmpty() {
		return $this->count() == 0;
	}
	
	public function getOffset() {
		return $this->arrContent['response']['start'];
	}
	
	public function setDocumentTemplates(array $arrDocTpls) {
		$this->arrDocTpls = $arrDocTpls;
	}
	
	public function getDocumentTemplate(ReflectionClass $objClass) {
		return $this->arrDocTpls[$objClass->getName()];
	}
	
	public function getDocument($intOffset) {
		if(isset($this->arrDocuments[$intOffset])) {
			return $this->arrDocuments[$intOffset];
		}
		
		$objClass = $this->getDocumentClass($intOffset);
		$objDoc = $objClass->newInstance();
		$objDoc->setData($this->arrContent['response']['docs'][$intOffset]);
		$objDoc->setTemplate($this->getDocumentTemplate($objClass));
		
		$this->arrDocuments[$intOffset] = $objDoc;
		return $objDoc;
	}
	
	protected function getDocumentClass($intOffset) {
		$strClass = $this->arrContent['response']['docs'][$intOffset]['m_doctype_s'];
		if(!strlen($strClass)) {
			$strClass = 'SolrDocument';
		}
		try {
			return new ReflectionClass($strClass);
			
		} catch (LogicException $e) {
			return new ReflectionClass('SolrDocument');
// 			throw $e; // TODO correct exception handling

		} catch (ReflectionException $e) {
			return new ReflectionClass('SolrDocument');
// 			throw $e; // TODO correct exception handling
		}
	}
	
	public function getNumFound() {
		return intval($this->arrContent['response']['numFound']);
	}
	
	public function count() {
		return count($this->arrContent['response']['docs']);
	}
	
	public function next() {
		$this->intPointer++;
	}
	
	public function current() {
		return $this->getDocument($this->intPointer);
	}
	
	public function key() {
		return $this->intPointer + $this->getOffset();
	}
	
	public function rewind() {
		$this->intPointer = 0;
	}
	
	public function valid() {
		return $this->intPointer < $this->count();
	}
	
}
