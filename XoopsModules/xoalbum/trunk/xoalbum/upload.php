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

$album_id = isset($_GET["albumId"]) ? intval($_GET["albumId"]) : 0 ;

if ( empty($xoopsUser) || !is_object($xoopsUser) ) {
    redirect_header( XOOPS_URL."/user.php", 5, _NOPERM);
}

$cat_handler = xoops_getmodulehandler("category");
$album_handler = xoops_getmodulehandler("album");


$album_obj = $album_handler->get($album_id);
if ( empty($album_obj) || $album_obj->isNew() ) {
    redirect_header("album.php",5,"抱歉，您访问的相册不存在或是被删除!");
}
if ( false == $album_obj->accessPerm() ) {
    redirect_header("index.php",5,_ALBUM_NOPERM_ACCESS);
}

$album = $album_obj->getValues();
$album["album_dateline"] = $album_obj->dateline();
$album["cat_name"] = $cat_handler->get($album_obj->getVar("cat_id"))->name();
$album["cover"] = $album_obj->cover();
$modulenav[] = array(
    "navlink"=>"index.php?catId=".$album_obj->getVar("cat_id"),
    "navtitle"=>$album["cat_name"]
);
$modulenav[] = array(
    "navlink"=>"album.php?albumId={$album_id}",
    "navtitle"=>$album_obj->getVar("album_name","n"),
);

$xoopsOption["xoops_pagetitle"] = _ALBUM_NAME . " - " . $album_obj->getVar("album_name","n") . " - " ._ALBUM_UPLOAD;
$xoopsOption["template_main"] = "album_upload.html";
include_once XOOPS_ROOT_PATH.'/header.php';	

$jsuploadpath = XOOPS_URL."/modules/".$xoopsModule->getVar("dirname")."/script/swfupload/";
$swfuploads = array(
    "upload_url" => XOOPS_URL."/modules/{$xoopsModule->getVar("dirname")}/action.php?op=upload",
    "file_size_limit" => 2*1024*1024,
    "file_types" => "*.jpg; *.jpeg; *.gif; *.png",
    "file_types_description" => "JPG Images",
    "file_upload_limit" => 60,
    "flash_url" => $jsuploadpath."swfupload.swf",
    "button_image_url" => $jsuploadpath."upload_bg.jpg",
    "post_params" => array(
        "albumId" => "{$album_id}",
        "uid" => $xoopsUser->uid(),
        "sign" => xoAlbum::uploadSign($album_id.$xoopsUser->uid().$_COOKIE["PHPSESSID"]),
        "PHPSESSID" => $_COOKIE["PHPSESSID"]
    ),
);

$xoopsTpl->assign(array(
    "album"=>$album,
    "modulenav"=>$modulenav,
    "swfuploads" => $swfuploads
));
xoAlbum::addModConf($script_arg);
include "footer.php";
?>