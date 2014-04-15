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
 */
if ( !defined("XOOPS_ROOT_PATH") ) die('XOOPS root path not defined');

if ( !class_exists("xoAlbum") ) {
	include dirname(dirname(__FILE__))."/include/xoalbum.php";
}

class xoAlbumGrid extends XoopsObject 
{
	public function __construct() 
	{
		$this->initVar("grid_id", XOBJ_DTYPE_INT, null, false);
		$this->initVar("pic_id", XOBJ_DTYPE_INT,0,true);
		$this->initVar("uid", XOBJ_DTYPE_INT,0,true);
		$this->initVar("grid_title", XOBJ_DTYPE_TXTBOX,null,true);
		$this->initVar("grid_data", XOBJ_DTYPE_ARRAY,null,true);
		$this->initVar("grid_date", XOBJ_DTYPE_INT,null,false);
	}
	
	public function style() 
	{
	    $data = $this->getVar("grid_data");
	    $top = $data["y1"] ."px";
	    $width = $data["w"] ."px";
	    $height = $data["h"] ."px";
	    $left = $data["x1"] ."px";
	    $css = "position: absolute; top: {$top}; left: {$left}; height: {$height}; width: {$width}; z-index: 1; text-indent: -1000px; overflow: hidden;";
	    return $css;
	}
}

class xoAlbumGridHandler extends XoopsPersistableObjectHandler
{
	public function __construct($db) 
	{
        parent::__construct($db,"album_grid","xoAlbumGrid","grid_id");
    } 
    
    public function setGrid( array $params ) 
    {
        $myts =  MyTextSanitizer::getInstance();
        if ( empty($params) || !is_array($params) ) return false;
        if ( !is_array($params["grid_data"]) || empty($params["grid_title"]) ) return false;
        $obj = $this->get();
        $obj->setVar("grid_date",time());
    	foreach ( $params as $key => $val ) {
			if ( !isset($obj->vars[$key]) || $myts->stripSlashesGPC($val) == $obj->getVar($key) ) continue;
			$obj->setVar($key, $val);
		}
    	if ( $id = $this->insert($obj) ) {
    	    return $id;
    	}
    	return false;
    }
    
    public function getGrids( array $params, $asObj=true ) 
    {
        $criteria = xoAlbum::getCriteria($params);
        $fields = ( isset($params["fields"]) && is_array($params["fields"]) ) ? $params["fields"] : null ;
        $ret = $this->getAll($criteria, $fields, $asObj);
        return $ret;
    }
    
    public function getGridList($id) 
    {
        $params = array(
            "criteria" => array("pic_id"=>$id)
        );
        $objs = $this->getGrids($params);
        
        $ret = array();
        if ( $objs ) {
            foreach ( $objs as $k=>$obj ) {
                $ret[$k]["id"] = $obj->getVar("grid_id","n");
                $ret[$k]["grid_title"] = $obj->getVar("grid_title","n");
                $ret[$k]["style"] = $obj->style();
            }
        }
        return $ret;
    }
}