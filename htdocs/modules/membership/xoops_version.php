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
 *//**
 * @package     xortify
 * @subpackage  module
 * @description	Sector Network Security Drone
 * @author	    Simon Roberts WISHCRAFT <simon@chronolabs.coop>
 * @copyright	copyright (c) 2010-2013 XOOPS.org
 * @licence		GPL 2.0 - see docs/LICENCE.txt
 */


if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}


$modversion['dirname'] 		= basename(dirname(__FILE__));
$modversion['name'] 		= ucfirst(basename(dirname(__FILE__)));
$modversion['version']     	= "1.09";
$modversion['releasedate'] 	= "2012-04-05";
$modversion['status']      	= "Stable";
$modversion['description'] 	= _MI_MEM_DESC;
$modversion['credits']     	= _MI_MEM_CREDITS;
$modversion['author']      	= "Wishcraft";
$modversion['help']        	= "";
$modversion['license']     	= "GPL 2.0";
$modversion['official']    	= 1;
$modversion['image']       	= "images/membership_slogo.png";


$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = 'Frameworks/moduleclasses/icons/32';

$modversion['release_info'] = "Stable 2012/04/05";
$modversion['release_file'] = XOOPS_URL."/modules/membership/docs/changelog.txt";
$modversion['release_date'] = "2012/04/05";

$modversion['author_realname'] = "Simon Antony Roberts";
$modversion['author_website_url'] = "http://www.chronolabs.org.au";
$modversion['author_website_name'] = "Chronolabs Australia";
$modversion['author_email'] = "simon@chronolabs.coop";
$modversion['demo_site_url'] = "Chronolabs Australia";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "http://www.chronolabs.org.au/forums/viewforum.php?forum=30";
$modversion['support_site_name'] = "Chronolabs";
$modversion['submit_bug'] = "http://www.chronolabs.org.au/forums/viewforum.php?forum=30";
$modversion['submit_feature'] = "http://www.chronolabs.org.au/forums/viewforum.php?forum=30";
$modversion['usenet_group'] = "sci.chronolabs";
$modversion['maillist_announcements'] = "";
$modversion['maillist_bugs'] = "";
$modversion['maillist_features'] = "";

$modversion['warning'] = "For XOOPS 2.5.x";

// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Main
$modversion['hasMain'] = 1;

$modversion['tables'][1] = 'membership_packages';

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modversion['system_menu']    	= 1;

// Install Script
$modversion['onInstall'] = "include/install.php";

// Update Script
$modversion['onUpdate'] = "include/onupdate.php";


$i = 0;
// Config items
xoops_load('XoopsEditorHandler');
$editor_handler = XoopsEditorHandler::getInstance();
foreach ($editor_handler->getList(false) as $id => $val)
	$options[$val] = $id;
	
$i++;
$modversion['config'][$i]['name'] = 'editor';
$modversion['config'][$i]['title'] = "_MEM_MI_EDITOR";
$modversion['config'][$i]['description'] = "_MEM_MI_EDITOR_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tinymce';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'expired_group';
$modversion['config'][$i]['title'] = '_MEM_MI_EXPIRED_GROUP';
$modversion['config'][$i]['description'] = '_MEM_MI_EXPIRED_GROUP_DESC';
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = XOOPS_GROUP_USERS;

$i++;
$modversion['config'][$i]['name'] = 'remove_groups';
$modversion['config'][$i]['title'] = '_MEM_MI_REMOVE_GROUP';
$modversion['config'][$i]['description'] = '_MEM_MI_REMOVE_GROUP_DESC';
$modversion['config'][$i]['formtype'] = 'group_multi';
$modversion['config'][$i]['valuetype'] = 'array';

$i++;
$modversion['config'][$i]['name'] = 'profile_field';
$modversion['config'][$i]['title'] = '_MEM_MI_PROFILE_FIELD';
$modversion['config'][$i]['description'] = '_MEM_MI_PROFILE_FIELD_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'membership';

$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_MEM_MI_HTACCESS";
$modversion['config'][$i]['description'] = "_MEM_MI_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_MEM_MI_BASEURL";
$modversion['config'][$i]['description'] = "_MEM_MI_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'membership';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_MEM_MI_ENDOFURL";
$modversion['config'][$i]['description'] = "_MEM_MI_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';


$i++;
$modversion['config'][$i]['name'] = 'crontype';
$modversion['config'][$i]['title'] = '_MEM_MI_CRONTYPE';
$modversion['config'][$i]['description'] = '_MEM_MI_CRONTYPE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'preloader';
$modversion['config'][$i]['options'] = 	array(	_MEM_MI_CRONTYPE_PRELOADER => 'preloader', 
												_MEM_MI_CRONTYPE_CRONTAB => 'crontab', 
												_MEM_MI_CRONTYPE_SCHEDULER => 'scheduler'
										);
										
$i++;
$modversion['config'][$i]['name'] = 'croninterval';
$modversion['config'][$i]['title'] = '_MEM_MI_CRONINTERVAL';
$modversion['config'][$i]['description'] = '_MEM_MI_CRONINTERVAL_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*2;

// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = 'membership_index.html';
$modversion['templates'][$i]['description'] = 'Packages Index!';
$i++;
$modversion['templates'][$i]['file'] = 'membership_item_xpayment.html';
$modversion['templates'][$i]['description'] = 'Package Item Node!';
$i++;
$modversion['templates'][$i]['file'] = 'membership_cpanel_packages_list.html';
$modversion['templates'][$i]['description'] = 'Cpanel Packages List!';
$i++;
$modversion['templates'][$i]['file'] = 'membership_cpanel_packages_edit.html';
$modversion['templates'][$i]['description'] = 'Cpanel Packages Edit!';


?>
