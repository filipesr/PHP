<?php
/**
 * JCollection Items View class
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
 * Items View
 *
 */
class JCollectionViewItems extends JView
{
	/**
	* Collection view display method
	* @access	public
	* @param	$tpl	The display template that will be used (null = default)
	* @return	void
	**/
	function display($tpl = null)
	{
		global $mainframe, $option;
		JHTML::_('behavior.tooltip');

		$bar = & JToolBar::getInstance('toolbar');
		JToolBarHelper::title(   JText::_( 'JCollection - Items' ), 'generic.png' );
		JToolBarHelper::preferences( $option, '450' );
		JToolBarHelper::divider();
		$bar->appendButton( 'Popup', 'upload', 'Import/Export', 'index.php?option=com_jcollection&amp;controller=importexport&amp;view=importexport&amp;layout=popup&amp;tmpl=component', 570, 370 );
		JToolBarHelper::divider();
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

		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();

		// build filters
		$filter_catid = $mainframe->getUserStateFromRequest( $option.'filter_catid', 'filter_catid', 0, 'int' );
		$filter_subcats = $mainframe->getUserStateFromRequest( $option.'filter_subcats', 'filter_subcats', 0, 'int' );
		$filter_order = $mainframe->getUserStateFromRequest( $option.'.filter_order', 'filter_order', 'i.ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'.filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );
		$filter_state = $mainframe->getUserStateFromRequest( $option.'.filter_state', 'filter_state', '', 'word' );
		$search = $mainframe->getUserStateFromRequest( $option.'.search', 'search', '', 'string' );
		$search = JString::strtolower( $search );
		$filter_access = $mainframe->getUserStateFromRequest( $option.'.filter_access', 'filter_access', -1, 'int' );
		$filter_approved = $mainframe->getUserStateFromRequest( $option.'.filter_approved', 'filter_approved', -1, 'int' );
		$filter_author = $mainframe->getUserStateFromRequest( $option.'filter_author', 'filter_author', 0, 'int' );

		// Get data from the model
		$items = & $this->get( 'Data');
		$total = & $this->get( 'Total');
		$pagination = & $this->get( 'Pagination' );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		$lists['state'] = JHTML::_('grid.state',  $filter_state, "Published", "Unpublished", "Archived", "Trashed" );
		$lists['access'] = JCollectionHelper::filterAccess( 'filter_access', $filter_access );
		$lists['catid'] = JCollectionHelper::filterCategory( 'filter_catid', intval($filter_catid) );
		$lists['subcats'] = JHTML::_('select.booleanlist', 'filter_subcats', 'onchange="document.adminForm.submit( );"', intval($filter_subcats) );
		$lists['author'] = JCollectionHelper::filterAuthor( 'filter_author', intval($filter_author) );
		$lists['approved'] = JCollectionHelper::filterApproved( 'filter_approved', intval($filter_approved) );

		$listid = $mainframe->getUserStateFromRequest( $option.'listid', 'listid', 0, 'int' );

		$this->assignRef('listid', $listid);
		$this->assignRef('user', JFactory::getUser());
		$this->assignRef('lists', $lists);
		$this->assignRef('items', $items);
		$this->assignRef('pagination',  $pagination);

		parent::display($tpl);
	}
}
?>
