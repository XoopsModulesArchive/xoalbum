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
define("_ALBUM_HOME", "首页");
define("_ALBUM_NAME", "相册");
define("_ALBUM_UPLOAD", "上传");
define("_ALBUM_UPLOAD_PICTURE", "上传图片");
define("_MA_ALBUM_MANAGE_ALBUM", "管理相册");
define("_ALBUM_CATEGORY", "分类");
define("_ALBUM_VIEWS", "查看");
define("_ALBUM_CREATE_ALBUM", "创建相册");
define("_ALBUM_PICTURE_LIST", "图片%s");
define("_ALBUM_INFO", "相册信息");
define("_ALBUM_UPLOADS_METHOD", "上传方式");
define("_ALBUM_UPLOADS_METHOD_OLD", "传统方式");
define("_ALBUM_UPLOADS_METHOD_FLASH", "批量上传");
define("_ALBUM_MYALBUM", "我的相册");
define("_ALBUM_PICTURE_NAME", "图片名称");
define("_ALBUM_MYALBUM_OTHER", "我的另外相册");
define("_ALBUM_USERALBUM_OTHER", "TA的另外相册");
define("_ALBUM_CREATE_ALBUM_DESC", "您好，您可以创建自己的相册，把您美丽的漂亮的照片用XoAlbum这个模块管理起来，请点击下面的按钮创建相册。");
define("_ALBUM_LIST_ALBUM_DESC", "选择图片名称的单选按钮，您可以设置相册的封面图片！");
define("_ALBUM_PICTURE_NO_DESC", "这张图片没有填写描述，点击这可增加！");
define("_ALBUM_COMMENTS", "评论");
define("_ALBUM_THUMB", "缩图");
define("_ALBUM_INFO", "信息");
define("_ALBUM_DOWNLOAD", "下载");
define("_ALBUM_DESC", "描述");
define("_ALBUM_DATE", "时间");
define("_ALBUM_AUTHOR", "上传");
define("_ALBUM_PICTURE_SIZE", "图片大小");
define("_ALBUM_PICTURE_DOWNLOAD", "下载原图");
define("_ALBUM_CATEGORY_OTHER_ALBUM", "同分类其他相册");
define("_ALBUM_CATEGORY_NO_ALBUM", "此分类下还没有相册");
define("_ALBUM_STATE", "状态");
define("_ALBUM_NO_USE", "此功能暂时还不使用");

define("_ALBUM_NOPICTURE", "抱歉，这个相册还没有上传照片！");
define("_ALBUM_NOALBUM", "抱歉，您还没有创建任何相册！");
define("_ALBUM_UPLOADS_NOPERM", "抱歉，上传目录没有权限！");
define("_ALBUM_UPLOADS_NUM", "共上传了 %s 张图片");
define("_ALBUM_HOT_ALBUM", "热门相册");
define("_ALBUM_HOT_PICTURE", "发烧相片");
define("_ALBUM_NEW_PICTURE", "最新上传");
define("_ALBUM_FROM", "于");
define("_ALBUM_SAYS", "写道");
define("_ALBUM_SAVE_SUCCEED", "保存成功");
define("_ALBUM_SAVE_FAILED", "保存失败，<small>(*)</small>项必须填写或有同名相册存在。");
define("_ALBUM_NOPERM_ACCESS", "抱歉，这个相册不可以公共访问。");
define("_ALBUM_SELECT_IMAGES", "选择文件");
define("_ALBUM_SELECT_IMAGE_SIZE", "&nbsp;单文件最大为2MB");
define("_ALBUM_DELETE_ALBUM", "确定删除 <strong>%s</strong> 这个相册? <br />此相册共有 <strong>%s</strong> 张图片！");
define("_ALBUM_DELETE_PICTURE", "确定删除 <strong>%s</strong> 这张照片? <br />此照片共有 <strong>%s</strong> 条评论！");

define("_ALBUM_SUCCEED", "该提交执行成功!");
define("_ALBUM_FAILED", "抱歉，该提交执行失败!");
define("_ALBUM_COVER_SUCCEED", "封面重新设置成功!");
define("_ALBUM_COVER_FAILED", "封面重新设置失败!");
define("_ALBUM_REFRESH", "刷新");

define("_AM_ALBUM_STATE0", "私人");
define("_AM_ALBUM_STATE1", "公开");
?>