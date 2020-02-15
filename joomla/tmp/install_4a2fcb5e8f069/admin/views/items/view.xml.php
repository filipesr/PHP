<?php
/**
 * JCollection Items XML View
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
 * Items XML View
 */
class JCollectionViewItems extends JView
{
	/**
	 * display method of Items view
	 * @return void
	 **/
	function display($tpl = null)
	{
		global $option, $mainframe;
		$doc = &JFactory::getDocument();
//		$cats =& $this->get('Data');

		$catid = $mainframe->getUserStateFromRequest( $option.'catid', 'catid', 0, 'int' );
		$active = $mainframe->getUserStateFromRequest( $option.'id', 'id', 0, 'int' );
		$itemlist = JCollectionHelper::listItem( 'itemid', $catid );

		$xmlstr = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?><document>";
		$xmlstr .= "<node id=\"itemid_div\"><![CDATA[".$itemlist."]]></node>";
		$xmlstr .= "</document>";

		$doc->setMimeEncoding('text/xml');
		echo $xmlstr;
		return;
	}
}
?>
