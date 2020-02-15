<?php
/**
 * List Categories Controller for JCollection Component
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
 * JCollection List listcats Controller
 *
 * @package JCollection
 * @subpackage com_jcollection
 */
class JCollectionControllerListcats extends JCollectionController
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

	/**
	* display the edit form
	* @return void
	*/
	function edit()
	{
		// redirect to listcat controller/view
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$cid = (int)$cid[0];
		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcat&view=listcat&cid[]='.(int)$cid );
	}

	/**
	* remove record(s)
	* @return void
	*/
	function remove()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = $this->getModel('listcat');
		if(!$model->delete( $cids )) {
			$msg = JText::_( 'Error: One or more list categories could not be deleted' );
		} else {
			$msg = JText::_( 'List category/-ies deleted' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	function publish()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('listcats', 'JCollectionModel');
		if(!$model->publish($cids)) {
			$msg = JText::_( 'Error: One or more list categories could not be published' );
		} else {
			$msg = JText::_( 'List category/-ies published' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	function unpublish()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('listcats', 'JCollectionModel');
		if(!$model->publish($cids, 0)) {
			$msg = JText::_( 'Error: One or more list categories could not be unpublished' );
		} else {
			$msg = JText::_( 'List category/-ies unpublished' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	function archive()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('listcats', 'JCollectionModel');
		if(!$model->archive($cids)) {
			$msg = JText::_( 'Error: One or more list categories could not be archived' );
		} else {
			$msg = JText::_( 'List category/-ies archived' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	function approve()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('listcats', 'JCollectionModel');
		if(!$model->approve($cids)) {
			$msg = JText::_( 'Error: One or more list categories could not be approved' );
		} else {
			$msg = JText::_( 'List category/-ies approved' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	function disapprove()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('listcats', 'JCollectionModel');
		if(!$model->disapprove($cids)) {
			$msg = JText::_( 'Error: One or more list categories could not be disapproved' );
		} else {
			$msg = JText::_( 'List category/-ies disapproved' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	function trash()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$model = &$this->getModel('listcats', 'JCollectionModel');
		if(!$model->trash($cids)) {
			$msg = JText::_( 'Error: One or more list categories could not be trashed' );
		} else {
			$msg = JText::_( 'List category/-ies trashed' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	/**
	* Changes the access level of a record
	*/
	function access()
	{
		global $mainframe;

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$db =& JFactory::getDBO();
		//$client =& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));


		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		$task   = JRequest::getCmd( 'task' );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, 'No listcats selected' );
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

		$model = &$this->getModel('listcats', 'JCollectionModel');
		if(!$model->access( $cid, $access )) {
			$msg = JText::_( 'Error: One or more list category access could not be updated' );
		} else {
			$msg = JText::_( 'List category access updated' );
		}

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	function saveorder()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order = JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );
		JArrayHelper::toInteger( $order );

		$model = $this->getModel('listcats', 'JCollectionModel');
		$model->saveorder( $cid, $order );

		$msg = 'New ordering saved';
		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats', $msg );
	}

	function orderup()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'listcats', 'JCollectionModel' );
		$model->move( $cid, -1 );

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats');
	}

	function orderdown()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'listcats', 'JCollectionModel' );
		$model->move( $cid, 1 );

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=listcats&view=listcats');
	}

}
?>
