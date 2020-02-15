<?php
/**
 * JCollection Info View
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
 * Info View
 */
class JCollectionViewInfo extends JView
{
  /**
   * display method of Item view
   * @return void
   **/
  function display($tpl = null)
  {
/*
    //get the item
    $item =& $this->get('Data');
    $isNew = ($item->id < 1);

    $text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
    JToolBarHelper::title(   JText::_( 'Item' ).': <small><small>[ ' . $text.' ]</small></small>' );
    JToolBarHelper::save();
    if ($isNew)  {
      JToolBarHelper::cancel();
    } else {
      // for existing items the button is renamed `close`
      JToolBarHelper::cancel( 'cancel', 'Close' );
    }

    $this->assignRef('item', $item);

    parent::display($tpl);
*/
//    $model = &$this->getModel();
//    $params = &$model->getParams();

    $item =& $this->get('Data');

    $paramsdata = $item->params;
	$paramsdefs = JPATH_COMPONENT.DS.'models'.DS.'info.xml';
	$params = new JParameter( $paramsdata, $paramsdefs );

    if($item->itemid == 0) {
      $item->itemid = JRequest::getInt('itemid');
    }

    $file = JPATH_COMPONENT.DS.'models'.DS.'info.xml';
    $params = new JParameter( $item->params, $file );

    $this->assignRef('params', $params);

    $document = & JFactory::getDocument();
    $document->setTitle( JText::_('Edit info') );

    JHTML::_('behavior.tooltip');

    $this->assignRef('item', $item);

    $lists = array();
    $db =& JFactory::getDBO();
    $query = "SELECT id,name FROM #__"._JC_DB.";";
    $db->setQuery($query);

    $items = array();
    $items[] = JHTML::_('select.option', '0', '- '.JText::_('Select item').' -', 'id', 'name');
    $items = array_merge($items, $db->loadObjectList());

    $lists['itemid'] = JHTML::_('select.genericlist', $items, 'itemid', 'class="inputbox" size="1"', 'id', 'name', $item->itemid);


    $query = "SELECT id,name FROM #__"._JC_DB."_type;";
    $db->setQuery($query);

    $types = array();
    $types[] = JHTML::_('select.option', '0', '- '.JText::_('Select type').' -', 'id', 'name');
    $types = array_merge($types, $db->loadObjectList());

    $lists['typeid'] = JHTML::_('select.genericlist', $types, 'typeid', 'class="inputbox" size="1"', 'id', 'name', $item->typeid);

    $this->assignRef('lists', $lists);

    $this->assignRef('params',$params);

    parent::display($tpl);

  }
}
?>
