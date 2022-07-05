<?php
/*
 *
 * @package		ARI Quiz
 * @author		ARI Soft
 * @copyright	Copyright (c) 2011 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('_JEXEC') or die;

class JButtonAriquizhelp extends JButton
{
	var $_name = 'Ariquizhelp';

	function fetchButton($type = 'Ariquizhelp', $url = '', $internal = true)
	{
		$text	= JText::_('Help');
		$doTask = $this->_getCommand($this->_buildLink($url, $internal)); 
		$class	= $this->fetchIconClass('help');

		$html = "<a href=\"#\" onclick=\"$doTask\" rel=\"help\" class=\"toolbar\">\n";
		$html .= "<span class=\"$class\">\n";
		$html .= "</span>\n";
		$html .= "$text\n";
		$html .= "</a>\n"; 

		return $html;
	}

	function fetchId($name)
	{
		return uniqid('aqh-', false) . "ariquizhelp";
	}

	function _buildLink($url, $internal)
	{
		if (!$internal)
			return $url;

		$config = AriQuizHelper::getConfig();
		$helpPath = $config->get('HelpPath');
		
		return $helpPath . $url;
	}

	function _getCommand($url)
	{
		$url = htmlspecialchars($url, ENT_QUOTES);
		$cmd = "popupWindow('$url', '" . JText::_('JHELP', true) . "', 800, 700, 1)";

		return $cmd;
	}
}