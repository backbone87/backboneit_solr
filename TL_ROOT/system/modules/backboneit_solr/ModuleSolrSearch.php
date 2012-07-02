<?php

class ModuleSolrSearch extends AbstractModuleSolr {

	const DEFAULT_TEMPLATE = 'mod_bbit_solr_search';
	
	public function generate() {
		return parent::generate($GLOBALS['TL_LANG']['FMD']['bbit_solr_search'][0]);
	}
	
	protected function compile() {
		$objPage = $this->jumpTo ? $this->getPageDetails($this->jumpTo) : $GLOBALS['objPage'];
		$strQuery = $this->getQuery($this->bbit_solr_target);
		
		$this->Template->action = $this->generateFrontendUrl($objPage->row());
		
		$this->Template->queryID = $this->getHTMLID();
		$this->Template->queryName = 'q';
		$this->Template->queryValue = $this->bbit_solr_rememberQuery ? $strQuery : '';
		$this->Template->queryAutocomplete = $this->bbit_solr_autocomplete ? 'on' : 'off';
		
		$this->Template->targetName = 't';
		$this->Template->targetValue = $this->bbit_solr_target;
		
		if($this->bbit_solr_live) {
			$GLOBALS['TL_JAVASCRIPT']['bbit.solr.js'] = 'system/modules/backboneit_solr/html/js/bbit.solr.js';
			$this->Template->live = true;
			$this->Template->liveTargetID = $this->getHTMLID($this->bbit_solr_liveTarget);
			$this->Template->liveTargetModule = intval($this->bbit_solr_liveTarget);
// 			$this->Template->liveOptions = array();
		}
	}
	
}
