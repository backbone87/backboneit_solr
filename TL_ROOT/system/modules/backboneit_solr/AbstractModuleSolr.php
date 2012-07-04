<?php

abstract class AbstractModuleSolr extends Module {

	const DEFAULT_TEMPLATE = 'mod_bbit_solr_search';
	
	protected $strDisplayName = 'bbit_solr';
	
	public function generate() {
		if(TL_MODE == 'BE') {
			return $this->generateBE($this->strDisplayName);
		}
		
		$this->setTemplate($this->bbit_solr_tpl ? $this->bbit_solr_tpl : $this::DEFAULT_TEMPLATE);
		
		return parent::generate();
	}
	
	protected function setTemplate($strTemplate) {
		$this->strTemplate = $this->bbit_solr_tpl = $strTemplate;
	}
	
	protected function getQuery($intTarget) {
		if($intTarget && isset($_GET['q' . $intTarget])) {
			return $this->Input->get('q' . $intTarget);
		} elseif(isset($_GET['q'])) {
			return $this->Input->get('q');
		}
	}
	
	protected function getHTMLID($intID = null, $strName = 'bbit_solr') {
		return $strName . ($intID === null ? $this->id : $intID);
	}

	protected function generateBE($strDisplayName) {
		$objTemplate = new BackendTemplate('be_wildcard');

		$objTemplate->wildcard = sprintf('### %s ###', $strDisplayName);
		$objTemplate->title = $this->headline;
		$objTemplate->id = $this->id;
		$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

		return $objTemplate->parse();
	}
	
}
