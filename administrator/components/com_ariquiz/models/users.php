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

AriKernel::import('Joomla.Database.DBUtils');
AriKernel::import('Utils.ArrayHelper');

class AriQuizModelUsers extends AriModel 
{
	function getUserList($gid = null)
	{
		$db =& $this->getDBO();
		
		$query = AriDBUtils::getQuery();
		$query->select(
			array(
				'U.id AS UserId',
				'U.name AS Name',
				'U.username AS LoginName',
				'U.email AS Email'
			)
		);
		$query->from('#__users U');
		if ($gid)
		{
			$gid = AriArrayHelper::toInteger($gid, 0);
			if (count($gid) == 0)
				return null;
			
			if (J1_5)
				$query->where('U.gid IN (' . join(',', $gid) . ')');
			else
			{
				$query->innerJoin('#__user_usergroup_map M ON U.id = M.user_id');
				$query->where('M.group_id IN (' . join(',', $gid) . ')');
				$query->group('U.id');
			}
		}

		$db->setQuery((string)$query);
		$users = $db->loadObjectList();
		if ($db->getErrorNum())
		{
			JError::raiseError(
				500, 
				JText::sprintf(
					'COM_ARIQUIZ_ERROR_SQL_QUERY', 
					__CLASS__ . '::' . __FUNCTION__ . '()', 
					$db->getQuery(), 
					$db->getErrorMsg()
				)
			);
			return null;
		}

		return $users;
	}
	
}