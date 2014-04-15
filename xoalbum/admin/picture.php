<?php
/**
 * XOOPS photo management module
 *
 * @copyright       The XOOPS project http://sourceforge.net/projects/xoops/ 
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since           1.0.0
 * @author          Xiao Hui <xh.8326@gmail.com>
 * @version         $Id$
 * @package         xoAlbum
 */
include "header.php";
$start = isset($_GET["start"]) ? intval($_GET["start"]) : 0;
$album_id = isset($_GET["albumId"]) ? intval($_GET["albumId"]) : 0;
if ( empty($album_id) ) redirect_header("album.php");
$limit = 10;

$picture_handler = xoops_getmodulehandler("picture");
$album_handler = xoops_getmodulehandler("album");

$album_obj = $album_handler->get($album_id);
$album = $album_obj->getValues();
$album["album_dateline"] = formatTimestamp($album["album_dateline"]);
$cat_handler = xoops_getmodulehandler("category");
$cat_obj = $cat_handler->get($album_obj->getVar("cat_id"));
$album["cat_name"] = $cat_obj->getVar("cat_name","n");
$album["state"] = $album_obj->getVar("album_state") ? _AM_ALBUM_STATE1 : _AM_ALBUM_STATE0 ;
$album["cover"] = !empty($album["album_cover"]) ? "<img src=\"".XOOPS_UPLOAD_URL."/{$album["album_cover"]}\" alt=\"\" />" : "<img src=\"".XOOPS_UPLOAD_URL."/album.gif\" alt=\"\" />" ;

$list = $picture_handler->getPictureList($album_id, $start, $limit );
$albums = $album_handler->getOtherAlbums($album_id);

$cat_handler = xoops_getmodulehandler("category");
$_cat_list = $cat_handler->getCatSelect();

$xoopsTpl->assign(array("pictures"=>$list["list"],"pagenav"=>$list["pagenav"],"album"=>$album,"albums"=>$albums,"categories"=>$_cat_list));
$xoopsTpl->display("db:album_cp_picture.html");
include "footer.php";
?>