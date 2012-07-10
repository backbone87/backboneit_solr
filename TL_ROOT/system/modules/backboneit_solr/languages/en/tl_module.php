<?php

$GLOBALS['TL_LANG']['tl_module']['bbit_solr_tpl']
	= array('Template', 'The template of this module.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_tplLabels']['mod_bbit_solr_result_grouped']
	= 'Grouped results';
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_tpl_blank']
	= 'Default template';
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docLabel']
	= array('Document type', '');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docType']
	= array('Document class', '');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_group']
	= array('Group', '');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_available']
	= array('Available', '');


$GLOBALS['TL_LANG']['tl_module']['bbit_solr_search_legend']
	= 'Search request settings';
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_rememberQuery']
	= array('Show last query', 'If enabled, the current search query is displayed in the search field.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_autocomplete']
	= array('Autocomplete (Browser)', 'If enabled, the autocomplete feature of the user\'s browser is activated.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_filter']
	= array('Document type filter', 'Offers the user the possibility to filter by predefined document type groups.');



$GLOBALS['TL_LANG']['tl_module']['bbit_solr_target']
	= array('Target result module', 'If there is more than one result module on the redirection target page, you can choose a target module, otherwise all result modules are triggered.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_live']
	= array('Live Search', 'Update the search result, while typing the search query.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_liveTarget']
	= array('Result module for Live Search', 'The target module that will be updated via Live Search. If it is not available on the current page, the form works as normal and redirects the user to the configured redirection target page.');


$GLOBALS['TL_LANG']['tl_module']['bbit_solr_copy']
	= array('Copy settings', 'Reuse the settings of another module.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_nocopy']
	= 'Do not copy settings';

$GLOBALS['TL_LANG']['tl_module']['bbit_solr_source_legend']
	= 'Search source';
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_index']
	= array('Solr index', 'Choose the Solr index to be searched.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_handler']
	= array('Solr request handler', 'Choose the Solr request handler to be used for search queries.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_sources']
	= array('Search sources', 'Choose the search sources that will be searched.');


$GLOBALS['TL_LANG']['tl_module']['bbit_solr_search_legend']
	= 'Search settings';
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_keywordSplit']
	= array('Query splitting', 'The characters at which the query will be split into separate search keywords.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_keywordSplitRaw']
	= array('Query splitting (RegEx)', 'The characters (in POSIX regular expression syntax) at which the query will be split into separate search keywords.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_keywordMinLength']
	= array('Keyword min length', 'The minimum length of search keywords. Keywords which are shorter will be ignored.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_prep']
	= array('Query Preparation', 'The mechanism to be used to prepare the query for search.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_prepOptions'] = array(
	'fuzzy'	=> 'Fuzzy search',
	'wildcard_all' => 'Wildcard at the end (all keywords)',
	'wildcard_last' => 'Wildcard at the end (only last keyword)',
	'fuzzy_wildcard_last' => 'Wildcard at the end (only last keyword), other keywords fuzzy search',
);
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTypes']
	= array('Document type filter', 'Choose the document types the results will be limited to.');


$GLOBALS['TL_LANG']['tl_module']['bbit_solr_tpl_legend']
	= 'Template settings';
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_perPage']
	= array('Results per page', 'The amount of results displayed per page (greater than or equal to 1).');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_maxPages']
	= array('Page count', 'The max amount of pages (greater than or equal to 0). "0" indicates, that as many as needed pages are displayed to reach alle found results.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_grouping']
	= array('Grouping', 'The groups in which the results should be devided into.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTpls']
	= array('Document templates', 'The templates to be used for the different document types, that <strong>could</strong> be within the result.');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTpl']
	= array('Template', '');
$GLOBALS['TL_LANG']['tl_module']['bbit_solr_showOnEmpty']
	= array('Alternate content on empty result', 'If the search result is empty, the selected static content is displayed.');
