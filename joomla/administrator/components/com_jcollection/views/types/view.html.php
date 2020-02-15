<?php
/**
 * JCollection Types View class
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
 * Types View
 *
 */
class JCollectionViewTypes extends JView
{
	/**
	 * Collection view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JHTML::_('behavior.tooltip');

		global $mainframe, $option;

		JToolBarHelper::title(   JText::_( 'JCollection - Types' ), 'generic.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Get data from the model
		$types = & $this->get( 'Data');

		$filter_order = $mainframe->getUserStateFromRequest( $option.'.filter_order_t', 'filter_order_t', 't.ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'.filter_order_Dir_t', 'filter_order_Dir_t', 'ASC', 'word' );

		$search = $mainframe->getUserStateFromRequest( $option.'.search_t', 'search_t', '', 'string' );
		$search = JString::strtolower( $search );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		$pagination = &$this->get('Pagination');

		$this->assignRef('types', $types);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('lists', $lists);
		$this->assignRef('user', JFactory::getUser());

		parent::display($tpl);
	}
}
?>
