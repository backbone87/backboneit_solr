<?php

abstract class SolrAbstractSearchSource implements SolrSearchSource {
	
	private $strName;
	
	protected function __construct($strName) {
		$this->strName = $strName;
	}
	
	public function getName() {
		return $this->strName;
	}
	
	public function getDisplayName() {
		$strName = $this->getName();
		SolrUtils::getInstance()->loadLanguageFile('bbit_solr');
		$strDisplayName = $GLOBALS['TL_LANG']['SOLR_SOURCES'][$strName];
		return $strDisplayName ? $strDisplayName : $strName;
	}
	
}
