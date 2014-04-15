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

$album_id = isset($_GET["albumId"]) ? intval($_GET["albumId"]) : 0;
$pic_id = isset($_GET["picId"]) ? intval($_GET["picId"]) : 0;
$start = isset($_GET["start"]) ? intval($_GET["start"]) : 0;

$album_handler = xoops_getmodulehandler("album");
$picture_handler = xoops_getmodulehandler("picture");
$cat_handler = xoops_getmodulehandler("category");

$album_obj = $album_handler->get($album_id);
if ( empty($album_obj) || $album_obj->isNew() ) {
    redirect_header("category.php",5,"抱歉，您访问的相册不存在或是被删除!");
}
$accessperm = true;
if ( false == $album_obj->accessPerm() ) {
    if ( !empty($pic_id) ) {
        redirect_header("index.php",5,_ALBUM_NOPERM_ACCESS);
    }
    $accessperm = false;
}

$album = $album_obj->getValues();
$album["album_dateline"] = $album_obj->dateline();
$album["cat_name"] = $cat_handler->get($album_obj->getVar("cat_id"))->name();
$album["cover"] = $album_obj->coverurl();

$modulenav[] = array(
    "navlink"=>"category.php?catId=".$album_obj->getVar("cat_id"),
    "navtitle"=>$album["cat_name"]
);

$modulenav[] = array(
    "navlink"=>"album.php?albumId={$album_id}",
    "navtitle"=>$album_obj->name()
);

$xoopsOption["xoops_pagetitle"] = _ALBUM_NAME ." - {$album["cat_name"]} - {$album_obj->name()}";
$xoopsOption["template_main"] = "album_album.html";
include_once XOOPS_ROOT_PATH."/header.php";	

$extra = "albumId={$album_id}";
$limit = 30;
$pagenav = "";
$op = false;
if ( !empty($pic_id) ) {
    $pic_obj = $picture_handler->get($pic_id);
    if ( empty($pic_obj) || $pic_obj->isNew() 
        || $pic_obj->getVar("album_id") != $album_id ) {
        redirect_header("album.php?albumId={$album_id}",_NOPERM);
    }
    $op = true;
    $picture = array();
    $grid_handler = xoops_getmodulehandler("grid");
    if ( $pic_obj ) {
        $picture = $pic_obj->getValues();
        $picture["pic_dateline"] = $pic_obj->dateline();
        $picture["pic_size"] = $pic_obj->size();
        $picture["picture"] = $pic_obj->thumburl(1);
        $picture["grids"] = $grid_handler->getGridList($pic_id);
    }
//    $limit = 8;
//    $start = $picture_handler->getInPageStart($pic_id,$album_id,$limit);
    $limit = 120;
    $start = 0;
    include(dirname(__FILE__)."/include/form.grid.php");
    $xoopsTpl->assign(array(
        "picture"=>$picture,
    ));
}

$params = array(
    "criteria" => array(
        "album_id" => $album_id
    ),
    "fields"=> array("album_id","pic_name","pic_thumbsecond"),
    "start" => $start,
    "limit" => $limit,
    "sort"  => "pic_dateline",
    "order" => "DESC",
    "extra" => $extra 
);

if ( empty($pic_id) ) {
    $pagenav = $picture_handler->getPageNav($params);
}
$pic_objs = $picture_handler->getPictures($params);
$pictures = array();
if ( $pic_objs ) {
    foreach ( $pic_objs as $k=>$obj ) { 
        $pictures[$k] = $obj->getValues();
        $pictures[$k]["pic_dateline"] = $obj->dateline();
        $pictures[$k]["pic_size"] = $obj->size();
        $pictures[$k]["thumb"] = $obj->thumb(2);
    }
    $form = new XoopsForm("", "coverfrm", "action.php", "post",true);
    $form->addElement( new XoopsFormHidden("op","album"));
    $form->addElement( new XoopsFormHidden("ac","cover"));
    $form->addElement( new XoopsFormHidden("album_id",$album_id));
    $form->assign($xoopsTpl);
}

$albums_cat = $albums_user = array();
if ( empty($pic_id) ) {
    unset($params);
    // 同分类相册
    $params = array(
        "criteria" => array(
            "cat_id" => $album_obj->getVar("cat_id")
        ),
        "fields"=> array("album_name","album_total","album_status","album_cover"),
        "limit" => 10,
        "sort"  => "album_total",
        "order" => "DESC"
    );
    $album_cat_objs = $album_handler->getAlbums($params);
    if ( isset($album_cat_objs[$album_id]) ) {
        unset($album_cat_objs[$album_id]);
    }
    if ( $album_cat_objs ) {
        foreach ( $album_cat_objs as $k=>$obj ) {
            $albums_cat[$k]["album_id"] =  $obj->id();
            $albums_cat[$k]["album_name"] =  $obj->name();
            $albums_cat[$k]["album_cover"] =  $obj->cover();
            $albums_cat[$k]["album_status"] =  $obj->state();
            $albums_cat[$k]["album_total"] =  $obj->getVar("album_total");
        }
        
    }
    unset($params);
    // 同分类相册
    $params = array(
        "criteria" => array(
            "uid" => $album_obj->uid()
        ),
        "fields"=> array("album_name","album_total","album_status","album_cover"),
        "limit" => 10,
        "sort"  => "album_total",
        "order" => "DESC"
    );
    $album_user_objs = $album_handler->getAlbums($params);
    if ( isset($album_user_objs[$album_id]) ) {
        unset($album_user_objs[$album_id]);
    }
    if ( $album_user_objs ) {
        foreach ( $album_user_objs as $k=>$obj ) {
            $albums_user[$k]["album_id"] =  $obj->id();
            $albums_user[$k]["album_name"] =  $obj->name();
            $albums_user[$k]["album_cover"] =  $obj->cover();
            $albums_user[$k]["album_status"] =  $obj->state();
            $albums_user[$k]["album_total"] =  $obj->getVar("album_total");
        }
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

// smarty values
$xoopsTpl->assign(array(
    "op"=>$op,
    "album"=>$album,
    "albums_cat"=>$albums_cat,
    "albums_user"=>$albums_user,
    "modulenav"=>$modulenav,
    "pictures"=>$pictures,
    "my_albums"=>$my_albums,
    "accessperm"=>$accessperm,
    "pagenav"=>$pagenav
));

// loads page must js and css
xoAlbum::addModConf($script_arg);
include "footer.php";
?>