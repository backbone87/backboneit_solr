<?php

class SolrSearchResult extends SolrJSONResult implements IteratorAggregate {
	
	protected $arrDocuments;
	
	public function __construct($strContent) {
		parent::__construct($strContent);
	}
	
	public function getDocumentTypes();
	
	public function getFields();
	
	public function isEmpty() {
		return $this->count() == 0;
	}
	
	public function count() {
		return $this->arrContent['response']['numFound'];
	}
	
	public function start() {
		return $this->arrContent['response']['start'];
	}
	
}
