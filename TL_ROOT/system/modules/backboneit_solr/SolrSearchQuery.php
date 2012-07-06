<?php

class SolrSearchQuery extends SolrAbstractQuery {
	
	private $arrKeywords;
	
	public function __construct(SolrRequestHandler $objHandler) {
		parent::__construct($objHandler);
	}
	
	protected function createResult(RequestExtended $objRequest) {
		if($this->getWriterType() != self::WT_JSON) {
			throw new SolrException(__CLASS__ . '::' . __METHOD__); // TODO
		}
		return new SolrSearchResult($this, $objRequest->response);
	}
	
	public function setLimit($intPerPage = 10, $intPage = 0) {
		$this->setParam('rows', $intPerPage);
		$this->setParam('start', $intPage * $intPerPage);
	}
	
	public function setDocTypeFilter($blnAsFilterQuery = true) {
		$arrConjunction = func_get_args();
		array_shift($arrConjunction);
		$arrConjunction = array_filter($arrConjunction);
		foreach($arrConjunction as &$arrDisjunction) {
			$arrDisjunction = str_replace('"', '\\"', array_filter((array) $arrDisjunction));
			$arrDisjunction && $arrDisjunction = '+("' . implode('" OR "', $arrDisjunction) . '")';
		}
		$arrConjunction = array_filter($arrConjunction);
		$arrConjunction && $this->setParam('fq', 'm_doctype_s:(' . implode(' AND ', $arrConjunction) . ')');
	}
	
	public function setQuery(array $arrKeywords, $strPrep = null) {
		$this->arrKeywords = $arrKeywords;
		switch($strPrep) {
			case 'fuzzy':
				$strPrepared = implode('~ ', $arrKeywords) . '~';
				break;
				
			case 'wildcard_all':
				$strPrepared = implode('* ', $arrKeywords) . '*';
				break;
					
			case 'wildcard_last':
				$strPrepared = implode(' ', $arrKeywords) . '*';
				break;
				
			default:
				$strPrepared = implode(' ', $arrKeywords);
				break;
		}
		$this->setParam('q', $strPrepared);
	}
	
	public function getKeywords() {
		return $this->arrKeywords;
	}
	
}
