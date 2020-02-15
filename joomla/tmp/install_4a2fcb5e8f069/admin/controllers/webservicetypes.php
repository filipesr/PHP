<?php
/**
 * JCollection Webservicetype controller class
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
 * JCollection Type Controller
 *
 * @package JCollection
 * @subpackage com_jcollection
 */
class JCollectionControllerWebservicetypes extends JCollectionController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add', 'edit' );
	}

	/**
	* display the edit form
	* @return void
	*/
	function edit()
	{
		// redirect to category controller/view
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cid = (int)$cid[0];
		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=webservicetype&view=webservicetype&cid[]='.$cid );
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$model = $this->getModel('type');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or more types (webservices) could not be deleted' );
		} else {
			$msg = JText::_( 'Type(s) (webservices) deleted' );
		}

		$this->setRedirect( 'index.php?option='.$option.'&controller=webservicetypes&view=webservicetypes', $msg );
	}
	function saveorder()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order = JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );
		JArrayHelper::toInteger( $order );

		$model = $this->getModel('webservicetypes', 'JCollectionModel');
		$model->saveorder( $cid, $order );

		$msg = 'New ordering saved';
		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=webservicetypes&view=webservicetypes', $msg );
	}

	function orderup()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'webservicetypes', 'JCollectionModel' );
		$model->move( $cid, -1 );

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=webservicetypes&view=webservicetypes');
	}

	function orderdown()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'webservicetypes', 'JCollectionModel' );
		$model->move( $cid, 1 );

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=webservicetypes&view=webservicetypes');
	}
}
?>
