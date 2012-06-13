<?php

interface SolrRequestHandler {
	
	public function getName();
	
	public function getType();
	
	public function getIndex();
	
	public function getEndpoint();
	
	public function hasQueryClass($strClass);
	
	public function createQuery($strClass = null);
	
}
