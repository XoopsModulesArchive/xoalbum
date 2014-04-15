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
 * @subpackage      class
 */

if ( !defined("XOOPS_ROOT_PATH") ) die('XOOPS root path not defined');

if ( !class_exists("xoAlbum") ) {
	include dirname(dirname(__FILE__))."/include/xoalbum.php";
}

class xoAlbumAlbum extends XoopsObject 
{
	public function __construct() 
	{
		$this->initVar("album_id", XOBJ_DTYPE_INT, null, false);
		$this->initVar("cat_id", XOBJ_DTYPE_INT,0,true);
		$this->initVar("uid", XOBJ_DTYPE_INT,0,true);
		$this->initVar("album_name", XOBJ_DTYPE_TXTBOX,null,true);
		$this->initVar("album_desc", XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar("album_total", XOBJ_DTYPE_INT,0,false);
		$this->initVar("album_cover", XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar("album_views", XOBJ_DTYPE_INT,0,false);
		$this->initVar("album_status", XOBJ_DTYPE_INT,0,false); 
		$this->initVar("album_dateline", XOBJ_DTYPE_INT,0,false);
	}
	
	public function id()
	{
	    return (int)$this->getVar("album_id");
	}
	
	public function uid() 
	{
	    return (int)$this->getVar("uid","n");
	}
	public function name() 
	{
	    return $this->getVar("album_name","n");
	}
	
	public function dateline($format="l")
	{
	    return formatTimestamp($this->getVar("album_dateline"),$format);
	}
	
	public function state() 
	{
	    return $this->getVar("album_status") ? _AM_ALBUM_STATE1 : _AM_ALBUM_STATE0;
	}
	
	public function coverurl()
	{
	    $src = XOOPS_URL . "/modules/xoalbum/images/nopicture.gif";
	    if ( $this->getVar("album_cover","n") ) {
	        $src = XOOPS_UPLOAD_URL . "/" . $this->getVar("album_cover","n") ;
	    }
	    return $src;
	}
	
	public function cover() 
	{
	    $src = XOOPS_URL . "/modules/xoalbum/images/nopicture.gif";
	    if ( $this->getVar("album_cover","n") ) {
	        $src = XOOPS_UPLOAD_URL . "/" . $this->getVar("album_cover","n") ;
	    }
	    return "<img src='{$src}' alt='' />";
	}
	
	public function accessPerm()
	{
	    global $xoopsUser;
	    if ( is_object($xoopsUser) && $this->getVar("uid") === $xoopsUser->uid() ) {
	        return true;
	    }
	    if ( (int)$this->getVar("album_status") === 1 ) return true;
	    return false;
	}
}

class xoAlbumAlbumHandler extends XoopsPersistableObjectHandler
{
	public function __construct($db) 
	{
        parent::__construct($db,"album_album","xoAlbumAlbum","album_id");
    } 
    
    /**
     * create or modify album
     *
     * @param array $params
     * @return int $album_id
     */
    public function setAlbum( array $params ) 
    {
        $myts =  MyTextSanitizer::getInstance();
        if ( empty($params) || !is_array($params) ) return false;
    	$album_id = isset($params["album_id"]) ? intval($params["album_id"]) : 0 ;
        if ( !empty($album_id) ) {
            $obj = $this->get($album_id);
        } else {
            $obj = $this->get();
            $obj->setVar("album_dateline",time());
        }
    	foreach ( $params as $key => $val ) {
			if ( !isset($obj->vars[$key]) || $myts->stripSlashesGPC($val) == $obj->getVar($key) ) continue;
			$obj->setVar($key, $val);
		}
    	if ( $album_id = $this->insert($obj) ) {
    	    return $album_id;
    	}
    	return false;
    }
    
    /**
     * get album list
     *
     * @param array $params
     * @param bool $asObj
     * @return array/object $ret
     */
    public function getAlbums( array $params, $asObj=true ) 
    {
        $criteria = xoAlbum::getCriteria($params);
        $fields = ( isset($params["fields"]) && is_array($params["fields"]) ) ? $params["fields"] : null ;
        $ret = $this->getAll($criteria, $fields, $asObj);
        return $ret;
    }
    
    /**
     * get album page nav
     *
     * @param array $params
     * @return string $pagenav
     */
    public function getPageNav( array $params ) 
    {
        $pagenav = "";
        $criteria = xoAlbum::getCriteria($params);
        $counts = $this->getCount($criteria);
        $extra = isset($params["extra"]) ? trim($params["extra"]) : "";
        if( $counts > $params["limit"]){	
        	$nav = new XoopsPageNav($counts, $params["limit"], $params["start"], "start",$extra);
        	$pagenav = $nav->renderNav(4);
        }
        return $pagenav;
    }
    
    /**
     * update album total
     *
     * @param int $album_id
     * @param int $num
     * @return bool
     */
    public function updateAlbumTotal($album_id,$num=0) 
    {
        if ( empty($album_id) || empty($num) ) return false;
        $album_obj = $this->get($album_id);
        if ( empty($album_obj) || !is_object($album_obj) ) return false;
        $album_obj->setVar("album_total",$album_obj->getVar("album_total") + $num );
        if ( $this->insert($album_obj) ) {
            return true;
        }
        return false;
    }
    
    public function updateAlbumCover($album_id,$cover)
    {
        if ( empty($album_id) || empty($cover) ) return false;
        $album_obj = $this->get($album_id);
        if ( empty($album_obj) || !is_object($album_obj) ) return false;
        $album_obj->setVar("album_cover",$cover);
        if ( $album_id = $this->insert($album_obj) ) {
            return $album_id;
        }
        return false;
    }
    
    public function delAlbum($album_id) {
        if ( empty($album_id) ) return false;
        $obj = $this->get($album_id);
        if ( $this->delete($obj) ) {
            return $album_id;
        }
        return false;
    }
    
    public function delAlbums($cat_id) {
        if ( empty($cat_id) ) return false;
        $criteria = new CriteriaCompo( new Criteria("cat_id",$cat_id) ) ;
        $album_ids = $this->getIds($criteria);
        if ( $this->deleteAll($criteria) ) {
            return $album_ids;
        }
        return false;
    }
    
}

?>