<?php
/*
 *
 * @package		ARI Framework
 * @author		ARI Soft
 * @copyright	Copyright (c) 2011 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

(defined('_JEXEC') && defined('ARI_FRAMEWORK_LOADED')) or die('Direct Access to this location is not allowed.');

AriKernel::import('SimpleTemplate.Filters.FilterBase');

class AriSimpleTemplateStripTagsFilter extends AriSimpleTemplateFilterBase
{
	function getFilterName()
	{
		return 'strip_tags';
	}

	function parse($value, $allowedTags = null)
	{
		return strip_tags($value, $allowedTags);
	}
}

new AriSimpleTemplateStripTagsFilter();