<?php

class SolrGenericRequestHandler implements SolrRequestHandler {
	
	protected $strName;
	
	protected $strType;
	
	protected $objIndex;
	
	protected $objQueryClass;
	
	public function __construct($strName, $strType, SolrIndex $objIndex, $strQueryClass) {
		$objQueryClass = new ReflectionClass($strQueryClass);
		if(!$objQueryClass->isSubclassOf('SolrQuery')) {
			throw new InvalidArgumentException(sprintf('Query class [%s] is not of type SolrQuery', $strQueryClass));
		}
		
		$this->strName = '/' . trim($strName, ' /');
		$this->strType = $strType;
		$this->objIndex = $objIndex;
		$this->objQueryClass = $objQueryClass;
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
	
	public function hasQueryClass($strClass) {
		return $this->objQueryClass->getName() == $strClass || $this->objQueryClass->isSubclassOf($strClass);
	}
	
	public function createQuery($strClass = null) {
		if(strlen($strClass) && !$this->hasQueryClass($strClass)) {
			throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
		}
		return $this->objQueryClass->newInstance($this);
	}
	
}
