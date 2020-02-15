<?php
/**
 * JCollection Type View class
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
 * Type View
 *
 */
class JCollectionViewType extends JView
{
	/**
	 * Collection view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		// disable the menu bar
		JRequest::setVar( 'hidemainmenu', 1 );

		//get the item
		$type =& $this->get('Data');
		$isNew = ($type->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Type' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::apply();
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('type', $type);

		JHTML::_('behavior.keepalive');

		$lists = array();

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, name AS text' .
                                ' FROM #__'._JC_DB.'_type' .
                                ' ORDER BY ordering';
		if(!$isNew) {
			$lists['ordering'] = JHTML::_('list.specificordering', $type, $type->id, $query, 1);
		} else {
			$lists['ordering'] = JHTML::_('list.specificordering', $type, '', $query, 1);
		}

		$paramsdata = $type->params;
		$paramsdefs = _JC_PATH.DS.'models'.DS.'type.xml';
		$params = new JParameter( $paramsdata, $paramsdefs );

		$this->assignRef('lists', $lists);
		$this->assignRef('params', $params);
		parent::display($tpl);
	}
}
?>
