<?php

class SolrFileDocument extends SolrDocument {
	
	protected $strTemplate = 'bbit_solr_doc_file';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function parse() {
		$this->href = $this->getURL(false);
		
		if(is_file(TL_ROOT . '/' . $this->m_path_s)) {
			$this->file = new File($this->m_path_s);
			$this->filesize = $this->getReadableSize($this->file->filesize, 1);
			$this->icon = TL_FILES_URL . 'system/themes/' . $this->getTheme() . '/images/' . $this->file->icon;
		}
		
		return parent::parse();
	}
	
	public function getURL($blnRelative = true) {
		if($blnRelative) {
			return $this->m_path_s;
		} else {
			return Environment::getInstance()->base . $this->m_path_s;
		}
	}
	
}
