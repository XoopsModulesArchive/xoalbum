<?php
/**
 * XOOPS photo management module
 *
 * @copyright       The XOOPS project http://sourceforge.net/projects/xoops/ 
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since           1.0.0
 * @author          Xiao Hui <xh.8326@gmail.com>
 * @version         $Id$
 * @package         xoAlbum
 * @subpackage      include
 */
if ( !defined("XOOPS_ROOT_PATH") ) die('XOOPS root path not defined');

$form = new XoopsForm("", "form", "action.upload.php", "post",true);
$form->setExtra("enctype=\"multipart/form-data\"");
$att_size = $xoopsModuleConfig["picturesize"];
for( $i=1; $i<=$xoopsModuleConfig["uploadsnum"]; $i++ ) {
	$form->addElement(new XoopsFormFile(sprintf(_ALBUM_PICTURE_LIST,$i),"picture_{$i}",$att_size));
}
$form->addElement( new XoopsFormHidden("op","upload"));
$form->addElement( new XoopsFormHidden("album_id",$album_id));
$form->addElement( new XoopsFormButton("","submit",_SUBMIT,"submit"));
$form->assign($xoopsTpl);
?>