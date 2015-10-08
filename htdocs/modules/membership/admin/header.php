<?php
	
	include('../../../include/cp_header.php');
	
	if (!defined('_CHARSET'))
		define("_CHARSET","UTF-8");
	if (!defined('_CHARSET_ISO'))
		define("_CHARSET_ISO","ISO-8859-1");
		
	$GLOBALS['myts'] = MyTextSanitizer::getInstance();
	
	$module_handler = xoops_gethandler('module');
	$config_handler = xoops_gethandler('config');
	if (!isset($GLOBALS['xoopsModule'])) $GLOBALS['xoopsModule'] = $module_handler->getByDirname('membership');
	if (!isset($GLOBALS['xoopsModuleConfig'])) $GLOBALS['xoopsModuleConfig'] = $config_handler->getConfigList($GLOBALS['xoopsModule']->getVar('mid')); 
	
	include_once $GLOBALS['xoops']->path('class'.DS.'cache'.DS.'xoopscache.php');
	include_once $GLOBALS['xoops']->path('class'.DS.'pagenav.php');
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopslists.php');
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopsmailer.php');
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopstree.php');
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopsformloader.php');
	include_once $GLOBALS['xoops']->path('/modules/membership/include/membership.functions.php');
	include_once $GLOBALS['xoops']->path('/modules/membership/include/membership.objects.php');
	include_once $GLOBALS['xoops']->path('/modules/membership/include/membership.forms.php');
	
	xoops_loadLanguage('admin', 'membership');
	
	if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
	        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
	        //return true;
	    }else{
	        echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
	        //return false;
	    }
	$GLOBALS['membershipImageIcon'] = XOOPS_URL .'/'. $GLOBALS['xoopsModule']->getInfo('icons16');
	$GLOBALS['membershipImageAdmin'] = XOOPS_URL .'/'. $GLOBALS['xoopsModule']->getInfo('icons32');
	
	if ($GLOBALS['xoopsUser']) {
	    $moduleperm_handler =& xoops_gethandler('groupperm');
	    if (!$moduleperm_handler->checkRight('module_admin', $GLOBALS['xoopsModule']->getVar( 'mid' ), $GLOBALS['xoopsUser']->getGroups())) {
	        redirect_header(XOOPS_URL, 1, _NOPERM);
	        exit();
	    }
	} else {
	    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
	    exit();
	}

	if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
		include_once(XOOPS_ROOT_PATH."/class/template.php");
		$GLOBALS['xoopsTpl'] = new XoopsTpl();
	}
	
	$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['membershipImageIcon']);
	$GLOBALS['xoopsTpl']->assign('pathImageAdmin', $GLOBALS['membershipImageAdmin']);
	
?>