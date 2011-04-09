<?php
	include ('header.php');
	
	$xoopsOption['template_main'] = 'membership_index.html';
	include_once $GLOBALS['xoops']->path('/header.php');
	
	$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	
	$packages_handler =& xoops_getmodulehandler('packages', 'membership');
	$groupperm_handler =& xoops_gethandler('groupperm');
	
	if (is_object($GLOBALS['xoopsUser']))
		$groups = $GLOBALS['xoopsUser']->getGroups();
	else
		$groups = XOOPS_GROUP_ANONYMOUS;
	
	$pids = $groupperm_handler->getItemIds(_MEM_MI_PERM_ACCESS, $groups, $GLOBALS['xoopsModule']->getVar('mid'));
			
	$criteria = new Criteria('pid','('.implode(',', $pids).')', "IN");
	
	$ttl = $packages_handler->getCount($criteria);
	$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):10;
	$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
	$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'weight';
	
	$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order);
	$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());

	if (is_object($GLOBALS['xoopsUser']))
		$groups = $GLOBALS['xoopsUser']->getGroups();
	else 
		$groups = XOOPS_GROUP_ANONYMOUS;
		
	$criteria->setStart($start);
	$criteria->setLimit($limit);
	$criteria->setSort($sort);
	$criteria->setOrder($order);
	
	$packages = $packages_handler->getObjects($criteria, true);
	foreach($packages as $pid => $package) {
		$GLOBALS['xoopsTpl']->append('packages', $package->toArray());
	}
	
	include_once $GLOBALS['xoops']->path('/footer.php');
	exit(0);