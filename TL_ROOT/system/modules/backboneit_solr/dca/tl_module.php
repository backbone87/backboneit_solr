<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'bbit_solr_copy';
	
$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_solr_search']
	= '{title_legend},name,bbit_solr_copy,headline,type'
	. ';{bbit_solr_tpl_legend}'
	. ',bbit_solr_tpl'
	. ',bbit_solr_docTpls'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space'
	;
	
$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_solr_searchnocopy']
	= '{title_legend},name,bbit_solr_copy,headline,type'
	. ';{bbit_solr_source_legend}'
	. ',bbit_solr_index,bbit_solr_source'
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
		'tl_class'	=> 'clr',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_sources'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_sources'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'options_callback' => array('SolrUtils', 'getSourceOptionsByIndex'),
	'eval'			=> array(
		'tl_class'	=> 'clr',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_docTypes'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTypes'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'options_callback' => array('SolrUtils', 'getDocumentTypeOptionsByIndex'),
	'eval'			=> array(
		'tl_class'	=> 'clr',
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_tpl'] = array(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_gs_tpl'],
	'exclude'	=> true,
	'inputType'	=> 'select',
	'options_callback' => array('SolrUtils', 'getTplOptions'),
	'eval'		=> array(
		'tl_class'		=> 'clr w50'
	),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_solr_docTpls'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTpls'],
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'docType' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docType'],
				'inputType'	=> 'text',
				'options_callback' => array('SolrUtils', 'getDocumentTypeOptionsByIndex'),
				'eval'		=> array(
					'readonly'		=> true,
					'style'			=> 'width: 250px;'
				)
			),
			'tpl' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_solr_docTpl'],
				'inputType'	=> 'select',
				'options_callback' => array('SolrUtils', 'getDocTplOptions'),
				'eval'		=> array(
					'rgxp'			=> 'digit',
					'style'			=> 'width: 250px;'
				)
			),
		),
		'buttons'	=> array('up' => false, 'down' => false, 'delete' => false, 'copy' => false),
		'tl_class'	=> 'clr'
	),
	'load_callback' => array(
		array('SolrUtils', 'loadDocTpls'),
	),
	
);
