<?php
/**
 * JCollection Review View
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
 * Category View
 */
class JCollectionViewRev extends JView
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
		$review =& $this->get('Data');
		$isNew = ($review->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Review' ).': <small><small>[ ' . $text.' ]</small></small>' );
		$bar = & JToolBar::getInstance('toolbar');

		$bar->appendButton( 'Popup', 'new', 'Info', 'index.php?option=com_jcollection&amp;controller=infos&amp;task=popup_rev&amp;tmpl=component', 570, 370 );
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


		$this->assignRef('review', $review);

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
		//$lists['parent'] = JCollectionHelper::categoryList('parent', 'class="inputbox" size="1"', $cat->parent, $cat->id);

		$lists['image'] = JHTML::_('list.images',  'img', $review->img, null, '/images/jcollection/' );

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, name AS text' .
                                ' FROM #__'._JC_DB.'_review' .
                                ' WHERE infoid = ' . (int) $review->infoid .
                                ' AND published >= 0' .
                                ' ORDER BY ordering';
		if(!$isNew) {
			$lists['ordering'] = JHTML::_('list.specificordering', $review, $review->id, $query, 1);
		} else {
			$lists['ordering'] = JHTML::_('list.specificordering', $review, '', $query, 1);
		}

		$catid = $mainframe->getUserStateFromRequest( $option.'catid', 'catid', 0, 'int' );
		$lists['cat'] = JCollectionHelper::categoryList('catid', 'class="inputbox" size="1"', $catid);
		$itemid = $mainframe->getUserStateFromRequest( $option.'itemid', 'itemid', 0, 'int' );
		$lists['item'] = JCollectionHelper::listItem( 'itemid', $catid, $itemid);
		$itemid = $mainframe->getUserStateFromRequest( $option.'infoid', 'infoid', 0, 'int' );
		$lists['info'] = JCollectionHelper::listInfo( 'infoid', $itemid, $infoid);
		jimport('joomla.html.pane');

		$pane =& JPane::getInstance('tabs');

		$paramsdata = $review->params;
		$paramsdefs = _JC_PATH.DS.'models'.DS.'rev.xml';
		$params = new JParameter( $paramsdata, $paramsdefs );

		$params->loadArray( $review );

		$this->assignRef('lists', $lists);
		$this->assignRef('pane',$pane);
		$this->assignRef('params',$params);

		$document = &JFactory::getDocument();
		//$document->addScript('../includes/js/joomla/popup.js');
		//$document->addStyleSheet('../includes/js/joomla/popup.css');

		$editor =& JFactory::getEditor();

		$js = "
		function submitbutton(pressbutton)
		{
                var form = document.adminForm;
                if (pressbutton == 'cancel') {
                        submitform( pressbutton );
                        return;
                } else {
                	if ( form.name.value == '' ){
                    	alert(\"".JText::_( 'Review must have a name', true )."\");
                    } else {
                                ".$editor->save( 'description' )."
                                ".$editor->save( 'review' )."
                                submitform(pressbutton);
                        }
                	//submitform( pressbutton );
                }
        }

		window.addEvent('domready', function() {

			// Ajax request if category is changed
			//$('catid').addEvent('change', catChanged);

			//$('itemid').addEvent('change', itemChanged);

		});

		function catChanged(e) {
			// prevent the change event
			e = new Event(e).stop();

			var catid = document.getElementById(\"catid\").value;
			var url = \"index.php?option=com_jcollection&controller=items&task=ajaxlist&catid=\"+catid+\"&format=raw\";

			/**
 			* The simple way for an Ajax request, use onRequest/onComplete/onFailure
 			* to do add your own Ajax depended code.
 			*/
			new Ajax(url, {
				method: 'get',
				onSuccess: updateItems,
				onFailure: ajaxFailed
			}).request();
		}

		function itemChanged(e) {
			// prevent the change event
			e = new Event(e).stop();

			var itemid = document.getElementById(\"itemid\").value;
			var url = \"index.php?option=com_jcollection&controller=infos&task=ajaxlist&itemid=\"+itemid+\"&format=raw\";

			/**
	 		* The simple way for an Ajax request, use onRequest/onComplete/onFailure
	 		* to do add your own Ajax depended code.
	 		*/
			new Ajax(url, {
				method: 'get',
				onSuccess: updateItems,
				onFailure: ajaxFailed
			}).request();
		}

		function ajaxFailed()
		{
			alert( '".JText::_( 'Ajax request failed.' )."' );
		}

		function updateItems(text,xml)
		{
			if(xml == null) { // check if text/xml response has been parsed properly
				// if not, try to parse text manually
				try //Internet Explorer
				{
					xml=new ActiveXObject(\"Microsoft.XMLDOM\");
					xml.async=\"false\";
					xml.loadXML(text);
				}
				catch(e)
				{
					try //Firefox, Mozilla, Opera, etc.
					{
	 					parser=new DOMParser();
						xml=parser.parseFromString(text,\"text/xml\");
					}
					catch(e)
  					{
  						alert(e.message);
  						return;
  					}
				}
			}

			var nodes = xml.getElementsByTagName(\"node\");
			if (nodes != null)
			{
				for (var i = 0; i < nodes.length; i++)
				{
					var n = nodes[i];
					var f = n.firstChild;
					var id = n.getAttribute(\"id\");
					if( id != null && id != '' ) {
						var d = document.getElementById(id);
						if( f!= null && d != null ) {
							var v = n.firstChild.nodeValue;
							d.innerHTML = v;
						}
					}
				}
			}
			//$('catid').addEvent('change', catChanged);
			//$('itemid').addEvent('change', itemChanged);
		};

		function jSelectInfo(id, title, itemname, catname, rating1label, rating2label, rating3label, rating4label, rating5label) {
			document.getElementById('infoid').value = id;
			document.getElementById('infoid_name').value = title;
			document.getElementById('itemname').value = itemname;
			document.getElementById('catname').value = catname;
			document.getElementById('rating1label').innerHTML = rating1label;
			document.getElementById('rating2label').innerHTML = rating2label;
			document.getElementById('rating3label').innerHTML = rating3label;
			document.getElementById('rating4label').innerHTML = rating4label;
			document.getElementById('rating5label').innerHTML = rating5label;
			document.getElementById('sbox-window').close();
		}

		";
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $js );

		parent::display($tpl);
	}
}
?>