<?php
/**
 * JCollection Categories View class
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
 * Categories View
 *
 * @package Collection.Manager
 * @subpackage com_collection
 */
class JCollectionViewWebservicetypes extends JView
{
	/**
	* Categories view display method
	* @return void
	**/
	function display($tpl = null)
	{
		JHTML::_('behavior.tooltip');

		// build toolbar
		JToolBarHelper::title(   JText::_( 'JCollection - Types (webservices)' ), 'generic.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::divider();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		global $mainframe, $option;
		$db =& JFactory::getDBO();

		// build filters
		$filter_order = $mainframe->getUserStateFromRequest( $option.'.filter_order', 'filter_order', 'i.ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'.filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );
		$search = $mainframe->getUserStateFromRequest( $option.'.search', 'search', '', 'string' );
		$search = JString::strtolower( $search );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		// Get data from the model
		$types = & $this->get( 'Data' );

		$pagination = &$this->get('Pagination');

		$this->assignRef('types', $types);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('lists', $lists);
		$this->assignRef('user', JFactory::getUser());

		parent::display($tpl);
	}
}
?>
