<?php

$this->loadLanguageFile('bbit_solr');

$GLOBALS['TL_DCA']['tl_bbit_solr_index'] = array(

	'config' => array(
		'dataContainer'		=> 'TableExtended',
		'ctable'			=> array('tl_bbit_solr_handler'),
		'enableVersioning'	=> true,
		'onload_callback'	=> array(
		),
		'onsubmit_callback'	=> array(
// 			array('SolrUtils', ''),
		),
	),
	
	'list' => array(
		'sorting' => array(
			'mode'			=> 2,
			'fields'		=> array('title'),
			'panelLayout'	=> 'filter,limit;search,sort',
			'disableGrouping' => true,
		),
		'label' => array(
			'fields'		=> array('title', 'url', 'core'),
			'format'		=> '%s <span style="color:#b3b3b3;padding-left:3px">[%s%s]</span>',
//			'label_callback' => array('SolrUtils', 'renderLabel'),
		),
		'global_operations' => array(
			'all' => array(
				'label'	=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'	=> 'act=select',
				'class'	=> 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array(
			'update' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['update'],
				'href'	=> 'key=update',
				'icon'	=> 'reload.gif',
				'button_callback' => array('SolrUtils', 'buttonUpdate'),
			),
			'edit' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['edit'],
				'href'	=> 'act=edit',
				'icon'	=> 'edit.gif'
			),
			'copy' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['copy'],
				'href'	=> 'act=copy',
				'icon'	=> 'copy.gif'
			),
			'delete' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['delete'],
				'href'	=> 'act=delete',
				'icon'	=> 'delete.gif',
				'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['show'],
				'href'	=> 'act=show',
				'icon'	=> 'show.gif'
			)
		),
	),
	
	'palettes' => array(
		'__selector__' => array(),
		
		'default'	=> '{general_legend},title'
			. ',url'
			. ',core'
			. ';{sources_legend}'
			. ',sources'
			,
		
	),
	
	'subpalettes' => array(
	),
	
	'fields' => array(
		
		'title' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['title'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array(
				'mandatory'			=> true,
				'maxlength'			=> 255,
				'tl_class'			=> 'clr long'
			)
		),
		'url' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['url'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array(
				'mandatory'			=> true,
				'maxlength'			=> 1022,
				'decodeEntities'	=> true,
				'tl_class'			=> 'clr long'
			)
		),
		'core' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['core'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array(
				'mandatory'			=> true,
				'maxlength'			=> 1022,
				'decodeEntities'	=> true,
				'tl_class'			=> 'clr w50'
			)
		),
		
		
		'sources' => array (
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_solr_index']['type'],
			'filter'		=> true,
			'inputType'		=> 'select',
			'options_callback' => array('SolrUtils', 'getSourceOptions'),
			'eval'			=> array(
				'multiple'			=> true,
				'size'				=> 10,
				'chosen'			=> true,
				'tl_class'			=> ''
			),
			'load_callback'	=> array(
				array('SolrUtils', 'loadCSL'),
			),
			'save_callback'	=> array(
				array('SolrUtils', 'saveCSL'),
			),
		),
		
	)
);
	