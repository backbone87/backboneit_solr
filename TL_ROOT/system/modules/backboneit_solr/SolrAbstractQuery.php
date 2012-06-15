<?php

abstract class SolrAbstractQuery implements SolrQuery {
	
	private $objHandler;
	
	private $arrParams;
	
	private $strContent;
	
	private $strContentMIME;
	
	protected function __construct(SolrRequestHandler $objHandler, array $arrParams = null) {
		$this->objHandler = $objHandler;
		$this->arrParams = array();
		$this->reset();
		$this->arrParams = array_merge($this->arrParams, (array) $arrParams);
	}
	
	public function getRequestHandler() {
		return $this->objHandler;
	}
	
	public function getWriterType() {
		return $this->getParam(SolrQuery::PARAM_WT);
	}
	
	public function setWriterType($strType = SolrQuery::WT_JSON) {
		$this->setParam(SolrQuery::PARAM_WT, $strType);
	}

	public function getParam($strName) {
		return $this->arrParams[$strName];
	}
	
	public function setParam($strName, $strValue) {
		$this->arrParams[$strName] = $strValue;
	}
	
	public function deleteParam($strName) {
		unset($this->arrParams[$strName]);
	}

	public function getParams() {
		return $this->arrParams;
	}

	public function setParams(array $arrParams) {
		$this->arrParams = $arrParams;
	}

	public function addParams(array $arrParams) {
		$this->arrParams = array_merge($this->arrParams, $arrParams);
	}
	
	public function hasContent() {
		return strlen($this->strContent) != 0;
	}
	
	public function getContent() {
		return $this->strContent;
	}
	
	public function getContentMIME() {
		return $this->strContentMIME;
	}
	
	public function setContent($strContent, $strMIME = 'application/octet-stream') {
		$this->strContent = $strContent;
		$this->strContentMIME = $strMIME;
	}
	
	public function deleteContent() {
		unset($this->strContent, $this->strContentMIME);
	}
	
	public function execute() {
		$objRequest = new RequestExtended();
		if($this->hasContent()) {
			$objRequest->data = $this->getContent();
			$objRequest->datamime = $this->getContentMIME();
			$objRequest->method = 'POST';
		} else {
			$objRequest->method = 'GET';
		}
		
		$this->prepareRequest($objRequest);
		try {
			$objRequest->send($this->getRequestURL());
		} catch(Exception $e) {
			throw new SolrException(__CLASS__ . '::' . __METHOD__ . ' - ' . $e->getMessage()); // TODO
		}
		
		$objResult = $this->createResult($objRequest);
// 		$objResult->dump();
		return $objResult;
	}
	
	public function reset() {
		unset($this->objResult, $this->strContent, $this->strContentMIME);
		$this->arrParams = array();
		$this->setWriterType();
	}
	
	public function getRequestURL() {
		return $this->getRequestHandler()->getEndpoint() . '?' . $this->getQueryString();
	}
	
	public function getQueryString() {
		return http_build_query($this->getParams());
	}
	
	protected function prepareRequest(RequestExtended $objRequest) {
	}
	
	abstract protected function createResult(RequestExtended $objRequest);
	
}
