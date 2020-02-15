<?php
/**
 * List View for Collection Manager Component
 *
 * @package com_collection
 * @license GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport( 'joomla.application.component.view' );

/**
 * List View
 *
 * @package    JCollection
 * @subpackage Components
 */
class JCollectionViewList extends JView
{
	/**
	* display method of Item view
	* @return void
	**/
	function display($tpl = null)
	{
		global $option, $mainframe;

		$user = &JFactory::getUser();

		$access = new stdClass();
		$access->canEdit = $user->authorize( 'com_jcollection', 'edit', 'list', 'all' );
		$access->canEditOwn = $user->authorize( 'com_jcollection', 'edit', 'list', 'own' );
		$access->canPublish = $user->authorize( 'com_jcollection', 'publish' );
		$access->canApprove = $user->authorize( 'com_jcollection', 'approve' );
		$access->uid = $user->get('id');


		$params = &JComponentHelper::getParams( $option );

		$model = &$this->getModel();
		$listid = JRequest::getVar( 'listid', -1 );
		if($listid == -1) {
			//get the category from the menu item
			$params = &JComponentHelper::getParams( $option );
			$listid = $params->get( 'listid' );
			if($catid) {
				JRequest::setVar( 'listid', $listid );
				$model->setId( $listid );
			}
		}

		$list =& $this->get( 'Data' );

		$pathway =& $mainframe->getPathway();
		if( $list->id ) {
			$link = JRoute::_( 'index.php?option=com_jcollection&view=list&listid='.$list->slug );
			$pathway->addItem( $list->name, $link );
		}

		$doc = &JFactory::getDocument();
		$oldtitle = $doc->getTitle();
		$doc->setTitle( $oldtitle.' - '.htmlspecialchars( $list->name ) );

		$filter_order = $mainframe->getUserStateFromRequest( $option.'.filter_order', 'filter_order', 'i.ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'.filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );

		$lists['order_sort'] = $filter_order;
		$lists['order_Dir_sort'] = $filter_order_Dir;

		$pagination = $this->get( 'Pagination' );

		$lists['cat'] = JCollectionHelper::listCategoryList( 'catid', 'class="inputbox" size="1"', $list->catid );

		$lists['image'] = JHTML::_( 'list.images',  'img', $list->img, null, '/images/jcollection/' );


		$this->assignRef( 'lists', $lists );
		$this->assignRef( 'access', $access );

		$this->assignRef( 'list', $list );
		$this->assignRef( 'params', $params );
		$this->assignRef( 'pagination',  $pagination );

		parent::display($tpl);
	}
}
