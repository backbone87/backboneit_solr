<?php

interface SolrSourceFactory extends IteratorAggregate {
	
	public function getSourceNames();
	
	public function getSources();
	
	public function getSource($strName);
	
	public function hasSource($strName);
	
}
