<?php

final class SolrContaoPageSourceManager extends Controller {
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!self::$objInstance) {
			self::$objInstance = new self();
		}
		return self::$objInstance;
	}
	
	protected function __construct() {
		parent::__construct();
		$this->import('Database');
	}
	
	protected function __clone() {
	}
	
	public function hookOutputFrontendTemplate() {
		if(!isset($GLOBALS['objPage'])) {
			return;
		}
		
		$intTime = time();
		$intPage = $GLOBALS['objPage']->id;
		$strURL = $this->Environment->base . $this->Environment->request;
		$intRoot = $GLOBALS['objPage']->rootId;
		
		$intCnt = $this->Database->prepare(
			'SELECT COUNT(*) AS cnt FROM tl_bbit_solr_page WHERE page = ? AND url = ? AND root = ?'
		)->execute($intPage, $strURL, $intRoot)->cnt;
		
		if($intCnt) {
			$this->Database->prepare(
				'UPDATE tl_bbit_solr_page SET tstamp = ? WHERE page = ? AND url = ? AND root = ?'
			)->execute($intTime, $intPage, $strURL, $intRoot);
			
		} else {
			$this->Database->prepare(
				'INSERT INTO tl_bbit_solr_page %s'
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
