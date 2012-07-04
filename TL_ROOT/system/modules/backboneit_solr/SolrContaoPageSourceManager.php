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
	
	public function hookOutputFrontendTemplate($strBuffer) {
		if(!isset($GLOBALS['objPage'])) {
			return $strBuffer;
		}
		
		$intTime = time();
		$intPage = $GLOBALS['objPage']->id;
		$strBase = $this->Environment->base;
		list($strRequest) = explode('?', $this->Environment->request, 2);
		$intRoot = $GLOBALS['objPage']->rootId;
		$strHash = md5($strBase . $strRequest);
		
		$intCnt = $this->Database->prepare(
			'SELECT COUNT(*) AS cnt FROM tl_bbit_solr_page WHERE page = ? AND hash = ?'
		)->execute($intPage, $strHash)->cnt;
		
		if($intCnt) {
			$this->Database->prepare(
				'UPDATE tl_bbit_solr_page SET tstamp = ?, root = ? WHERE page = ? AND hash = ?'
			)->execute($intTime, $intRoot, $intPage, $strHash);
			
		} else {
			$this->Database->prepare(
				'INSERT INTO tl_bbit_solr_page %s'
			)->set(array(
				'page' => $intPage,
				'hash' => $strHash,
				'base' => $strBase,
				'request' => $strRequest,
				'root' => $intRoot,
				'tstamp' => $intTime
			))->execute();
		}
		
		return $strBuffer;
	}
	
	public function deleteInvalid() {
		$this->Database->query(
			'DELETE
			FROM	s
			USING	tl_bbit_solr_page AS s
			LEFT JOIN tl_page AS p ON p.id = s.page
			WHERE	p.id IS NULL
			OR		0 = LOCATE(p.alias, s.request)'
		);
	}
	
// 	public function addSearchablePages() {
// 		SolrUtils::getInstance()->getSearchablePages();
// 	}
	
}
