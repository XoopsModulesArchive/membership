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
 *//*
Module: Xcenter

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/



if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Blue Room Xcenter
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class MembershipPackages extends XoopsObject
{

    function MembershipPackages($id = null)
    {
        $this->initVar('pid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('description', XOBJ_DTYPE_OTHER, null, false, 5000);
		$this->initVar('currency', XOBJ_DTYPE_TXTBOX, 'AUD', false, 3);
		$this->initVar('price', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('period', XOBJ_DTYPE_INT, 31536000, false);
		$this->initVar('period_text', XOBJ_DTYPE_TXTBOX, '1 Year', false, 128);
		$this->initVar('groups', XOBJ_DTYPE_ARRAY, array(), false);
		$this->initVar('created', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('last', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('purchases', XOBJ_DTYPE_INT, 0, false);
	
    }
	
	function toArray() {
		
		$ret = parent::toArray();
		
		xoops_load('XoopsFormLoader');
		$formobj=array();
		$formobj['pid'] = new XoopsFormHidden('pid['.$this->getVar('pid').']', $this->getVar('pid'));
		$formobj['weight'] = new XoopsFormText('', $this->getVar('pid').'[weight]', 4, 5, $this->getVar('weight'));
		$formobj['title'] = new XoopsFormText('', $this->getVar('pid').'[title]', 30, 128, $this->getVar('title'));
		$formobj['currency'] = new XoopsFormText('', $this->getVar('pid').'[currency]', 3, 3, $this->getVar('currency'));
		$formobj['price'] = new XoopsFormText('', $this->getVar('pid').'[price]', 10, 11, $this->getVar('price'));
		$formobj['period'] = new XoopsFormText('', $this->getVar('pid').'[period]', 10, 20, $this->getVar('period'));
		$formobj['period_text'] = new XoopsFormText('', $this->getVar('pid').'[period_text]', 10, 128, $this->getVar('period_text'));
		$formobj['groups'] = new XoopsFormSelectGroup('', $this->getVar('pid').'[groups]', false, $this->getVar('groups'), 5, true);
		
		foreach(array_keys($formobj) as $id)
			$ret['form'][$id] = $formobj[$id]->render();

		$ret['description'] = $this->getVar('description');
		
		$ret['created_datetime'] = date(_DATESTRING, $this->getVar('created'));
		$ret['updated_datetime'] = date(_DATESTRING, $this->getVar('updated'));
		$ret['last_datetime'] = date(_DATESTRING, $this->getVar('last'));
		
		if (is_object($GLOBALS['xoopsUser']))
			$ret['user'] = $GLOBALS['xoopsUser']->toArray();
			
		return $ret;
	}
		
}


/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class MembershipPackagesHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'membership_packages', 'MembershipPackages', "pid", "title");
    }
    
    function insert($object, $force = true)
    {
    	if ($object->isNew())
    		$object->setVar('created', time());
    	else 
    		$object->setVar('updated', time());
    
    	return parent::insert($object, $force);
    }
	
}

?>