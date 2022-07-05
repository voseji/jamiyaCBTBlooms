<?php

/**
* @extension     JExtBOX Equation
* @author        Galaa
* @authorUrl     www.galaa.mn
* @publisher     JExtBOX - BOX of Joomla Extensions
* @publisherURL  www.jextbox.com
* @copyright     Copyright (C) 2013-2016 Galaa
* @license       This extension in released under the GNU/GPL License - http://www.gnu.org/copyleft/gpl.html
*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class PlgContentJExtBOXEquationInstallerScript
{

	public function update($parent)
	{

		$this->install($parent);

	}

	public function install($parent)
	{

		// Enable plugin
		$db	= JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->update('#__extensions')
			->set($db->quoteName('enabled') . ' = 1')
			->where($db->quoteName('element') . ' = ' . $db->quote('jextboxequation'))
			->where($db->quoteName('type') . ' = ' . $db->quote('plugin'))
			->where($db->quoteName('folder') . ' = ' . $db->quote('content'))
		;
		$db->setQuery($query);
		$db->execute();

	}

}

?>
