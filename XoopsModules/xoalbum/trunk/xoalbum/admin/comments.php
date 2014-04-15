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
loadModuleAdminMenu(3, "");
$start = isset($_GET["start"]) ? intval($_GET["start"]) : 0;
$pic_id = isset($_GET["picId"]) ? intval($_GET["picId"]) : 0;
$limit = 20;
$comment_handler = xoops_getmodulehandler("comment");
$list = $comment_handler->getCommentsList($pic_id, 0, $start, $limit);
$xoopsTpl->assign(array("pagenav"=>$list["pagenav"],"comments"=>$list["list"]));
$xoopsTpl->display("db:album_cp_comments.html");
include "footer.php";
?>