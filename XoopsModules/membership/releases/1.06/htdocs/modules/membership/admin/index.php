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
	xoops_cp_header();
	
	include_once $GLOBALS['xoops']->path( "/class/template.php" );
	$GLOBALS['membershipTpl'] = new XoopsTpl();
	$GLOBALS['membershipTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	
	xoops_loadLanguage('admin', 'membership');
		
	switch($_REQUEST['op']) {
	default:
	case "packages":	
		switch ($_REQUEST['fct'])
		{
		default:
		case "list":
			$packages_handler =& xoops_getmodulehandler('packages', 'membership');
			
			$ttl = $packages_handler->getCount(NULL);
			$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
			$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
			$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
			$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'weight';
			
			$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct']);
			$GLOBALS['membershipTpl']->assign('pagenav', $pagenav->renderNav());

			foreach (array(	'weight','title','currency','price','period','period_text','groups', 'last', 'purchases') as $id => $key) {
				$GLOBALS['membershipTpl']->assign(strtolower($key.'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$_REQUEST['op'].'&fct='.$_REQUEST['fct'].'">'.(defined('_MEM_AM_TH_'.strtoupper($key))?constant('_MEM_AM_TH_'.strtoupper($key)):'_MEM_AM_TH_'.strtoupper($key)).'</a>');
			}
			
			$criteria = new Criteria('1','1');
			$criteria->setStart($start);
			$criteria->setLimit($limit);
			$criteria->setSort($sort);
			$criteria->setOrder($order);
			
			$packages = $packages_handler->getObjects($criteria, true);
			foreach($packages as $pid => $package) {
				$GLOBALS['membershipTpl']->append('packages', $package->toArray());
			}
					
			$GLOBALS['membershipTpl']->display('db:membership_cpanel_packages_list.html');
			break;
		case 'add':

			$GLOBALS['membershipTpl']->assign('form', membership_admin_package('0'));
			$GLOBALS['membershipTpl']->assign('pid', 0);		
			$GLOBALS['membershipTpl']->display('db:membership_cpanel_packages_edit.html');
			break;
		case 'edit':

			$GLOBALS['membershipTpl']->assign('form', membership_admin_package($_REQUEST['pid']));
			$GLOBALS['membershipTpl']->assign('pid', $_REQUEST['pid']);	
			$GLOBALS['membershipTpl']->display('db:membership_cpanel_packages_edit.html');
			break;		
		case 'delete':
			if (!isset($_POST['confirm'])) {
				xoops_confirm(array('confirm'=>true,'op'=>$_REQUEST['op'],'fct'=>$_REQUEST['fct'],'pid'=>$_REQUEST['pid']), $_SERVER['PHP_SELF'], _MEM_AM_MSG_CONFIRM_DELETE);
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