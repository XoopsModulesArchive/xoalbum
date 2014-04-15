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

class xoAlbumCategory extends XoopsObject 
{
	public function __construct() {
		$this->initVar("cat_id", XOBJ_DTYPE_INT, null, false);
		$this->initVar("cat_name", XOBJ_DTYPE_TXTBOX);
		$this->initVar("cat_total", XOBJ_DTYPE_INT);
		$this->initVar("cat_order", XOBJ_DTYPE_INT);
		$this->initVar("cat_dateline", XOBJ_DTYPE_INT);
	}
	
	public function name()
	{
	    return $this->getVar("cat_name","n");
	}
}

class xoAlbumCategoryHandler extends XoopsPersistableObjectHandler
{
	public function __construct($db) 
	{
        parent::__construct($db,"album_category","xoAlbumCategory","cat_id");
    } 
    
    public function setCategory( array $params ) 
    {
        $myts =  MyTextSanitizer::getInstance();
        if ( empty($params) || !is_array($params) ) return false;
    	$cat_id = isset($params["cat_id"]) ? intval($params["cat_id"]) : 0 ;
        if ( !empty($cat_id) ) {
            $obj = $this->get($cat_id);
        } else {
            $obj = $this->get();
            $obj->setVar("cat_dateline",time());
        }
    	foreach ( $params as $key => $val ) {
			if ( !isset($obj->vars[$key]) || $myts->stripSlashesGPC($val) == $obj->getVar($key) ) continue;
			$obj->setVar($key, $val);
		}
    	if ( $cat_id = $this->insert($obj) ) {
    	    return $cat_id;
    	}
    	return false;
    }
    
    public function getCategories( array $params, $asObj=true ) 
    {
        $criteria = xoAlbum::getCriteria($params);
        $fields = ( isset($params["fields"]) && is_array($params["fields"]) ) ? $params["fields"] : null ;
        $ret = $this->getAll($criteria, $fields, $asObj);
        return $ret;
    }
    
    public function getCatList() {
        $params = array(
            "criteria" => array(),
            "fields" => array("cat_name","cat_total","cat_dateline"),
            "sort"  => "cat_order",
            "order" => "ASC"
        );
        $cat_list = $this->getCategories($params, false);
        if ( $cat_list ) {
            foreach ( $cat_list as $k=>$v ) {
                $cat_list[$k] = $v;
                $cat_list[$k]["cat_dateline"] = formatTimestamp($v["cat_dateline"]);
            }
        }
        return $cat_list;
    }
    
    
    public function updateCatTotal($cat_id,$num=0) {
        if ( empty($cat_id) || empty($num) ) return false;
        $cat_obj = $this->get($cat_id);
        if ( empty($cat_obj) || !is_object($cat_obj) ) return false;
        $cat_obj->setVar("cat_total",$cat_obj->getVar("cat_total") + $num );
        if ( $this->insert($cat_obj) ) {
            return true;
        }
        return false;
    }
    
    public function delCategory($cat_id) {
        if ( empty($cat_id) ) return false;
        $obj = $this->get($cat_id);
        if ( $cat_id = $this->delete($obj) ) {
            return $cat_id;
        }
        return false;
    }
    
}

?>