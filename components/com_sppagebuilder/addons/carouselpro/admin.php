<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\Language\Text;

//no direct accees
defined ('_JEXEC') or die ('restricted access');

SpAddonsConfig::addonConfig(
	array(
		'type'=>'repeatable',
		'addon_name'=>'sp_carouselpro',
		'category'=>'Slider',
		'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED'),
		'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_DESC'),
		'attr'=>false,
		'pro'=>true,
	)
);
