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
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class JExtBOXEquationViewInsert extends JViewLegacy
{
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new Exception(implode("\n", $errors));
        }
 
		// Display the view
		parent::display($tpl);
	}
}

?>
