<?php

interface SolrIndex {
	
	public function getName();
	
	public function getDisplayName();
	
	public function getEndpoint();
	
	public function getRequestHandler($strName);
	
	public function getRequestHandlers();
	
	public function getRequestHandlersByType($varType);
	
	public function getRequestHandlersByQueryClass($varQueryClass);
	
	public function getSources();
	
	public function update($blnScheduled = true);
	
}
