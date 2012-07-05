<?php

class ModuleSolrSearch extends AbstractModuleSolr {

	const DEFAULT_TEMPLATE = 'mod_bbit_solr_search';
	
	public function generate() {
		$this->strDisplayName = $GLOBALS['TL_LANG']['FMD']['bbit_solr_search'][0];
		return parent::generate();
	}
	
	protected function compile() {
		$this->loadLanguageFile('bbit_solr');
		$objPage = $this->jumpTo ? $this->getPageDetails($this->jumpTo) : $GLOBALS['objPage'];
		$strQuery = $this->getQuery($this->bbit_solr_target);
		
		$this->Template->action = $this->generateFrontendUrl($objPage->row());
		
		$this->Template->queryID = $this->getHTMLID();
		$this->Template->queryName = 'q';
		$this->Template->queryValue = $this->bbit_solr_rememberQuery ? $strQuery : '';
		$this->Template->queryAutocomplete = $this->bbit_solr_autocomplete ? 'on' : 'off';
		
		$this->Template->targetName = 't';
		$this->Template->targetValue = $this->bbit_solr_target;
		
		$arrFilter = array();
		foreach(deserialize($this->bbit_solr_filter) as $strDocType => $strGroup) {
			$arrFilter[$strGroup][] = $strDocType;
		}
		foreach($arrFilter as &$arrDocTypes) {
			$arrDocTypes = implode(',', $arrDocTypes);
		}
		$this->Template->filter = $arrFilter;
		$this->Template->filterID = 'f' . $this->id;
		$this->Template->filterName = 'f';
		$strChecked = $this->Input->get('f');
		$this->Template->filterChecked = isset($arrFilter[$strChecked]) ? $strChecked : 'all';
		
		if($this->bbit_solr_live) {
			$GLOBALS['TL_JAVASCRIPT']['bbit.solr.js'] = 'system/modules/backboneit_solr/html/js/bbit.solr.js';
			$this->Template->live = true;
			$this->Template->liveTargetID = $this->getHTMLID($this->bbit_solr_liveTarget);
			$this->Template->liveTargetModule = intval($this->bbit_solr_liveTarget);
// 			$this->Template->liveOptions = array();
		}
	}
	
}
