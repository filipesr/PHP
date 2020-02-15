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
 * JCollection Webservicetype Controller
 *
 */
class JCollectionControllerWebservicetype extends JCollectionController
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

		$model = $this->getModel('webservicetype');

		if ($model->store()) {
			$msg = JText::_( 'Type (webservices) saved!' );
		} else {
			$msg = JText::_( 'Error saving type (webservices)' );
		}

		global $option;
		$link = 'index.php?option='.$option.'&controller=webservicetypes&view=webservicetypes';
		$this->setRedirect($link, $msg);
	}

	/**
	* apply a record
	* @return void
	*/
	function apply()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$model = $this->getModel('webservicetype');

		$id = 0;
		if ($model->store()) {
			$id = $model->getId();
			$msg = JText::_( 'Changes saved!' );
		} else {
			$msg = JText::_( 'Error saving changes' );
		}

		global $option;
		$link = 'index.php?option='.$option.'&controller=webservicetype&view=webservicetype&task=edit&cid[]='.$id;
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
			$msg = JText::_( 'Webservice type closed' );

		global $option;
		$this->setRedirect( 'index.php?option='.$option.'&controller=webservicetypes&view=webservicetypes', $msg );
	}

}
?>
