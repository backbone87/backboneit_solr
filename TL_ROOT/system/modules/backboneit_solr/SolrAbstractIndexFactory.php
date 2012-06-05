<?php

abstract class SolrAbstractIndexFactory implements SolrIndexFactory {
	
	protected function __construct() {
	}
	
	public function getIterator() {
		return new ArrayIterator($this->getIndexes());
	}
	
	public function getIndexes() {
		$arrIndexes = array();
		foreach($this->getIndexNames() as $strName) {
			$arrIndexes[$strName] = $this->getIndex($strName);
		}
		return $arrIndexes;
	}
	
	public function hasIndex($strName) {
		return in_array($strName, $this->getIndexNames());
	}
	
}
