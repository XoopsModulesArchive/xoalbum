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
/**
 * 初使化请求的参数
 */
$cat_id = isset($_GET["catId"]) ? intval($_GET["catId"]) : 0;
$uid = isset($_GET["uid"]) ? intval($_GET["uid"]) : 0;
$start = isset($_GET["start"]) ? intval($_GET["start"]) : 0;
$extra = "";

/**
 * 加载页面所需要的类文件
 */
$cat_handler = xoops_getmodulehandler("category");
$album_handler = xoops_getmodulehandler("album");
$picture_handler = xoops_getmodulehandler("picture");
/**
 * 页面的title信息和模块的导航栏
 */
$xoopsOption["xoops_pagetitle"] = _ALBUM_NAME;
/**
 * 指定文件所需要的模块文件
 */
$xoopsOption["template_main"] = "album_index.html";
include_once XOOPS_ROOT_PATH."/header.php";	

$my_albums = array();
if ( is_object($xoopsUser) ) {
    $params = array(
        "criteria" => array(
            "uid" => (int)$xoopsUser->uid()
        ),
        "fields"=>array("album_name","album_total","album_cover"),
        "limit" => 10,
        "sort"  => "album_dateline",
        "order" => "DESC"
    );
    $album_my_objs = $album_handler->getAlbums($params);
    if ( $album_my_objs ) {
        foreach ( $album_my_objs as $k=>$obj ) {
            $my_albums[$k]["album_name"] = $obj->name();
            $my_albums[$k]["album_total"] = $obj->getVar('album_total');
            $my_albums[$k]["cover"] = $obj->cover();
            $my_albums[$k]["album_id"] = $obj->id();
        }
    }
}

/**
 * 最新的上传图片
 */
unset($params);
$params = array(
    "criteria" => array(),
    "fields"=>array("album_id","pic_name","pic_thumbfirst","pic_thumbsecond"),
    "limit" => 8,
    "sort"  => "pic_dateline",
    "order" => "DESC"
);
$objs = $picture_handler->getPictures($params);
$pictures = array();
if ( $objs ) {
    foreach ( $objs as $k=>$obj ) {
        $pictures[$k]["pic_id"] = $obj->getVar("pic_id");
        $pictures[$k]["album_id"] = $obj->getVar("album_id");
        $pictures[$k]["pic_name"] = $obj->name();
        $pictures[$k]["image"] = $obj->thumburl(1);
        $pictures[$k]["thumb"] = $obj->thumburl(2);
    }
    unset($objs);
}

/**
 * 图片最热的相册
 */
unset($params);
$params = array(
    "criteria" => array(
        "album_status" => 1
    ),
    "fields"=>array("album_name","album_cover","album_total"),
    "limit" => 4,
    "sort"  => "album_total",
    "order" => "DESC"
);
$objs = $album_handler->getAlbums($params);
$hotalbums = array();
if ( $objs ) {
    foreach ( $objs as $k=>$obj ) {
        $hotalbums[$k]["album_name"] = $obj->name();
        $hotalbums[$k]["album_total"] = $obj->getVar('album_total');
        $hotalbums[$k]["cover"] = $obj->coverurl();
        $hotalbums[$k]["album_id"] = $obj->id();
    }
}
/**
 * 获取分类的列表
 */
$categories = $cat_handler->getCatList();
/**
 * 将值传入模板文件
 */
$xoopsTpl->assign(array(
    "my_albums"=>$my_albums,
    "pictures" => $pictures,
    "categories" => $categories,
    "hotalbums" => $hotalbums,
    "modulenav"=>$modulenav // 模块导航的值
));

/**
 * 调用页面所需要的JS和CSS文件
 */
xoAlbum::addModConf($script_arg);
include "footer.php";
?>