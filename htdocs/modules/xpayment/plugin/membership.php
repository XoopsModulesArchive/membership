<?php
	function PaidMembershipHook($invoice) {
		list($pid, $uid) = explode('|', $invoice->getVar('key'));
		
		$packages_handler =& xoops_getmodulehandler('packages', 'membership');	
		$package = $packages_handler->get($pid);
		
		$member_handler =& xoops_gethandler('member');
		if ($uid>0) {
			foreach($package->getVar('groups') as $groupid) {
				$member_handler->addUserToGroup($groupid, $uid);
			}
		}

		$package->setVar('last', time());
		$package->setVar('purchases', $package->getVar('purchases')+1);
		$packages_handler->insert($package);
		
		$profile_handler =& xoops_getmodulehandler('profile', 'profile');
		$profile = $profile_handler->get($uid);
	
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$xoMod = $module_handler->getByDirname('membership');
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));
			
		if ($profile->getVar($xoConfig['profile_field'])==0||$profile->getVar($xoConfig['profile_field'])<time()+3600) {
			$profile->setVar($xoConfig['profile_field'], time()+($package->getVar('period')*$invoice->getVar('items')));
		} else {
			$profile->setVar($xoConfig['profile_field'], $profile->getVar($xoConfig['profile_field'])+($package->getVar('period')*$invoice->getVar('items')));
		}
		
		$profile_handler->insert($profile);
		
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');		
		return PaidXPaymentHook($invoice);
		
	}
	
	function UnpaidMembershipHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return UnpaidXPaymentHook($invoice);		
	}
	
	function CancelMembershipHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return CancelXPaymentHook($invoice);
	}
	