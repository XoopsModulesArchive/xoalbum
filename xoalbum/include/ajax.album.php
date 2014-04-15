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
 * @subpackage      include
 */
if ( !defined("XOOPS_ROOT_PATH") ) die('XOOPS root path not defined');

switch ($ac){
    case "delete":
        $album_id = isset($_GET["albumId"]) ? intval($_GET["albumId"]) : 0;
        $album_obj = $album_handler->get($album_id);
        if ( !is_object($album_obj) && $album_obj->uid() != $xoopsUser->uid() ) {
            echo _NOPERM;
            exit();
        }
        $form = new XoopsForm("", "form", $formurl, "post",true);
        $form->addElement( new XoopsFormLabel("","确定删除 [{$album_obj->name()}] 这个相册 !"));
        $form->addElement( new XoopsFormHidden("op","album"));
        $form->addElement( new XoopsFormHidden("ac","delete"));
        if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
        	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
        } else {
            $form->addElement( new XoopsFormButton("","submit",_DELETE,"submit"));
        }
        $form->assign($xoopsTpl);
        break;
    case "edit":
    case "create":
        $album_id = isset($_GET["albumId"]) ? intval($_GET["albumId"]) : 0;
        $album_obj = empty($album_id) ? $album_handler->get() : $album_handler->get($album_id);
        if ( !is_object($album_obj) ) {
            echo _NOPERM;
            exit();
        }
        $isnew = $album_obj->isNew();
        $album = $album_obj->getValues();
        $categories = $cat_handler->getCatList();
        
        $formurl = "action.php";
        include(dirname(__FILE__)."/form.album.php");
        break;
    default:
        echo "not params";
}