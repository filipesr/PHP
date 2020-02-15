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
 * Item View
 *
 * @package    Collection.Manager
 * @subpackage com_collection
 */
class JCollectionViewItem extends JView
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

		//get the item
		$item =& $this->get('Data');

		$paramsdata = $item->params;
		$paramsdefs = _JC_PATH.DS.'models'.DS.'item.xml';
		$params = new JParameter( $paramsdata, $paramsdefs );

		$isNew = ($item->id < 1);

		if(!$isNew) {
			$params->loadArray( $item );
		}

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Item' ).': <small><small>[ ' . $text.' ]</small></small>' );
		$bar = & JToolBar::getInstance('toolbar');

		JToolBarHelper::media_manager();
		JToolBarHelper::divider();
		JToolBarHelper::apply();
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		// include for proper popup operation
		JHTML::_('behavior.modal');

		// include for session
		JHTML::_('behavior.keepalive');

		// include for proper tooltip operation
		JHTML::_('behavior.tooltip');


		$db =& JFactory::getDBO();

		$lists = array();

		$lists['catid'] = JCollectionHelper::categoryList( 'catid', 'class="inputbox" size="1"', $item->catid, null, 'Root' );

		$editor =& JFactory::getEditor();

		jimport('joomla.html.pane');

		//$infoid = $mainframe->getUserStateFromRequest( $option.'.infoid', 'infoid', 0,'int' );
		$infoid = (int)$item->info->id;
		$lists['infoid'] = JCollectionHelper::filterInfo( 'infoid', $item->id, $infoid );

		$pane =& JPane::getInstance('tabs');

		$typeid = (int)$item->info->typeid;
		$lists['typeid'] = JCollectionHelper::filterType( 'typeid', $typeid );

		$infoparamsdata = $item->info->params;
		$infoparamsdefs = _JC_PATH.DS.'models'.DS.'info.xml';
		$infoparams = new JParameter( $infoparamsdata, $infoparamsdefs );

		if(!$isNew) {
			$infoparams->loadArray( $item->info );
		}

		$lists['image'] = JHTML::_('list.images',  'img', $item->img, null, '/images/jcollection/' );
		$js = "onchange=\"javascript:if (document.forms.adminFormInfo.infoimg.options[selectedIndex].value!='') {document.imagelib2.src='../images/jcollection/'+ document.forms.adminFormInfo.infoimg.options[selectedIndex].value} else {document.imagelib2.src='../images/blank.png'}\"";
		$lists['infoimg'] = JHTML::_('list.images',  'infoimg', $item->info->img, $js, '/images/jcollection/' );

		$this->assignRef('types', $types);
		$this->assignRef('item', $item);
		$this->assignRef('pane',$pane);
		$this->assignRef('params',$params);
		$this->assignRef('infoparams', $infoparams);
		$this->assignRef('lists', $lists);
		$this->assignRef('editor',$editor);

		$js = "
		function submitbutton(pressbutton)
		{
                var form = document.adminForm;
                if (pressbutton == 'cancel') {
                        submitform( pressbutton );
                        return;
                } else {
                	var id = document.getElementById(\"id\").value;
                	if(id>0) {
                		".$editor->save( 'infodescription' )."
                		document.adminFormInfo.submit(pressbutton);
                	}
                	if ( form.name.value == '' ){
                    	alert(\"".JText::_( 'Item must have a name', true )."\");
                    } else {
                                ".$editor->save( 'description' )."
                                submitform(pressbutton);
                        }
                	//submitform( pressbutton );
                }
        }

		window.addEvent('domready', function() {
			changeType();

			// Ajax request if info set is changed
			$('infoid').addEvent('change', listChanged);

			/*
			$('infoup').addEvent('click', function(e) {
				// prevent the click event
				e = new Event(e).stop();
				var infostatus = $('infostatus');
				infostatus.innerHTML = '<b>Reordering...</b>';
				var infoid = $('infoid').value;
				var infoid_el = $('infoid');
				var url = 'index.php?option=com_jcollection&controller=item&task=ajaxinfoup&cid[]='+infoid+'&format=raw';
				new Ajax(url, {
					method: 'get',
					onSuccess: function(text,xml) {
						infostatus.innerHTML = '<b>".JText::_('Reordered', true)."</b>';
						var index = infoid_el.selectedIndex;
						if(index>1) {
							moveInList( 'adminFormInfo', 'infoid', infoid_el.selectedIndex, -1);
						}
					},
					onFailure: ajaxFailed
				}).request();
			});

			$('infodown').addEvent('click', function(e) {
				// prevent the click event
				e = new Event(e).stop();
				var infostatus = $('infostatus');
				infostatus.innerHTML = '<b>Reordering...</b>';
				var infoid = $('infoid').value;
				var infoid_el = $('infoid');
				var url = 'index.php?option=com_jcollection&controller=item&task=ajaxinfodown&cid[]='+infoid+'&format=raw';
				new Ajax(url, {
					method: 'get',
					onSuccess: function(text,xml) {
						infostatus.innerHTML = '<b>".JText::_('Reordered', true)."</b>';
						moveInList( 'adminFormInfo', 'infoid', infoid_el.selectedIndex, 1);
					},
					onFailure: ajaxFailed
				}).request();
			});
			*/

			// Ajax request to save info field
			$('adminFormInfo').addEvent('submit', function(e) {
				// prevent the submit event
				e = new Event(e).stop();

				".$editor->save( 'infodescription' )."
				var infostatus = $('infostatus');
				infostatus.innerHTML = '<b>Saving...</b>';
				var infoid = document.getElementById('infoid').value;
				var infoid_el = document.getElementById('infoid');
				var infoname = document.getElementById('infoname').value;
				this.send({
					onSuccess: function(text,xml) {
						if(infoid == '0' && text!=null && text!='0' && text!='-1') {
							infostatus.innerHTML = '<b>".JText::_('Success - new info set saved', true)."</b>';
							var infolist = $('infoid');

							var l = infolist.length;
							for(var i = l; i>1; i--) {
								infolist.options[i] = new Option(infolist.options[i-1].text,infolist.options[i-1].value);
							}
							infolist.options[1] = new Option(infoname, text, false, true);

						} else {
							if( text!=null && infoid == text) {
								infostatus.innerHTML = '<b>".JText::_('Success - info set saved', true)."</b>';
								infoid_el.options[infoid_el.selectedIndex].text = infoname;
							} else {
								infostatus.innerHTML = '<b>".JText::_('Could not save info set', true)."</b>';
							}
						}
					},
					onFailure: ajaxFailed
				});
			});
		});

		function listChanged(e) {
			if(e!=null) {
				// prevent the change event
				e = new Event(e).stop();
			}

			var infoid = document.getElementById(\"infoid\").value;
			var url = \"index.php?option=com_jcollection&controller=item&task=ajaxfetchinfo&cid[]=\"+infoid+\"&format=raw\";

			/**
	 		* The simple way for an Ajax request, use onRequest/onComplete/onFailure
	 		* to do add your own Ajax depended code.
	 		*/
			new Ajax(url, {
				method: 'get',
				onSuccess: updateInfo,
				onFailure: ajaxFailed
			}).request();
		}

		function ajaxFailed()
		{
			alert( '".JText::_( 'Ajax request failed.', true )."' );
		}

		function updateList()
		{
			var infostatus = $('infostatus');
			infostatus.innerHTML = '<b>Update list...</b>';
			var itemid = $('itemid').value;
			var url = 'index.php?option=com_jcollection&controller=infos&task=ajaxlist&filter_itemid='+itemid+'&format=raw';
			new Ajax(url, {
					method: 'get',
					onSuccess: updateInfo,
					onFailure: ajaxFailed
				}).request();
		}

		function updateInfo(text,xml)
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

			//var newinfo = document.getElementById(\"infoid\").value;

			var nodes = xml.getElementsByTagName(\"valuenode\");
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
							d.value = v;
						}
					}
				}
			}
			nodes = xml.getElementsByTagName(\"htmlnode\");
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
			nodes = xml.getElementsByTagName(\"editornode\");
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
							".$editor->setContent('infodescription','v')."
						}
					}
				}
			}

		};
		";
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $js );

		parent::display($tpl);
	}
}
?>
