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
loadModuleAdminMenu(2, "");
$start = isset($_GET["start"]) ? intval($_GET["start"]) : 0;
$album_id = isset($_GET["albumId"]) ? intval($_GET["albumId"]) : 0;
$cat_id = isset($_GET["catId"]) ? intval($_GET["catId"]) : 0;
$limit = 10;

$album_handler = xoops_getmodulehandler("album");
$list = $album_handler->getAlbumList( $cat_id, 0, 0, $start, $limit);

if ( !empty($album_id) ) {
    $album_obj = $album_handler->get($album_id);
}
if ( empty($album_obj) || !is_object($album_obj) ) {
    $album_obj = $album_handler->get();
}
$isNew = $album_obj->isNew();
$album_rows = $album_obj->getValues();

$cat_handler = xoops_getmodulehandler("category");
$_cat_list = $cat_handler->getCatSelect(1);
$formurl = "action.album.php";
include_once(dirname(__FILE__)."../../include/form.album.php");

$xoopsTpl->assign("categories",$_cat_list);
$xoopsTpl->assign(array("albums"=>$list["list"],"pagenav"=>$list["pagenav"]));
$xoopsTpl->display("db:album_cp_album.html");
include "footer.php";
?>