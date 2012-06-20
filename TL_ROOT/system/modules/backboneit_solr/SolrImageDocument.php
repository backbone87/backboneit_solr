<?php

class SolrImageDocument extends SolrDocument {
	
	protected $strTemplate = 'bbit_solr_doc_image';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getImageURL($blnRelative = true) {
		if($blnRelative) {
			$strBase = Environment::getInstance()->base;
			$n = strlen($strBase);
			if(0 == strncmp($strBase, $this->m_src_s, $n)) {
				return substr($this->m_src_s, $n);
			} else {
				return $this->m_src_s;
			}
		} else {
			return $this->m_src_s;
		}
	}
	
	public function prepareImage(array $arrSize = null, $strMode = 'box') {
		$strURL = $this->getImageURL();
		if(!$arrSize || 0 == strncmp($strURL, 'http://', 7)) {
			$this->src = $strURL;
			$this->width = $arrSize[0];
			$this->height = $arrSize[1];
		} else {
			$this->src = $this->getImage($strURL, $arrSize[0], $arrSize[1], $strMode);
			$objImage = new File($this->src);
			$this->width = $objImage->width;
			$this->height = $objImage->height;
		}
	}
	
}
