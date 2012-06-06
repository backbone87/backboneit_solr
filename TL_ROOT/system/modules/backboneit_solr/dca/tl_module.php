<?php

SolrUtils::getInstance()->loadLanguageFile('bbit_solr');

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'bbit_solr_copy';
	
$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_solr_search']
	= '{title_legend},name,headline,type,bbit_solr_copy'
	. ';{bbit_solr_tpl_legend}'
	. ',bbit_solr_tpl'
	. ',bbit_solr_docTpls'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space'
	;
	
$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_solr_searchbbit_solr_nocopy']
	= '{title_legend},name,headline,type,bbit_solr_copy'
	. ';{bbit_solr_source_legend}'
	. ',bbit_solr_index,bbit_solr_handler'
	. ',bbit_solr_sources'
	. ';{bbit_solr_filter_legend}'
	. ',bbit_solr_docTypes'
	. ';{bbit_solr_tpl_legend}'
	. ',bbit_solr_tpl'
	. ',bbit_solr_docTpls'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space'
	;
	
$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_copy'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_copy'],
	'exclude'		=> true,
	'default'		=> 'bbit_solr_nocopy',
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getSearchModuleOptions'),
	'eval'			=> array(
		'tl_class'	=> 'clr',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_index'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_index'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getIndexOptions'),
	'eval'			=> array(
		'mandatory'	=> true,
		'includeBlankOption' => true,
		'submitOnChange' => true,
		'tl_class'	=> 'clr w50',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_handler'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_handler'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('SolrUtils', 'getSearchHandlerOptions'),
	'eval'			=> array(
		'mandatory'	=> true,
		'includeBlankOption' => true,
// 		'submitOnChange' => true,
		'tl_class'	=> 'w50',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_sources'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_sources'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'options_callback' => array('SolrUtils', 'getSourceOptionsByIndex'),
	'eval'			=> array(
		'mandatory'	=> true,
		'multiple'	=> true,
		'tl_class'	=> 'clr',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_docTypes'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTypes'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'options_callback' => array('SolrUtils', 'getDocumentTypeOptionsByIndex'),
	'eval'			=> array(
		'mandatory'	=> true,
		'multiple'	=> true,
		'tl_class'	=> 'clr',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_tpl'] = array(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_gs_tpl'],
	'exclude'	=> true,
	'inputType'	=> 'select',
	'options_callback' => array('SolrUtils', 'getTplOptions'),
	'eval'		=> array(
		'includeBlankOption' => true,
		'blankOptionLabel' => &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_tpl_blank'],
		'tl_class'		=> 'clr w50'
	),
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
					'readonly'		=> true,
					'style'			=> 'width: 200px;'
				)
			),
			'tpl' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTpl'],
				'inputType'	=> 'select',
				'options_callback' => array('SolrUtils', 'getDocTplOptions'),
				'eval'		=> array(
					'includeBlankOption' => true,
					'blankOptionLabel' => &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_tpl_blank'],
					'style'			=> 'width: 200px;'
				)
			),
			'docType' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docType'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'		=> true,
					'style'			=> 'width: 200px;'
				)
			),
		),
		'buttons'	=> array('up' => false, 'down' => false, 'delete' => false, 'copy' => false),
		'tl_class'	=> 'clr'
	),
	'load_callback' => array(
		array('SolrUtils', 'loadDocTpls'),
	),
	'save_callback' => array(
		array('SolrUtils', 'saveDocTpls'),
	),
	
);
