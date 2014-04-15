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
loadModuleAdminMenu(0, "");
$cat_handler = xoops_getmodulehandler("category");
$album_handler = xoops_getmodulehandler("album");
$picture_handler = xoops_getmodulehandler("picture");
// get new pictures
$new_pictures = $picture_handler->getPictureNew(20);
// get category list
$categories = $cat_handler->getCatList();
$xoopsTpl->assign("categories",$categories);
$xoopsTpl->assign("new_pictures",$new_pictures);
$xoopsTpl->display("db:album_cp_index.html");
include "footer.php";
?>