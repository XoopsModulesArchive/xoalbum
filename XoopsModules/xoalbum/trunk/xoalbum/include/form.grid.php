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
$form = new XoopsForm("", "gridfrm", "action.php", "post",true);
$form->addElement( new XoopsFormText("","grid_title",6,32));
$form->addElement( new XoopsFormHidden("x1","0"));
$form->addElement( new XoopsFormHidden("y1","0"));
$form->addElement( new XoopsFormHidden("x2","0"));
$form->addElement( new XoopsFormHidden("y2","0"));
$form->addElement( new XoopsFormHidden("w","0"));
$form->addElement( new XoopsFormHidden("h","0"));
$form->addElement( new XoopsFormHidden("op","grid"));
$form->addElement( new XoopsFormHidden("pic_id",$pic_id));
$form->assign($xoopsTpl);