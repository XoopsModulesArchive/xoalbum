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
include "header.php";
$op = isset($_REQUEST["op"]) ? trim($_REQUEST["op"]) : "";
$ac = isset($_REQUEST["ac"]) ? trim($_REQUEST["ac"]) : "";
$cat_handler = xoops_getmodulehandler("category");
$cat_id = isset($_REQUEST["cat_id"]) ? intval($_REQUEST["cat_id"]) : "";
switch ($op) {
    case "delete":      
        $obj = $cat_handler->get($cat_id);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if($cat_handler->delCategory($cat_id)) {
                redirect_header('category.php', 3, _AM_ABOUT_DELETESUCCESS);
            }else{
                echo $obj->getHtmlErrors();
            }
        }else{
            xoops_confirm(array('ok' => 1, 'id' => $obj->getVar('cat_id'), 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_RUSUREDEL, $obj->getVar('car_name')));
        }
    break;
    case "category":
        if ( !$GLOBALS['xoopsSecurity']->check() ) {
            redirect_header("category.php", 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $cat_name = isset($_POST["cat_name"]) ? trim($_POST["cat_name"]) : "";
        $cat_order = isset($_POST["cat_order"]) ? intval($_POST["cat_order"]) : 0;
        if ( empty($cat_name) ) {
            redirect_header("category.php", 5, _AM_ERROR_NOCATNAME);
        }
        switch ($ac) {
            case "edit":
                $cat_id = isset($_POST["cat_id"]) ? trim($_POST["cat_id"]) : 0;
                if ( $cat_handler->setCategory($cat_id, $cat_name, $cat_order) ) {
                    redirect_header("category.php", 5, _AM_SUCCEED);
                }
                redirect_header("category.php", 5, _AM_FAILED);
            break;
            
            default:
            case "create":
                $cat_id = 0;
                if ( $cat_handler->setCategory($cat_id, $cat_name, $cat_order) ) {
                    redirect_header("category.php", 5, _AM_SUCCEED);
                }
                redirect_header("category.php", 5, _AM_FAILED);
            break;
        }
    break;
    

}
?>