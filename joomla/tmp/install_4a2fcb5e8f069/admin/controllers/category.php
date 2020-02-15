<?php
/**
 * Category Controller for JCollection Component
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
 * JCollection Category Controller
 *
 * @package JCollection
 * @subpackage com_jcollection
 */
class JCollectionControllerCategory extends JCollectionController
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

		$model = $this->getModel('category');

		if ($model->store($post)) {
			$msg = JText::_( 'Category saved!' );
		} else {
			$msg = JText::_( 'Error saving category' );
		}

		global $option;

		$link = 'index.php?option='.$option.'&controller=categories&view=categories';
		$this->setRedirect($link, $msg);
	}

	/**
	* apply a record
	* @return void
	*/
	function apply()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$model = $this->getModel('category');

		$id = 0;
		if ($model->store()) {
			$id = $model->getId();
			$msg = JText::_( 'Category saved!' );
		} else {
			$msg = JText::_( 'Error saving category' );
		}

		global $option;
		$link = 'index.php?option='.$option.'&controller=category&view=category&task=edit&cid[]='.$id;
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
		$this->setRedirect( 'index.php?option='.$option.'&controller=categories&view=categories', $msg );
	}

}
?>
