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
$xoopsLogger->activated = false;
$ts =  MyTextSanitizer::getInstance();
$op = isset($_REQUEST["op"]) ? trim($_REQUEST["op"]) : "";
$ac = isset($_POST["ac"]) ? trim($_POST["ac"]) : "";
$redirect_url = isset($_POST["redirect_url"]) ? $ts->stripSlashesGPC($redirect_url) : "index.php";

switch ($op){
    case "grid":
        $info = array();
        if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
        	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
        	
        } else {
            if (!$GLOBALS["xoopsSecurity"]->check()) {
                redirect_header($redirect_url, 3, implode("<br />", 
                                $GLOBALS["xoopsSecurity"]->getErrors()));
            }
        }
        if ( empty($xoopsUser) || !is_object($xoopsUser) ) {
            $info[] = "需要登陆，才能使用这个功能!";
        }
        extract($_POST);
        if ( !$x1 || !$y1 || !$x2 || !$y2 || !$w || !$h || !$grid_title || !$pic_id ) {
            $info[] = "选择有误，请重新选择!";
        }
        
        if ( $info ) {
            $ret = array("status"=>"100","message"=>implode("<br />", $info));
            echo json_encode($ret);
            exit;
        }
        $params = array(
            "grid_title"=> $grid_title,
            "grid_data"=> array("x1"=>$x1,"y1"=>$y1,"x2"=>$x2,"y2"=>$y2,"w"=>$w,"h"=>$h),
            "uid"=>(int)$xoopsUser->uid(),
            "pic_id"=>(int)$pic_id
        );
        $grid_handler = xoops_getmodulehandler("grid");
        if ( $id = $grid_handler->setGrid($params) ) {
            $ret = array("status"=>"200","message"=>"保存成功!");
            echo json_encode($ret);
        	exit;
        }
        break;
    case "album":
        $album_handler = xoops_getmodulehandler("album");
        $cat_handler = xoops_getmodulehandler("category");
        $params = $_POST;
        include(dirname(__FILE__)."/include/action.album.php");
        if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
        	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
        	if ( $msg ) {
        	    $str = implode("<br />", $msg);
        	    $status = "100";
        	} else {
        	    $str = _ALBUM_SUCCEED;
        	    $status = "200";
        	}
        	$json = array("status"=>$status,"message"=>$str);
        	echo json_encode($json);
        	exit;
        } else {
            if ( $msg ) {
                redirect_header($redirect_url, 3, implode("<br />", $msg));
            }
            redirect_header("album.php?albumId={$album_id}", 3, _ALBUM_SUCCEED);
        }
        break;
    case "category":
        include(dirname(__FILE__)."/include/action.category.php");
        break;
    case "picture":
        $album_handler = xoops_getmodulehandler("album");
        $picture_handler = xoops_getmodulehandler("picture");
        switch ($ac) {
            case "delete":
                $album_id = isset($_POST["album_id"]) ? intval($_POST["album_id"]) : 0;
                $pic_id = isset($_POST["pic_id"]) ? intval($_POST["pic_id"]) : 0;
                $album_obj = $album_handler->get($album_id);
                $info = array("status"=>"100");
                if ( !is_object($album_obj) && $album_obj->uid() != $xoopsUser->uid() ) {
                    $info["message"] = _NOPERM;
                }
                if ( empty($info["message"]) ) {
                    $pic_obj = $picture_handler->get($pic_id);
                    if ( !is_object($pic_obj) ) {
                        $info["message"] = "图片不存在或是被删除!";
                    }
                }
                if ( $picture_handler->delete($pic_obj) ) {
                    $album_handler->updateAlbumTotal($album_id,-1);
                    $info["status"] = "200";
                    $info["picid"] = $pic_id;
                    $info["message"] = "图片删除成功!";
                } else {
                    $info["message"] = "图片删除失败!";
                }
                if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
                	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
                	echo json_encode($info);
                	exit;
                } else {
                    if ( $info["status"] == "200" ) {
                        redirect_header($redirect_url, 3, implode("<br />", $info["message"]));
                    }
                    redirect_header("album.php?albumId={$album_id}", 3, _ALBUM_SUCCEED);
                }
                break;
            case "edit":
                $err = xoAlbum::checkSubmitFields("picture",$_POST,false);
                $info = array();
                if ( true === $err ) {
                    if ( $picture_handler->setPicture($_POST) ) {
                        $info["status"] = "200";
                        $info["message"] = "图片编辑成功!";
                    } else {
                        $info["status"] = "300";
                        $info["message"] = "图片编辑失败!";
                    }
                } else {
                    $info["status"] = "100";
                    $info["message"] = $err;
                }
                if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
                	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
                	echo json_encode($info);
                	exit;
                } else {
                    if ( $info["status"] == "200" ) {
                        redirect_header($redirect_url, 3, implode("<br />", $info["message"]));
                    }
                    redirect_header("album.php?albumId={$album_id}", 3, _ALBUM_SUCCEED);
                }
                break;
            default:
                die("no params");
        }
        break;
        
    case "upload":
        $album_handler = xoops_getmodulehandler("album");
        $picture_handler = xoops_getmodulehandler("picture");
        if (isset($_POST["PHPSESSID"])) {
        	session_id($_POST["PHPSESSID"]);
        }
        session_start();
        
        $album_id = isset($_POST["albumId"]) ? intval($_POST["albumId"]) : 0;
        $uid = isset($_POST["uid"]) ? intval($_POST["uid"]) : 0;
        $sign = isset($_POST["sign"]) ? $_POST["sign"] : 0;
        $sess_id = isset($_POST["PHPSESSID"]) ? $_POST["PHPSESSID"] : 0;
        // prem error
        $str = $album_id.$uid.$sess_id;
        $error = array();
        
        if ( false == xoAlbum::checkSign($str,$sign) ) {
            $error[] = "签名错误";
        }
        $album_obj = $album_handler->get($album_id);
        
        if ( !is_object($album_obj) || $album_obj->isNew() ||
             $album_obj->uid() != $uid ) {
             $error[] = "抱歉，这个相册不是您的";
        }
        include(dirname(__FILE__)."/include/action.picture.php");
        break;
    default:
        die("no params");
}