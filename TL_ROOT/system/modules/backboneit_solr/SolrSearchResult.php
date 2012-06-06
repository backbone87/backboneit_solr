<?php

interface SolrSearchResult extends SolrResult, IteratorAggregate {
	
	public function getDocumentTypes();
	
	public function getFields();
	
}
