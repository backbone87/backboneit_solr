<?php

class SolrJSONResult extends SolrResult {
	
	protected $arrContent;
	
	public function __construct($strContent) {
		$this->arrContent = json_decode($strContent, true);
	}
	
	public function getContent() {
		return $this->arrContent;
	}
	
	public function getWriterType() {
		return SolrQuery::WT_JSON;
	}
	
	public function isValid() {
		return (boolean) $this->arrContent;
	}
	
	public function wasSuccess() {
		return $this->isValid();
	}
	
	public function dump() {
		echo '<pre>';
		var_dump($this->arrContent);
		echo '</pre>';
	}
	
}
