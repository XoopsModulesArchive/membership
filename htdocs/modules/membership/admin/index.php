<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 */	
	include('header.php');
	error_reporting(E_ALL);
	
	$op = (isset($_REQUEST['op']))?strtolower($_REQUEST['op']):'dashboard';
	$fct = (isset($_REQUEST['fct']))?strtolower($_REQUEST['fct']):'';	
	
	xoops_cp_header();

	$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	
	xoops_loadLanguage('admin', 'membership');
		
	switch($op) {
	default:
	case 'dashboard':

		$indexAdmin = new ModuleAdmin();
		echo $indexAdmin->addNavigation('index.php?op=dashboard');	
		
		$invoices_handler = xoops_getmodulehandler('invoice', 'xpayment');
		$packages_handler = xoops_getmodulehandler('packages', 'membership');
		$field_handler = xoops_getmodulehandler('field', 'profile');
	 	
		$indexAdmin = new ModuleAdmin();
	    $indexAdmin->addInfoBox(_MEM_AM_ADMIN_REQUIREMENTS);
	    $indexAdmin->addInfoBoxLine(_MEM_AM_ADMIN_REQUIREMENTS, "<label>"._MEM_AM_ADMIN_PROFILE_FIELD."</label>", $GLOBALS['xoopsModuleConfig']['profile_field'], 'Blue');
	    $indexAdmin->addInfoBoxLine(_MEM_AM_ADMIN_REQUIREMENTS, "<label>"._MEM_AM_EXISTS_PROFILE_FIELD."</label>", (($i = $field_handler->getCount(new Criteria('field_name', $GLOBALS['xoopsModuleConfig']['profile_field'])))>0?_YES:_NO), ($i>0?'Green':'Red'));
	 	
	 	$indexAdmin->addInfoBox(_MEM_AM_ADMIN_COUNTS);
	    $criteria = new CriteriaCompo(new Criteria('`mode`', 'UNPAID'));
	    $criteria->add(new Criteria('plugin', 'membership'));
	    $indexAdmin->addInfoBoxLine(_MEM_AM_ADMIN_COUNTS, "<label>"._MEM_AM_ADMIN_THEREARE_INVOICES_UNPAID."</label>", $invoices_handler->getCount($criteria), 'Green');
	    $criteria = new CriteriaCompo(new Criteria('`mode`', 'PAID'));
	    $criteria->add(new Criteria('plugin', 'membership'));
	    $indexAdmin->addInfoBoxLine(_MEM_AM_ADMIN_COUNTS, "<label>"._MEM_AM_ADMIN_THEREARE_INVOICES_PAID."</label>", $invoices_handler->getCount($criteria), 'Green');
	    $indexAdmin->addInfoBoxLine(_MEM_AM_ADMIN_COUNTS, "<label>"._MEM_AM_ADMIN_THEREARE_PACKAGES."</label>", $packages_handler->getCount(NULL), 'Orange');
	    $indexAdmin->addInfoBoxLine(_MEM_AM_ADMIN_COUNTS, "<label>"._MEM_AM_ADMIN_AMOUNT_INVOICES."</label>", $invoices_handler->getSumByField('grand', '`plugin`', 'membership', array(), 'AND'), 'Purple');
	    if ($GLOBALS['xoopsModuleConfig']['crontype']=='preloader') {
	    	$result = XoopsCache::read('membership_core_include_common_end');
	    	if (isset($result['time']))
	    		$indexAdmin->addInfoBoxLine(_MEM_AM_ADMIN_COUNTS, "<label>"._MEM_AM_ADMIN_NEXTRUN_PRELOAD."</label>", date(_DATESTRING, $result['time']), 'Blue');
	    }	    
	    echo $indexAdmin->renderIndex();
		
		break;				
	    	
	case  'about':

		$indexAdmin = new ModuleAdmin();
		echo $indexAdmin->addNavigation('index.php?op=about');	
		
		$paypalitemno='MEMBERSHIP106';
		$aboutAdmin = new ModuleAdmin();
		$about = $aboutAdmin->renderabout($paypalitemno, false);
		$donationform = array(	0 => '<form name="donation" id="donation" action="http://www.chronolabs.coop/modules/xpayment/" method="post" onsubmit="return xoopsFormValidate_donation();">',
								1 => '<table class="outer" cellspacing="1" width="100%"><tbody><tr><th colspan="2">'.constant('_MEM_AM_ABOUT_MAKEDONATE').'</th></tr><tr align="left" valign="top"><td class="head"><div class="xoops-form-element-caption-required"><span class="caption-text">Donation Amount</span><span class="caption-marker">*</span></div></td><td class="even"><select size="1" name="item[A][amount]" id="item[A][amount]" title="Donation Amount"><option value="5">5.00 AUD</option><option value="10">10.00 AUD</option><option value="20">20.00 AUD</option><option value="40">40.00 AUD</option><option value="60">60.00 AUD</option><option value="80">80.00 AUD</option><option value="90">90.00 AUD</option><option value="100">100.00 AUD</option><option value="200">200.00 AUD</option></select></td></tr><tr align="left" valign="top"><td class="head"></td><td class="even"><input class="formButton" name="submit" id="submit" value="'._SUBMIT.'" title="'._SUBMIT.'" type="submit"></td></tr></tbody></table>',
								2 => '<input name="op" id="op" value="createinvoice" type="hidden"><input name="plugin" id="plugin" value="donations" type="hidden"><input name="donation" id="donation" value="1" type="hidden"><input name="drawfor" id="drawfor" value="Chronolabs Co-Operative" type="hidden"><input name="drawto" id="drawto" value="%s" type="hidden"><input name="drawto_email" id="drawto_email" value="%s" type="hidden"><input name="key" id="key" value="%s" type="hidden"><input name="currency" id="currency" value="AUD" type="hidden"><input name="weight_unit" id="weight_unit" value="kgs" type="hidden"><input name="item[A][cat]" id="item[A][cat]" value="XDN%s" type="hidden"><input name="item[A][name]" id="item[A][name]" value="Donation for %s" type="hidden"><input name="item[A][quantity]" id="item[A][quantity]" value="1" type="hidden"><input name="item[A][shipping]" id="item[A][shipping]" value="0" type="hidden"><input name="item[A][handling]" id="item[A][handling]" value="0" type="hidden"><input name="item[A][weight]" id="item[A][weight]" value="0" type="hidden"><input name="item[A][tax]" id="item[A][tax]" value="0" type="hidden"><input name="return" id="return" value="http://www.chronolabs.coop/modules/donations/success.php" type="hidden"><input name="cancel" id="cancel" value="http://www.chronolabs.coop/modules/donations/success.php" type="hidden"></form>',																'D'=>'',
								3 => '',
								4 => '<!-- Start Form Validation JavaScript //-->
<script type="text/javascript">
<!--//
function xoopsFormValidate_donation() { var myform = window.document.donation; 
var hasSelected = false; var selectBox = myform.item[A][amount];for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected == true && selectBox.options[i].value != \'\') { hasSelected = true; break; } }if (!hasSelected) { window.alert("Please enter Donation Amount"); selectBox.focus(); return false; }return true;
}
//--></script>
<!-- End Form Validation JavaScript //-->');
	$paypalform = array(	0 => '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">',
								1 => '<input name="cmd" value="_s-xclick" type="hidden">',
								2 => '<input name="hosted_button_id" value="%s" type="hidden">',
								3 => '<img alt="" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" height="1" border="0" width="1">',
								4 => '<input src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" border="0" type="poster">',
								5 => '</form>');
		for($key=0;$key<=4;$key++) {
			switch ($key) {
				case 2:
					$donationform[$key] =  sprintf($donationform[$key], $GLOBALS['xoopsConfig']['sitename'] . ' - ' . (strlen($GLOBALS['xoopsUser']->getVar('name'))>0?$GLOBALS['xoopsUser']->getVar('name'). ' ['.$GLOBALS['xoopsUser']->getVar('uname').']':$GLOBALS['xoopsUser']->getVar('uname')), $GLOBALS['xoopsUser']->getVar('email'), XOOPS_LICENSE_KEY, strtoupper($GLOBALS['xoopsModule']->getVar('dirname')),  strtoupper($GLOBALS['xoopsModule']->getVar('dirname')). ' '.$GLOBALS['xoopsModule']->getVar('name'));
					break;
			}
		}
		
		$istart = strpos($about, ($paypalform[0]), 1);
		$iend = strpos($about, ($paypalform[5]), $istart+1)+strlen($paypalform[5])-1;
		echo (substr($about, 0, $istart-1));
		echo implode("\n", $donationform);
		echo (substr($about, $iend+1, strlen($about)-$iend-1));
		
		break;				
		
	case "packages":
		switch ($fct)
		{
		default:
		case "list":
			$indexAdmin = new ModuleAdmin();
	   		echo $indexAdmin->addNavigation('index.php?op=packages&fct=list');
	   	
			$packages_handler =& xoops_getmodulehandler('packages', 'membership');
			
			$ttl = $packages_handler->getCount(NULL);
			$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
			$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
			$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
			$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'weight';
			
			$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct);
			$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());

			foreach (array(	'weight','title','currency','price','period','period_text','groups', 'last', 'purchases') as $id => $key) {
				$GLOBALS['xoopsTpl']->assign(strtolower($key.'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$op.'&fct='.$fct.'">'.(defined('_MEM_AM_TH_'.strtoupper($key))?constant('_MEM_AM_TH_'.strtoupper($key)):'_MEM_AM_TH_'.strtoupper($key)).'</a>');
			}
			
			$criteria = new Criteria('1','1');
			$criteria->setStart($start);
			$criteria->setLimit($limit);
			$criteria->setSort($sort);
			$criteria->setOrder($order);
			
			$packages = $packages_handler->getObjects($criteria, true);
			foreach($packages as $pid => $package) {
				$GLOBALS['xoopsTpl']->append('packages', $package->toArray());
			}
					
			$GLOBALS['xoopsTpl']->display('db:membership_cpanel_packages_list.html');
			break;
		case 'add':
			$indexAdmin = new ModuleAdmin();
	   		echo $indexAdmin->addNavigation('index.php?op=packages&fct=add');
	   	
			$GLOBALS['xoopsTpl']->assign('form', membership_admin_package('0'));
			$GLOBALS['xoopsTpl']->assign('pid', 0);		
			$GLOBALS['xoopsTpl']->display('db:membership_cpanel_packages_edit.html');
			break;
		case 'edit':
			$indexAdmin = new ModuleAdmin();
	   		echo $indexAdmin->addNavigation('index.php?op=packages&fct=list');
			
			$GLOBALS['xoopsTpl']->assign('form', membership_admin_package($_REQUEST['pid']));
			$GLOBALS['xoopsTpl']->assign('pid', $_REQUEST['pid']);	
			$GLOBALS['xoopsTpl']->display('db:membership_cpanel_packages_edit.html');
			break;		
		case 'delete':
			if (!isset($_POST['confirm'])) {
				xoops_confirm(array('confirm'=>true,'op'=>$op,'fct'=>$fct,'pid'=>$_REQUEST['pid']), $_SERVER['PHP_SELF'], _MEM_AM_MSG_CONFIRM_DELETE);
				xoops_cp_footer();
				exit(0);
			}			
			$packages_handler =& xoops_getmodulehandler('packages', 'membership');
			$package = $packages_handler->get($_REQUEST['pid']);
			$packages_handler->delete($package);
			redirect_header($_SERVER['PHP_SELF'].'?op=packages&fct=list', 3, _MEM_AM_MSG_PACKAGE_DELETED);
			exit(0);
			break;
		case 'save':
			$packages_handler =& xoops_getmodulehandler('packages', 'membership');
			foreach($_POST['pid'] as $pid) {
				if ($pid!=0)
					$package = $packages_handler->get($pid);
				else 
				 	$package = $packages_handler->create(); 	
				
				$package->setVars($_POST[$pid]);
				 	
				$packages_handler->insert($package);
			}
			redirect_header($_SERVER['PHP_SELF'].'?op=packages&fct=list', 3, _MEM_AM_MSG_PACKAGES_SAVED);
			break;
		}
		break;
	case 'permissions':
		$indexAdmin = new ModuleAdmin();
	   	echo $indexAdmin->addNavigation('index.php?op=permissions');
	   	
		include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

		$module_handler =& xoops_gethandler('module');
		$xoMod = $module_handler->getByDirname('membership');
	
		$opform = new XoopsThemeForm(_MEM_AM_PERM_ACTION, 'actionform', 'index.php?op=permissions', "get");
		$op_select = new XoopsFormSelect("", 'action');
		$op_select->setExtra('onchange="document.forms.actionform.submit()"');
		$op_select->addOptionArray(array(
			_MEM_MI_PERM_ACCESS=>_MEM_MI_PERM_ACCESS_DESC, 
			));
		$op_select->setValue((isset($_REQUEST['action'])?$_REQUEST['action']:_MEM_MI_PERM_ACCESS));
		$opform->addElement($op_select);
		$opform->display();
		
		switch ((isset($_REQUEST['action'])?$_REQUEST['action']:_MEM_MI_PERM_ACCESS)) {
		default:
		case _MEM_MI_PERM_ACCESS:	
			
			echo "
				<fieldset><legend style='font-weight: bold; color: #900;'>"._MEM_AM_PERM_ACCESS_HEADER."</legend>\n
				<div style='padding: 2px;'>\n";
			
		
			$permform = new XoopsGroupPermForm('', $xoMod->getVar('mid'), _MEM_MI_PERM_ACCESS, _MEM_AM_PERM_ACCESS_DESC, '/admin/index.php?op=permissions&action='.(isset($_REQUEST['action'])?$_REQUEST['action']:_MEM_MI_PERM_ACCESS));
			
			$packages_handler =& xoops_getmodulehandler('packages', 'membership');
			$packages = $packages_handler->getObjects(NULL, true); 
			
			foreach($packages as $pid => $package)
				$permform->addItem($pid, ucfirst($package->getVar('title')));
		
			echo $permform->render();
			echo "</div></fieldset><br />";
			unset ($permform);
			break;
		}
		break;
	}
	
	xoops_cp_footer();
?>