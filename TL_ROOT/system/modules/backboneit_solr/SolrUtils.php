<?php

final class SolrUtils extends Backend {
	
	public static function unnestStringsAsSet(&$arrCollection, $arrArgs) {
		foreach($arrCollection as $varString) {
			if(is_string($varString)) {
				$arrTypes[$varString] = true;
			} elseif(is_array($varString)) {
				self::collectStringArgs($arrCollection, $varString);
			}
		}
	}
	
	public function getIndexesAsOptions() {
		$arrOptions = array();
		foreach(SolrIndexManager::getInstance() as $strName => $objIndex) {
			$arrOptions[$strName] = $objIndex->getDisplayName();
		}
		return $arrOptions;
	}
	
	public function getSearchSourcesAsOptions() {
		$arrOptions = array();
		foreach(SolrSearchSourceManager::getInstance() as $strName => $objSource) {
			$arrOptions[$strName] = $objSource->getDisplayName();
		}
		return $arrOptions;
	}
	
	public function executeCallbacks($varCallbacks) {
		if(is_string($varCallbacks)) {
			$varCallbacks = $GLOBALS['BBIT_SOLR_HOOKS'][$varCallbacks];
		}
		if(!is_array($varCallbacks)) {
			return array();
		}
	
		$arrArgs = array_slice(func_get_args(), 1);
		$arrResults = array();
		foreach($varCallbacks as $arrCallback) {
			if(is_array($arrCallback)) {
				$this->import($arrCallback[0]);
				$arrCallback[0] = $this->{$arrCallback[0]};
				$arrResults[] = call_user_func_array($arrCallback, $arrArgs);
			}
		}
		return $arrResults;
	}
	
	public function getSearchablePages() {
		$arrPages = $this->findSearchablePages();
		
		// HOOK: take additional pages
		if (isset($GLOBALS['TL_HOOKS']['getSearchablePages']) && is_array($GLOBALS['TL_HOOKS']['getSearchablePages']))
		{
			foreach ($GLOBALS['TL_HOOKS']['getSearchablePages'] as $callback)
			{
				$this->import($callback[0]);
				$arrPages = $this->$callback[0]->$callback[1]($arrPages);
			}
		}
		
		return $arrPages;
	}
	
	public function getChildRecords($arrParentIds, $strTable, $blnSorting = false, $arrReturn = array()) {
		return parent::getChildRecords($arrParentIds, $strTable, $blnSorting, $arrReturn);
	}
	
	public function loadLanguageFile($strName) {
		return parent::loadLanguageFile($strName);
	}
	
	private function __construct() {
		parent::__construct();
	}
	
	private function __clone() {
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!self::$objInstance) {
			self::$objInstance = new self();
		}
		return self::$objInstance;
	}
	
}
