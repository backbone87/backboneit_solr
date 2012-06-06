-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

CREATE TABLE `tl_bbit_solr_page` (

  `page` int(10) unsigned NOT NULL default '0',
  `url` varchar(1024) NOT NULL default '',
  `root` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  
  PRIMARY KEY  (`page`, `url`(54)),
  KEY `tstamp` (`tstamp`),
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_module` (

  `bbit_solr_copy` varchar(255) NOT NULL default 'bbit_solr_nocopy',
  `bbit_solr_index` varchar(255) NOT NULL default '',
  `bbit_solr_handler` varchar(255) NOT NULL default '',
  `bbit_solr_sources` blob NULL,
  `bbit_solr_docTypes` blob NULL,
  `bbit_solr_tpl` varchar(255) NOT NULL default '',
  `bbit_solr_docTpls` blob NULL,
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
