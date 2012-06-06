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
		$objPage = $GLOBALS['objPage'];
		$strQuery = $this->Input->get('query');
		
		$this->Template->action = $this->generateFrontendUrl($objPage->row());
		$this->Template->queryID = 'bbit_solr_search' . $this->id;
		$this->Template->queryName = 'query';
		$this->Template->queryValue = $strQuery;
		
		if($strQuery) {
			$objIndex = SolrIndexManager::findIndex($this->bbit_solr_index);
			if(!$objIndex) {
				var_dump("shit");
				return;
			}
			$objHandler = $objIndex->getRequestHandler($this->bbit_solr_handler);
			if(!$objHandler
			|| ($objHandler->getQueryClass()->getName() != 'SolrSearchQuery'
			&& !$objHandler->getQueryClass()->isSubclassOf('SolrSearchQuery'))
			) {
				var_dump("shit2");
				return;
			}
			$objQuery = $objHandler->createQuery();
			$objQuery->setParam('q', $strQuery);
			if(!$objQuery->execute()) {
				var_dump("shit3");
				return;
			}
			$this->Template->result = $objQuery->getResult()->getContent();
		}
	}

	protected function generateBE() {
		return '### Solr search ###';
	}
	
}
