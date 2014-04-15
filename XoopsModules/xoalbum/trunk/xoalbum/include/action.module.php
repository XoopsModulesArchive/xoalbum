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

function xoops_module_install_xoalbum(&$module)
{
    $GLOBALS['xoopsDB']->queryFromFile(XOOPS_ROOT_PATH . "/modules/" . $module->getVar("dirname") . "/sql/mysql.default.category.sql");
    return true;
}
function xoops_module_update_xoalbum(&$module)
{
    return true;
}
function xoops_module_uninstall_xoalbum(&$module)
{
    return true;
}
?>