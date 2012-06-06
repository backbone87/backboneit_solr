<?php

class ModuleSolr extends BackendModule {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function generate() {
		SolrIndexManager::getInstance()->runUpdates(false);
		$this->loadLanguageFile('bbit_solr');
		$_SESSION['TL_INFO']['bbit_solr_runUpdates'] = $GLOBALS['TL_LANG']['bbit_solr']['runUpdates'];
// 		$this->redirect($this->getReferer());
		exit;
	}
	
	protected function compile() {
	}
	
}
