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
		$doc = &JFactory::getDocument();
		$item =& $this->get('Data');

		$isNew = ((int)$item->id == 0);
		$id = $item->id;
		$lists = array();
		$lists['infoid'] = JCollectionHelper::filterInfo( 'infoid', $item->itemid, $id, ' onchange="listChanged(null);"' );

		$row = &$item;

		$typeid = (int)$item->typeid;
		//$lists['typeid'] = JCollectionHelper::filterType( 'typeid', $typeid, false );

		$infoparamsdata = $item->params;
		$infoparamsdefs = _JC_PATH.DS.'models'.DS.'info.xml';
		$infoparams = new JParameter( $infoparamsdata, $infoparamsdefs );

		if(!$isNew) {
			$infoparams->loadArray( $item );
		}

		$i = $infoparams->render('params','Amazon');

		jimport('joomla.html.pane');
		$pane =& JPane::getInstance('tabs');
		$this->assignRef('item', $item);
		$this->assignRef('pane',$pane);
		$this->assignRef('infoparams', $infoparams);
		$this->assignRef('lists', $lists);

		if ($row->img == '') {
			$row->img = 'blank.png';
		}

		$xmlstr = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>";
		$xmlstr .= "<document>";
		$xmlstr .= "<htmlnode id=\"infoid_div\"><![CDATA[".$lists['infoid']."]]></htmlnode>";
		$xmlstr .= "<valuenode id=\"infoname\"><![CDATA[".$row->name."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"typeid\">".(int)$row->typeid."</valuenode>";
		$xmlstr .= "<valuenode id=\"info1\"><![CDATA[".$row->info1."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info2\"><![CDATA[".$row->info2."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info3\"><![CDATA[".$row->info3."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info4\"><![CDATA[".$row->info4."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info5\"><![CDATA[".$row->info5."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info6\"><![CDATA[".$row->info6."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info7\"><![CDATA[".$row->info7."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info8\"><![CDATA[".$row->info8."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info9\"><![CDATA[".$row->info9."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"info10\"><![CDATA[".$row->info10."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infotitle\"><![CDATA[".$row->title."]]></valuenode>";
		$xmlstr .= "<editornode id=\"infodescription\"><![CDATA[".$row->description."]]></editornode>";
		$xmlstr .= "<valuenode id=\"infoimg\"><![CDATA[".$row->img."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infourl\"><![CDATA[".$row->url."]]></valuenode>";
		/*
		$xmlstr .= "<valuenode id=\"showinfo1\"><![CDATA[".$infoparams->get('showinfo1')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo2\"><![CDATA[".$infoparams->get('showinfo2')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo3\"><![CDATA[".$infoparams->get('showinfo3')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo4\"><![CDATA[".$infoparams->get('showinfo4')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo5\"><![CDATA[".$infoparams->get('showinfo5')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo6\"><![CDATA[".$infoparams->get('showinfo6')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo7\"><![CDATA[".$infoparams->get('showinfo7')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo8\"><![CDATA[".$infoparams->get('showinfo8')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo9\"><![CDATA[".$infoparams->get('showinfo9')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"showinfo10\"><![CDATA[".$infoparams->get('showinfo10')."]]></valuenode>";

		$xmlstr .= "<valuenode id=\"created_by\"><![CDATA[".$row->created_by."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"created_by_alias\"><![CDATA[".$row->created_by_alias."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"access\"><![CDATA[".$row->access."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"published\"><![CDATA[".$row->published."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"approved\"><![CDATA[".$row->approved."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"date\"><![CDATA[".$row->date."]]></valuenode>";
		*/
		$xmlstr .= "<valuenode id=\"infoparamsshow_vote\"><![CDATA[".$infoparams->get( 'show_vote', '' )."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo1overwrite\"><![CDATA[".$infoparams->get('info1overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo2overwrite\"><![CDATA[".$infoparams->get('info2overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo3overwrite\"><![CDATA[".$infoparams->get('info3overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo4overwrite\"><![CDATA[".$infoparams->get('info4overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo5overwrite\"><![CDATA[".$infoparams->get('info5overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo6overwrite\"><![CDATA[".$infoparams->get('info6overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo7overwrite\"><![CDATA[".$infoparams->get('info7overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo8overwrite\"><![CDATA[".$infoparams->get('info8overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo9overwrite\"><![CDATA[".$infoparams->get('info9overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsinfo10overwrite\"><![CDATA[".$infoparams->get('info10overwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamstitleoverwrite\"><![CDATA[".$infoparams->get('titleoverwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsdescriptionoverwrite\"><![CDATA[".$infoparams->get('descriptionoverwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsimgoverwrite\"><![CDATA[".$infoparams->get('imgoverwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"infoparamsurloverwrite\"><![CDATA[".$infoparams->get('urloverwrite')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"amazonitem_id\"><![CDATA[".$infoparams->get('amazonitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"amazonitem_name\"><![CDATA[".$infoparams->get('amazonitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"googlebookitem_id\"><![CDATA[".$infoparams->get('googlebookitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"googlebookitem_name\"><![CDATA[".$infoparams->get('googlebookitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"wikipediaitem_id\"><![CDATA[".$infoparams->get('wikipediaitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"wikipediaitem_name\"><![CDATA[".$infoparams->get('wikipediaitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"isbndbitem_id\"><![CDATA[".$infoparams->get('isbndbitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"isbndbitem_name\"><![CDATA[".$infoparams->get('isbndbitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"imdbitem_id\"><![CDATA[".$infoparams->get('imdbitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"imdbitem_name\"><![CDATA[".$infoparams->get('imdbitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"yahoomapitem_id\"><![CDATA[".$infoparams->get('yahoomapitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"yahoomapitem_name\"><![CDATA[".$infoparams->get('yahoomapitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"ebayitem_id\"><![CDATA[".$infoparams->get('ebayitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"ebayitem_name\"><![CDATA[".$infoparams->get('ebayitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"zanoxitem_id\"><![CDATA[".$infoparams->get('zanoxitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"zanoxitem_name\"><![CDATA[".$infoparams->get('zanoxitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"googlemapitem_id\"><![CDATA[".$infoparams->get('googlemapitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"googlemapitem_name\"><![CDATA[".$infoparams->get('googlemapitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"yahoomusicitem_id\"><![CDATA[".$infoparams->get('yahoomusicitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"yahoomusicitem_name\"><![CDATA[".$infoparams->get('yahoomusicitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"yahooitem_id\"><![CDATA[".$infoparams->get('yahooitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"yahooitem_name\"><![CDATA[".$infoparams->get('yahooitem')."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"lastfmitem_id\"><![CDATA[".addslashes( $infoparams->get('lastfmitem') )."]]></valuenode>";
		$xmlstr .= "<valuenode id=\"lastfmitem_name\"><![CDATA[".addslashes( $infoparams->get('lastfmitem') )."]]></valuenode>";
		$xmlstr .= "</document>";

		$doc->setMimeEncoding('text/xml');
		echo $xmlstr;
		return;
	}
}
?>
