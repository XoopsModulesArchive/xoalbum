CREATE TABLE `album` (
  `album_id`       INT(8)       NOT NULL AUTO_INCREMENT,
  `cat_id`         SMALLINT(6)  NOT NULL,
  `uid`            INT(8)       NOT NULL,
  `album_name`     VARCHAR(64)  NOT NULL,
  `album_desc`     VARCHAR(255) NOT NULL,
  `album_total`    SMALLINT(6)  NOT NULL,
  `album_cover`    VARCHAR(255) NOT NULL,
  `album_views`    SMALLINT(6)  NOT NULL,
  `album_status`   TINYINT(1)   NOT NULL,
  `album_dateline` INT(10)      NOT NULL,
  PRIMARY KEY (`album_id`),
  KEY `cat_id` (`cat_id`),
  KEY `uid` (`uid`)
)
  ENGINE =MyISAM;

CREATE TABLE `category` (
  `cat_id`       SMALLINT(6) NOT NULL AUTO_INCREMENT,
  `cat_name`     VARCHAR(32) NOT NULL,
  `cat_total`    INT(8)      NOT NULL,
  `cat_order`    SMALLINT(6) NOT NULL,
  `cat_dateline` INT(10)     NOT NULL,
  PRIMARY KEY (`cat_id`)
)
  ENGINE =MyISAM;

CREATE TABLE `grid` (
  `grid_id`    INT(8)       NOT NULL AUTO_INCREMENT,
  `uid`        INT(8)       NOT NULL,
  `pic_id`     INT(8)       NOT NULL,
  `grid_title` VARCHAR(120) NOT NULL,
  `grid_data`  VARCHAR(255) NOT NULL,
  `grid_date`  INT(10)      NOT NULL,
  PRIMARY KEY (`grid_id`),
  KEY `uid` (`uid`, `pic_id`)
)
  ENGINE =MyISAM;

CREATE TABLE `picture` (
  `pic_id`          INT(8)       NOT NULL AUTO_INCREMENT,
  `uid`             INT(8)       NOT NULL,
  `album_id`        INT(8)       NOT NULL,
  `pic_name`        VARCHAR(32)  NOT NULL,
  `pic_desc`        VARCHAR(255) NOT NULL,
  `pic_filename`    VARCHAR(255) NOT NULL,
  `pic_filetype`    VARCHAR(64)  NOT NULL,
  `pic_thumbfirst`  VARCHAR(255) NOT NULL,
  `pic_thumbsecond` VARCHAR(255) NOT NULL,
  `pic_size`        INT(8)       NOT NULL,
  `pic_dateline`    INT(10)      NOT NULL,
  `pic_comments`    SMALLINT(6)  NOT NULL,
  `pic_downloads`   SMALLINT(6)  NOT NULL,
  PRIMARY KEY (`pic_id`),
  KEY `album_id` (`album_id`),
  KEY `uid` (`uid`)
)
  ENGINE =MyISAM;
