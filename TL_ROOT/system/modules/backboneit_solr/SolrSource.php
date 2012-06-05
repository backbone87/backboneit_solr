<?php

interface SolrSource {
	
	public static function create($strName);
	
	public function getName();
	
	public function getDisplayName();
	
	public function getDocumentTypes();
	
	public function getFields();
	
	public function index(SolrRequestHandler $objHandler);

	public function unindex(SolrRequestHandler $objHandler);
	
	public function isCompatibleRequestHandler(SolrRequestHandler $objHandler);
	
}
