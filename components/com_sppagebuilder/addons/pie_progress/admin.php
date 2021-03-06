<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\Language\Text;

//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

SpAddonsConfig::addonConfig(
	array(
		'type'=>'content',
		'addon_name'=>'sp_pie_progress',
		'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_PIE_PROGRESS'),
		'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_PIE_PROGRESS_DESC'),
		'category'=>'Content',
		'attr'=>false,
		'pro'=>true,
	)
);
