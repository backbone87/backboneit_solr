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
	
}
