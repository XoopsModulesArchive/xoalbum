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

$upload_dirname = xoAlbum::setDirname(array("prefix" => $xoopsModule->dirname("n")));
if ( !$upload_dirname ) {
    $error[] = XOOPS_UPLOAD_PATH ." 或 ".XOOPS_VAR_PATH . "没有写权限! ";
}
if ( !$_FILES["Filedata"]["size"] || 
    $_FILES["Filedata"]["size"] > 2*1024*1024 ) {
    $error[] = "图片大小有误!";
}
if ( $error ) {
    $str = implode("<br />",$error);
    $json_arg = array(
        "status" => "10000",
        "message" => $str
    );
    echo json_encode($json_arg);
    exit;
}
$params = array(
    "upload_path"=>$upload_dirname["image"]["path"],
    "filename"=>"Filedata",
    "allow_filetype"=> array(
        "image/gif", 
        "image/jpeg", 
        "image/pjpeg", 
        "image/x-png", 
        "image/png",
        "application/octet-stream"
     )
);
if ( !$upload_filename = xoAlbum::uploadFile($params) ) {
    $error[] = "上传出错";
}
error_log($upload_filename);
unset($params);

$thumb_path = $upload_dirname["thumb"];
$image_info = @getimagesize($upload_dirname["image"]["path"]."/{$upload_filename}");
$params = array(
    "thumb_wh" => array("640","640"),
    "thumb_filename" => $thumb_path["0"]["path"]."/{$upload_filename}",
    "image_filename" => $upload_dirname["image"]["path"]."/{$upload_filename}",
    "image_info" => $image_info
);

/**
 * 生成第1张略图
 */
$thumb_conf_wh = explode("|",$xoopsModuleConfig["thumb1wh"]);
if ( (int)$thumb_conf_wh["0"] && (int)$thumb_conf_wh["1"] ) {
    $params["thumb_wh"] = $thumb_conf_wh;
}
if ( !xoAlbum::createThumb($params) ){
    $error[] = "第一张略图生成失败";
}

/**
 * 生成第二张略图
 */
unset($params,$thumb_conf_wh);
$params = array(
    "thumb_wh" => array("80","80"),
    "thumb_filename" => $thumb_path["1"]["path"]."/{$upload_filename}",
    "image_filename" => $upload_dirname["image"]["path"]."/{$upload_filename}",
    "image_info" => $image_info
);
$thumb_conf_wh = explode("|",$xoopsModuleConfig["thumb2wh"]);
if ( (int)$thumb_conf_wh["0"] && (int)$thumb_conf_wh["1"] ) {
    $params["thumb_wh"] = $thumb_conf_wh;
}
if ( !xoAlbum::createThumb($params) ) {
    $error[] = "第二张略图生成失败";
}
/**
 * 封面更新
 */
unset($params);
if ( !$album_obj->getVar("album_cover") ) {
    $album_handler->updateAlbumCover($album_id,
                                     $thumb_path["1"]["dirname"]."/{$upload_filename}");
}
if ( $error ) {
    $str = implode("<br />",$error);
    $json_arg = array(
        "status" => "10001",
        "message" => $str
    );
    echo json_encode($json_arg);
    exit;
}
/**
 * 保存图片数据
 */
$params = array(
    "uid"           => $uid,
    "album_id"      => $album_id,
    "pic_name"      => $_FILES["Filedata"]["name"],
    "pic_filename"  => $upload_filename,
    "pic_filetype"  => $image_info["mime"],
    "pic_size"      =>  $_FILES["Filedata"]["size"],
    "pic_thumbfirst" =>  $thumb_path["0"]["dirname"]."/{$upload_filename}",
    "pic_thumbsecond" =>  $thumb_path["1"]["dirname"]."/{$upload_filename}"
);
if ( !$picture_handler->setPicture($params) ) {
    $error[] = "图片数据保存失败";
}
if ( $error ) {
    $str = implode("<br />",$error);
    $json_arg = array(
        "status" => "10001",
        "message" => $str
    );
    echo json_encode($json_arg);
    exit;
}
/**
 * 更新相册图片总数
 */
$album_handler->updateAlbumTotal($album_id,1);

$json_arg = array(
    "status" => "200",
    "message" => "图片上传成功!"
);
echo json_encode($json_arg);
exit;