<?php
/**
 * @package     membership
 * @subpackage  module
 * @description	Sector Nexoork Security Drone
 * @author	    Simon Roberts WISHCRAFT <simon@chronolabs.coop>
 * @author	    Richardo Costa TRABIS 
 * @copyright	copyright (c) 2010-2013 XOOPS.org
 * @licence		GPL 2.0 - see docs/LICENCE.txt
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class MembershipCorePreload extends XoopsPreloadItem
{
	
	function eventCoreIncludeCommonEnd($args)
	{
		error_reporting(E_ALL);
		
		xoops_loadLanguage('modinfo', 'membership');
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');		
		$GLOBALS['membershipModule'] = $module_handler->getByDirname('membership');
		if (is_object($GLOBALS['membershipModule'])) {
			$GLOBALS['membershipModuleConfig'] = $config_handler->getConfigList($GLOBALS['membershipModule']->getVar('mid'));
		}
		
	    $result = XoopsCache::read('membership_core_include_common_end');
	    if ((isset($result['time'])?(float)$result['time']:0)<=microtime(true)&&$GLOBALS['membershipModuleConfig']['crontype']=='preloader') {
			XoopsCache::write('membership_core_include_common_end', array('time'=>microtime(true)+$GLOBALS['membershipModuleConfig']['croninterval']), $GLOBALS['membershipModuleConfig']['croninterval']);
			ob_start();
			include_once XOOPS_ROOT_PATH . ( '/modules/membership/cron/expire.php' );
			ob_end_clean();
		}
		
	}

}

?>