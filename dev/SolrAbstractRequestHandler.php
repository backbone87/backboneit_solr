<?php

abstract class SolrAbstractRequestHandler implements SolrRequestHandler {
	
	protected $strName;
	
	protected $strType;
	
	protected $objIndex;
	
	protected function __construct($strName, $strType, SolrIndex $objIndex) {
		$this->strName = '/' . trim($strName, ' /');
		$this->strType = $strType;
		$this->objIndex = $objIndex;
	}
	
	public function getName() {
		return $this->strName;
	}
	
	public function getType() {
		return $this->strType;
	}
	
	public function getIndex() {
		return $this->objIndex;
	}
	
	public function getEndpoint() {
		return $this->getIndex()->getEndpoint() . $this->getName();
	}
	
}
