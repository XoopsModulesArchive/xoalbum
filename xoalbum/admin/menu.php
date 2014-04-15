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
$adminmenu = array(); 
$adminmenu[] = array(
		'title' => _AM_HOME,  
		'link'  => 'admin/index.php'
);
$adminmenu[] = array(
		'title' => _AM_CATEGORY,  
		'link'  => 'admin/category.php'
);
$adminmenu[] = array(
		'title' => _AM_ALBUM,  
		'link'  => 'admin/album.php'
);
$adminmenu[] = array(
		'title' => _AM_COMMENTS,  
		'link'  => 'admin/comments.php'
);
?>