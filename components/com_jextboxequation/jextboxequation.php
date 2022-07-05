<?php
/**
 * @version    CVS: 2.8.2
 * @package    Com_Jextboxequation
 * @author     Galaa <>
 * @copyright  2013-2017 Galaa
 * @license    GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// Get an instance of the controller prefixed by HelloWorld
$controller = JControllerLegacy::getInstance('JextboxEquation');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();

?>
