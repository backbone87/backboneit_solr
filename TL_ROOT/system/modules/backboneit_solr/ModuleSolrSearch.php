<?php

class ModuleSolrSearch extends Module {

	const DEFAULT_TEMPLATE = 'mod_bbit_solr_search';
	
	public function generate() {
		if(TL_MODE == 'BE') {
			return $this->generateBE();
		}
	
		$this->strTemplate = $this->bbit_solr_tpl = $this->bbit_solr_tpl ? $this->bbit_solr_tpl : self::DEFAULT_TEMPLATE;
	
		return parent::generate();
	}
	
	protected function compile() {
		$objPage = $this->jumpTo ? $this->getPageDetails($this->jumpTo) : $GLOBALS['objPage'];
		$strQuery = $this->Input->get('q');
		
		$this->Template->action = $this->generateFrontendUrl($objPage->row());
		
		$this->Template->queryID = 'bbit_solr_search' . $this->id;
		$this->Template->queryName = 'q';
		$this->Template->queryValue = $this->bbit_solr_rememberQuery ? $strQuery : '';
		$this->Template->queryAutocomplete = $this->bbit_solr_autocomplete ? 'on' : 'off';
		
		$this->Template->targetName = 't';
		$this->Template->targetValue = $this->bbit_solr_target;
		
		if($this->bbit_solr_live) {
			$this->Template->liveTargetID = $this->getResultModuleCSSID($this->bbit_solr_liveTarget);
		}
	}
	
	protected function getResultModuleCSSID($intModuleID) {
		$this->import('Database');
		$objModule = $this->Database->prepare(
			'SELECT	cssID
			FROM	tl_module
			WHERE	id = ?'
		)->execute($intModuleID);
		
		if(!$objModule->numRows) {
			return false;
		}
		
		list($strID) = deserialize($objModule->cssID, true);
		return strlen($strID) ? $strID : 'bbit_solr_result' . $intModuleID;
	}

	protected function generateBE() {
		$objTemplate = new BackendTemplate('be_wildcard');

		$objTemplate->wildcard = sprintf('### %s ###', $GLOBALS['TL_LANG']['FMD']['bbit_solr_search'][0]);
		$objTemplate->title = $this->headline;
		$objTemplate->id = $this->id;
		$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

		return $objTemplate->parse();
	}
	
}
