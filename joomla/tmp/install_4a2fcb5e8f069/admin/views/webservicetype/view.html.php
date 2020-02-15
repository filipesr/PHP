<?php
/**
 * JCollection Webservicetype View
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
 * Webservicetype View
 */
class JCollectionViewWebservicetype extends JView
{
	/**
	* display method of Item view
	* @return void
	**/
	function display($tpl = null)
	{
		// disable the menu bar
		JRequest::setVar( 'hidemainmenu', 1 );

		//get the type
		$type =& $this->get('Data');
		$isNew = ($cat->id < 1);

		//$paramsdata = $type->params;
		//$paramsdefs = JPATH_COMPONENT.DS.'models'.DS.'webservicetype.xml';
		//$params = new JParameter( $paramsdata, $paramsdefs );

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Type (webservices)' ).': <small><small>[ ' . $text.' ]</small></small>' );
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


		$this->assignRef('type', $type);

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
		$webservices = JCollectionHelper::getWebservices();
		$ws = array();
		foreach($webservices as $webservice) {
			$w = new stdClass();
			$w->text = $webservice;
			$w->value = $webservice;
			$ws[] = $w;
		}

		$w = $webservices[0];
		if($type->webservice) {
			$w = $type->webservice;
		}

		$lists['webservice'] = JHTML::_('select.genericlist', $ws, 'webservice', 'class="inputbox" size="1"', 'value', 'text', $w );

		$db =& JFactory::getDBO();
		$query = "SELECT id,name FROM #__"._JC_DB."_type;";
    	$db->setQuery($query);

    	$types = array();
    	$types[] = JHTML::_('select.option', '0', '- '.JText::_('Select type').' -', 'id', 'name');
    	$types = array_merge($types, $db->loadObjectList());
		$lists['typeid'] = JHTML::_('select.genericlist', $types, 'typeid', 'class="inputbox" size="1"', 'id', 'name', $type->typeid);


		jimport('joomla.html.pane');

		$pane =& JPane::getInstance('tabs');

		//if($type->params) {
			$paramsdata = $type->params;
		//} else {
		//	$paramsdata = '';
		//}

		$paramsdefs = JPATH_COMPONENT.DS.'models'.DS.'webservicetype.xml';
		$params = new JParameter( $paramsdata, $paramsdefs );

		if($type->id) {
			$params->loadArray( $type );
		}

		$editor =& JFactory::getEditor();

		$this->assignRef('lists', $lists);
		$this->assignRef('pane',$pane);
		$this->assignRef('params',$params);

		$this->assignRef('editor',$editor);

		$js = "
		function submitbutton(pressbutton)
		{
                var form = document.adminForm;
                if (pressbutton == 'cancel') {
                        submitform( pressbutton );
                        return;
                } else {
                	if ( form.name.value == '' ){
                    	alert(\"".JText::_( 'Webservice type must have a name', true )."\");
                    } else {
                                ".$editor->save( 'disclaimer' )."
                                submitform(pressbutton);
                        }
                	//submitform( pressbutton );
                }
        }
        ";

		$document = &JFactory::getDocument();
		$document->addScriptDeclaration($js);

		parent::display($tpl);
	}
}
?>