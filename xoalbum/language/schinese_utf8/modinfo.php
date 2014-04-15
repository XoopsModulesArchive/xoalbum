<?php
/**
 * Tag management for XOOPS
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		tag
 */
if (!defined('XOOPS_ROOT_PATH')) { exit(); }
// MENU
define("_AM_HOME", "首页");
define("_AM_CATEGORY", "分类");
define("_AM_ALBUM", "相册");
define("_AM_PICTURE", "图片");
define("_AM_COMMENTS", "评论");

define("ALBUM_MI_NAME", "相册");
define("ALBUM_MI_DESC", "为XOOPS3提供图片、像册管理功能。");

define("ALBUM_MI_MYALBUM", "我的相册");


define("ALBUM_MI_ISUSERCREATE", "是否允许用户创建相册");
define("ALBUM_MI_ISUSERCREATE_DESC", "其他用户是否可以创建自己的相册。");

define("ALBUM_MI_PICTURESIZE", "图片上传的大小");
define("ALBUM_MI_PICTURESIZE_DESC", "图片上传的大小，单位b");

define("ALBUM_MI_THUMB1WH", "一次缩略图的宽度、高度");
define("ALBUM_MI_THUMB1WH_DESC", "宽度、高度用“|”隔开,如: 640|640。");

define("ALBUM_MI_THUMB2WH", "二次缩略图的宽度、高度");
define("ALBUM_MI_THUMB2WH_DESC", "宽度、高度用“|”隔开,如: 80|80。");

define("ALBUM_MI_UPLOADSNUM", "附件上传的数量");
define("ALBUM_MI_UPLOADSNUM_DESC", "传统上传，每次上传的最多附件数量。");
// for blocks 
define("ALBUM_MI_BLOCK_NEWPICTURE","最新上传");
define("ALBUM_MI_BLOCK_NEWPICTURE_DESC","");
?>