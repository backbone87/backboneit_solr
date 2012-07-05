<?php

class SolrDocument extends Template {
	
	protected $strTemplate = 'bbit_solr_doc';
	
	public function __construct() {
		$strTemplate = $this->strTemplate;
		parent::__construct();
		$this->setTemplate($strTemplate);
	}
	
	public function setTemplate($strTemplate) {
		if(strlen($strTemplate)) {
			$this->setName($strTemplate);
		}
	}
	
	public function getTitle($intIndex = 0) {
		return $this->title[$intIndex];
	}
	
	public function getTitles($strGlue = null) {
		if(is_string($strGlue)) {
			return implode($strGlue, $this->title);
		} else {
			return $this->title;
		}
	}
	
	public function getURL($blnRelative = true) {
		if($blnRelative && Environment::getInstance()->base == $this->m_base_s) {
			return $this->m_request_s;
		} else {
			return $this->m_base_s . $this->m_request_s;
		}
	}
	
	public function getType() {
		return get_class($this);
	}
	
}
