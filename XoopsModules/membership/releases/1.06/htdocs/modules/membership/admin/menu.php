<?php
global $adminmenu;
$adminmenu=array();
$adminmenu[1]['title'] = _MEM_MI_ADMENU1;
$adminmenu[1]['icon'] = 'images/packages.png';
$adminmenu[1]['image'] = 'images/packages.png';
$adminmenu[1]['link'] = "admin/index.php?op=packages&fct=list";
$adminmenu[2]['title'] = _MEM_MI_ADMENU2;
$adminmenu[2]['icon'] = 'images/add.package.png';
$adminmenu[2]['image'] = 'images/add.package.png';
$adminmenu[2]['link'] = "admin/index.php?op=packages&fct=add";
$adminmenu[3]['title'] = _MEM_MI_ADMENU3;
$adminmenu[3]['icon'] = 'images/permissions.png';
$adminmenu[3]['image'] = 'images/permissions.png';
$adminmenu[3]['link'] = "admin/index.php?op=permissions";

?>