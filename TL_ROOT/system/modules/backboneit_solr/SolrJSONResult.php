<?php

class SolrJSONResult implements SolrResult {
	
	protected $arrContent;
	
	public function __construct($strContent) {
		$this->arrContent = json_decode($strContent, true);
		
		if(is_null($this->arrContent)) {
			throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
		}
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
