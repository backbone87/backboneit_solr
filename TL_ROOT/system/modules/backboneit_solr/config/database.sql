-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

CREATE TABLE `tl_bbit_solr_index` (

  `id` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  
  `title` varchar(255) NOT NULL default '',
  `url` varchar(1022) NOT NULL default '',
  `core` varchar(1022) NOT NULL default '',
  
  `sources` blob NULL,
  
  PRIMARY KEY  (`id`),
  KEY `tstamp` (`tstamp`),
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_bbit_solr_handler` (

  `id` int(10) unsigned NOT NULL default '0',
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  
  `handlerClass` varchar(1022) NOT NULL default '',
  `queryClass` varchar(1022) NOT NULL default '',
  `endpoint` varchar(1022) NOT NULL default '',
  `solrClass` varchar(1022) NOT NULL default '',
  
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `tstamp` (`tstamp`),
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_bbit_solr_page` (

  `page` int(10) unsigned NOT NULL default '0',
  `hash` char(32) NOT NULL default '',
  `base` varchar(1024) NOT NULL default '',
  `request` varchar(1024) NOT NULL default '',
  `root` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  
  PRIMARY KEY  (`page`, `hash`),
  KEY `tstamp` (`tstamp`),
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_module` (

  `bbit_solr_tpl` varchar(255) NOT NULL default '',
	
  `bbit_solr_rememberQuery` char(1) NOT NULL default '',
  `bbit_solr_autocomplete` char(1) NOT NULL default '',
  `bbit_solr_filter` blob NULL,
  `bbit_solr_target` int(10) unsigned NOT NULL default '0',
  `bbit_solr_live` char(1) NOT NULL default '',
  `bbit_solr_liveTarget` int(10) unsigned NOT NULL default '0',
  
  `bbit_solr_copy` varchar(255) NOT NULL default 'bbit_solr_nocopy',
  `bbit_solr_index` varchar(255) NOT NULL default '',
  `bbit_solr_handler` varchar(255) NOT NULL default '',
  `bbit_solr_sources` blob NULL,
  `bbit_solr_keywordSplit` varchar(255) NOT NULL default '',
  `bbit_solr_keywordSplitRaw` varchar(255) NOT NULL default '',
  `bbit_solr_keywordMinLength` int(10) unsigned NOT NULL default '0',
  `bbit_solr_prep` varchar(255) NOT NULL default '',
  `bbit_solr_docTypes` blob NULL,
  `bbit_solr_perPage` int(10) unsigned NOT NULL default '0',
  `bbit_solr_maxPages` int(10) unsigned NOT NULL default '0',
  `bbit_solr_grouping` blob NULL,
  `bbit_solr_docTpls` blob NULL,
  `bbit_solr_showOnEmpty` char(1) NOT NULL default '',
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
