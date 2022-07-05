<?php
/**
 * @package SP_Page_Builder
 * @author JoomShaper <support@joomshaper.com>
 * @copyright Copyright (c) 2010 - 2021 JoomShaper <http://www.joomshaper.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
// No direct accees
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Component\Router\RouterBase;

/**
 * SP Page Builder Router class
 *
 * @since 1.0.0
 */
class SppagebuilderRouterBase
{
	/**
	 * Build route function
	 *
	 * @param   string $query Query string
	 * @return  mixed
	 */
	public static function buildRoute(&$query)
	{
		$segments = array();
		$menu = Factory::getApplication()->getMenu();

		// We need a menu item.  Either the one specified in the query, or the current active one if none specified
		if (empty($query['Itemid']))
		{
			$menuItem = $menu->getActive();
			$menuItemGiven = false;
		}
		else
		{
			$menuItem = $menu->getItem($query['Itemid']);
			$menuItemGiven = true;
		}

		// Check again
		if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_sppagebuilder')
		{
			$menuItemGiven = false;
			unset($query['Itemid']);
		}

		if (isset($query['view']))
		{
			$view = $query['view'];
		}
		else
		{
			// We need to have a view in the query or it is an invalid URL
			return $segments;
		}

		if (($menuItem instanceof stdClass) && $menuItem->query['view'] == $query['view'] && isset($query['id']) && $menuItem->query['id'] == (int) $query['id'])
		{
			unset($query['view']);
			unset($query['id']);

			return $segments;
		}

		if ($menuItemGiven)
		{
			if (isset($query['view']) && $query['view'])
			{
				unset($query['view']);
			}

			if (isset($query['id']) && $query['id'])
			{
				$id = $query['id'];
				unset($query['id']);
			}

			if (isset($query['tmpl']) && $query['tmpl'])
			{
				unset($query['tmpl']);
			}

			if (isset($query['layout']) && $query['layout'])
			{
				$segments[] = $query['layout'];

				if (isset($id))
				{
					$segments[] = $id;
				}

				unset($query['layout']);
			}
		}

		return $segments;
	}

	/**
	 * Undocumented function
	 *
	 * @param   [type] $segments
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	public static function parseRoute(&$segments)
	{
		$app = Factory::getApplication();
		$menu = $app->getMenu();
		$item = $menu->getActive();
		$total = count((array) $segments);
		$vars = array();
		$view = (isset($item->query['view']) && $item->query['view']) ? $item->query['view'] : '';

		// Form
		if (count($segments) == 2 && $segments[0] == 'edit')
		{
			$vars['view'] = 'form';
			$vars['id'] = (int) $segments[1];
			$vars['tmpl'] = 'component';
			$vars['layout'] = 'edit';

			return $vars;
		}

		return $vars;
	}
}

if (JVERSION >= 4)
{
	/**
	 * SP Page Builder Router class
	 *
	 * @since 1.0.0
	 */
	class SppagebuilderRouter extends RouterBase
	{
		/**
		 * Undocumented function
		 *
		 * @param   [type] $query
		 * @return void
		 *
		 * @since 1.0.0
		 */
		public function build(&$query)
		{
			$segments = SppagebuilderRouterBase::buildRoute($query);

			return $segments;
		}

		/**
		 * Undocumented function
		 *
		 * @param   [type] $segments
		 * @return void
		 *
		 * @since 1.0.0
		 */
		public function parse(&$segments)
		{
			$vars = SppagebuilderRouterBase::parseRoute($segments);

			$segments = array();

			return $vars;
		}
	}
}

/**
 * Undocumented function
 *
 * @param   string $query   query string
 * @return mixed
 *
 * @since 1.0.0
 */
function SppagebuilderBuildRoute(&$query)
{
	$segments = SppagebuilderRouterBase::buildRoute($query);

	return $segments;
}

/**
 * Undocumented function
 *
 * @param   string $segments    query string
 * @return mixed
 */
function SppagebuilderParseRoute(&$segments)
{
	$vars = SppagebuilderRouterBase::parseRoute($segments);

	return $vars;
}
