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

$form = new XoopsForm("", "form", $formurl, "post",true);
$cat = new XoopsFormSelect(_AM_CATEGORY_NAME,"cat_id",$album["cat_id"] );
$cat_list = array();
if ( $categories ) {
    foreach ( $categories as $k=>$val ) {
        $cat_list[$k] = $val["cat_name"]."(".$val["cat_total"].")";
    }
}
$cat->addOptionArray($cat_list);
$form->addElement($cat);
$form->addElement( new XoopsFormText(_AM_ALBUM_NAME,"album_name",24,255,$album["album_name"]));
$form->addElement( new XoopsFormTextArea(_AM_ALBUM_DESC,"album_desc",$album["album_desc"], 2, 32));
$form->addElement( new XoopsFormRadioYN(_AM_ALBUM_STATE,
                                        "album_status",
                                        !empty($album["album_status"]) ? $album["album_status"] : 0 , 
                                        _AM_ALBUM_STATE1, 
                                        _AM_ALBUM_STATE0));
$form->addElement( new XoopsFormHidden("op","album"));
if ( !empty($isnew) ) {
    $form->addElement( new XoopsFormHidden("ac","create"));
} else {
    $form->addElement( new XoopsFormHidden("ac","edit"));
    $form->addElement( new XoopsFormHidden("album_id",$album["album_id"]));
}
if ( isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && 
	$_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ) {
} else {
    $form->addElement( new XoopsFormButton("","submit",_SUBMIT,"submit"));
}
$form->assign($xoopsTpl);