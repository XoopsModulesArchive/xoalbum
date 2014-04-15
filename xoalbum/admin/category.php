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
loadModuleAdminMenu(1, "");
$cat_handler = xoops_getmodulehandler("category");
$cat_id = isset($_GET["cat_id"]) ? intval($_GET["cat_id"]) : 0;
if ( !empty($cat_id) ) {
    $cat_obj = $cat_handler->get($cat_id);
}
if ( empty($cat_obj) || !is_object($cat_obj) ) {
    $cat_obj = $cat_handler->get();
}
$isNew = $cat_obj->isNew();
$cat_rows = $cat_obj->getValues();
include_once(dirname(__FILE__)."../../include/form.category.php");
$xoopsTpl->assign("categories",$cat_handler->getCatList());
$xoopsTpl->display("db:album_cp_category.html");
include "footer.php";
?>