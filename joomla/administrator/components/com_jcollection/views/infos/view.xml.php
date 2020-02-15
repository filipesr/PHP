<?php
/**
 * JCollection Infos XML View
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
 * Infos XML View
 */
class JCollectionViewInfos extends JView
{
	/**
	 * display method of Infos view
	 * @return void
	 **/
	function display($tpl = null)
	{
		global $option, $mainframe;
		$doc = &JFactory::getDocument();
//		$cats =& $this->get('Data');

		$itemid = $mainframe->getUserStateFromRequest( $option.'filter_itemid', 'filter_itemid', 0, 'int' );
		$active = $mainframe->getUserStateFromRequest( $option.'infoid', 'infoid', 0, 'int' );
		$infolist = JCollectionHelper::listInfo( 'infoid', $itemid, $active, 'ordering', 'onchange="listChanged(null);"' );

		$xmlstr = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?><document>";
		$xmlstr .= "<htmlnode id=\"infoid_div\"><![CDATA[".$infolist."]]></htmlnode>";
		$xmlstr .= "</document>";

		$doc->setMimeEncoding('text/xml');
		echo $xmlstr;
		return;
	}
}
?>
