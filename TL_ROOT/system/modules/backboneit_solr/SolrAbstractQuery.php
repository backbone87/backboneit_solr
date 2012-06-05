<?php

abstract class SolrAbstractQuery implements SolrQuery {
	
	protected $objHandler;
	
	protected $arrParams = array();
	
	protected $objRequest;
	
	protected $strContent;
	
	protected $strContentMIME = 'application/octet-stream';
	
	protected function __construct(SolrRequestHandler $objHandler) {
		$this->objHandler = $objHandler;
	}
	
	public function getRequestHandler() {
		return $this->objHandler;
	}
	
	public function execute() {
		$objRequest = new RequestExtended();
		if(strlen($this->strContent)) {
			$objRequest->data = $this->strContent;
			$objRequest->datamime = $this->strContentMIME;
			$objRequest->method = 'POST';
		} else {
			$objRequest->method = 'GET';
		}
		
		$this->prepareRequest($objRequest);
		
		if($objRequest->send($this->getRequestURL())) {
			return false;
		}
		
		$objResult = $this->createResult($objRequest);
		
		return $objResult->isSucceed();
	}
	
	public function setParam($strName, $strValue) {
		$this->arrParams[$strName] = $strValue;
	}

	public function setParams(array $arrParams) {
		$this->arrParams = $arrParams;
	}

	public function addParams(array $arrParams) {
		$this->arrParams = array_merge($this->arrParams, $arrParams);
	}

	public function getParam($strName) {
		return $this->arrParams[$strName];
	}

	public function getParams() {
		return $this->arrParams;
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
