<?php
/**
 * JCollection router
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

function JCollectionBuildRoute( &$query )
{
	$segments = array();

	// get a menu item based on Itemid or currently active
	$menu = &JSite::getMenu();
	if ( empty( $query[ 'Itemid' ] ) ) {
		$menuItem = &$menu->getActive();
	} else {
		$menuItem = &$menu->getItem( $query[ 'Itemid' ] );
	}

	$mView  = ( empty( $menuItem->query['view'] ) ) ? null : $menuItem->query['view'];
	$mCatid = ( empty( $menuItem->query['catid'] ) ) ? null : $menuItem->query['catid'];
	$mListid = ( empty( $menuItem->query['listid'] ) ) ? null : $menuItem->query['listid'];
	$mId = ( empty( $menuItem->query['id'] ) ) ? null : $menuItem->query['id'];

	if ( isset( $query['view'] ) ) {
		$segments[] = $query['view'];
		unset( $query['view'] );
	} else if( isset( $mView ) ) {
		$segments[] = $mView;
		switch( $mView ) {
			case 'item':
				$segments[] = $mId;
				unset( $query['id'] );
				break;
			case 'category':
				$segments[] = $mCatid;
				unset( $query['catid'] );
				break;
			case 'list':
				$segments[] = $mListid;
				unset( $query['listid'] );
				break;
		}
	}
	if ( isset( $query['catid'] ) ) {
		$segments[] = $query['catid'];
		unset( $query['catid'] );
	}
	if ( isset( $query['id'] ) ) {
		$segments[] = $query['id'];
		unset( $query['id'] );
	}
	if ( isset( $query['listid'] ) && $segments[0] != 'items' ) {
		$segments[] = $query['listid'];
		unset( $query['listid'] );
	}

	return $segments;
}

function JCollectionParseRoute($segments)
{
	$vars = array();

	//Get the active menu item
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();

	// Count route segments
	$count = count( $segments );

	//Standard routing for JCollection items
	if( !isset( $item ) )
	{
		$vars['view']  = $segments[0];
		$vars['id']    = $segments[$count - 1];
		return $vars;
	}

	$view = $segments[0];
	$vars['view'] = $view;
	switch( $view )
	{
		case 'item':
			$vars['id'] = $segments[$count - 1];
			if( $count > 1 && $segments[$count - 2] != 'item' )
			{
				$vars['catid'] = $segments[$count - 2];
			}
			break;
		case 'category':
			$vars['catid'] = $segments[$count - 1];
			break;
		case 'list':
			$vars['listid'] = $segments[$count - 1];
			break;
	}

	return $vars;
}
?>
