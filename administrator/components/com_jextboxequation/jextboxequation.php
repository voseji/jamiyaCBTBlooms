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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_jextboxequation'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Jextboxequation', JPATH_COMPONENT_ADMINISTRATOR);

$controller = JControllerLegacy::getInstance('Jextboxequation');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
