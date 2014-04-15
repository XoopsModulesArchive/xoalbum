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

$msg = array();
if ( empty($xoopsUser) || !is_object($xoopsUser) ) {
    $msg[] = _NOPERM ; break;
}
if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
} else {
    if (!$GLOBALS["xoopsSecurity"]->check()) {
        $msg[] = "页面过期，请重新提交" ; break;
    }
}
switch ($ac) {
    case "delete":
        $album_id = isset($_POST["album_id"]) ? intval($_POST["album_id"]) : 0;
        $album_obj = $album_handler->get($album_id);
        if ( !is_object($album_obj) && $album_obj->uid() != $xoopsUser->uid() ) {
            $msg[] = _ALBUM_UPLOADS_NOPERM ; break;
        }
        $cat_id = $album_obj->getVar("cat_id");
        if ( $album_handler->delAlbum($album_id) ) {
            $cat_handler = xoops_getmodulehandler("category");
            $cat_handler->updateCatTotal($cat_id,-1);
            
            $picture_handler = xoops_getmodulehandler("picture");
            $picture_handler->delPictures($album_id);
            
        	$json = array(
        	   "status"=>"200",
        	   "message"=>_ALBUM_SUCCEED,
        	   "albumid"=>$album_id
        	);
        	echo json_encode($json);
        	exit;
        }
        $msg[] = _ALBUM_SAVE_FAILED;
        break;
    case "cover":
        $album_id = isset($_POST["album_id"]) ? intval($_POST["album_id"]) : 0;
        $pic_id = isset($_POST["album_cover"]) ? intval($_POST["album_cover"]) : 0;
        $album_obj = $album_handler->get($album_id);
        if ( !is_object($album_obj) && $album_obj->uid() != $xoopsUser->uid() ) {
            $msg[] = _ALBUM_UPLOADS_NOPERM ; break;
        }
        $picture_handler = xoops_getmodulehandler("picture");
        $pic_obj = $picture_handler->get($pic_id);
        if ( !is_object($pic_obj) ) {
            $msg[] = "图片不存在或是被删除!";break;
        }
        if ( $album_handler->updateAlbumCover($album_id,$pic_obj->getVar("pic_thumbsecond","n")) ) {
        	$json = array(
        	   "status"=>"200",
        	   "message"=>_ALBUM_SUCCEED,
        	   "image"=>XOOPS_UPLOAD_URL."/".$pic_obj->getVar("pic_thumbsecond","n")
        	);
        	echo json_encode($json);
        	exit;
        }
        $msg[] = _ALBUM_SAVE_FAILED;
        break;
    case "edit":
        $cat_id = isset($_POST["cat_id"]) ? intval($_POST["cat_id"]) : 0;
        $album_id = isset($_POST["album_id"]) ? intval($_POST["album_id"]) : 0;
        $album_obj = $album_handler->get($album_id) ;
        if ( $album_obj->getVar("uid") != $xoopsUser->getVar("uid") ) {
            $msg[] = _ALBUM_UPLOADS_NOPERM; break;
        }
        if ( $album_id = $album_handler->setAlbum($params) ) {
            if ( $cat_id != $album_obj->getVar("cat_id") ) {
                $cat_handler->updateCatTotal($cat_id,1);
                $cat_handler->updateCatTotal($album_obj->getVar("cat_id"),-1);
            }
            break;
        }
        $msg[] = _ALBUM_SAVE_FAILED;
        break;
    case "create":
        $err = xoAlbum::checkSubmitFields("album",$_POST,false);
        if ( true !== $err ) {
            $msg[] = $err ;
            break;
        }
        $criteria = array(
            'criteria' => array(
                'uid' => (int)$xoopsUser->uid(),
                'cat_id' => $params["cat_id"],
                'album_name' => $params["album_name"],
            ),
        );
        $total = $album_handler->getAlbums($criteria);
        if ( !empty($total) ) {
            $msg[] = _ALBUM_SAVE_FAILED ;
            break;
        }
        $params["uid"] = (int)$xoopsUser->uid();
        if ( $album_id = $album_handler->setAlbum($params) ) {
            $cat_handler->updateCatTotal($params["cat_id"],1);
            break;
        }
    	$msg[] = _ALBUM_SAVE_FAILED;
        break;
    default:
        $msg[] = "not params";
}