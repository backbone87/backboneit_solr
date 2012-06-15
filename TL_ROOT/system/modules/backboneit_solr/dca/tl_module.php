<?php

SolrUtils::getInstance()->loadLanguageFile('bbit_solr');

/*** COMMON FIELDS ***/

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_tpl'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_gs_tpl'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback'=> array('SolrUtils', 'getTplOptions'),
	'eval'			=> array(
		'includeBlankOption'=> true,
		'blankOptionLabel'=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_tpl_blank'],
		'chosen'		=> true,
	),
);



/*** SEARCH MODULE ***/

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'bbit_solr_live';

$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_solr_search']
	= '{title_legend},name,headline,type'
	. ';{bbit_solr_search_legend}'
	. ',bbit_solr_rememberQuery,bbit_solr_autocomplete'
	. ';{redirect_legend}'
	. ',bbit_solr_target'
	. ',jumpTo'
	. ',bbit_solr_live'
	. ';{bbit_solr_tpl_legend}'
	. ',bbit_solr_tpl'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space'
	;
	
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['bbit_solr_live'] = 'bbit_solr_liveTarget';

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_rememberQuery'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_rememberQuery'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'default'		=> 1,
	'eval'			=> array(
		'tl_class'		=> 'clr w50 cbx',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_autocomplete'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_autocomplete'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'default'		=> 1,
	'eval'			=> array(
		'tl_class'		=> 'w50 cbx',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_target'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_target'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getResultModuleOptions'),
	'eval'			=> array(
		'includeBlankOption'=> true,
		'chosen'		=> true,
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_live'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_live'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array(
		'submitOnChange'=> true,
		'tl_class'		=> 'clr w50 cbx m12',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_liveTarget'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_liveTarget'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getResultModuleOptions'),
	'eval'			=> array(
		'mandatory'		=> true,
		'chosen'		=> true,
		'tl_class'		=> 'w50',
	)
);



/*** RESULT MODULE ***/

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'bbit_solr_copy';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'bbit_solr_showOnEmpty';

$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_solr_result']
	= '{title_legend},name,headline,type,bbit_solr_copy'
	. ';{bbit_solr_tpl_legend}'
	. ',bbit_solr_tpl'
	. ',bbit_solr_docTpls'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space'
	;
	
$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_solr_resultbbit_solr_nocopy']
	= '{title_legend},name,headline,type,bbit_solr_copy'
	. ';{bbit_solr_source_legend}'
	. ',bbit_solr_index,bbit_solr_handler'
	. ',bbit_solr_sources'
	. ';{bbit_solr_filter_legend}'
	. ',bbit_solr_docTypes'
	. ';{bbit_solr_tpl_legend}'
	. ',bbit_solr_tpl'
	. ',bbit_solr_docTpls'
	. ',bbit_solr_showOnEmpty'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space'
	;
	
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['bbit_solr_showOnEmpty'] = 'bbit_mod_art_container,bbit_mod_art_id';

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_copy'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_copy'],
	'exclude'		=> true,
	'default'		=> 'bbit_solr_nocopy',
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getResultModuleOptions'),
	'bbit_solr_nocopyOption' => true,
	'eval'			=> array(
		'chosen'		=> true,
		'tl_class'		=> 'w50',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_index'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_index'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getIndexOptions'),
	'eval'			=> array(
		'mandatory'		=> true,
		'includeBlankOption'=> true,
		'submitOnChange'=> true,
		'chosen'		=> true,
		'tl_class'		=> 'w50',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_handler'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_handler'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getSearchHandlerOptions'),
	'eval'			=> array(
		'mandatory'		=> true,
		'includeBlankOption'=> true,
// 		'submitOnChange'=> true,
		'chosen'		=> true,
		'tl_class'		=> 'w50',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_sources'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_sources'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getSourceOptionsByIndex'),
	'eval'			=> array(
		'mandatory'		=> true,
		'multiple'		=> true,
		'chosen'		=> true,
		'size'			=> 5,
		'style'			=> 'width: 100%',
	),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_showOnEmpty'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_showOnEmpty'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array(
		'submitOnChange'=> true,
		'tl_class'		=> 'clr w50',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_docTypes'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTypes'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getDocumentTypeOptionsByIndex'),
	'eval'			=> array(
		'mandatory'		=> true,
		'multiple'		=> true,
		'chosen'		=> true,
		'size'			=> 5,
		'style'			=> 'width: 100%',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_docTpls'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTpls'],
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'label' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docLabel'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'	=> true,
					'style'		=> 'width: 200px;'
				)
			),
			'tpl' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTpl'],
				'inputType'	=> 'select',
				'options_callback' => array('SolrUtils', 'getDocTplOptions'),
				'eval'		=> array(
					'includeBlankOption'=> true,
					'blankOptionLabel'=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_tpl_blank'],
					'chosen'	=> true,
					'style'		=> 'width: 200px;'
				)
			),
			'docType' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docType'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'	=> true,
					'style'		=> 'width: 200px;'
				)
			),
		),
		'buttons'	=> array('up' => false, 'down' => false, 'delete' => false, 'copy' => false),
	),
	'load_callback' => array(
		array('SolrUtils', 'loadDocTpls'),
	),
	'save_callback' => array(
		array('SolrUtils', 'saveDocTpls'),
	),
	
);
