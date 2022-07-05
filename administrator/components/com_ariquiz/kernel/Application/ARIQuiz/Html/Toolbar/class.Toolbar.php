<?php
/*
 *
 * @package		ARI Quiz
 * @author		ARI Soft
 * @copyright	Copyright (c) 2011 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

(defined('_JEXEC') && defined('ARI_FRAMEWORK_LOADED')) or die;

class AriQuizToolbarHelper extends JToolBarHelper
{
	function ariQuizHelp($url, $internal = true)
	{
		$bar = & JToolBar::getInstance('toolbar');
		$bar->addButtonPath(dirname(__FILE__) . DS . 'Button');
		
		$bar->appendButton('Ariquizhelp', $url, $internal);
	}
}