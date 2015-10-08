<?php
	function membership_admin_package($pid=0) {

		$packages_handler =& xoops_getmodulehandler('packages', 'membership');
		
		if ($pid!=0) {
			$package = $packages_handler->get($pid);
			$sform = new XoopsThemeForm(_MEM_AM_FRM_PACKAGE_EDIT, 'payment', $_SERVER['PHP_SELF'], 'post');
		} else { 
		 	$package = $packages_handler->create();
			$sform = new XoopsThemeForm(_MEM_AM_FRM_PACKAGE_NEW, 'payment', $_SERVER['PHP_SELF'], 'post');
		}
		
		$formobj = array();	
		$eletray = array();
				
		$formobj=array();
		$formobj['pid'] = new XoopsFormHidden('pid['.$pid.']', $pid);
		$formobj['weight'] = new XoopsFormText(_MEM_AM_FRM_PACKAGE_WEIGHT, $pid.'[weight]', 4, 5, $package->getVar('weight'));
		$formobj['title'] = new XoopsFormText(_MEM_AM_FRM_PACKAGE_TITLE, $pid.'[title]', 30, 128, $package->getVar('title'));
		
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$xoMod = $module_handler->getByDirname('membership');
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));
		
		$description_configs = array();
		$description_configs['name'] = $pid.'[description]';
		$description_configs['value'] = $package->getVar('description');
		$description_configs['rows'] = 35;
		$description_configs['cols'] = 60;
		$description_configs['width'] = "100%";
		$description_configs['height'] = "400px";
		$description_configs['editor'] = $xoConfig['editor'];
		$formobj['description'] = new XoopsFormEditor(_MEM_AM_FRM_PACKAGE_DESCRIPTION, $description_configs['name'], $description_configs);
				
		$formobj['currency'] = new XoopsFormText(_MEM_AM_FRM_PACKAGE_CURRENCY, $pid.'[currency]', 3, 3, $package->getVar('currency'));
		$formobj['price'] = new XoopsFormText(_MEM_AM_FRM_PACKAGE_PRICE, $pid.'[price]', 10, 11, $package->getVar('price'));
		$formobj['period'] = new XoopsFormText(_MEM_AM_FRM_PACKAGE_PERIOD, $pid.'[period]', 10, 20, $package->getVar('period'));
		$formobj['period_text'] = new XoopsFormText(_MEM_AM_FRM_PACKAGE_PERIOD_TEXT, $pid.'[period_text]', 10, 128, $package->getVar('period_text'));
		$formobj['groups'] = new XoopsFormSelectGroup(_MEM_AM_FRM_PACKAGE_GROUPS, $pid.'[groups]', false, $package->getVar('groups'), 5, true);
		
		if ($pid>0) {
			$formobj['created'] = new XoopsFormLabel(_MEM_AM_FRM_PACKAGE_CREATED, date(_DATESTRING, $package->getVar('created')));
			$formobj['updated'] = new XoopsFormLabel(_MEM_AM_FRM_PACKAGE_UPDATED, date(_DATESTRING, $package->getVar('updated')));
			$formobj['last'] = new XoopsFormLabel(_MEM_AM_FRM_PACKAGE_LAST, date(_DATESTRING, $package->getVar('last')));
			$formobj['purchases'] = new XoopsFormLabel(_MEM_AM_FRM_PACKAGE_PURCHASES, $package->getVar('purchases'));
		}
				
		$eletray['buttons'] = new XoopsFormElementTray('', '&nbsp;');
		$sformobj['buttons']['save'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		$eletray['buttons']->addElement($sformobj['buttons']['save']);
		$formobj['buttons'] = $eletray['buttons'];
				
		$required = array('weight', 'title', 'currency', 'price', 'period', 'period_text', 'groups');
		
		foreach($formobj as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($formobj[$id], true);			
			else
				$sform->addElement($formobj[$id], false);
	
		$sform->addElement(new XoopsFormHidden('op', 'packages'));	
		$sform->addElement(new XoopsFormHidden('fct', 'save'));	
		
		return $sform->render();
	
	}
	
?>