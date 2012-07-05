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
		$arrIndexes = array();
		foreach(SolrIndexManager::getInstance() as $strName => $objIndex) {
			$arrIndexes[$strName] = $objIndex->getDisplayName();
		}
		asort($arrIndexes);
		return $arrIndexes;
	}
	
	public function getSearchHandlerOptions($objDC) {
		try {
			$objIndex = SolrIndexManager::findIndex($objDC->activeRecord->bbit_solr_index);
			$arrHandlers = array_keys($objIndex->getRequestHandlersByQueryClass('SolrSearchQuery'));
			sort($arrHandlers);
			return $arrHandlers;
			
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
		asort($arrSources);
		return $arrOptions;
	}
	
	public function getSourceOptionsByIndex($objDC) {
		$arrSources = array();
		try {
			$objIndex = SolrIndexManager::findIndex($objDC->activeRecord->bbit_solr_index);
			foreach($objIndex->getSources() as $objSource) {
				$arrSources[$objSource->getName()] = $objSource->getDisplayName();
			}
			
		} catch(SolrException $e) {
			self::logException($e);
		}
		asort($arrSources);
		return $arrSources;
	}
	
	public function getDocumentTypeOptions() {
		$arrTypes = array();
		foreach($GLOBALS['SOLR_DOCTYPES'] as $strDocType) {
			$arrTypes[$strDocType] = $this->getDocumentTypeLabel($strDocType);
		}
		asort($arrTypes);
		return $arrTypes;
	}
	
	public function getDocumentTypeOptionsByIndex($objDC) {
		$arrTypes = array();
		try {
			$objIndex = SolrIndexManager::findIndex($objDC->activeRecord->bbit_solr_index);
			foreach($objIndex->getSources() as $objSource) {
				foreach($objSource->getDocumentTypes() as $strDocType) {
					$arrTypes[$strDocType] = $this->getDocumentTypeLabel($strDocType);
				}
			}
			
		} catch(SolrException $e) {
			self::logException($e);
		}
		asort($arrTypes);
		return $arrTypes;
	}
	
	public function getDocumentTypeLabel($strDocType) {
		$strLabel = $GLOBALS['TL_LANG']['bbit_solr']['docTypes'][$strDocType];
		return $strLabel ? $strLabel : $strDocType;
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
		
		sort($arrTpls);
		return $arrTpls;
	}
	
	public function getResultModuleOptions($objDC) {
		$objResult = $this->Database->prepare(
			'SELECT id, name FROM tl_module WHERE id != ? AND type = ? ORDER BY name'
		)->execute($objDC->activeRecord->id, 'bbit_solr_result');
		
		$arrModules = array();
		if($objDC && $GLOBALS['TL_DCA']['tl_module']['fields'][$objDC->field]['bbit_solr_nocopyOption']) {
			$arrModules['bbit_solr_nocopy'] = &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_nocopy'];
		}
		while($objResult->next()) {
			$arrModules[$objResult->id] = $objResult->name . ' (ID ' . $objResult->id . ')';
		}
		
		return $arrModules;
	}
	
	public function loadGroups($varValue, $objDC) {
		$arrGrouping = deserialize($varValue, true);
		$arrDocTypes = $GLOBALS['TL_DCA'][$objDC->table]['fields'][$objDC->field]['bbit_solr_useIndexDocTypes']
			? $this->getDocumentTypeOptionsByIndex($objDC)
			: $this->getDocumentTypeOptions();
		// filter unknown doctypes and apply user order
		$arrDocTypes = array_merge(array_intersect_key($arrGrouping, $arrDocTypes), $arrDocTypes);
		
		$arrRows = array();
		foreach($arrDocTypes as $strDocType => $strLabel) {
			$arrRow = array(
				'label' => $strLabel,
				'docType' => $strDocType,
			);
			if(isset($arrGrouping[$strDocType])) {
				$arrRow['group'] = $arrGrouping[$strDocType] == $strGroup ? '' : $arrGrouping[$strDocType];
				$arrRow['available'] = true;
				$strGroup = $arrGrouping[$strDocType];
			}
			$arrRows[] = $arrRow;
		}
		
		return array_values($arrRows);
	}
	
	public function saveGroups($varValue, $objDC) {
		$blnAll = !isset($GLOBALS['TL_DCA'][$objDC->table]['fields'][$objDC->field]['eval']['columnFields']['available']);
		$arrGrouping = array();
		
		foreach(deserialize($varValue, true) as $i => $arrRow) if($blnAll || $arrRow['available']) {
			$strGroup = $arrRow['group']
				? $arrRow['group']
				: ($strGroup ? $strGroup : $this->getDocumentTypeLabel($arrRow['docType']));
			$arrGrouping[$arrRow['docType']] = $strGroup;
		}
		
		return $arrGrouping;
	}
	
	public function savePositiveInteger($varValue) {
		return max(1, intval($varValue));
	}
	
	public function saveNonNegativeInteger($varValue) {
		return max(0, intval($varValue));
	}
	
	public function loadDocTpls($varValue, $objDC) {
		$arrRows = array();
		
		foreach($this->getDocumentTypeOptionsByIndex($objDC) as $strDocType => $strLabel) {
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
