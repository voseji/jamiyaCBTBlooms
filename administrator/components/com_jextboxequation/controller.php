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
 * Class JextboxequationController
 *
 * @since  1.6
 */
class JextboxequationController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   mixed    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return   JController This object to support chaining.
	 *
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$view = JFactory::getApplication()->input->getCmd('view', 'info');
		JFactory::getApplication()->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}

}
