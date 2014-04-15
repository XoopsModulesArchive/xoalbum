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

if ( !empty($cat_id) ) {
    /**
     * 检查是否存在这个分类
     */
    $cat_obj = $cat_handler->get($cat_id);
    if ( empty($cat_obj) || !is_object($cat_obj) ) { 
        redirect_header("category.php",3,"抱歉，你选择的分类不存在或是被删除!");
    }
}

if ( !empty($cat_id) ) {
    /**
     * 增加页面导航
     */
    $modulenav[] = array(
        "navlink"=>"category.php?catId={$cat_id}",
        "navtitle"=>$cat_obj->name()
    );
    $extra = "catId={$cat_id}";
}
/**
 * 页面的title信息和模块的导航栏
 */
$xoopsOption["xoops_pagetitle"] = !empty($cat_id) ? 
                                  _ALBUM_NAME . " - " . $cat_obj->name() : _ALBUM_NAME;
/**
 * 指定文件所需要的模块文件
 */
$xoopsOption["template_main"] = "album_category.html";
include_once XOOPS_ROOT_PATH."/header.php";	

/**
 * 获取分类的列表
 */
$categories = $cat_handler->getCatList();

/**
 * 获取相册的列表
 * $params 是相册查询条件所配置的参数
 */
$limit = 20;
$params = array(
    "criteria" => array(),
    "start" => $start,
    "limit" => $limit,
    "sort"  => "album_dateline",
    "order" => "DESC",
    "extra" => $extra
);
if ( !empty($cat_id) ) {
    $params["criteria"]["cat_id"] = (int)$cat_id;
}
if ( !empty($uid) ) {
    $params["criteria"]["uid"] = (int)$uid;
}
/**
 * 跟据条件的查询结果，$album_objs 得到的是多个对象的数组
 * 处理查询结果
 */
$album_objs = $album_handler->getAlbums($params);
$pagenav = $album_handler->getPageNav($params);
$list = array();
if ( $album_objs ) {
//    $user_ids = array();
//    foreach ( $album_objs as $k=>$obj ) {
//        $user_ids[] = $obj->getVar("uid");
//    }
//    if ( $user_ids ) {
//        $user_ids = array_unique($user_ids);
//    }
//    $members = $user_ids ? xoAlbum::getUsers($user_ids) : array();
    foreach ( $album_objs as $k=>$obj ) {
        $list[$k]["album_name"] = $obj->name();
        $list[$k]["album_total"] = $obj->getVar('album_total');
        $list[$k]["album_dateline"] = $obj->dateline();
        $list[$k]["uid"] = $obj->uid();
        $list[$k]["album_views"] = $obj->getVar('album_views');
//        $list[$k]["name"] = !empty($members[$obj->getVar('uid')]["name"]) ? 
//                            $members[$obj->getVar('uid')]["name"] : 
//                            $members[$obj->getVar('uid')]["uname"] ;
//        $list[$k]["uid"] = $obj->getVar('uid');
        $list[$k]["state"] = $obj->state();
        $list[$k]["cover"] = $obj->cover();
        $list[$k]["album_id"] = $obj->id();
        $list[$k]["cat_id"] = $obj->getVar("cat_id");
        $list[$k]["cat_name"] = isset($categories[$obj->getVar("cat_id")]) ? 
                                $categories[$obj->getVar("cat_id")]["cat_name"] : "" ;
    }
}

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
 * 将值传入模板文件
 */
$xoopsTpl->assign(array(
    "albums"=>$list,
    "pagenav"=>$pagenav,
    "categories"=>$categories,
    "my_albums"=>$my_albums,
    "modulenav"=>$modulenav // 模块导航的值
));

/**
 * 调用页面所需要的JS和CSS文件
 */
xoAlbum::addModConf($script_arg);
include "footer.php";
?>