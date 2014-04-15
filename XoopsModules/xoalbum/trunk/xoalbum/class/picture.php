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
 * @subpackage      class
 */
if ( !defined("XOOPS_ROOT_PATH") ) die('XOOPS root path not defined');

if ( !class_exists("xoAlbum") ) {
	include dirname(dirname(__FILE__))."/include/xoalbum.php";
}

class xoAlbumPicture extends XoopsObject 
{
	public function __construct() 
	{
		$this->initVar("pic_id", XOBJ_DTYPE_INT, null, false);
		$this->initVar("uid", XOBJ_DTYPE_INT,0,true);
		$this->initVar("album_id", XOBJ_DTYPE_INT,0,true);
		$this->initVar("pic_name", XOBJ_DTYPE_TXTBOX,null,true);
		$this->initVar("pic_desc", XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar("pic_filetype", XOBJ_DTYPE_TXTBOX);
		$this->initVar("pic_filename", XOBJ_DTYPE_TXTBOX);
		$this->initVar("pic_thumbfirst", XOBJ_DTYPE_TXTBOX);
		$this->initVar("pic_thumbsecond", XOBJ_DTYPE_TXTBOX);
		$this->initVar("pic_size", XOBJ_DTYPE_INT);
		$this->initVar("pic_dateline", XOBJ_DTYPE_INT);
		$this->initVar("pic_comments", XOBJ_DTYPE_INT);
		$this->initVar("pic_downloads", XOBJ_DTYPE_INT);
	}
	
	public function dateline($format="l")
	{
	    return formatTimestamp($this->getVar("pic_dateline"),$format);
	}
	
	public function name() 
	{
	    return $this->getVar("pic_name","n");
	}
	public function uid()
	{
	    return (int)$this->getVar("uid","n");
	}
	
	public function size()
	{
	    return @number_format(((int)$this->getVar("pic_size") / 1024),2) ."Kb";
	}
	
	public function thumb($num=1) {
	    $pic_thumb = $num == 1 ? "pic_thumbfirst" : "pic_thumbsecond";
	    $src = XOOPS_UPLOAD_URL . "/" . $this->getVar($pic_thumb,"n") ;
	    return "<img src='{$src}' alt='' />";
	}
	public function thumburl($num=1) {
	    $pic_thumb = $num == 1 ? "pic_thumbfirst" : "pic_thumbsecond";
	    return XOOPS_UPLOAD_URL . "/" . $this->getVar($pic_thumb,"n");
	}
}

class xoAlbumPictureHandler extends XoopsPersistableObjectHandler
{
	public function __construct($db) 
	{
        parent::__construct($db,"album_picture","xoAlbumPicture","pic_id");
    } 
    
    /**
     * create or modify picture info
     *
     * @param array $params
     * @return int $pic_id
     */
    public function setPicture( array $params ) 
    {
        $myts =  MyTextSanitizer::getInstance();
        if ( empty($params) || !is_array($params) ) return false;
    	$pic_id = isset($params["pic_id"]) ? intval($params["pic_id"]) : 0 ;
        if ( !empty($pic_id) ) {
            $obj = $this->get($pic_id);
        } else {
            $obj = $this->get();
            $obj->setVar("pic_dateline",time());
        }
    	foreach ( $params as $key => $val ) {
			if ( !isset($obj->vars[$key]) || $myts->stripSlashesGPC($val) == $obj->getVar($key) ) continue;
			$obj->setVar($key, $val);
		}
    	if ( $pic_id = $this->insert($obj) ) {
    	    return $pic_id;
    	}
    	return false;
    }
    
    public function getPictures( array $params, $asObj=true ) 
    {
        $criteria = xoAlbum::getCriteria($params);
        $fields = ( isset($params["fields"]) && is_array($params["fields"]) ) ? $params["fields"] : null ;
        $ret = $this->getAll($criteria, $fields, $asObj);
        return $ret;
    }
    
    public function getPageNav( array $params ) 
    {
        $pagenav = "";
        $criteria = xoAlbum::getCriteria($params);
        $counts = $this->getCount($criteria);
        $extra = isset($params["extra"]) ? trim($params["extra"]) : "";
        if( $counts > $params["limit"]){	
        	$nav = new XoopsPageNav($counts, $params["limit"], $params["start"], "start", $extra);
        	$pagenav = $nav->renderNav(4);
        }
        return $pagenav;
    }
    
    public function getPictureCount( array $params ) 
    {
        $criteria = xoAlbum::getCriteria($params);
        return $this->getCount($criteria);
    }
    
    public function getInPageStart($pic_id,$album_id, $limit=10) {
        $criteria = new CriteriaCompo(new Criteria("album_id",$album_id));
        $criteria->setOrder("DESC");
        $criteria->setSort("pic_dateline");
        $pic_ids = $this->getIds($criteria);
        rsort($pic_ids);
        $ret = 0;
        if ( $pic_ids && in_array($pic_id,$pic_ids)) {
            foreach ( $pic_ids as $k=>$v) {
                if ( $v == $pic_id ) {
                    $val = $k ;
                    break;
                }
            }
            if ( $val < $limit ) {
                return $ret;
            }
            $ret = floor( $val / $limit ) * $limit;
            return $ret;
        }
        return $ret;
    }
    
    public function delPicture($pic_id) {
        if ( empty($pic_id) ) return false;
        $obj = $this->get($pic_id);
        if ( $this->delete($obj) ) {
            return $pic_id;
        }
        return false;
    }
    
    public function delPictures($album_id) {
        if ( empty($album_id) ) return false;
        $criteria = new CriteriaCompo( new Criteria("album_id",$album_id) ) ;
        $pic_ids = $this->getIds($criteria);
        if ( $this->deleteAll($criteria) ) {
            return $pic_ids;
        }
        return false;
    }
    
}

?>