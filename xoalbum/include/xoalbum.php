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

if ( !class_exists("XoopsMediaUploader") ) {
    include XOOPS_ROOT_PATH."/class/uploader.php";
}

class xoAlbum 
{
	private static function _getkey(){
	    return "Rdkfd4asdfGFye9834";
	}
	
	/**
	 * Check post fields
	 *
	 * @param string $classname
	 * @param array $params
	 * @param bool $token
	 * @return $msg
	 */
	public static function checkSubmitFields($classname, array $params, $token=true) 
	{
		$classname = strtolower($classname);
		if ( empty($classname) || !file_exists(dirname(dirname(__FILE__))."/class/{$classname}.php") ) return false;
		
		if ( true === $token ) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				$msg = "抱歉，页面已过期!";
				return $msg;
			}
		}
		
		$msg = array();
		
		$check_handler = xoops_getmodulehandler($classname);
		$check_obj = $check_handler->create();
		$check_vars = $check_obj->vars;
		
		foreach ( $params as $k=>$val ) {
			if ( !empty($check_vars[$k]["required"]) && !trim($val) ) {
				$msg[] = "字段 {$k} 不能为空";
			}
			
			if ( !empty($check_vars[$k]["required"]) && trim($val) &&
				 $check_vars[$k]["data_type"] != self::checkFieldType($val,$check_vars[$k]["data_type"]) ) {
				$msg[] = "字段 {$k} 类型错误";
			}
		}
		
		if ( empty($msg) ) {
			return true;
		}
		return implode("<br />",$msg);
	}

	/**
	 * Enter description here...
	 *  define('XOBJ_DTYPE_TXTBOX',     1);
	 *  define('XOBJ_DTYPE_TXTAREA',    2);
	 *  define('XOBJ_DTYPE_INT',        3);
	 *  define('XOBJ_DTYPE_URL',        4);
	 *  define('XOBJ_DTYPE_EMAIL',      5);
	 *  define('XOBJ_DTYPE_ARRAY',      6);
	 *  define('XOBJ_DTYPE_OTHER',      7);
	 *  define('XOBJ_DTYPE_SOURCE',     8);
	 *  define('XOBJ_DTYPE_STIME',      9);
	 *  define('XOBJ_DTYPE_MTIME',      10);
	 *  define('XOBJ_DTYPE_LTIME',      11);
	 * @param string $val
	 * @param int $type
	 * @return int $val 
	 */
	public static function checkFieldType($val, $type=1) 
	{
		if ( empty($val) || empty($type) ) return false;
		switch ($type) {
			case XOBJ_DTYPE_TXTBOX:
				if ( true === is_string($val) ) {
					return XOBJ_DTYPE_TXTBOX;
				}
				break;
				
			case XOBJ_DTYPE_TXTAREA:
				if ( true === is_string($val) ) {
					return XOBJ_DTYPE_TXTAREA;
				}
				break;
				
			case XOBJ_DTYPE_OTHER:
				if ( true === is_string($val) ) {
					return XOBJ_DTYPE_OTHER;
				}
				break;
				
			case XOBJ_DTYPE_INT:
				if ( true === is_int((int)$val) ) {
					return XOBJ_DTYPE_INT;
				}
				break;
				
			case XOBJ_DTYPE_URL:
				if ( preg_match("/^http[s]*:\/\//i", $val) ) {
					return XOBJ_DTYPE_URL; 
				}
				break;
				
			case XOBJ_DTYPE_EMAIL:
				if ( preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i",$val) ) {
					return XOBJ_DTYPE_EMAIL; 
				}
				break;
				
			case XOBJ_DTYPE_ARRAY:
				if ( is_array($val) ) {
					return XOBJ_DTYPE_ARRAY; 
				}
				break;
				
			case XOBJ_DTYPE_STIME:
				if ( strtotime($val) ) {
					return XOBJ_DTYPE_STIME;
				}
				break;
				
			case XOBJ_DTYPE_MTIME:
				if ( strtotime($val) ) {
					return XOBJ_DTYPE_MTIME;
				}
				break;
				
			case XOBJ_DTYPE_LTIME:
				if ( strtotime($val) ) {
					return XOBJ_DTYPE_LTIME;
				}
				break;
				
			default:
				return false;
				
		}
		
	}
	
	public static function uploadSign($str=null)
	{ 
	    if ( null == $str || empty($str) ) return false;
	    $sgin = md5($str.self::_getkey());
	    return $sgin;
	}
	
	public static function checkSign($str=null,$sign)
	{
	    if ( strtoupper(md5($str.self::_getkey())) == strtoupper($sign) ) {
	        return true;
	    }
	    return false;
	}
	
	/**
	 * dirname album_20091011
	 *         album_20091011_small
	 *
	 * @param unknown_type $srcdir
	 * @param unknown_type $thumbdir
	 * @return unknown
	 */
	public static function setDirname( array $params )
    {
        extract($params);
        $prefix = !empty($prefix) ? $prefix : "album";
        
        $file_dirname = $prefix . "_" . date("Ymd");
        $path_file = XOOPS_VAR_PATH . "/{$file_dirname}";
        if ( !is_dir($path_file) ) {
            if ( !@mkdir($path_file, 0777) ) return false ;
			@chmod($path_file, 0777);
        }
        $path_thumb = XOOPS_UPLOAD_PATH. "/{$file_dirname}";
        if ( !is_dir($path_thumb) ) {
            if ( !@mkdir($path_thumb, 0777) ) return false ;
            if ( !@mkdir($path_thumb."_small", 0777) ) return false ;
			@chmod($path_thumb, 0777);
			@chmod($path_thumb."_small", 0777);
        }
        
        $upload_dirname = array(
            "image"=> array(
                    "path"=>$path_file,
                    "dirname"=>$file_dirname
                ),
            "thumb"=> array()
        );
        $upload_dirname["thumb"][] = array(
            "path"=>$path_thumb,
            "dirname"=>$file_dirname
        );
        $upload_dirname["thumb"][] = array(
            "path"=>$path_thumb . "_small",
            "dirname"=>$file_dirname . "_small"
        );
        return $upload_dirname;
    }
	
    public static function uploadFile( array $params )
    {
        extract($params);
        if ( empty($upload_path) || empty($filename) ) return false;
        $prefix = !empty($prefix) ? $prefix : date("YmdHis");
		$image_maxsize = $_FILES[$filename]["size"];
        if ( !$allow_filetype || !is_array($allow_filetype) ) return false;
        $uploader = new XoopsMediaUploader($upload_path, $allow_filetype, $image_maxsize);
        if ( false == $uploader->fetchMedia($filename) ) return false;
	    $uploader->setPrefix($prefix."_");
	    if ( $uploader->upload() ) {
	        return $uploader->getSavedFileName(); 
	    }
	    return false; 
    }
    
    public static function createThumb( array $params ) 
    {
        extract($params);
        if ( null==$thumb_wh || !is_array($thumb_wh) )  return false;
		$src_file = $image_filename;
		$new_file = $thumb_filename;
		
		if ( !filesize($src_file) || !is_readable($src_file)) {
			return false;
		}
		
		if( $image_info[0] <= $thumb_wh[0] && $image_info[1] <= $thumb_wh[1]) {
			@copy($src_file,$new_file);
			return true;
		}
		
		$newWidth = (int)(min($image_info[0],$thumb_wh[0]));
		$newHeight = (int)($image_info[1] * $newWidth / $image_info[0]);
	
		if ( $newHeight > $thumb_wh[1] ) {
			$newHeight = (int)(min($image_info[1],$thumb_wh[1]));
			$newWidth  = (int)($image_info[0] * $newHeight / $image_info[1]);
		}
		
		$type = $image_info[2];
		$supported_types = array();
		if (!extension_loaded("gd")) return false;
		if (function_exists("imagegif")) $supported_types[] = 1;
		if (function_exists("imagejpeg"))$supported_types[] = 2;
		if (function_exists("imagepng")) $supported_types[] = 3;
		
	    $imageCreateFunction = (function_exists("imagecreatetruecolor"))? "imagecreatetruecolor" : "imagecreate";
	
		if (in_array($type, $supported_types) )
		{
			switch ($type)
			{
				case 1 :
				if (!function_exists("imagecreatefromgif")) return false;
				$im = imagecreatefromgif($src_file);
				$new_im = imagecreate($newWidth, $newHeight);
				if(function_exists("ImageCopyResampled"))
				ImageCopyResampled($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight,$image_info[0],$image_info[1]); 
				else
				ImageCopyResized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $image_info[0],$image_info[1]);
				imagegif($new_im, $new_file);
				imagedestroy($im);
				imagedestroy($new_im);
				break;
			case 2 :
				$im = imagecreatefromjpeg($src_file);
				$new_im = $imageCreateFunction($newWidth, $newHeight);
				if(function_exists("ImageCopyResampled"))
				ImageCopyResampled($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight,$image_info[0],$image_info[1]); 
				else
				ImageCopyResized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $image_info[0],$image_info[1]);
				imagejpeg($new_im, $new_file,90);
				imagedestroy($im);
				imagedestroy($new_im);
				break;
			case 3 :
				$im = imagecreatefrompng($src_file);
				$new_im = $imageCreateFunction($newWidth, $newHeight);
				if(function_exists("ImageCopyResampled"))
				ImageCopyResampled($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight,$image_info[0],$image_info[1]); 
				else
				ImageCopyResized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $image_info[0],$image_info[1]);
				imagepng($new_im, $new_file);
				imagedestroy($im);
				imagedestroy($new_im);
				break;
			}
			return true;
		}
		return false;
    }
	
	public static function addModConf( array $configs ) 
	{
	    global $xoTheme, $xoopsModule;
	    $myts =  MyTextSanitizer::getInstance();
	    extract($configs);
	    if ( $jscript ) {
	        foreach ( $jscript as $val ){
	            $xoTheme->addScript( XOOPS_URL ."/modules/{$xoopsModule->getVar("dirname","n")}/{$myts->stripSlashesGPC($val)}" );
	        }
	    }
	    if ( $style ) {
	        foreach ( $style as $val ){
	            $xoTheme->addStylesheet( XOOPS_URL ."/modules/{$xoopsModule->getVar("dirname","n")}/{$myts->stripSlashesGPC($val)}" );
	        }
	    }
	    return ;
	}
	/**
     * select xoops users table, max limit 30 
     *
     * @param array $user_ids
     * @param bool $online
     * @return array $ret array("uid","name","avatar")
     */
	public static function getUsers( array $user_ids, $online=false ) 
	{
		$ret = array();
		$user_handler = xoops_gethandler("member");
		$criteria = new CriteriaCompo();
		$criteria->add( new Criteria("uid"," ( " . implode(",",$user_ids) . " ) ","in") );
		$users = $user_handler->getUsers($criteria);
        
        if ( !empty($online) ) {
            unset($criteria);
	    	$online_handler = xoops_gethandler("online");
			$criteria = new CriteriaCompo(new Criteria("online_uid"," ( " . implode(",",$user_ids) . " ) ","in"));
			$ol_objs = $online_handler->getAll($criteria);
			$onlines = array();
			if ( $ol_objs ) {
				foreach ( $ol_objs as $k=>$obj ) {
					$onlines[$k] = true;
				}
			}
    	}
    	
        if ( !empty($users) ) {
            foreach ( $users as $k=>$obj ) {
                $ret[$obj->uid()]["uid"] = $obj->uid();
                $ret[$obj->uid()]["name"] = $obj->name() ? $obj->name() : $obj->uname() ;
                $ret[$obj->uid()]["avatar"] = $obj->user_avatar();
                $ret[$obj->uid()]["online"] = isset($onlines[$obj->uid()]) ? $onlines[$obj->uid()] : false;
            }
        }
        return $ret;
	}
	
	public static function getCriteria ( array $params ) {
		$criteria = new CriteriaCompo();
        if ( isset($params["criteria"]) && is_array($params["criteria"]) ) {
            foreach( $params["criteria"] as $k=>$val ) {
                if ( is_array($val) ) {                    
                    $criteria->add( new Criteria($k," ( " . implode(",",$val) . " ) ","in") );
                } else {
                    $criteria->add( new Criteria($k,$val) );
                }
            }
        }
        if ( isset($params["start"]) ) {
            $criteria->setStart( intval($params["start"]) );
        }
        if ( isset($params["limit"]) ) {
            $criteria->setLimit( intval($params["limit"]) );
        }
        if ( isset($params["order"]) ) {
			$criteria->setOrder( trim($params["order"]) );
        }
        if ( isset($params["sort"]) ) {
            $sort_str = $params["sort"] ;
            if ( is_array($sort_str) ) {
                $order = isset($params["order"]) ? $params["order"] : "ASC";
                $sort = "";
                $_fields = array_keys($sort_str);
                $sort .= "{$_fields["0"]} {$sort_str[$_fields["0"]]} ";
                for ( $i=1; $i<count($_fields)-1; $i++ ) {
                    $sort .= ", {$_fields[$i]} {$sort_str[$_fields[$i]]} ";
                }
                $sort .= ", {$_fields[count($sort_str)-1]}";
                $sort_str = $sort;
            } 
            $criteria->setSort( $sort_str );
        }
        return $criteria;		
	}
}


