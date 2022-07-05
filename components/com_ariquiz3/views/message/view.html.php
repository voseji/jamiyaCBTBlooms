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

require_once dirname(__FILE__) . DS . '..' . DS . 'view.php';

class AriQuizViewMessage extends AriQuizView 
{
	var $_isFormView = true;

	function display($tpl = null) 
	{
		$returnUrl = JRequest::getString('rurl');
		if ($returnUrl)
			$returnUrl = urldecode($returnUrl);
		else 
		{
			$config = AriQuizHelper::getConfig();
			$returnUrl = $config->get('ReturnUrl');
		}

		$hideBtn = JRequest::getBool('hide_btn');

		$this->assign('message', JText::_(JRequest::getString('msg')));
		$this->assign('returnUrl', $returnUrl);
		$this->assign('hideBtn', $hideBtn);

		parent::display($tpl);
	}
}