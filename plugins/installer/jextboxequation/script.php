<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * 
 * @package     Installer - JExtBOX Equation
 * @author      Galaa
 * @publisher   JExtBOX.com - BOX of Joomla Extensions (www.jextbox.com)
 * @copyright   Copyright (C) 2017 Galaa
 * @authorUrl   www.galaa.mn
 * @license     This extension in released under the GNU/GPL License - http://www.gnu.org/copyleft/gpl.html
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgInstallerJExtBOXEquationInstallerScript
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
			->where($db->quoteName('folder') . ' = ' . $db->quote('installer'))
		;
		$db->setQuery($query);
		$db->execute();

	}

}

?>
