<?php

$GLOBALS['TL_CONFIG']['bbit_solr_page_outdate'] = 60 * 60 * 24 * 30;

$GLOBALS['FE_MOD']['application']['bbit_solr_search'] = 'ModuleSolrSearch';
$GLOBALS['FE_MOD']['application']['bbit_solr_result'] = 'ModuleSolrResult';

$GLOBALS['BE_MOD']['system']['bbit_solr_index'] = array('callback' => 'ModuleSolrBackend'); 

$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('SolrContaoPageSourceManager', 'hookOutputFrontendTemplate');

$GLOBALS['TL_CACHE']['bbit_solr_page'] = 'tl_bbit_solr_page';

// $GLOBALS['TL_CRON']['daily'][] = array('SolrContaoPageSourceManager', 'cleanURLIndex');
$GLOBALS['TL_CRON']['daily'][] = array('SolrIndexManager', 'runUpdates');

// $GLOBALS['BBIT_SOLR_HOOKS']['beforeRunUpdates'] = array('', '');
// $GLOBALS['BBIT_SOLR_HOOKS']['afterRunUpdates'] = array('', '');
// $GLOBALS['BBIT_SOLR_HOOKS']['beforeUpdate'] = array('', '');
// $GLOBALS['BBIT_SOLR_HOOKS']['afterUpdate'] = array('', '');
$GLOBALS['BBIT_SOLR_HOOKS']['beforeRunUpdates'] = array('SolrContaoPageSourceManager', 'cleanURLIndex');

// default index config
$GLOBALS['SOLR_DEFAULT_INDEX'] = array(
	'url' => 'http://localhost:8080/solr',
	'core' => '/contao',
	'handlers' => array(
// 		array(
// 			'name'		=> '/update/json',
// 			'type'		=> 'solr.JsonUpdateRequestHandler',
// 			'query'		=> 'SolrUpdateQuery',
// 		),
// 		array(
// 			'name'		=> '/update/extract',
// 			'type'		=> 'solr.ExtractingRequestHandler',
// 			'query'		=> 'SolrExtractingUpdateQuery',
// 		),
		array(
			'name'		=> '/select',
			'type'		=> 'solr.SearchHandler',
			'query'		=> 'SolrSearchQuery',
		),
		array(
			'name'		=> '/update/contao-page',
			'type'		=> 'solr.handler.dataimport.DataImportHandler',
			'query'		=> 'SolrDIHQuery',
		),
		array(
			'name'		=> '/update/contao-file',
			'type'		=> 'solr.handler.dataimport.DataImportHandler',
			'query'		=> 'SolrDIHQuery',
		),
	),
	'sources' => array(
		array('name' => 'bbit_solr_page', 'handler' => '/update/contao-page'),
		array('name' => 'bbit_solr_file_pdf', 'handler' => '/update/contao-file'),
	),
);

$GLOBALS['SOLR_DEFAULT_SEARCH_SOURCES']['bbit_solr_page'] = array(
	'class' => 'SolrContaoPageSource',
	'config' => array(
// 		array('setRoots', 0),
// 		array('setExtractImages', true),
	)
);
$GLOBALS['SOLR_DEFAULT_SEARCH_SOURCES']['bbit_solr_file_pdf'] = array(
	'class' => 'SolrFileSource',
	'config' => array(
// 		array('setRoots', 'tl_files'),
		array('setExtension', 'pdf'),
	)
);

$GLOBALS['SOLR_DOCTYPES'][] = 'SolrContaoPageDocument';
$GLOBALS['SOLR_DOCTYPES'][] = 'SolrFileDocument';
$GLOBALS['SOLR_DOCTYPES'][] = 'SolrImageDocument';

// add all factories for indexes and search sources to their respective managers
// the managers are aggregation factories
SolrIndexManager::getInstance()->add(SolrDefaultIndexFactory::getInstance());
SolrSourceManager::getInstance()->add(SolrDefaultSourceFactory::getInstance());
