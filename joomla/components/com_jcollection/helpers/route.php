<?php
/**
 * JCollection route helper
 *
 * @version $Id$
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Component Helper
jimport('joomla.application.component.helper');

/**
 * JCollection Component Route Helper
 *
 */
class JCollectionHelperRoute
{
	/**
	* Returns a string that points to the desired item
	* @param int Collection item id
	* @param int Collection category id
	* @return string holding the link
	*/
	function getItemRoute($id, $catid = 0)
	{
		global $option;

		$needles = array(
			'item'  => (int) $id,
			'category' => (int) $catid,
			);

		//Create the link
		$link = 'index.php?option='.$option.'&view=item&id='. $id;

		/*
		if($catid) {
			$link .= '&catid='.$catid;
		}
		*/

		if($item = ContentHelperRoute::_findMenuItem($needles)) {
			$link .= '&Itemid='.$item->id;
		};

		return $link;
	}

	/**
	* Returns a linkt to the category
	* @param int Collection category id
	* @return string holding the link
	*/
	function getCategoryRoute( $catid )
	{
		global $option;

		$needles = array(
			'category' => (int) $catid,
			);

		//Create the link
		$link = 'index.php?option='.$option.'&view=category&catid='.$catid;

		if($item = ContentHelperRoute::_findMenuItem($needles)) {
			if(isset($item->query['layout'])) {
				$link .= '&layout='.$item->query['layout'];
			}
			$link .= '&Itemid='.$item->id;
		}

		return $link;
	}

	function _findMenuItem($needles)
	{
		global $option;
		$component =& JComponentHelper::getComponent( $option );

		$menus  = &JApplication::getMenu('site', array());
		$items  = $menus->getItems('componentid', $component->id);

		$match = null;

		foreach($needles as $needle => $id)
		{
			foreach($items as $item)
			{
				if ((@$item->query['view'] == $needle) && (@$item->query['id'] == $id)) {
					$match = $item;
					break;
				}
			}

			if(isset($match)) {
				break;
			}
		}

		return $match;
	}
}
?>
