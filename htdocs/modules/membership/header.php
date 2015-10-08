<?php
	include('../../mainfile.php');
	
	include_once $GLOBALS['xoops']->path('/modules/membership/include/membership.functions.php');
	include_once $GLOBALS['xoops']->path('/modules/membership/include/membership.objects.php');
	include_once $GLOBALS['xoops']->path('/modules/membership/include/membership.forms.php');

	xoops_load('pagenav');	
	xoops_load('mailer');
	
	$myts = MyTextSanitizer::getInstance();
		
	
?>