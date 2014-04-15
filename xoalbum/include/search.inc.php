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

function xoalbum_search($queryarray, $andor, $limit, $offset, $userid, $sortby = "album_dateline ASC")
{
    global $xoopsDB, $xoopsConfig;
    $ret = array();
    $count = is_array($queryarray) ? count($queryarray) : 0;
    $sql = "SELECT * FROM " . $xoopsDB->prefix("album_album");
    if ($count > 0) {
        if ($andor == "exact") {
            $sql .= " WHERE album_name = '{$queryarray[0]}'";
            for ($i = 1 ; $i < $count; $i++) {
                $sql .= " {$andor} album_name = '{$queryarray[$i]}'";
            }
        } else {
            $sql .= " WHERE album_name LIKE '%{$queryarray[0]}%'";
            for ($i=1 ; $i < $count; $i++) {
                $sql .= " {$andor} album_name LIKE '%{$queryarray[$i]}%'";
            }
        }
    } else {
        return $ret;
    }
    if ($sortby) {
        $sql .= " ORDER BY {$sortby}";
    }
    $result = $xoopsDB->query($sql, $limit, $offset);
    $i = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$i]["link"] = "album.php?albumId=".$myrow["album_id"];
        $ret[$i]["title"] = $myrow["album_name"];
        $i++;
    }
    return $ret;
}
?>