<?php

class SolrExtractingUpdateQuery extends SolrAbstractQuery {
	
	public function __construct(SolrRequestHandler $objHandler) {
		parent::__construct($objHandler);
	}
	
	public function setFile(File $objFile) {
		$this->objFile = $objFile;
	}
	
	public function getFile() {
		return $this->objFile;
	}
	
	public function setID() {
		$this->setParam('literal.id', $strValue);
	}
	
	protected function prepareRequest(RequestExtended $objRequest) {
		$objRequest->datamime = $this->objFile->mime;
		$objFormdata = new MultipartFromdata();
		$objFormdata->setFileField('file', TL_ROOT . '/' . $this->objFile->value, $this->objFile->mime);
	}
	
}
