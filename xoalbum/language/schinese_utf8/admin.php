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
define('_AM_RUSUREDEL',"是否删除 %S") ;

// for category
define("_AM_CATEGORY_NAME", "分类");
define("_AM_CATEGORY_ORDER", "排序");
define("_AM_CREATE_DATE", "创建时间");
define("_AM_OPERATION", "操作");
define("_AM_CONTENT", "内容");
define("_AM_STATISTICS", "简单统计"); 
// for album
define("_AM_ALBUM_NAME", "名称");
define("_AM_ALBUM_DESC", "描述");
define("_AM_ALBUM_COVER", "封面");
define("_AM_ALBUM_VIEWS", "查看");
define("_AM_ALBUM_STATE", "状态");
define("_AM_ALBUM_STATE0", "私人");
define("_AM_ALBUM_STATE1", "公开");
define("_AM_OTHER_ALBUM_NAME", "同分类其他相册");
define("_AM_ALBUM_COMMENTS", "评论");
define("_AM_ALBUM_NEW_PICTURE", "最新上传");
// error
define("_AM_ERROR_NOCATNAME", "错误,分类名不能为空");
define("_AM_ERROR_FORM_ALBUM", "错误，请选择分类或相册名称不能为空！");
define("_AM_SUCCEED", "该提交执行成功!");
define("_AM_FAILED", "抱歉，该提交执行失败!");
?>