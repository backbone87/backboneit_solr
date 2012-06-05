<?php

interface SolrQuery {
	
	public function getRequestHandler();
	
	public function getParam($strName);
	
	public function setParam($strName, $strValue);
	
	public function getParams();
	
	public function setParams(array $arrParams);
	
	public function addParams(array $arrParams);
	
	public function getContent();
	
	public function getContentMIME();
	
	public function setContent($strContent, $strMIME = 'application/octet-stream');
	
	public function execute();
	
	public function getResult();
	
}
