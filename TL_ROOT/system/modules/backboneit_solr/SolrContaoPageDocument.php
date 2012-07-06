<?php

class SolrContaoPageDocument extends SolrDocument {
	
	protected $strTemplate = 'bbit_solr_doc_page';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getURL($blnRelative = true) {
		$strURL = parent::getURL($blnRelative);
		$objQuery = $this->getQuery();
		if($objQuery) {
			$strCon = strpos($strURL, '?') === false ? '?' : '&';
			$strURL .= $strCon . 'h=' . urlencode(implode(',', $objQuery->getKeywords()));
		}
		return $strURL;
	}
	
}
