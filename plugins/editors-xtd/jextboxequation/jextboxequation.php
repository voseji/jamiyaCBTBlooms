<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * @extension     Button - JExtBOX Equation
 * @author        Galaa
 * @authorUrl     www.galaa.mn
 * @publisher     JExtBOX - BOX of Joomla Extensions
 * @publisherURL  www.jextbox.com
 * @copyright     Copyright (C) 2016-2021 Galaa
 * @license       This extension in released under the GNU/GPL License - http://www.gnu.org/copyleft/gpl.html
 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Plugin\CMSPlugin;

class PlgButtonJExtBOXEquation extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Display the button
	 *
	 * @param   string  $name  The name of the button to add
	 *
	 * @return  CMSObject  The button options as JObject
	 *
	 * @since   1.5
	 */
	public function onDisplay($name)
	{

		$parameters = JComponentHelper::getParams('com_jextboxequation');
		$input = JFactory::getApplication()->input;
		if (($parameters->get('apply', 'whole-site') !== 'whole-site') && ($input->get('option') !== 'com_content'))
		{
			return false;
		}
		/*
		 * View element calls insertJExtBOXEquation when a button is clicked.
		 * insertJExtBOXEquation creates the script and sends it to the editor, and closes the frame.
		 */
		if ($not_J4 = version_compare(JVERSION, '4.0.0', '<'))
		{
			$js = str_replace("\t", '', "
			function insertJExtBOXEquation(math, editor)
			{
				jInsertEditorText(math, editor);
				jModalClose();
			}");
		}
		else
		{
			$js = str_replace("\t", '', "
			function insertJExtBOXEquation(math, editor)
			{
				if (!window.parent.Joomla.getOptions('xtd-jextbox-equation')) { // Something went wrong!
					window.parent.Joomla.Modal.getCurrent().close();
					return;
				}
				window.parent.Joomla.editors.instances[editor].replaceSelection(math);
				window.parent.Joomla.Modal.getCurrent().close();
			}");
		}

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);

		Factory::getDocument()->addScriptOptions('xtd-jextbox-equation', array('editor' => $name));
		$link = 'index.php?option=com_jextboxequation&amp;view=insert&amp;tmpl=component&amp;editor_name=' . $name;

		$button = new CMSObject;
		$button->modal   = true;
		$button->link    = $link;
		$button->text    = Text::_('PLG_JEXTBOXEQUATION_BUTTON_INSERT_MATH');
		if ($not_J4)
		{
			$button->name    = 'plus';
			$button->options = "{handler: 'iframe', size: {x: 500, y: 350}}";
		}
		else
		{
			$button->name    = $this->_type . '_' . $this->_name;
			$button->icon    = 'plus';
			$button->iconSVG = '<svg version="1.1" width="24" height="24" viewBox="0 0 16 16">
<path d="M15.5 6h-5.5v-5.5c0-0.276-0.224-0.5-0.5-0.5h-3c-0.276 0-0.5 0.224-0.5 0.5v5.5h-5.5c-0.276 0-0.5 0.224-0.5 0.5v3c0 0.276 0.224 0.5 0.5 0.5h5.5v5.5c0 0.276 0.224 0.5 0.5 0.5h3c0.276 0 0.5-0.224 0.5-0.5v-5.5h5.5c0.276 0 0.5-0.224 0.5-0.5v-3c0-0.276-0.224-0.5-0.5-0.5z"></path>
</svg>'; // SVG from IcoMoon
			$button->options = [
				'height'     => '200px',
				'width'      => '400px',
				'bodyHeight' => '70',
				'modalWidth' => '80',
			];
		}

		return $button;

	}

}
