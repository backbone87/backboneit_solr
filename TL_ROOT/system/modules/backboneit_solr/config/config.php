<?php

$GLOBALS['BE_MOD']['system']['bbit_solr_index'] = array('callback' => 'ModuleSolr'); 
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('SolrContaoPageSearchSourceManager', 'hookOutputFrontendTemplate');
$GLOBALS['TL_CRON']['daily'][] = array('SolrIndexManager', 'runUpdates');

// $GLOBALS['BBIT_SOLR_HOOKS']['beforeRunUpdates'] = array('', '');
// $GLOBALS['BBIT_SOLR_HOOKS']['afterRunUpdates'] = array('', '');
// $GLOBALS['BBIT_SOLR_HOOKS']['beforeUpdate'] = array('', '');
// $GLOBALS['BBIT_SOLR_HOOKS']['afterUpdate'] = array('', '');

// default index config
$GLOBALS['SOLR_DEFAULT_INDEX'] = array(
	'url' => 'http://localhost:8080/solr',
	'core' => '/contao',
	'handlers' => array(
		array(
			'name'		=> '/update/json',
			'type'		=> 'solr.JsonUpdateRequestHandler',
			'query'		=> 'SolrUpdateQuery'
		),
		array(
			'name'		=> '/update/extract',
			'type'		=> 'solr.ExtractingRequestHandler',
			'query'		=> 'SolrExtractingUpdateQuery'
		),
		array(
			'name'		=> '/select',
			'type'		=> 'solr.SearchHandler',
			'query'		=> 'SolrSearchQuery'
		),
		array(
			'name'		=> '/cto2solr',
			'type'		=> 'solr.handler.dataimport.DataImportHandler',
			'query'		=> 'SolrDIHQuery'
		),
	),
	'sources' => array(
		array('name' => 'bbit_solr_page', 'handler' => '/cto2solr'),
	),
);

$GLOBALS['SOLR_DEFAULT_SEARCH_SOURCES']['bbit_solr_page'] = array(
	'class' => 'SolrContaoPageSearchSource',
	'config' => array(
		array('setRoots', 0),
		array('setExtractImages', true),
	)
);

// add all factories for indexes and search sources to their respective managers
// the managers are aggregation factories
SolrIndexManager::getInstance()->add(SolrDefaultIndexFactory::getInstance());
SolrSearchSourceManager::getInstance()->add(SolrDefaultSearchSourceFactory::getInstance());
