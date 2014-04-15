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
$op = isset($_POST["op"]) ? trim($_POST["op"]) : "";
$ac = isset($_POST["ac"]) ? trim($_POST["ac"]) : "";

$album_handler = xoops_getmodulehandler("album");

switch ($op) {
    case "album":
        if ( !$GLOBALS['xoopsSecurity']->check() ) {
            redirect_header("category.php", 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $cat_id = isset($_POST["cat_id"]) ? intval($_POST["cat_id"]) : 0;
        $album_name = isset($_POST["album_name"]) ? trim($_POST["album_name"]) : "";
        $album_desc = isset($_POST["album_desc"]) ? trim($_POST["album_desc"]) : "";
        $album_state = isset($_POST["album_state"]) ? intval($_POST["album_state"]) : 0;
        if ( empty($cat_id) || empty($album_name) ) {
            redirect_header("album.php", 5, _AM_ERROR_FORM_ALBUM);
        }
        switch ($ac) {
            case "edit":
                $album_id = isset($_POST["album_id"]) ? trim($_POST["album_id"]) : 0;
                if ( $album_id = $album_handler->setAlbum($album_id, $cat_id, $xoopsUser->getVar("uid"), $album_name, $album_desc, $album_state) ) {
                    redirect_header("album.php", 5, _AM_SUCCEED);
                }
                redirect_header("album.php", 5, _AM_FAILED);
            break;
            
            default:
            case "create":
                $album_id = 0;
                if ( $album_id = $album_handler->setAlbum($album_id, $cat_id, $xoopsUser->getVar("uid"), $album_name, $album_desc, $album_state) ) {
                    $cat_handler = xoops_getmodulehandler("category");
                    $cat_handler->setCatAmount($cat_id,1);
                    redirect_header("album.php", 5, _AM_SUCCEED);
                }
                redirect_header("album.php", 5, _AM_FAILED);
            break;
        }
    break;
    
    default:
        redirect_header("index.php");
    break;
}
?>