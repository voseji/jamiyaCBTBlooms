<?php

/**
 * @version    2.8.0
 * @package    JExtBOX Equation
 * @author     Galaa
 * @copyright  2016 Galaa
 * @license    GNU General Public License version 2 or later
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * JExtBOXEquation model.
 */
class JExtBOXEquationModelInsert extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_JEXTBOXEQUATION';

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = false)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_jextboxequation.insert.insert.data', 'insert', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form)) {
			return false;
		}

		return $form;
	}

}
