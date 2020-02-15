<?php
/**
 * JCollection Review controller class
 *
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

/**
 * JCollection Info Controller
 *
 */
class JCollectionControllerRev extends JCollectionController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$model = $this->getModel( 'rev' );

		if ( $model->store() ) {
			$msg = JText::_( 'Review saved!' );
		} else {
			$msg = JText::_( 'Error saving review' );
		}

		$cache = &JFactory::getCache( 'com_jcollection_item' );
		$cache->clean();

		$referer = JRequest::getString( 'ret', base64_encode( JURI::base() ), 'get' );
		$referer = base64_decode( $referer );
		if ( !JURI::isInternal( $referer ) ) {
			$referer = '';
		}
		$this->setRedirect( $referer, $msg );
	}

	/**
	 * apply a record
	 * @return void
	 */
	function apply()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$model = $this->getModel( 'rev' );

		$id = 0;
		if ($model->store()) {
			$id = $model->get('id');
			$msg = JText::_( 'Changes saved!' );
		} else {
			$msg = JText::_( 'Error saving changes' );
		}

		$cache = &JFactory::getCache( 'com_jcollection_item' );
		$cache->clean();

		if( $id ) {
			$link = 'index.php?option=com_jcollection&controller=rev&view=rev&task=edit&id='.$id;
		} else {
			$referer = JRequest::getString( 'ret', base64_encode( JURI::base() ), 'get' );
			$referer = base64_decode( $referer );
			if ( !JURI::isInternal( $referer ) ) {
				$referer = '';
			}
			$link = $referer;
		}
		$this->setRedirect($link, $msg);
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		if(JRequest::getVar('id') == 0) {
			$msg = JText::_( 'Operation cancelled' );
		} else {
			$msg = JText::_( 'Review closed' );
		}

		$referer = JRequest::getString( 'ret', base64_encode( JURI::base() ), 'get' );
		$referer = base64_decode( $referer );
		if ( !JURI::isInternal( $referer ) ) {
			$referer = '';
		}
		$this->setRedirect( $referer, $msg );
	}

	function vote_useful()
	{
		$userIP =  $_SERVER['REMOTE_ADDR'];
		$itemid = JRequest::getVar( 'itemid', 0, '', 'int' );
		$reviewid = JRequest::getVar( 'id', 0, '', 'int' );
		$msg = '';
		if( $reviewid && $itemid )
		{
			$rate = JRequest::getVar( 'useful', 0, '', 'int' );
			$url = JRequest::getVar('url', '', 'default', 'string');
			if( !JURI::isInternal( $url ) ) {
				$url = JRoute::_( 'index.php?option=com_jcollection&view=item&id='.$itemid );
			}
			$db = &JFactory::getDBO();

			$query = "SELECT * FROM #__"._JC_DB."_reviewrating "
			."\n WHERE reviewid = ".(int)$reviewid;
			$db->setQuery( $query );
			$rating = $db->loadObject();

			if( !$rating )
			{
				if( $rate == 0 )
				{
					$query = "INSERT INTO #__"._JC_DB."_reviewrating (`reviewid`,`lastip`,`useful_yes`,`useful_no`) "
					."\n VALUES ('".(int)$reviewid."',".$db->Quote( $userIP ).",'0','1') "
					;
				} else {
					$query = "INSERT INTO #__"._JC_DB."_reviewrating (`reviewid`,`lastip`,`useful_yes`,`useful_no`) "
					."\n VALUES ('".(int)$reviewid."',".$db->Quote( $userIP ).",'1','0') "
					;
				}
				$db->setQuery( $query );
				if ( !$db->query() ) {
					JError::raiseError( 500, $db->stderr());
				}
				$cache = &JFactory::getCache( 'com_jcollection_item' );
				$cache->clean();
				$msg = JText::_( 'Thanks for rating!' );
			} else {
				if( $userIP != $rating->lastip )
				{
					if( $rate == 0 )
					{
						$query = "UPDATE #__"._JC_DB."_reviewrating "
						."\n SET useful_no = useful_no + 1, "
						."\n lastip = ".$db->Quote( $userIP )
						."\n WHERE reviewid = ".(int)$reviewid
						;
					} else {
						$query = "UPDATE #__"._JC_DB."_reviewrating "
						."\n SET useful_yes = useful_yes + 1, "
						."\n lastip = ".$db->Quote( $userIP )
						."\n WHERE reviewid = ".(int)$reviewid
						;
					}
					$db->setQuery( $query );
					if ( !$db->query() ) {
						JError::raiseError( 500, $db->stderr());
					}
					$cache = &JFactory::getCache( 'com_jcollection_item' );
					$cache->clean();
					$msg = JText::_( 'Thanks for rating!' );
				} else {
					$msg = JText::_( 'You have already voted!' );
				}
			}
		}
		$this->setRedirect( $url, $msg );
	}

	function edit()
	{
		$user =& JFactory::getUser();

		// Create a user access object for the user
		$access = new stdClass();
		$access->canEdit = $user->authorize( 'com_jcollection', 'edit', 'rev', 'all' );
		$access->canEditOwn = $user->authorize( 'com_jcollection', 'edit', 'rev', 'own' );
		$access->canPublish = $user->authorize( 'com_jcollection', 'publish' );
		$access->canApprove = $user->authorize( 'com_jcollection', 'approve' );
		$access->uid = $user->get('id');

		$model  = &$this->getModel( 'rev' );
		$view = &$this->getView( 'rev', 'html' );
		if ( !( $access->canEdit || $access->canEditOwn ) ) {
			JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
		}

		if( $model->getId() > 0 && $user->get( 'gid' ) <= 19 && $model->getCreated_by() != $user->id ) {
			JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
		}

		if ( $model->isCheckedOut( $user->get( 'id' ) ) )
		{
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The review' ), $model->getName() );
			$this->setRedirect( JRoute::_( 'index.php?view=item&id='.$model->getItemid(), false ), $msg );
			return;
		}

		//Checkout the article
		$model->checkout();

		// Push the model into the view (as default)
		$view->setModel( $model, true );

		// Set the layout
		$view->setLayout( 'form' );

		// Display the view
		$view->display();
	}

}
?>
