<?php

class SolrGenericRequestHandler implements SolrRequestHandler {
	
	protected $strName;
	
	protected $strType;
	
	protected $objIndex;
	
	protected $objQueryClass;
	
	protected function __construct($strName, $strType, SolrIndex $objIndex, $strQueryClass) {
		$objQueryClass = new ReflectionClass($strQueryClass);
		if(!$objQueryClass->isSubclassOf('SolrQuery')) {
			throw new Exception(sprintf('Query class [%s] is not of type SolrQuery', $strQueryClass));
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
	
	public function getQueryClass() {
		return $this->objQueryClass;
	}
	
	public function createQuery() {
		return $this->objQueryClass->newInstance($this);
	}
	
}
