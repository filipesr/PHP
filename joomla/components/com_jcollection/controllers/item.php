<?php
/**
 * JCollection Item controller class
 *
 * @version $Id$
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
 * JCollection Item Controller
 *
 */
class JCollectionControllerItem extends JCollectionController
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

		$model = $this->getModel( 'item' );

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
			$msg = JText::_( 'Item saved!' );
		} else {
			$msg = JText::_( 'Error saving item' );
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

		$model = $this->getModel('item');

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

		$id = 0;
		if ( $model->store( $data ) ) {
			$id = $model->getId();
			$msg = JText::_( 'Item saved!' );
		} else {
			$msg = JText::_( 'Error saving item' );
		}

		$cache = &JFactory::getCache( 'com_jcollection_item' );
		$cache->clean();

		if( $id )
		{
			$referer = 'index.php?option=com_jcollection&controller=item&view=item&task=edit&id='.(int)$id;
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

		if(JRequest::getVar('id') == 0) {
			$msg = JText::_( 'Operation cancelled' );
		} else {
			$msg = JText::_( 'Item closed' );
		}

		$referer = JRequest::getString( 'ret', base64_encode( JURI::base() ), 'get' );
		$referer = base64_decode( $referer );
		if ( !JURI::isInternal( $referer ) ) {
			$referer = '';
		}
		$this->setRedirect( $referer, $msg );
	}

	function edit()
	{
		$user =& JFactory::getUser();
		$uid = $user->get( 'id', 0 );
		$gid = $user->get( 'gid', 0 );

		// Create a user access object for the user
		$access = new stdClass();
		$access->canEdit = $user->authorize( 'com_jcollection', 'edit', 'item', 'all' );
		$access->canEditOwn = $user->authorize( 'com_jcollection', 'edit', 'item', 'own' );
		$access->canPublish = $user->authorize( 'com_jcollection', 'publish' );
		$access->canApprove = $user->authorize( 'com_jcollection', 'approve' );

		$model  = &$this->getModel( 'item' );
		$view = &$this->getView( 'item', 'html' );
		if ( !( $access->canEdit || $access->canEditOwn ) ) {
			JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
			return;
		}

		if( $model->getId() > 0 && ( !$access->canEdit && $model->getCreated_by() != $uid ) ) {
			JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
			return;
		}

		if ( $model->isCheckedOut( $uid ) )
		{
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The item' ), $model->getName() );
			$this->setRedirect( JRoute::_( 'index.php?view=item&id='.$model->getId(), false ), $msg );
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
