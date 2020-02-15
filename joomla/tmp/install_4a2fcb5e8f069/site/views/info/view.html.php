<?php
/**
 * JCollection Info View class
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
class JCollectionViewInfo extends JView
{
	function display($tpl = null)
	{
		global $option, $mainframe;

		$user = &JFactory::getUser();

		$access = new stdClass();
		$access->canEdit = $user->authorize( 'com_jcollection', 'edit', 'item', 'all' );
		$access->canEditOwn = $user->authorize( 'com_jcollection', 'edit', 'item', 'own' );
		$access->canPublish = $user->authorize( 'com_jcollection', 'publish' );
		$access->canApprove = $user->authorize( 'com_jcollection', 'approve' );
		$access->uid = $user->get( 'id' );

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

		$info = $this->get( 'Data' );

		$pathway =& $mainframe->getPathway();
		if($info->id) {

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
		$pane =& JPane::getInstance( 'sliders',array( 'allowAllClose' => true ) );

		$doc = &JFactory::getDocument();
		$oldtitle = $doc->getTitle();
		$doc->setTitle( $oldtitle.' - '.htmlspecialchars( $info->name ) );

		$lists = array();
		$url = JURI::root() . 'images/jcollection/';
		$blankurl = JURI::root() . 'images/blank.png';
		$js = "onchange=\"javascript:if (document.forms.adminForm.img.options[selectedIndex].value!='') {document.imagelib.src='$url'+ document.forms.adminForm.img.options[selectedIndex].value} else {document.imagelib.src='$blankurl'}\"";
		$lists['image'] = JHTML::_( 'list.images',  'img', $item->img, $js, '/images/jcollection/' );

		$typeid = (int)$info->typeid;
		$lists['typeid'] = JCollectionHelper::filterType( 'typeid', $typeid );

		$js = "
			window.addEvent('domready', function() {
				changeType();
			});
		";
		$doc->addScriptDeclaration( $js );

		$infoparamsdata = $info->params;
		$infoparamsdefs = _JC_PATH.DS.'models'.DS.'info.xml';
		$infoparams = new JParameter( $infoparamsdata, $infoparamsdefs );

		$this->assignRef( 'lists', $lists );
		$this->assignRef( 'info', $info );
		$this->assignRef( 'pane', $pane );
		$this->assignRef( 'doc', $doc );
		$this->assignRef( 'params', $params );
		$this->assignRef( 'infoparams', $infoparams );
		$this->assignRef( 'access', $access );

		parent::display( $tpl );
	}
}
?>
