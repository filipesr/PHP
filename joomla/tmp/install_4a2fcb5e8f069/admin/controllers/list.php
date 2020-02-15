<?php
/**
 * List Controller for JCollection Component
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
 * JCollection List Controller
 *
 * @package JCollection
 * @subpackage com_jcollection
 */
class JCollectionControllerList extends JCollectionController
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

		$model = $this->getModel('list');

		if ($model->store($post)) {
			$msg = JText::_( 'List saved!' );
		} else {
			$msg = JText::_( 'Error saving list' );
		}

		global $option;

		$link = 'index.php?option='.$option.'&controller=lists&view=lists';
		$this->setRedirect($link, $msg);
	}

	/**
	* apply a record
	* @return void
	*/
	function apply()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$model = $this->getModel('list');

		$id = 0;
		if ( $model->store() ) {
			$id = $model->getId();
			$msg = JText::_( 'List saved!' );
		} else {
			$msg = JText::_( 'Error saving list' );
		}

		global $option;
		$link = 'index.php?option='.$option.'&controller=list&view=list&task=edit&cid[]='.$id;
		$this->setRedirect($link, $msg);
	}

	/**
	* cancel editing a record
	* @return void
	*/
	function cancel()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$msg = JText::_( 'Operation cancelled' );
		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=lists&view=lists', $msg );
	}

	function popup_sort()
	{
		$model = &$this->getModel( 'list', 'JCollectionModel' );
		$view = &$this->getView( 'list', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('popup_sort');
		$view->display();
	}

	function saveorder()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order = JRequest::getVar( 'order', array(), 'post', 'array' );
		$listid = JRequest::getVar( 'listid', 0, 'post', 'int' );
		JArrayHelper::toInteger( $cid );
		JArrayHelper::toInteger( $order );

		$model = $this->getModel('list', 'JCollectionModel');
		$model->setId( $listid );
		$model->saveorder_sort( $cid, $order );

		$view = &$this->getView( 'list', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('popup_sort');
		$view->display();
	}

	function orderup()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$listid = JRequest::getVar( 'listid', 0, 'post', 'int' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'list', 'JCollectionModel' );
		$model->setId( $listid );
		$model->move_sort( $cid, -1 );

		$view = &$this->getView( 'list', 'html' );
		$view->setModel( $model, true );
		$view->setLayout( 'popup_sort' );
		$view->display();
	}

	function orderdown()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$listid = JRequest::getVar( 'listid', 0, 'post', 'int' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'list', 'JCollectionModel' );
		$model->setId( $listid );
		$model->move_sort( $cid, 1 );

		$view = &$this->getView( 'list', 'html' );
		$view->setModel( $model, true );
		$view->setLayout( 'popup_sort' );
		$view->display();
	}

	function delete()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$listid = JRequest::getVar( 'listid', 0, 'post', 'int' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'list', 'JCollectionModel' );
		$model->setId( $listid );
		$model->delete_sort( $cid );

		$view = &$this->getView( 'list', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('popup_sort');
		$view->display();
	}

}
?>
