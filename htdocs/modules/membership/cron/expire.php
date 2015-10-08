<?php
	include('../header.php');

	xoops_loadLanguage('cron', 'membership');
	
	$module_handler =& xoops_gethandler('module');
	$config_handler =& xoops_gethandler('config');
	$user_handler =& xoops_gethandler('user');
		
	$xoMod = $module_handler->getByDirname('membership');
	if (is_object($xoMod)) {
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));
		if ($xoMod->getVar('isactive')) {
			$sql = "SELECT DISTINCT a.profile_id as uid FROM ".$GLOBALS['xoopsDB']->prefix('profile_profile')." a INNER JOIN ".$GLOBALS['xoopsDB']->prefix('groups_users_link')." b ON a.profile_id = b.uid WHERE b.groupid IN (".implode(',', $xoConfig['remove_groups']).") AND a.".$xoConfig['profile_field']." < ".time();
			
			$result = $GLOBALS['xoopsDB']->queryF($sql);
			
			while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
						
				$sql = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('groups_users_link')." WHERE groupid IN (".implode(',', $xoConfig['remove_groups']).") AND uid = ".$row['uid'];
				$GLOBALS['xoopsDB']->queryF($sql);

				$sql = "INSERT INTO ".$GLOBALS['xoopsDB']->prefix('groups_users_link')." (groupid, uid) VALUE(".$xoConfig['expired_group'].",".$row['uid'].")";
				$GLOBALS['xoopsDB']->queryF($sql);

				$user = $user_handler->get($row['uid']);
				
				$xoopsMailer =& getMailer();
				$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/membership/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
				$xoopsMailer->setTemplate('membership_expired.tpl');
				$xoopsMailer->setSubject(sprintf(_MEM_EMAIL_EXPIRED_SUBJECT, $user->getVar('uname'), date(_DATESTRING, $user->getVar('last_login'))));
				
				$xoopsMailer->setToEmails($user->getVar('email'));
				
				$xoopsMailer->assign("SITEURL", XOOPS_URL);
				$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
				$xoopsMailer->assign("MEMBERSHIPURL", XOOPS_URL.'/modules/membership/');
				
				if(!$xoopsMailer->send() ){
					xoops_error($xoopsMailer->getErrors(true), 'Email Send Error');
				}
			}
		}
	}
?>	