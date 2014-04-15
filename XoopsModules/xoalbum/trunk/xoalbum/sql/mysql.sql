CREATE TABLE `album_album` (
  `album_id` int(8) NOT NULL auto_increment,
  `cat_id` smallint(6) NOT NULL,
  `uid` int(8) NOT NULL,
  `album_name` varchar(64) NOT NULL,
  `album_desc` varchar(255) NOT NULL,
  `album_total` smallint(6) NOT NULL,
  `album_cover` varchar(255) NOT NULL,
  `album_views` smallint(6) NOT NULL,
  `album_status` tinyint(1) NOT NULL,
  `album_dateline` int(10) NOT NULL,
  PRIMARY KEY  (`album_id`),
  KEY `cat_id` (`cat_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM ;

CREATE TABLE `album_category` (
  `cat_id` smallint(6) NOT NULL auto_increment,
  `cat_name` varchar(32) NOT NULL,
  `cat_total` int(8) NOT NULL,
  `cat_order` smallint(6) NOT NULL,
  `cat_dateline` int(10) NOT NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM ;

CREATE TABLE `album_grid` (
  `grid_id` int(8) NOT NULL auto_increment,
  `uid` int(8) NOT NULL,
  `pic_id` int(8) NOT NULL,
  `grid_title` varchar(120) NOT NULL,
  `grid_data` varchar(255) NOT NULL,
  `grid_date` int(10) NOT NULL,
  PRIMARY KEY  (`grid_id`),
  KEY `uid` (`uid`,`pic_id`)
) ENGINE=MyISAM ;

CREATE TABLE `album_picture` (
  `pic_id` int(8) NOT NULL auto_increment,
  `uid` int(8) NOT NULL,
  `album_id` int(8) NOT NULL,
  `pic_name` varchar(32) NOT NULL,
  `pic_desc` varchar(255) NOT NULL,
  `pic_filename` varchar(255) NOT NULL,
  `pic_filetype` varchar(64) NOT NULL,
  `pic_thumbfirst` varchar(255) NOT NULL,
  `pic_thumbsecond` varchar(255) NOT NULL,
  `pic_size` int(8) NOT NULL,
  `pic_dateline` int(10) NOT NULL,
  `pic_comments` smallint(6) NOT NULL,
  `pic_downloads` smallint(6) NOT NULL,
  PRIMARY KEY  (`pic_id`),
  KEY `album_id` (`album_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;