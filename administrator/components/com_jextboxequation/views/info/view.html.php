<?php

/**
 * @version    2.12.0
 * @package    JExtBOX Equation
 * @author     Galaa
 * @copyright  2016-2018 Galaa
 * @license    GNU General Public License version 2 or later
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for Info.
 */
class JExtBOXEquationViewInfo extends JViewLegacy
{

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{

		// Check for errors.
		if (!is_null($errors = $this->get('Errors')) && count($errors))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();

		parent::display($tpl);

	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{

		JToolBarHelper::title(JText::_('COM_JEXTBOXEQUATION'), 'info-2');

		require_once JPATH_COMPONENT.'/helpers/jextboxequation.php';

		$canDo	= JextboxequationHelper::getActions();

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_jextboxequation');
		}

	}

}
