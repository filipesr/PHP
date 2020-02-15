<?php
/**
 * JCollection Googlebookitems View class
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

jimport( 'joomla.application.component.view' );

/**
 * Googlebookitems View
 *
 * @package Collection.Manager
 * @subpackage com_collection
 */
class JCollectionViewGooglebookitems extends JView
{
	/**
	* Googlebookitems view display method
	* @return void
	**/
	function display($tpl = null)
	{
		JHTML::_('behavior.tooltip');

		global $mainframe, $option;

		// build filters
		$search = $mainframe->getUserStateFromRequest( $option.'.search_wsg', 'search_wsg', '', 'string' );
		$search = JString::strtolower( $search );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		// Get data from the model
		$items = & $this->get( 'Data' );

		$pagination = &$this->get('Pagination');

		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('lists', $lists);
		$this->assignRef('user', JFactory::getUser());

		parent::display($tpl);
	}
}
?>
