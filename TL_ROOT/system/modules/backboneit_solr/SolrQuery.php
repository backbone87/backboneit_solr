<?php

interface SolrQuery {
	
	/**
	 * The writer type parameter name.
	 * @var string
	 */
	const PARAM_WT	= 'wt';
	
	/**
	 * The writer type parameter value to select the JSON response writer.
	 * @var string
	 */
	const WT_JSON	= 'json';
	
	public function getRequestHandler();
	
	public function getParam($strName);
	
	public function setParam($strName, $strValue);
	
	public function unsetParam($strName);
	
	public function getParams();
	
	public function setParams(array $arrParams);
	
	public function addParams(array $arrParams);
	
	public function getContent();
	
	public function getContentMIME();
	
	public function setContent($strContent, $strMIME = 'application/octet-stream');
	
	public function execute();
	
	public function getResult();
	
	public function reset();
	
}
