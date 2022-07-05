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

jimport('joomla.application.component.view');

/**
 * View class for insert Math.
 */
class JExtBOXEquationViewInsert extends JViewLegacy
{

    /**
     * Display the view
     */
    public function display($tpl = null)
    {

        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors));
        }

        parent::display($tpl);

    }

}
