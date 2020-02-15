<?php
/**
 * JCollection Info controller class
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
class JCollectionControllerInfo extends JCollectionController
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

		$data = JRequest::get( 'post' );

		$desc = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$desc = str_replace( '<br>', '<br />', $desc );
		$data['description'] = $desc;

		$model = $this->getModel( 'info' );

		$user = &JFactory::getUser();
		$uid = $user->get( 'id', 0 );
		$gid = $user->get( 'gid', 0 );

		if( !$uid || $gid < 19 )
		{
			JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
			return;
		}

		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			if( !( $user->authorize( 'com_jcollection', 'edit', 'item', 'own' ) && ( $data['id'] == 0 || $data['created_by'] == $uid ) ) )
			{
				JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
				return;
			}
		}

		if ( $model->store( $data ) ) {
			$msg = JText::_( 'Info set saved!' );
		} else {
			$msg = JText::_( 'Error saving info set' );
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

		$data = JRequest::get( 'post' );

		$desc = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$desc = str_replace( '<br>', '<br />', $desc );
		$data['description'] = $desc;

		$model = $this->getModel( 'info' );

		$user = &JFactory::getUser();
		$uid = $user->get( 'id', 0 );
		$gid = $user->get( 'gid', 0 );

		if( !$uid || $gid < 19 )
		{
			JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
			return;
		}

		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			if( !( $user->authorize( 'com_jcollection', 'edit', 'item', 'own' ) && ( $data['infoid'] == 0 || $data['created_by'] == $uid ) ) )
			{
				JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
				return;
			}
		}

		$id = 0;
		if ( $model->store( $data ) ) {
			$id = $model->getId();
			$msg = JText::_( 'Info set saved!' );
		} else {
			$msg = JText::_( 'Error saving info set' );
		}

		$cache = &JFactory::getCache( 'com_jcollection_item' );
		$cache->clean();

		if( $id )
		{
			$referer = 'index.php?option=com_jcollection&controller=info&view=info&task=edit&infoid='.(int)$id;
		} else {
			$referer = JRequest::getString( 'ret', base64_encode( JURI::base() ), 'get' );
			$referer = base64_decode( $referer );
			if ( !JURI::isInternal( $referer ) ) {
				$referer = '';
			}
		}
		$this->setRedirect( $referer, $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		if(JRequest::getVar('id') == 0)
		$msg = JText::_( 'Operation cancelled' );
		else
		$msg = JText::_( 'Info set closed' );

		$referer = JRequest::getString( 'ret', base64_encode( JURI::base() ), 'get' );
		$referer = base64_decode( $referer );
		if ( !JURI::isInternal( $referer ) ) {
			$referer = '';
		}
		$this->setRedirect( $referer, $msg );
	}

	function vote()
	{
		$userIP =  $_SERVER['REMOTE_ADDR'];
		$ratingno = JRequest::getVar( 'ratingno', 0, '', 'int' );
		$infoid = JRequest::getVar( 'id', 0, '', 'int' );
		$itemid = JRequest::getVar( 'itemid', 0, '', 'int' );
		$msg = '';
		if( $ratingno && $infoid )
		{
			$rate = JRequest::getVar( 'user_rating', 0, '', 'int' );
			$url = JRequest::getVar('url', '', 'default', 'string');
			if( !JURI::isInternal( $url ) ) {
				$url = JRoute::_( 'index.php?option=com_jcollection&view=item&id='.$itemid );
			}
			$db = &JFactory::getDBO();

			$query = "SELECT * FROM #__"._JC_DB."_rating "
			."\n WHERE infoid = ".(int)$infoid;
			$db->setQuery( $query );
			$rating = $db->loadObject();

			if( !$rating )
			{
				$query = "INSERT INTO #__"._JC_DB."_rating (`infoid`,`lastip$ratingno`,`ratingsum$ratingno`,`ratingcount$ratingno`) "
				."\n VALUES ('".(int)$infoid."','$userIP','$rate','1') "
				;
				$db->setQuery( $query );
				if ( !$db->query() ) {
					JError::raiseError( 500, $db->stderr());
				}
				$cache = &JFactory::getCache( 'com_jcollection_item' );
				$cache->clean();
				$msg = JText::_( 'Thanks for rating!' );
			} else {
				$lastipname = 'lastip'.$ratingno;
				if( $userIP != $rating->$lastipname )
				{
					$query = "UPDATE #__"._JC_DB."_rating "
					."\n SET ratingcount".$ratingno." = ratingcount".$ratingno." + 1, ratingsum".$ratingno." = ratingsum".$ratingno." + ".(int)$rate.', '
					."\n lastip".$ratingno." = ".$db->Quote( $userIP )
					."\n WHERE infoid = ".(int)$infoid
					;
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
		$access->canEdit = $user->authorize( 'com_jcollection', 'edit', 'item', 'all' );
		$access->canEditOwn = $user->authorize( 'com_jcollection', 'edit', 'item', 'own' );
		$access->canPublish = $user->authorize( 'com_jcollection', 'publish' );
		$access->canApprove = $user->authorize( 'com_jcollection', 'approve' );
		$access->uid = $user->get('id');

		$model  = &$this->getModel( 'info' );
		$view = &$this->getView( 'info', 'html' );
		if ( !( $access->canEdit || $access->canEditOwn ) ) {
			JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
		}

		if( $model->getId() > 0 && $user->get( 'gid' ) <= 19 && $model->getCreated_by() != $user->id ) {
			JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
		}

		if ( $model->isCheckedOut( $user->get( 'id' ) ) )
		{
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The info set' ), $model->getName() );
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
