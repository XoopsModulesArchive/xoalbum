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
if (!defined("XOOPS_ROOT_PATH")) { exit(); }

$modversion = array();
$modversion["name"]         = "xoAlbum";
$modversion["version"]      = 1.01;
$modversion["description"]  = "";
$modversion["image"]        = "images/logo.png";
$modversion["dirname"]      = "xoalbum";
$modversion["author"]       = "Xiao Hui <xh.8326@gmail.com>";
// database tables
$modversion["sqlfile"]["mysql"] = "sql/mysql.sql";
$modversion["tables"] = array(
    "album_album",
    "album_category",
    "album_picture",
);

// Admin things
$modversion["hasAdmin"] = true;
$modversion["adminindex"] = "admin/index.php";
$modversion["adminmenu"] = "admin/menu.php";

// Menu
$modversion["hasMain"] = 1;
$modversion["sub"] = array();
if( is_object($GLOBALS["xoopsUser"]) ){
    $modversion["sub"][] = array("name" => ALBUM_MI_MYALBUM,	"url"=>"index.php?uid={$GLOBALS["xoopsUser"]->uid()}");
}
// update
$modversion["onInstall"]    = "include/action.module.php";
$modversion["onUpdate"]     = "include/action.module.php";
$modversion["onUninstall"]  = "include/action.module.php";
/**
* Templates
*/
$modversion["templates"]    = array();
$modversion["templates"][]  = array(
    "file"          =>  "album_index.html",
    "description"   =>  "",
);
$modversion["templates"][]  = array(
    "file"          =>  "album_header.html",
    "description"   =>  "",
);
$modversion["templates"][]  = array(
    "file"          =>  "album_category.html",
    "description"   =>  "",
);
$modversion["templates"][]  = array(
    "file"          =>  "album_album.html",
    "description"   =>  "",
);
$modversion["templates"][]  = array(
    "file"          =>  "album_detail.html",
    "description"   =>  "",
);
$modversion["templates"][]  = array(
    "file"          =>  "album_upload.html",
    "description"   =>  "",
);
$modversion["templates"][]  = array(
    "file"          =>  "album_form.html",
    "description"   =>  "",
);

//for admin templates
$modversion["templates"][]  = array(
    "file"          =>  "album_cp_index.html",
    "description"   =>  "",
);
$modversion["templates"][]  = array(
    "file"          =>  "album_cp_category.html",
    "description"   =>  "",
);
$modversion["templates"][]  = array(
    "file"          =>  "album_cp_picture.html",
    "description"   =>  "",
);
// Blocks
$modversion["hasBlocks"]    = true;
$modversion["blocks"]    = array();
$modversion["blocks"][]    = array(
    "file"          => "block.php",
    "name"          => ALBUM_MI_BLOCK_NEWPICTURE,
    "description"   => ALBUM_MI_BLOCK_NEWPICTURE_DESC,
    "show_func"     => "album_block_newpicture_show",
    "edit_func"     => "album_block_newpicture_edit",
    "options"       => "10",
    "template"      => "album_blocks_newpicture.html",
    );

// Search
$modversion["hasSearch"]    = true;
$modversion["search"]     = array(
    "file"          =>  "include/search.inc.php",
    "func"          =>  "xoalbum_search"
    );

// Configs
$modversion["hasConfig"] = true;
$modversion["config"] = array();
    
$modversion["config"][] = array(
    "name"          => "isusercreate",
    "title"         => "ALBUM_MI_ISUSERCREATE",
    "description"   => "ALBUM_MI_ISUSERCREATE_DESC",
    "formtype"      => "yesno",
    "valuetype"     => "int",
    "default"       => 1,
    );
$modversion["config"][] = array(
    "name"          => "picturesize",
    "title"         => "ALBUM_MI_PICTURESIZE",
    "description"   => "ALBUM_MI_PICTURESIZE_DESC",
    "formtype"      => "text",
    "valuetype"     => "int",
    "default"       => 1024*1024*2,
    );
$modversion["config"][] = array(
    "name"          => "thumb1wh",
    "title"         => "ALBUM_MI_THUMB1WH",
    "description"   => "ALBUM_MI_THUMB1WH_DESC",
    "formtype"      => "text",
    "valuetype"     => "text",
    "default"       => "640|640",
    );
$modversion["config"][] = array(
    "name"          => "thumb2wh",
    "title"         => "ALBUM_MI_THUMB2WH",
    "description"   => "ALBUM_MI_THUMB2WH_DESC",
    "formtype"      => "text",
    "valuetype"     => "text",
    "default"       => "80|80",
    );
$modversion["config"][] = array(
    "name"          => "uploadsnum",
    "title"         => "ALBUM_MI_UPLOADSNUM",
    "description"   => "ALBUM_MI_UPLOADSNUM_DESC",
    "formtype"      => "text",
    "valuetype"     => "int",
    "default"       => 5,
    );

?>