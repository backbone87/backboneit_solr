<?php

interface SolrIndexFactory extends IteratorAggregate {
	
	public function getIndexNames();
	
	public function getIndexes();
	
	public function getIndex($strName);
	
	public function hasIndex($strName);
	
}
