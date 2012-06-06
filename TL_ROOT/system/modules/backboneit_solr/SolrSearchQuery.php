<?php

class SolrSearchQuery extends SolrAbstractQuery {
	
	public function __construct(SolrRequestHandler $objHandler) {
		parent::__construct($objHandler);
	}
	
	protected function createResult(RequestExtended $objRequest) {
		return new SolrJSONResult($objRequest->response);
	}
	
}
