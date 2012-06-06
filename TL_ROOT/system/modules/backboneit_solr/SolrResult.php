<?php

interface SolrResult {
	
	public function getContent();
	
	public function getWriterType();
	
	public function isValid();
	
	public function wasSuccess();
	
}
