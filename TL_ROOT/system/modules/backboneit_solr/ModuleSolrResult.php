<?php

class ModuleSolrResult extends Module {
	
	const DEFAULT_TEMPLATE = 'mod_bbit_solr_result';
	
	public function generate() {
		if(TL_MODE == 'BE') {
			return $this->generateBE();
		}
	
		$this->strTemplate = $this->bbit_solr_tpl = $this->bbit_solr_tpl ? $this->bbit_solr_tpl : self::DEFAULT_TEMPLATE;
	
		return parent::generate();
	}
	
	protected function compile() {
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
			$objResult = $objQuery->execute();

		} catch(SolrException $e) {
			var_dump($e);
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
	}
	
	protected function generateBE() {
		$objTemplate = new BackendTemplate('be_wildcard');

		$objTemplate->wildcard = sprintf('### %s ###', $GLOBALS['TL_LANG']['FMD']['bbit_solr_result'][0]);
		$objTemplate->title = $this->headline;
		$objTemplate->id = $this->id;
		$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

		return $objTemplate->parse();
	}
	
}
