<?php

final class SolrContaoPageSearchSourceManager extends Controller {
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!self::$objInstance) {
			self::$objInstance = new self();
		}
		return self::$objInstance;
	}
	
	private function __construct() {
		parent::__construct();
		$this->import('Database');
	}
	
	private function __clone() {
	}
	
	public function hookOutputFrontendTemplate() {
		if(!isset($GLOBALS['objPage'])) {
			return;
		}
		
		$intTime = time();
		$intPage = $GLOBALS['objPage']->id;
		$strURL = $this->Environment->base . $this->Environment->request;
		$intRoot = $GLOBALS['objPage']->root;
		
		$intCnt = $this->Database->prepare(
			'SELECT COUNT(*) AS cnt FROM tl_bbit_solr_page WHERE id = ? AND url = ? AND root = ?'
		)->execute($intPage, $strURL, $intRoot)->cnt;
		
		if($intCnt) {
			$this->Database->prepare(
				'UPDATE tl_bbit_solr_page WHERE id = ? AND url = ? AND root = ? SET tstamp = ?'
			)->execute($intPage, $strURL, $intRoot, $intTime);
			
		} else {
			$this->Database->prepare(
				'INSERT INTO tl_bbit_solr_page'
			)->set(array(
				'page' => $intPage,
				'url' => $strURL,
				'root' => $intRoot,
				'tstamp' => $intTime
			))->execute();
		}
	}
	
// 	public function addSearchablePages() {
// 		SolrUtils::getInstance()->getSearchablePages();
// 	}
	
}
