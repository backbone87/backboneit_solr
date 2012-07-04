<?php

class ModuleSolrResult extends AbstractModuleSolr {
	
	const DEFAULT_TEMPLATE = 'mod_bbit_solr_result';
	
	public function generate() {
		$this->strDisplayName = $GLOBALS['TL_LANG']['FMD']['bbit_solr_result'][0];
		$strHTML = parent::generate();
		if(TL_MODE == 'FE' && $_GET['l'] == 1) {
			while(ob_end_clean());
			$objTemplate = new BlankFrontendTemplate($strHTML);
			$objTemplate->output();
			exit;
		} else {
			return $strHTML;
		}
	}
	
	protected function compile() {
		$this->Template->id = $this->getHTMLID();
		
		$strQuery = $this->Input->get('q');
	
		if(!strlen($strQuery)) {
			return;
		}
		
		try {
			$objQuery = SolrIndexManager::findIndex(
				$this->bbit_solr_index
			)->getRequestHandler(
				$this->bbit_solr_handler
			)->createQuery(
				'SolrSearchQuery'
			);
			
			$objQuery->setParam('q', $strQuery);
			
			$strFilter = deserialize($this->bbit_solr_docTypes, true);
			$strFilter = $strFilter ? '+(' . implode(' OR ', $strFilter) . ')' : '';
			$strUserFilter = $this->Input->get('f');
			if($strUserFilter) {
				$strUserFilter = '+"' . str_replace('"', '\\"', $strUserFilter) . '"';
				$strFilter = $strFilter ? $strFilter . ' AND ' . $strUserFilter : $strUserFilter;
			}
			$strFilter && $objQuery->setParam('fq', 'm_doctype_s:(' . $strFilter . ')');
			
			$intPage = $this->Input->get('page');
			$intPage || $intPage = 1;
			$objQuery->setLimit($this->bbit_solr_perPage, $intPage - 1);
			
			$objResult = $objQuery->execute();

		} catch(SolrException $e) {
			SolrUtils::getInstance()->logException($e);
			$this->Template->content = BE_USER_LOGGED_IN;
			$this->Template->exception = $e;
			return;
		}
		
// 		var_dump($objResult);
		if($objResult->isEmpty()) {
			if($this->bbit_solr_showOnEmpty) {
				$this->Template->content = true;
				$this->Template->alternate = IncludeArticleUtils::generateArticle(
					$this->bbit_mod_art_id,
					$this->bbit_mod_art_nosearch,
					$this->bbit_mod_art_container,
					$this->strColumn
				);
			}
			return;
		}
		
		$objResult->setDocumentTemplates(deserialize($this->bbit_solr_docTpls, true));
		
		$this->Template->content = true;
		$this->Template->query = $strQuery;
		$this->Template->result = $objResult;
		$this->Template->perPage = $this->bbit_solr_perPage;
		$this->Template->maxResults = $this->bbit_solr_maxPages
			? $this->bbit_solr_maxPages * $this->bbit_solr_perPage
			: PHP_INT_MAX;
	}
	
}
