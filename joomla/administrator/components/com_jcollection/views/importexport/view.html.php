<?php
/**
 * JCollection Importexport View
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

jimport( 'joomla.application.component.view' );

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

/**
 * List View
 */
class JCollectionViewImportexport extends JView
{
	/**
	 * display method of Item view
	 * @return void
	 **/
	function display($tpl = null)
	{
		global $option, $mainframe;

		// disable the menu bar
		JRequest::setVar( 'hidemainmenu', 1 );

		// include for session
		JHTML::_('behavior.keepalive');

		parent::display($tpl);
	}
}
?>