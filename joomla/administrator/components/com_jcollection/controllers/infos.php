<?php
/**
 * JCollection Infos controller class
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
 * JCollection Infos Controller
 *
 * @package JCollection
 * @subpackage com_jcollection
 */
class JCollectionControllerInfos extends JCollectionController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		$this->registerTask( 'accesspublic', 'access' );
		$this->registerTask( 'accessregistered', 'access' );
		$this->registerTask( 'accessspecial', 'access' );
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$model = $this->getModel('info');

		if ($model->store()) {
			$msg = JText::_( 'Item saved!' );
		} else {
			$msg = JText::_( 'Error saving item' );
		}

		$link = 'index.php?option='.$option.'&controller=infos&view=infos';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function delete()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$itemid = JRequest::getVar( 'itemid', 0, 'post', 'int' );
		JRequest::setVar('filter_itemid', $itemid);
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'infos', 'JCollectionModel' );
		$model->delete( $cid );

		$view = &$this->getView( 'infos', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('popup_item');
		$view->display();
	}

	function ajaxlist()
	{
		//$model  = &$this->getModel( 'infos', 'JCollectionModel' );
		$view = &$this->getView( 'infos', 'xml' );
		//$view->setModel( $model, true );
		$view->display();
	}

	function popup_item()
	{
		$model = &$this->getModel( 'infos', 'JCollectionModel' );
		$view = &$this->getView( 'infos', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('popup_item');
		$view->display();
	}

	function popup_rev()
	{
		$model = &$this->getModel( 'infos', 'JCollectionModel' );
		$view = &$this->getView( 'infos', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('popup_rev');
		$view->display();
	}

	function saveorder()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order = JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );
		JArrayHelper::toInteger( $order );

		$model = $this->getModel('infos', 'JCollectionModel');
		$model->saveorder( $cid, $order );

		$msg = 'New ordering saved';
		global $option;
		$task = JRequest::getVar( 'ptask', '', 'post', 'string' );
		if($task) {
			$task = "&task=".$task;
		}
		//$this->setRedirect( 'index.php?option='.$option.'&controller=infos'.$view.$l.$tmpl, $msg );
		$this->setRedirect( 'index.php?option='.$option.'&controller=infos&'.$task.'&tmpl=component' );
	}

	function orderup()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'infos', 'JCollectionModel' );
		$model->move( $cid, -1 );

		global $option;
		$task = JRequest::getVar( 'ptask', '', 'post', 'string' );
		if($task) {
			$task = "&task=".$task;
		}
		$this->setRedirect( 'index.php?option='.$option.'&controller=infos'.$task.'&tmpl=component');
	}

	function orderdown()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'infos', 'JCollectionModel' );
		$model->move( $cid, 1 );

		global $option;
		$task = JRequest::getVar( 'ptask', '', 'post', 'string' );
		if($task) {
			$task = "&task=".$task;
		}
		$this->setRedirect( 'index.php?option='.$option.'&controller=infos'.$task.'&tmpl=component');
	}

}
?>
