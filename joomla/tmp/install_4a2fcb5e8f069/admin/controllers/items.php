<?php
/**
 * JCollection Items controller class
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
 * JCollection Items Controller
 *
 * @package Collection.Manager
 * @subpackage com_collection
 */
class JCollectionControllerItems extends JCollectionController
{
	/**
	* constructor (registers additional tasks to methods)
	* @return void
	*/
	function __construct()
	{
		parent::__construct();

		// Register extra tasks
		$this->registerTask( 'add', 'edit' );

		$this->registerTask( 'accesspublic', 'access' );
		$this->registerTask( 'accessregistered', 'access' );
		$this->registerTask( 'accessspecial', 'access' );
	}


	function publish()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('items', 'JCollectionModel');
		if(!$model->publish($cids)) {
			$msg = JText::_( 'Error: One or more items could not be published' );
		} else {
			$msg = JText::_( 'Item(s) published' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	/**
	* display the edit form
	* @return void
	*/
	function edit()
	{
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cid = (int)$cid[0];
		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=item&view=item&cid[]='.(int)$cid );
	}

	/**
	* remove record(s)
	* @return void
	*/
	function remove()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('items','JCollectionModel');
		if(!$model->delete($cids)) {
			$msg = JText::_( 'Error: One or more items could not be deleted' );
		} else {
			$msg = JText::_( 'Item(s) deleted' );
		}

		global $option;

		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	function unpublish()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('items', 'JCollectionModel');
		if(!$model->publish($cids, 0)) {
			$msg = JText::_( 'Error: One or more categories could not be unpublished' );
		} else {
			$msg = JText::_( 'Item(s) unpublished' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	function archive()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('items', 'JCollectionModel');
		if(!$model->archive($cids)) {
			$msg = JText::_( 'Error: One or more items could not be archived' );
		} else {
			$msg = JText::_( 'Item(s) archived' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	function approve()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('items', 'JCollectionModel');
		if(!$model->approve($cids)) {
			$msg = JText::_( 'Error: One or more items could not be approved' );
		} else {
			$msg = JText::_( 'Item(s) approved' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	function disapprove()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('items', 'JCollectionModel');
		if(!$model->disapprove($cids)) {
			$msg = JText::_( 'Error: One or more items could not be disapproved' );
		} else {
			$msg = JText::_( 'Item(s) disapproved' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	function trash()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('items', 'JCollectionModel');
		if(!$model->trash($cids)) {
			$msg = JText::_( 'Error: One or more items could not be trashed' );
		} else {
			$msg = JText::_( 'Items trashed' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	/**
	* Changes the access level of a record
	*/
	function access()
	{
		global $mainframe;

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db =& JFactory::getDBO();

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		$task   = JRequest::getCmd( 'task' );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, 'No items selected' );
		}

		switch ( $task )
		{
			case 'accesspublic':
				$access = 0;
				break;

			case 'accessregistered':
				$access = 1;
				break;

			case 'accessspecial':
				$access = 2;
				break;
		}

		$model = &$this->getModel('items', 'JCollectionModel');
		if(!$model->access( $cid, $access )) {
			$msg = JText::_( 'Error: One or more item access could not be updated' );
		} else {
			$msg = JText::_( 'Item(s) access updated' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	function saveorder()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order = JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );
		JArrayHelper::toInteger( $order );

		$model = $this->getModel('items', 'JCollectionModel');
		$model->saveorder( $cid, $order );

		$msg = 'New ordering saved';
		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	function orderup()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'items', 'JCollectionModel' );
		$model->move( $cid, -1 );

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items');
	}

	function orderdown()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'items', 'JCollectionModel' );
		$model->move( $cid, 1 );

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items');
	}

	function ajaxlist()
	{
		$model  = &$this->getModel( 'items', 'JCollectionModel' );
		$view = &$this->getView( 'items', 'xml' );
		$view->setModel( $model, true );
		$view->display();
	}

	function popup_listadd()
	{
		$model = &$this->getModel( 'items', 'JCollectionModel' );
		$view = &$this->getView( 'items', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('popup_listadd');
		$view->display();
	}

	function addtolist()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );
		$listid = JRequest::getVar( 'listid', 0, 'post', 'int' );
		if($listid) {
			$model = &$this->getModel( 'list', 'JCollectionModel' );
			$model->addItems($cid, $listid);
		}

	}

}
?>
