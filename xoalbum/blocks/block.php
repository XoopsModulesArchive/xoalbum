<?php
/**
 * XOOPS photo management module
 *
 * @copyright       The XOOPS project http://sourceforge.net/projects/xoops/ 
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since           1.0.0
 * @author          Xiao Hui <xh.8326@gmail.com>
 * @author          Susheng Yang <ezskyyoung@gmail.com> 
 * @version         $Id$
 * @package         xoAlbum
 */
if (false === defined("XOOPS_ROOT_PATH")) {exit();}

function album_block_newpicture_show($options) {
    // get new pictures
$picture_handler = xoops_getmodulehandler("picture",'xoalbum');
$block = $new_pictures = $picture_handler->getPictureNew($options[0]);
return $block;
}

function album_block_newpicture_edit($options) {
    $form  =  ALBUM_MI_BLOCK_NEWPICTURE_NUM . ":&nbsp;&nbsp;<input type=\"text\" name=\"options[0]\" value=\"" . $options[0] . "\" />";
    return $form;
}
?>