<?php
/**
 * JCollection List Categories View class
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
 * List Categories View
 *
 * @package JCollection
 * @subpackage com_jcollection
 */
class JCollectionViewListcats extends JView
{
	/**
	* Categories view display method
	* @return void
	**/
	function display($tpl = null)
	{
		JHTML::_('behavior.tooltip');

		// build toolbar
		JToolBarHelper::title(   JText::_( 'JCollection - List Categories' ), 'generic.png' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::divider();
		JToolBarHelper::custom('approve', 'apply', '', 'Approve');
		JToolBarHelper::custom('disapprove', 'cancel', '', 'Disapprove');
		JToolBarHelper::divider();
		JToolBarHelper::archiveList();
		JToolBarHelper::divider();
		JToolBarHelper::trash();
		JToolBarHelper::deleteList();
		JToolBarHelper::divider();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		global $mainframe, $option;
		$db =& JFactory::getDBO();

		// build filters
		$filter_order = $mainframe->getUserStateFromRequest( $option.'.filter_order', 'filter_order', 'c.ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'.filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );
		$filter_state = $mainframe->getUserStateFromRequest( $option.'.filter_state', 'filter_state', '', 'word' );
		$search = $mainframe->getUserStateFromRequest( $option.'.search', 'search', '', 'string' );
		$search = JString::strtolower( $search );
		$filter_access = $mainframe->getUserStateFromRequest( $option.'.filter_access', 'filter_access', -1, 'int' );
		$filter_approved = $mainframe->getUserStateFromRequest( $option.'.filter_approved', 'filter_approved', -1, 'int' );
		$filter_author = $mainframe->getUserStateFromRequest( $option.'filter_author', 'filter_author', 0, 'int' );

		$lists = array();

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		$lists['state'] = JCollectionHelper::filterState( 'filter_state_c', $filter_state );
		$lists['access'] = JCollectionHelper::filterAccess( 'filter_access_c', $filter_access );
		$lists['author'] = JCollectionHelper::filterAuthor( 'filter_author_c', intval($filter_author) );
		$lists['approved'] = JCollectionHelper::filterApproved( 'filter_approved_c', intval($filter_approved) );

		// Get data from the model
		$listcats = & $this->get( 'Data' );

		$pagination = &$this->get('Pagination');

		$this->assignRef('listcats', $listcats);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('lists', $lists);
		$this->assignRef('user', JFactory::getUser());

		parent::display($tpl);
	}
}
?>
