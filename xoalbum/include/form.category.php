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
 */
if ( !defined("XOOPS_ROOT_PATH") ) die('XOOPS root path not defined');

$form = new XoopsForm("", "form", "action.category.php", "post",true);
$form->addElement( new XoopsFormText(_AM_CATEGORY_NAME,"cat_name",36,255,$cat_rows["cat_name"]),true );
$form->addElement( new XoopsFormText(_AM_CATEGORY_ORDER,"cat_order",12,12,$cat_rows["cat_order"]));
$form->addElement( new XoopsFormHidden("op","category"));
if ( !empty($isNew) ) {
    $form->addElement( new XoopsFormHidden("ac","create"));
} else {
    $form->addElement( new XoopsFormHidden("ac","edit"));
    $form->addElement( new XoopsFormHidden("cat_id",$cat_rows["cat_id"]));
}
$form->addElement( new XoopsFormButton("","submit",_SUBMIT,"submit"));
$form->assign($xoopsTpl);
?>