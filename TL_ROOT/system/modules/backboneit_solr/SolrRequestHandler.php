<?php

interface SolrRequestHandler {
	
	public function getName();
	
	public function getType();
	
	public function getIndex();
	
	public function getEndpoint();
	
	public function getQueryClass();
	
	public function createQuery();
	
}
