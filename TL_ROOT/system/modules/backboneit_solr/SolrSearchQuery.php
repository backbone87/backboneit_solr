<?php

class SolrSearchQuery extends SolrAbstractQuery {
	
	public function __construct(SolrRequestHandler $objHandler) {
		parent::__construct($objHandler);
	}
	
	protected function createResult(RequestExtended $objRequest) {
		return new SolrSearchResult($objRequest->response);
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
	
	public function setQuery($strQuery) {
		$this->setParam('q', $strQuery);
	}
	
	public function prepareQuery($strQuery, $blnFuzzy = true) {
		$arrQuery = preg_split('/[\s\.\,\;\:\)\(\]\[\}\{_-]+/', $strQuery);
		$arrQuery = array_filter($arrQuery, create_function('$str', 'return strlen($str) > 2;'));
		return $arrQuery ? $blnFuzzy ? implode('~ ', $arrQuery) . '~' : implode(' ', $arrQuery) : '';
	}
	
}
