<?php
/**
 * JCollection List Category View
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
 * List Category View
 */
class JCollectionViewListcat extends JView
{
	/**
	 * display method of Item view
	 * @return void
	 **/
	function display($tpl = null)
	{
		// disable the menu bar
		JRequest::setVar( 'hidemainmenu', 1 );

		//get the category
		$cat =& $this->get('Data');
		$isNew = ($cat->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'List Category' ).': <small><small>[ ' . $text.' ]</small></small>' );
		$bar = & JToolBar::getInstance('toolbar');

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


		$this->assignRef('cat', $cat);

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
		$lists['image'] = JHTML::_('list.images',  'img', $cat->img );

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, name AS text' .
                                ' FROM #__'._JC_DB.'_listcat' .
                                ' WHERE published >= 0' .
                                ' ORDER BY ordering';
		if(!$isNew) {
			$lists['ordering'] = JHTML::_('list.specificordering', $cat, $cat->id, $query, 1);
		} else {
			$lists['ordering'] = JHTML::_('list.specificordering', $cat, '', $query, 1);
		}

		jimport('joomla.html.pane');

		$pane =& JPane::getInstance('tabs');

		$paramsdata = $cat->params;
		$paramsdefs = _JC_PATH.DS.'models'.DS.'listcat.xml';
		$params = new JParameter( $paramsdata, $paramsdefs );

		$params->loadArray( $cat );

		$this->assignRef('lists', $lists);
		$this->assignRef('pane',$pane);
		$this->assignRef('params',$params);

		$document = &JFactory::getDocument();

		parent::display($tpl);
	}
}
?>