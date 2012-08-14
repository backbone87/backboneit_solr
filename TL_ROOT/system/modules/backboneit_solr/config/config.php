<?php

$GLOBALS['TL_CONFIG']['bbit_solr_page_outdate'] = 60 * 60 * 24 * 30;

$GLOBALS['FE_MOD']['application']['bbit_solr_search'] = 'ModuleSolrSearch';
$GLOBALS['FE_MOD']['application']['bbit_solr_result'] = 'ModuleSolrResult';

$GLOBALS['BE_MOD']['bbit_solr']['bbit_solr_source']['icon'] = '';
$GLOBALS['BE_MOD']['bbit_solr']['bbit_solr_source']['tables'][] = 'tl_bbit_solr_source';
$GLOBALS['BE_MOD']['bbit_solr']['bbit_solr_index']['icon'] = '';
$GLOBALS['BE_MOD']['bbit_solr']['bbit_solr_index']['tables'][] = 'tl_bbit_solr_index';
$GLOBALS['BE_MOD']['bbit_solr']['bbit_solr_index']['tables'][] = 'tl_bbit_solr_handler';

$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('SolrContaoPageSourceManager', 'hookOutputFrontendTemplate');

$GLOBALS['TL_CACHE']['bbit_solr_page'] = 'tl_bbit_solr_page';

$GLOBALS['TL_CRON']['daily'][] = array('SolrIndexManager', 'runUpdates');


$GLOBALS['BBIT_SOLR']['HOOKS']['beforeRunUpdates'] = array('SolrContaoPageSourceManager', 'cleanURLIndex');

$GLOBALS['BBIT_SOLR']['HANDLER'] = 'SolrGenericRequestHandler';

$GLOBALS['BBIT_SOLR']['DOCTYPES'][] = 'SolrContaoPageDocument';
$GLOBALS['BBIT_SOLR']['DOCTYPES'][] = 'SolrFileDocument';
$GLOBALS['BBIT_SOLR']['DOCTYPES'][] = 'SolrImageDocument';

$GLOBALS['BBIT_SOLR']['SOURCES'][] = 'SolrContaoPageSource';
$GLOBALS['BBIT_SOLR']['SOURCES'][] = 'SolrFileSource';

// default index config
$GLOBALS['BBIT_SOLR']['DEFAULT_INDEX']['url'] = 'http://localhost:8080/solr';
$GLOBALS['BBIT_SOLR']['DEFAULT_INDEX']['core'] = '/contao';
$GLOBALS['BBIT_SOLR']['DEFAULT_INDEX']['handlers'][] = array(
	'name'		=> '/select',
	'type'		=> 'solr.SearchHandler',
	'query'		=> 'SolrSearchQuery',
);
$GLOBALS['BBIT_SOLR']['DEFAULT_INDEX']['handlers'][] = array(
	'name'		=> '/update/contao-page',
	'type'		=> 'solr.handler.dataimport.DataImportHandler',
	'query'		=> 'SolrDIHQuery',
);
$GLOBALS['BBIT_SOLR']['DEFAULT_INDEX']['handlers'][] = array(
	'name'		=> '/update/contao-file',
	'type'		=> 'solr.handler.dataimport.DataImportHandler',
	'query'		=> 'SolrDIHQuery',
);
$GLOBALS['BBIT_SOLR']['DEFAULT_INDEX']['sources'][] = array(
	'name'		=> 'bbit_solr_page',
	'handler'	=> '/update/contao-page'
);
$GLOBALS['BBIT_SOLR']['DEFAULT_INDEX']['sources'][] = array(
	'name'		=> 'bbit_solr_file_pdf',
	'handler'	=> '/update/contao-file'
);

$GLOBALS['BBIT_SOLR']['DEFAULT_SOURCES']['bbit_solr_page']['class'] = 'SolrContaoPageSource';
// $GLOBALS['BBIT_SOLR']['DEFAULT_SOURCES']['bbit_solr_page']['config'][] = array('setRoots', 0);
// $GLOBALS['BBIT_SOLR']['DEFAULT_SOURCES']['bbit_solr_page']['config'][] = array('setExtractImages', true);

$GLOBALS['BBIT_SOLR']['DEFAULT_SOURCES']['bbit_solr_file_pdf']['class'] = 'SolrFileSource';
// $GLOBALS['BBIT_SOLR']['DEFAULT_SOURCES']['bbit_solr_file_pdf']['config'][] = array('setRoots', 'tl_files');
$GLOBALS['BBIT_SOLR']['DEFAULT_SOURCES']['bbit_solr_file_pdf']['config'][] = array('setExtension', 'pdf');


// add all factories for indexes and search sources to their respective managers
// the managers are aggregation factories
SolrIndexManager::getInstance()->add(SolrDefaultIndexFactory::getInstance());
SolrSourceManager::getInstance()->add(SolrDefaultSourceFactory::getInstance());


/**
 * @deprecated
 */
$GLOBALS['SOLR_DEFAULT_INDEX'] = &$GLOBALS['BBIT_SOLR']['DEFAULT_INDEX'];
/**
 * @deprecated
 */
$GLOBALS['SOLR_DEFAULT_SEARCH_SOURCES'] = &$GLOBALS['BBIT_SOLR']['DEFAULT_SOURCES'];

