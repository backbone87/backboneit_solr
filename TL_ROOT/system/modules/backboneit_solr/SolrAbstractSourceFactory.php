<?php

abstract class SolrAbstractSourceFactory implements SolrSourceFactory {
	
	protected function __construct() {
	}
	
	public function getIterator() {
		return new ArrayIterator($this->getSources());
	}
	
	public function getSources() {
		$arrIndexes = array();
		foreach($this->getSourceNames() as $strName) {
			$arrIndexes[$strName] = $this->getSource($strName);
		}
		return $arrIndexes;
	}
	
	public function hasSource($strName) {
		return in_array($strName, $this->getSourceNames());
	}
	
}
