<?php
/**
 * JCollection List View
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
class JCollectionViewList extends JView
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

		//get the category
		$l =& $this->get('Data');
		$isNew = ($l->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'List' ).': <small><small>[ ' . $text.' ]</small></small>' );
		$bar = & JToolBar::getInstance('toolbar');

		$bar->appendButton( 'Popup', 'new', 'Add Items', 'index.php?option=com_jcollection&amp;controller=items&amp;task=popup_listadd&amp;listid='.(int)$l->id.'&amp;tmpl=component', 570, 370 );

		JToolBarHelper::divider();
		JToolBarHelper::apply();
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing categories the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		// include for proper popup operation
		//JHTML::_('behavior.modal');

		// include for session
		JHTML::_('behavior.keepalive');


		$this->assignRef('l', $l);

		$lists = array();

		$db =& JFactory::getDBO();
		/*
		 // If a not a new item, lets set the menu item id
		 if ( $cat->id ) {
			$id = ' AND id != '.intval($cat->id);
			} else {
			$id = '';
			}

			// In case the parent was null
			if (!$item->parent) {
			$item->parent = 0;
			}

			// get a list of the menu items
			// excluding the current menu item and its child elements
			$query = "SELECT * "
			."\n FROM #__"._CM_DB."_cat "
			."\n WHERE published != -2 "
			.$id
			."\n ORDER BY parent, ordering";
			$db->setQuery( $query );
			$mitems = $db->loadObjectList();

			// establish the hierarchy of the menu
			$children = array();

			if ( $mitems )
			{
			// first pass - collect children
			foreach ( $mitems as $v )
			{
			$pt = $v->parent;
			$list = @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
			}
			}

			// second pass - get an indent list of the items
			$list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );

			// assemble menu items to the array
			$mitems         = array();
			$mitems[]       = JHTML::_('select.option',  '0', JText::_( 'Top' ) );

			foreach ( $list as $it ) {
			$mitems[] = JHTML::_('select.option',  $it->id, '&nbsp;&nbsp;&nbsp;'. $it->treename );
			}

			$lists['parent'] = JHTML::_('select.genericlist',   $mitems, 'parent', 'class="inputbox" size="1"', 'value', 'text', $cat->parent );
			*/
		$lists['cat'] = JCollectionHelper::listCategoryList('catid', 'class="inputbox" size="1"',$l->catid );

		$lists['image'] = JHTML::_('list.images',  'img', $l->img, null, '/images/jcollection/' );

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, name AS text' .
                                ' FROM #__'._JC_DB.'_list' .
                                ' WHERE catid = ' . (int) $l->catid .
                                ' AND published >= 0' .
                                ' ORDER BY ordering';
		if(!$isNew) {
			$lists['ordering'] = JHTML::_('list.specificordering', $l, $l->id, $query, 1);
		} else {
			$lists['ordering'] = JHTML::_('list.specificordering', $l, '', $query, 1);
		}

		jimport('joomla.html.pane');

		$pane =& JPane::getInstance('tabs');

		$paramsdata = $l->params;
		$paramsdefs = _JC_PATH.DS.'models'.DS.'list.xml';
		$params = new JParameter( $paramsdata, $paramsdefs );

		$params->loadArray( $l );


		$filter_order = $mainframe->getUserStateFromRequest( $option.'.filter_order', 'filter_order', 'i.ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'.filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );

		$lists['order_sort'] = $filter_order;
		$lists['order_Dir_sort'] = $filter_order_Dir;

		$this->assignRef('lists', $lists);
		$this->assignRef('pane',$pane);
		$this->assignRef('params',$params);

		$pagination = & $this->get( 'Pagination' );

		$this->assignRef('pagination',  $pagination);

		$document = &JFactory::getDocument();
		//$document->addScript('../includes/js/joomla/popup.js');
		//$document->addStyleSheet('../includes/js/joomla/popup.css');

		parent::display($tpl);
	}
}
?>