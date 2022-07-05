<?php
/*
 *
 * @package		ARI Quiz
 * @author		ARI Soft
 * @copyright	Copyright (c) 2011 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

(defined('_JEXEC') && defined('ARI_FRAMEWORK_LOADED')) or die;

AriKernel::import('Joomla.Database.DatabaseQuery');

class AriDBUtils
{
	function quote($value)
	{
		$ret = null;
		$db =& JFactory::getDBO();
		
		if (is_array($value))
		{
			$ret = array();
			foreach ($value as $key => $v)
				$ret[$key] = $db->Quote($v);
		}
		else
			$ret = $db->Quote($value);
			
		return $ret;
	}
	
	function getQuery()
	{
		if (J1_6)
		{
			$db =& JFactory::getDBO();
			return $db->getQuery(true);
		}
		else
			return new JDatabaseQuery();
	}
}