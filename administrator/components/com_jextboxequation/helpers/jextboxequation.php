<?php

/**
 * @version    2.8.0
 * @package    JExtBOX Equation
 * @author     Galaa
 * @copyright  2016 Galaa
 * @license    GNU General Public License version 2 or later
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Jextboxequation helper.
 */
class JextboxequationHelper
{

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_jextboxequation';

		$actions = array
		(
			'core.admin'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

}
