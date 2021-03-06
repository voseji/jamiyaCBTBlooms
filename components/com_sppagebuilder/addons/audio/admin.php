<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

use Joomla\CMS\Language\Text;

SpAddonsConfig::addonConfig(
array(
	'type'=>'content',
	'addon_name'=>'sp_audio',
	'pro'=>true,
	'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_AUDIO'),
	'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_AUDIO_DESC'),
	'category'=>'Media',
	'attr'=> false
	)
);
