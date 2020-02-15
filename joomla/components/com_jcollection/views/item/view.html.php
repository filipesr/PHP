<?php
/**
 * JCollection Items View class
 *
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Collection Manager Component
 *
 * @package com_collection
 */
class JCollectionViewItem extends JView
{
	function display($tpl = null)
	{
		global $option, $mainframe;

		$dispatcher =& JDispatcher::getInstance();
		JPluginHelper::importPlugin( 'jcollection' );

		$user = &JFactory::getUser();

		$access = new stdClass();
		$access->canEdit = $user->authorize( 'com_jcollection', 'edit', 'item', 'all' );
		$access->canEditOwn = $user->authorize( 'com_jcollection', 'edit', 'item', 'own' );
		$access->canEditRev = $user->authorize( 'com_jcollection', 'edit', 'rev', 'all' );
		$access->canEditOwnRev = $user->authorize( 'com_jcollection', 'edit', 'rev', 'own' );
		$access->canPublish = $user->authorize( 'com_jcollection', 'publish' );
		$access->canApprove = $user->authorize( 'com_jcollection', 'approve' );
		$access->canAdd = $user->authorize( 'com_jcollection', 'add', 'item', 'all' );
		$access->uid = $user->get('id');

		// retrive parameters (already with the correct overrides)
		$params = &JComponentHelper::getParams( $option );

		$itemid = JRequest::getVar( 'id', -1 );
		if($itemid == -1) {
			//get the category from the menu item
			$itemid = $params->get('itemid');
			if($itemid) {
				JRequest::setVar( 'id', $itemid );
			}
		}

		//$model = &$this->getModel();

		$conf = &JFactory::getConfig();

		$lifetime = $params->get( 'item_cache_time', $conf->getValue( 'config.cachetime' ) ) * 60;

		$itemmodel = &JModel::getInstance( 'item', 'jcollectionmodel' );

		$cache = &JFactory::getCache( 'com_jcollection_item' );
		$cache->setCaching( 1 );
		$cache->setLifeTime( $lifetime );
		//$item = $cache->get( array( $itemmodel, 'getData' ), array(), (int)$itemid );
		$item = $cache->get( array( $this, 'get' ), array( 'Data' ), (int)$itemid );

		// without cache:
		//$item =& $this->get( 'Data' );

		$pathway =& $mainframe->getPathway();
		if( $item->id ) {

			// get a menu item based on Itemid or currently active
			$menu = &JSite::getMenu();
			if ( empty( $query[ 'Itemid' ] ) ) {
				$menuItem = &$menu->getActive();
			} else {
				$menuItem = &$menu->getItem( $query[ 'Itemid' ] );
			}

			$mView  = (empty($menuItem->query['view'])) ? null : $menuItem->query['view'];
			$mCatid = (empty($menuItem->query['catid'])) ? null : $menuItem->query['catid'];
			$mListid = (empty($menuItem->query['listid'])) ? null : $menuItem->query['listid'];
			$mId    = (empty($menuItem->query['id'])) ? null : $menuItem->query['id'];

			if( $mView != 'item' ) {

				if( $mView == 'list' && $mListid ) {
					$actlist = &JTable::getInstance('list','Table');
					$actlist->load( (int)$mListid );
					$listlink = JRoute::_('index.php?option=com_jcollection&view=list&listid='.$mListid );
					$pathway->addItem( $actlist->name, $listlink );
				} else {
					$ccats = count($item->cats);
					if($mCatid) {
						$inc = false;
					} else {
						$inc = true;
					}
					for($i=0; $i<$ccats; $i++)
					{
						$actcat = &$item->cats[$i];
						if($inc) {
							$catlink = JRoute::_('index.php?option=com_jcollection&view=category&catid='.$actcat->slug);
							$pathway->addItem( $actcat->name, $catlink );
						}
						if($actcat->id == (int)$mCatid) {
							$inc = true;
						}
					}
				}
			}
			$link = JRoute::_( 'index.php?option=com_jcollection&view=item&id='.$item->slug );
			$pathway->addItem( $item->name, $link );
		}

		jimport( 'joomla.html.pane' );
		if( $item->id ) {
			$infosetsas = $item->params->get( 'showinfosetsas', 'lists' );
			switch( $infosetsas )
			{
				case 'tabs':
					$pane =& JPane::getInstance( 'tabs', array( 'allowAllClose' => true ) );
					break;
				case 'sliders':
					$pane =& JPane::getInstance( 'sliders', array( 'allowAllClose' => true ) );
					break;
				default:
					$pane = null;
					break;
			}
		} else {
			$pane = null;
		}

		$doc = &JFactory::getDocument();
		$oldtitle = $doc->getTitle();
		$doc->setTitle( $oldtitle.' - '.htmlspecialchars( $item->name ) );

		$lists = array();
		$lists['catid'] = JCollectionHelper::categoryList( 'catid', 'class="inputbox" size="1"', $item->catid, null, 'Root' );
		$url = JURI::root() . 'images/jcollection/';
		$blankurl = JURI::root() . 'images/blank.png';
		$js = "onchange=\"javascript:if (document.forms.adminForm.img.options[selectedIndex].value!='') {document.imagelib.src='$url'+ document.forms.adminForm.img.options[selectedIndex].value} else {document.imagelib.src='$blankurl'}\"";
		$lists['image'] = JHTML::_( 'list.images',  'img', $item->img, $js, '/images/jcollection/' );

		if( $item->id )
		{
			$cinfo = count( $item->infos );
			for( $j = 0; $j < $cinfo; $j++ )
			{
				$info = &$item->infos[$j];
				$info->event = new stdClass();
				$results = $dispatcher->trigger( 'onBeforeDisplayInfo', array ( &$info, &$item->params ) );
				$info->event->beforeDisplayInfo = trim( implode( "\n", $results ) );
				$results = $dispatcher->trigger( 'onAfterDisplayInfo', array ( &$info, &$item->params ) );
				$info->event->afterDisplayInfo = trim( implode( "\n", $results ) );
				$results = $dispatcher->trigger( 'onAfterDisplayInfoTitle', array ( &$info, &$item->params ) );
				$info->event->afterDisplayInfoTitle = trim( implode( "\n", $results ) );
				$crevs = count( $info->revs );
				for( $k = 0; $k<$crevs; $k++ )
				{
					$rev = &$info->revs[$k];
					$rev->event = new stdClass();
					$results = $dispatcher->trigger( 'onBeforeDisplayRev', array ( &$rev, &$item->params ) );
					$rev->event->beforeDisplayRev = trim( implode( "\n", $results ) );
					$results = $dispatcher->trigger( 'onAfterDisplayRev', array ( &$rev, &$item->params ) );
					$rev->event->afterDisplayRev = trim( implode( "\n", $results ) );
					$results = $dispatcher->trigger( 'onAfterDisplayRevTitle', array ( &$rev, &$item->params ) );
					$rev->event->afterDisplayRevTitle = trim( implode( "\n", $results ) );
				}
			}

			$item->event = new stdClass();
			$results = $dispatcher->trigger( 'onBeforeDisplayItem', array ( &$item, &$item->params ) );
			$item->event->beforeDisplayItem = trim( implode( "\n", $results ) );
			$results = $dispatcher->trigger( 'onAfterDisplayItem', array ( &$item, &$item->params ) );
			$item->event->afterDisplayItem = trim( implode( "\n", $results ) );
			$results = $dispatcher->trigger( 'onAfterDisplayItemTitle', array ( &$item, &$item->params ) );
			$item->event->afterDisplayItemTitle = trim( implode( "\n", $results ) );
		}

		$this->assignRef( 'lists', $lists );
		$this->assignRef( 'item', $item );
		$this->assignRef( 'pane', $pane );
		$this->assignRef( 'doc', $doc );
		$this->assignRef( 'params', $item->params );
		$this->assignRef( 'access', $access );

		parent::display( $tpl );
	}
}
?>
