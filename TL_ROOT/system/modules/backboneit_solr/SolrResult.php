<?php

interface SolrResult {
	
	public function getQuery();
	
	public function getContent();
	
	public function getWriterType();
	
	public function isSuccess();
	
}
