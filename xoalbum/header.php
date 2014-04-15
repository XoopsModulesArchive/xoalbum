<?php
/**
 * XOOPS xoAlbum management module
 * demo http://www.xoyoke.com/modules/xoalbum/
 *
 * @copyright       The XOOPS project http://code.google.com/p/xoalbum/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since           2.0.0
 * @author          Xiao Hui <xh.8326@gmail.com>
 * @version         $Id$
 * @package         xoAlbum
 */
include "../../mainfile.php";
include dirname(__FILE__)."/include/configs.php";
include dirname(__FILE__)."/include/xoalbum.php";
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include XOOPS_ROOT_PATH."/class/pagenav.php";
$modulenav = array();
$modulenav[] = array("navtitle"=>_ALBUM_HOME,"navlink"=>XOOPS_URL);
$modulenav[] = array("navtitle"=>_ALBUM_NAME,"navlink"=>"index.php");
?>