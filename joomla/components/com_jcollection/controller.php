<?php
/**
 * JCollection default controller
 *
 * @version $Id$
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport('joomla.application.component.controller');

/**
 * Collection Manager Component Controller
 *
 */
class JCollectionController extends JController
{
	/**
	* Method to display the view
	*
	* @access public
	*/
	function display()
	{
		parent::display();
	}
}
?>
