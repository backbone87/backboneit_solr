<?php

class SolrDIHQuery extends SolrAbstractQuery {
	
	const PARAM_COMMAND		= 'command';
	const PARAM_ENTITY		= 'entity';
	const PARAM_CLEAN		= 'clean';
	const PARAM_COMMIT		= 'commit';
	const PARAM_OPTIMIZE	= 'optimize';
	const PARAM_DEBUG		= 'debug';
	
	const COM_FULL_IMPORT	= 'full-import';
	const COM_DELTA_IMPORT	= 'delta-import';
	const COM_STATUS		= 'status';
	const COM_RELOAD_CONFIG	= 'reload-config';
	const COM_ABORT			= 'abort';
	
	public function __construct(SolrRequestHandler $objHandler) {
		parent::__construct($objHandler);
		$this->reset();
	}
	
	public function reset() {
		parent::reset();
		$this->setCommand();
	}
	
	public function createResult(RequestExtended $objRequest) {
		// TODO
	}
	
	
	public function getCommand() {
		return $this->getParam(self::PARAM_COMMAND);
	}
	
	public function setCommand($strCommand = self::COM_FULL_IMPORT) {
		$this->setParam(self::PARAM_COMMAND, $strCommand);
	}
	
	
	public function getEntities() {
		return explode(',', $this->getParam(self::PARAM_ENTITY));
	}
	
	public function setEntities($strEnitity) {
		$arrEntities = array();
		$arrArgs = func_get_args();
		SolrUtils::unnestStringsAsSet($arrEntities, $arrArgs);
		$arrEntities = array_filter($arrEntities, 'strlen');
		if($arrEntities) {
			$this->setParam(self::PARAM_ENTITY, implode(',', $arrEntities));
		} else {
			$this->unsetParam(self::PARAM_ENTITY);
		}
	}
	
	
	public function getClean() {
		return $this->getBoolean(self::PARAM_CLEAN);
	}
	
	public function setClean($blnClean) {
		$this->setBoolean(self::PARAM_CLEAN, $blnClean);
	}
	
	
	public function getCommit() {
		return $this->getBoolean(self::PARAM_COMMIT);
	}
	
	public function setCommit($blnCommit) {
		$this->setBoolean(self::PARAM_COMMIT, $blnCommit);
	}
	
	
	public function getOptimize() {
		return $this->getBoolean(self::PARAM_OPTIMIZE);
	}
	
	public function setOptimize($blnOptimize) {
		$this->setBoolean(self::PARAM_OPTIMIZE, $blnOptimize);
	}
	
	
	public function getDebug() {
		return $this->getBoolean(self::PARAM_DEBUG);
	}
	
	public function setDebug($blnDebug) {
		$this->setBoolean(self::PARAM_DEBUG, $blnDebug);
	}
	
	
	protected function getBoolean($strName) {
		return $this->getParam($strName) == 'true';
	}
	
	protected function setBoolean($strName, $blnState) {
		$this->setParam($strName, $blnState ? 'true' : 'false');
	}
	
}
