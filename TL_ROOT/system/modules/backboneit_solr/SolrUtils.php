<?php

final class SolrUtils extends Backend {
	
	public static function unnestStringsAsSet(&$arrCollection, $arrArgs) {
		foreach($arrArgs as $varString) {
			if(is_string($varString)) {
				$arrCollection[$varString] = true;
			} elseif(is_array($varString)) {
				self::unnestStringsAsSet($arrCollection, $varString);
			}
		}
	}
	
	public function getIndexOptions() {
		$arrOptions = array();
		foreach(SolrIndexManager::getInstance() as $strName => $objIndex) {
			$arrOptions[$strName] = $objIndex->getDisplayName();
		}
		return $arrOptions;
	}
	
	public function getSearchHandlerOptions($objDC) {
		try {
			$objIndex = SolrIndexManager::findIndex($objDC->activeRecord->bbit_solr_index);
			return array_keys($objIndex->getRequestHandlersByQueryClass('SolrSearchQuery'));
			
		} catch(SolrException $e) {
			self::logException($e);
			return array();
		}
	}
	
	public function getSourceOptions() {
		$arrOptions = array();
		foreach(SolrSourceManager::getInstance() as $strName => $objSource) {
			$arrOptions[$strName] = $objSource->getDisplayName();
		}
		return $arrOptions;
	}
	
	public function getSourceOptionsByIndex($objDCA) {
		$arrSources = array();
		try {
			$objIndex = SolrIndexManager::findIndex($objDCA->activeRecord->bbit_solr_index);
			foreach($objIndex->getSources() as $objSource) {
				$arrSources[$objSource->getName()] = $objSource->getDisplayName();
			}
			
		} catch(SolrException $e) {
			self::logException($e);
		}
		return $arrSources;
	}
	
	public function getDocumentTypeOptionsByIndex($objDCA) {
		$arrTypes = array();
		try {
			$objIndex = SolrIndexManager::findIndex($objDCA->activeRecord->bbit_solr_index);
			foreach($objIndex->getSources() as $objSource) {
				foreach($objSource->getDocumentTypes() as $strDocType) {
					$strLabel = $GLOBALS['TL_LANG']['bbit_solr']['docTypes'][$strDocType];
					$arrTypes[$strDocType] = $strLabel ? $strLabel : $strDocType;
				}
			}
			
		} catch(SolrException $e) {
			self::logException($e);
		}
		return $arrTypes;
	}
	
	public function getTplOptions($objDC) {
		$strClass = $GLOBALS['FE_MOD']['application'][$objDC->activeRecord->type];
		
		if(!$strClass) {
			return array();
		}
		
		try {
			$objClass = new ReflectionClass($strClass);
		} catch (LogicException $e) {
			return array();
		}
		
		$strDefault = $objClass->getConstant('DEFAULT_TEMPLATE');
		 
		if(!$strDefault) {
			return array();
		}
		
		return $this->getTemplateGroupExcludeDefault($strDefault);
	}
	
	public function getDocTplOptions() {
		return $this->getTemplateGroupExcludeDefault('bbit_solr_doc');
	}
	
	protected function getTemplateGroupExcludeDefault($strDefault) {
		$intPID = $this->Input->get('act') == 'overrideAll' ? $this->Input->get('id') : $objDC->activeRecord->pid;
		$arrTpls = $this->getTemplateGroup($strDefault, $intPID);
		
		$intDefault = array_search($strDefault, $arrTpls);
		if($intDefault !== false) {
			unset($arrTpls[$intDefault]);
			$arrTpls = array_values($arrTpls);
		}
		
		return $arrTpls;
	}
	
	public function getResultModuleOptions($objDCA) {
		$objResult = $this->Database->prepare(
			'SELECT id, name FROM tl_module WHERE id != ? AND (type = ? OR type = ?)'
		)->execute($objDCA->activeRecord->id, 'bbit_solr_result');
		
		$arrModules = array('bbit_solr_nocopy' => &$GLOBALS['TL_LANG']['bbit_solr']['nocopy']);
		while($objResult->next()) {
			$arrModules[$objResult->id] = $objResult->name . ' (ID ' . $objResult->id . ')';
		}
		
		return $arrModules;
	}
	
	public function loadDocTpls($varValue, $objDCA) {
		$arrRows = array();
		
		foreach($this->getDocumentTypeOptionsByIndex($objDCA) as $strDocType => $strLabel) {
			$arrRows[$strDocType] = array('docType' => $strDocType, 'label' => $strLabel);
		}
		
		foreach(deserialize($varValue, true) as $strDocType => $strTpl) if(isset($arrRows[$strDocType])) {
			$arrRows[$strDocType]['tpl'] = $strTpl;
		}
		
		return array_values($arrRows);
	}
	
	public function saveDocTpls($varValue) {
		$arrRows = array();
		
		foreach(deserialize($varValue, true) as $arrRow) {
			$arrRows[$arrRow['docType']] = $arrRow['tpl'];
		}
		
		return $arrRows;
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
	
	public function logException(Exception $e) {
		// TODO
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
	
	public function loadLanguageFile($strName, $strLanguage = false, $blnNoCache = false) {
		return parent::loadLanguageFile($strName);
	}
	
	protected function __construct() {
		parent::__construct();
	}
	
	protected function __clone() {
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!self::$objInstance) {
			self::$objInstance = new self();
		}
		return self::$objInstance;
	}
	
}
