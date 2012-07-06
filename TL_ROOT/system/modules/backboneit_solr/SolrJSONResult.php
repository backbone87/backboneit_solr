<?php

class SolrJSONResult implements SolrResult {
	
	protected $arrContent;
	
	protected $objQuery;
	
	public function __construct(SolrQuery $objQuery, $strContent) {
		$this->objQuery = $objQuery;
		$this->arrContent = json_decode($strContent, true);
		
		if(is_null($this->arrContent)) {
			throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
		}
	}
	
	public function getQuery() {
		return $this->objQuery;
	}
	
	public function getContent() {
		return $this->arrContent;
	}
	
	public function getWriterType() {
		return SolrQuery::WT_JSON;
	}
	
	public function isSuccess() {
		return true;
	}
	
	public function dump() {
		echo '<pre>';
		var_dump($this->arrContent);
		echo '</pre>';
	}
	
}
