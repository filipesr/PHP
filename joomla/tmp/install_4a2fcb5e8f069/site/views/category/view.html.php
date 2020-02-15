<?php
/**
 * Category View for Collection Manager Component
 *
 * @package JCollection
 * @license GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport( 'joomla.application.component.view' );

/**
 * Category View
 *
 * @package    JCollection
 * @subpackage com_jcollection
 */
class JCollectionViewCategory extends JView
{
	/**
	 * display method of Category view
	 * @return void
	 **/
	function display($tpl = null)
	{
		global $option, $mainframe;

		$user = &JFactory::getUser();

		$access = new stdClass();
		$access->canEdit = $user->authorize( 'com_jcollection', 'edit', 'cat', 'all' );
		$access->canEditOwn = $user->authorize( 'com_jcollection', 'edit', 'cat', 'own' );
		$access->canPublish = $user->authorize( 'com_jcollection', 'publish' );
		$access->canApprove = $user->authorize( 'com_jcollection', 'approve' );
		$access->canAdd = $user->authorize( 'com_jcollection', 'add', 'item', 'all' );
		$access->uid = $user->get('id');

		$params = &JComponentHelper::getParams( $option );

		$catid = JRequest::getVar( 'catid', -1 );
		if($catid == -1) {
			//get the category from the menu item
			$catid = $params->get('catid');
			if($catid) {
				JRequest::setVar( 'catid', $catid );
			}
		}

		$all = JRequest::getVar( 'all', -1 );
		if($all == -1) {
			//get the category from the menu item
			$all = $params->get('all', -1);
			if($all != -1) {
				JRequest::setVar( 'all', $all );
			}
		}

		$model = &$this->getModel();

		//$catmodel = &JModel::getInstance( 'category', 'jcollectionmodel' );

		// with cache - TODO: honour limits, sorting etc...
		/*
		$conf =& JFactory::getConfig();

		$lifetime = $params->get('cachetime', $conf->getValue( 'config.cachetime' )) * 60;

		$cache = &JFactory::getCache( 'com_jcollection_cat' );
		$cache->setCaching( 1 );
		$cache->setLifeTime( $lifetime );
		$cat = $cache->get( array( $this, 'get' ), array( 'Data' ), (int)$catid );
		*/
		// without cache
		$cat =& $this->get('Data');

		$pathway =& $mainframe->getPathway();
		if($cat->id) {
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

			$ccats = count($cat->cats);
			if($mCatid) {
				$inc = false;
			} else {
				$inc = true;
			}
			for($i=0; $i<$ccats; $i++)
			{
				$actcat = &$cat->cats[$i];
				if($inc) {
					$catlink = JRoute::_('index.php?option=com_jcollection&view=category&catid='.$actcat->slug);
					$pathway->addItem( $actcat->name, $catlink );
				}
				if($actcat->id == (int)$mCatid) {
					$inc = true;
				}
			}
		}

		$doc = &JFactory::getDocument();
		$oldtitle = $doc->getTitle();
		$doc->setTitle( $oldtitle.' - '.htmlspecialchars( $cat->name ) );

		$pagination = &$this->get( 'Pagination' );

		$this->assignRef( 'cat', $cat );
		$this->assignRef( 'params', $params );
		$this->assignRef( 'pagination', $pagination );
		$this->assignRef( 'access', $access );

		parent::display($tpl);
	}
}
