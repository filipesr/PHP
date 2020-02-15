<?php
/**
 * JCollection Imdbitem element (for usage in parameter panels)
 *
 * @version $Id$
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

class JElementImdbitem extends JElement
{
	/**
	* Element name
	*
	* @access      protected
	* @var         string
	*/
	var     $_name = 'Imdbitem';

	function fetchElement($name, $value, &$node, $control_name)
	{
		global $mainframe, $option;

		$db =& JFactory::getDBO();
		$doc =& JFactory::getDocument();
		$template = $mainframe->getTemplate();
		$fieldName = $control_name.'['.$name.']';
		//JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS._JC_COMPNAME.DS.'tables');
		//$item =& JTable::getInstance('item', 'Table');
		//if ($value) {
		//	$item->load($value);
		//} else {
		//	$item->name = JText::_('Select an Item');
		//}
		$item = new stdClass();
		if($value) {
			$item->name = $value;
		} else {
			$item->name = JText::_('Find imdb id');
		}

		$js = "function jSelectItem(id, title, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;
			document.getElementById('sbox-window').close();
			}";
		$doc->addScriptDeclaration($js);

		$link = 'index.php?option='._JC_COMPNAME.'&amp;controller=elements&amp;task=imdbitem&amp;tmpl=component&amp;object='.$name;

		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<div style="float: left;"><input style="background: #ffffff;" type="text" id="'.$name.'_name" value="'.htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
//              $html .= "\n &nbsp; <input class=\"inputbox modal-button\" type=\"button\" value=\"".JText::_('Select')."\" />";
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('Select an Item').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}">'.JText::_('Select').'</a></div></div>'."\n";
		$html .= '<div class="button2-left"><div class="blank"><span onclick="jSelectItem(\'\',\''.JText::_('Select an Item').'\',\''.$name.'\');" title="'.JText::_('Clear selection').'">'.JText::_('Clear').'</span></div></div>'."\n";
		$html .= "\n".'<input type="hidden" id="'.$name.'_id" name="'.$fieldName.'" value="'.htmlspecialchars(strval($value), ENT_QUOTES, 'UTF-8').'" />';

		return $html;
	}
}
?>
