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
include "header.php";
include XOOPS_ROOT_PATH."/class/template.php";
$xoopsLogger->activated = false;
$op = isset($_REQUEST["op"]) ? trim($_REQUEST["op"]) : "";
$ac = isset($_REQUEST["ac"]) ? trim($_REQUEST["ac"]) : "";
if ( empty($xoopsUser) || !is_object($xoopsUser) ) {
    echo _NOPERM;
    exit;
}
switch ($op){
    case "album":
        $xoopsTpl = new XoopsTpl();
        xoops_loadLanguage("admin","xoalbum");
        $album_handler = xoops_getmodulehandler("album");
        $cat_handler = xoops_getmodulehandler("category");
        switch ($ac){
            case "delete":
                $album_id = isset($_GET["albumId"]) ? intval($_GET["albumId"]) : 0;
                $album_obj = $album_handler->get($album_id);
                if ( !is_object($album_obj) && $album_obj->uid() != $xoopsUser->uid() ) {
                    echo _NOPERM;
                    exit();
                }
                $form = new XoopsForm("", "form", "action.php", "post",true);
                $form->addElement( new XoopsFormLabel("","确定删除 [{$album_obj->name()}] 这个相册 !"));
                $form->addElement( new XoopsFormHidden("album_id",$album_id));
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
                include(dirname(__FILE__)."/include/form.album.php");
                break;
            default:
                echo "not params";
        }
        $xoopsTpl->display("db:album_form.html");
        break;
    case "category":
        include(dirname(__FILE__)."/include/ajax.category.php");
        break;
    case "picture":
        $xoopsTpl = new XoopsTpl();
        $album_handler = xoops_getmodulehandler("album");
        $picture_handler = xoops_getmodulehandler("picture");
        $album_id = isset($_GET["albumId"]) ? intval($_GET["albumId"]) : 0;
        $pic_id = isset($_GET["picId"]) ? intval($_GET["picId"]) : 0;
        $album_obj = $album_handler->get($album_id);
        if ( !is_object($album_obj) && $album_obj->uid() != $xoopsUser->uid() ) {
            echo _NOPERM;
            exit();
        }
        switch ($ac){
            case "delete":
                $pic_obj = $picture_handler->get($pic_id);
                if ( !is_object($pic_obj) || $pic_obj->isNew() ) {
                    echo "不存在的图片";
                    exit();
                }
                $form = new XoopsForm("", "form", "action.php", "post",true);
                $form->addElement( new XoopsFormLabel("","确定删除 [{$pic_obj->name()}] 这张图片 !"));
                $form->addElement( new XoopsFormHidden("pic_id",$pic_id));
                $form->addElement( new XoopsFormHidden("album_id",$album_id));
                $form->addElement( new XoopsFormHidden("op","picture"));
                $form->addElement( new XoopsFormHidden("ac","delete"));
                if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
                	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
                } else {
                    $form->addElement( new XoopsFormButton("","submit",_DELETE,"submit"));
                }
                $form->assign($xoopsTpl);
                break;
            case "edit":
                $pic_obj = $picture_handler->get($pic_id);
                if ( !is_object($pic_obj) ) {
                    echo "不存在的图片";
                    exit();
                }
                $form = new XoopsForm("", "form", "action.php", "post",true);
                $form->addElement( new XoopsFormText("名称","pic_name",24,32,$pic_obj->name()));
                $form->addElement( new XoopsFormTextArea("描述","pic_desc",$pic_obj->getVar("pic_desc"),4,32));
                $form->addElement( new XoopsFormHidden("pic_id",$pic_id));
                $form->addElement( new XoopsFormHidden("album_id",$album_id));
                $form->addElement( new XoopsFormHidden("op","picture"));
                $form->addElement( new XoopsFormHidden("ac","edit"));
                if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
                	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
                } else {
                    $form->addElement( new XoopsFormButton("","submit",_DELETE,"submit"));
                }
                $form->assign($xoopsTpl);
                break;
            default:
                echo "no params";
        }
        $xoopsTpl->display("db:album_form.html");
//        include(dirname(__FILE__)."/include/ajax.picture.php");
        break;
    default:
        die("no params");
}