<?php

class BlankFrontendTemplate extends FrontendTemplate {
	
	public function __construct($strContent) {
		parent::__construct();
		$this->strContent = strval($strContent);
	}
	
	public function parse() {
		return $this->strContent;
	}
	
}
