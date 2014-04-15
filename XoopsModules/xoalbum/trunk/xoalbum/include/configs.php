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
// script file
$script_arg = array(
    "jscript" => array(
        "script/jquery/jquery-1.3.2.min.js",
        "script/jquery/jquery.form.js",
        "script/jquery/jquery-menu.js",
        "script/jquery/jquery-ui-1.7.2.custom.min.js",
        "script/jquery/jquery.imgareaselect.min.js",
        "script/swfupload/swfupload.js",
//         "script/swfupload/swfupload.queue.js",
        "script/swfupload/handlers.js",
        "script/xoalbum.js",
    ),
    "style" => array(
        "script/style/style.css",
        "script/style/ui-darkness/jquery-ui-1.7.2.custom.css",
        "script/style/imgareaselect/imgareaselect-default.css",
    )
);