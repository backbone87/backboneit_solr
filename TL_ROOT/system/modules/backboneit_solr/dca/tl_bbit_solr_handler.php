<?php

$GLOBALS['TL_DCA']['tl_bbit_solr_handler'] = array(

	'config' => array(
		'dataContainer'		=> 'TableExtended',
		'ptable'			=> 'tl_bbit_solr_index',
		'enableVersioning'	=> true,
		'onload_callback'	=> array(
		),
		'onsubmit_callback'	=> array(
		),
	),
	
	'list' => array(
		'sorting' => array(
			'mode'			=> 4,
			'fields'		=> array('endpoint'),
			'panelLayout'	=> 'filter,search,limit',
			'headerFields'	=> array('title', 'url', 'core', 'id'),
			'child_record_callback'   => array('SolrUtils', 'renderHandlerRecord')
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
			'edit' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['edit'],
				'href'	=> 'act=edit',
				'icon'	=> 'edit.gif'
			),
			'copy' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['copy'],
				'href'	=> 'act=copy',
				'icon'	=> 'copy.gif'
			),
			'delete' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['delete'],
				'href'	=> 'act=delete',
				'icon'	=> 'delete.gif',
				'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array(
				'label'	=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['show'],
				'href'	=> 'act=show',
				'icon'	=> 'show.gif'
			)
		),
	),
	
	'palettes' => array(
		'__selector__' => array('handlerClass'),
		
		'default'	=> '{general_legend}'
			. ',handlerClass'
			,
		
		'SolrGenericRequestHandler'	=> '{general_legend}'
			. ',endpoint'
			. ',handlerClass,queryClass'
			. ',solrClass'
			,
	),
	
	'subpalettes' => array(
	),
	
	'fields' => array(
		
		'endpoint' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['endpoint'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array(
				'mandatory'			=> true,
				'maxlength'			=> 1022,
				'decodeEntities'	=> true,
				'tl_class'			=> 'clr long'
			)
		),
		'handlerClass' => array (
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['handlerClass'],
			'exclude'		=> false,
			'default'		=> 'SolrGenericRequestHandler',
			'filter'		=> true,
			'inputType'		=> 'select',
			'options'		=> $GLOBALS['BBIT_SOLR']['HANDLER'],
			'reference'		=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['sourceOptions'],
			'eval'			=> array(
				'mandatory'			=> true,
				'submitOnChange'	=> true,
				'tl_class'			=> 'clr w50'
			)
		),
		'queryClass' => array (
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['handlerClass'],
			'exclude'		=> false,
// 			'default'		=> 'SolrGenericRequestHandler',
			'filter'		=> true,
			'inputType'		=> 'select',
			'options'		=> $GLOBALS['BBIT_SOLR']['HANDLER'],
			'reference'		=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['sourceOptions'],
			'eval'			=> array(
				'mandatory'			=> true,
				'tl_class'			=> 'w50'
			)
		),
		'solrClass' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_solr_handler']['solrClass'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array(
				'maxlength'			=> 1022,
				'decodeEntities'	=> true,
				'tl_class'			=> 'clr long'
			)
		),
		
		'format' => array (
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_mm_captions']['format'],
			'exclude'		=> false,
			'default'		=> 'auto',
			'filter'		=> true,
			'inputType'		=> 'select',
			'options'		=> array('auto', 'srt', 'ttml'),
			'reference'		=> &$GLOBALS['TL_LANG']['tl_bbit_mm_captions']['formatOptions'],
			'eval'			=> array(
				'mandatory'			=> true,
				'tl_class'			=> 'w50'
			)
		),
		'local' => array (
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_mm_captions']['local'],
			'exclude'		=> false,
			'inputType'		=> 'fileTree',
			'eval'			=> array(
				'mandatory'			=> true,
				'fieldType'			=> 'radio',
				'files'				=> true,
				'filesOnly'			=> true,
				'extensions'		=> 'srt,ttml,xml',//srt -> application/x-subrip, application/ttml+xml
				'tl_class'			=> 'clr'
			)
		),
		'external' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_bbit_mm_captions']['external'],
			'exclude'		=> false,
			'inputType'		=> 'text',
			'eval'			=> array(
				'mandatory'			=> true,
				'maxlength'			=> 1023,
				'rgxp'				=> 'url',
				'tl_class'			=> 'clr long',
				'decodeEntities'	=> true
			)
		)
		
	)
);
	