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

		$model = $this->getModel('item');

		if ($model->store()) {
			$msg = JText::_( 'Item saved!' );
		} else {
			$msg = JText::_( 'Error saving item' );
		}

		$cache = &JFactory::getCache( 'com_jcollection_item' );
		$cache->clean();

		global $option;

		$link = 'index.php?option='.$option.'&controller=items&view=items';
		$this->setRedirect($link, $msg);
	}

	/**
	* apply a record
	* @return void
	*/
	function apply()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$model = $this->getModel('item');

		$id = 0;
		if ($model->store()) {
			$id = $model->getId();
			$msg = JText::_( 'Changes saved! ID '.$id );
		} else {
			$msg = JText::_( 'Error saving changes' );
		}

		//$id = JRequest::getInt('id');
		if($id == 0) {
			$db = & JFactory::getDBO();
			$id = intval($db->insertid());
		}

		$cache = &JFactory::getCache( 'com_jcollection_item' );
		$cache->clean();

		global $option;

		$link = 'index.php?option='.$option.'&controller=item&view=item&task=edit&cid[]='.$id;
		$this->setRedirect($link, $msg);
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
			$msg = JText::_( 'Item closed' );

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', $msg );
	}

	function ajaxfetchinfo()
	{
		$model  = &$this->getModel( 'info' );
		$view = &$this->getView( 'info', 'xml' );
		$view->setModel( $model, true );
		//$view->setLayout('element');
		$view->display();
	}

	function ajaxsaveinfo()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$infoid = JRequest::getVar( 'infoid' );
		$infoname = JRequest::getVar( 'infoname' );
		$infoparams = JRequest::getVar( 'infoparams' );
		$infotitle = JRequest::getVar( 'infotitle' );
		$infodescription = JRequest::getVar( 'infodescription' );
		$infodescription = JRequest::getVar( 'infodescription', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$infodescription = str_replace( '<br>', '<br />', $infodescription );
		$infoimg = JRequest::getVar( 'infoimg' );
		$infourl = JRequest::getVar( 'infourl' );
		JRequest::setVar( 'id', $infoid, 'post' );
		JRequest::setVar( 'cid', array($infoid), 'post' );
		JRequest::setVar( 'name', $infoname, 'post' );
		JRequest::setVar( 'title', $infotitle, 'post' );
		JRequest::setVar( 'description', $infodescription, 'post' );
		JRequest::setVar( 'img', $infoimg, 'post' );
		JRequest::setVar( 'url', $infourl, 'post' );
		JRequest::setVar( 'params', $infoparams, 'post' );
		$model = $this->getModel( 'info' );
		if( $model->store() ) {
			echo $model->getId();
		} else {
			echo "-1";
		}
		$cache = &JFactory::getCache( 'com_jcollection_item' );
		$cache->clean();

	}

	function ajaxinfoup()
	{
		//JRequest::checkToken() or jexit( 'Invalid Token' );
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'info', 'JCollectionModel' );
		$model->move( $cid, -1 );
	}

	function ajaxinfodown()
	{
		//JRequest::checkToken() or jexit( 'Invalid Token' );
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		JArrayHelper::toInteger( $cid );

		$model = $this->getModel( 'info', 'JCollectionModel' );
		$model->move( $cid, 1 );
	}

}
?>
