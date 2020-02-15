<?php
/**
 * JCollection Helper class
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

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport('joomla.utilities.date');
jimport( 'joomla.filesystem.file' );

class JCollectionHelper
{
	/**
	 * Construct a category HTML list
	 *
	 * @param string $name Name of the HTML tag
	 * @param string $attribs Atrributes of the HTML tag
	 * @param integer $active Active element
	 * @param integer $skipid The ID of the entry to skip
	 * @param string $top Text for the root category
	 * @return string HTML code of the select list
	 *
	 */
	function categoryList( $name, $attribs, $active=null, $skipid=null, $top='Top' )
	{
		$db =& JFactory::getDBO();

		// If a not a new item, lets set the menu item id
		if ( $skipid ) {
			$id = ' AND id != '.intval($skipid);
		} else {
			$id = '';
		}

		// get a list of the categories
		// excluding the current category and its child elements if we build this list to choose a parent
		$query = "SELECT * "
		."\n FROM #__"._JC_DB."_cat "
		."\n WHERE published != -2 "
		.$id
		."\n ORDER BY parent, ordering";
		$db->setQuery( $query );
		$citems = $db->loadObjectList();

		// establish the hierarchy of the categories
		$children = array();

		if ( $citems )
		{
			// first pass - collect children
			foreach ( $citems as $v )
			{
				$pt = $v->parent;
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}
		}

		// second pass - get an indent list of the items
		$list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );

		// assemble categories to the array
		$citems         = array();
		$citems[]       = JHTML::_('select.option',  '0', JText::_( $top ) );

		foreach ( $list as $it ) {
			$citems[] = JHTML::_('select.option',  $it->id, '&nbsp;&nbsp;&nbsp;'. $it->treename );
		}

		$list = JHTML::_('select.genericlist', $citems, $name, $attribs, 'value', 'text', $active );
		return $list;
	}

	/**
	 * Construct a list category HTML list
	 *
	 * @param string $name Name of the HTML tag
	 * @param string $attribs Atrributes of the HTML tag
	 * @param integer $active Active element
	 * @param integer $skipid The ID of the entry to skip
	 * @param string $top Text for the root category
	 * @return string HTML code of the select list
	 *
	 */
	function listCategoryList( $name, $attribs, $active=null, $skipid=null, $top='Top' )
	{
		$db =& JFactory::getDBO();

		// If a not a new item, lets set the menu item id
		if ( $skipid ) {
			$id = ' AND id != '.intval($skipid);
		} else {
			$id = '';
		}

		// get a list of the categories
		// excluding the current category and its child elements if we build this list to choose a parent
		$query = "SELECT id AS value,name AS text "
		."\n FROM #__"._JC_DB."_listcat "
		."\n WHERE published != -2 "
		.$id
		."\n ORDER BY ordering";
		$db->setQuery( $query );

		// assemble categories to the array
		$citems         = array();
		if($top) {
			$citems[]       = JHTML::_('select.option',  '0', JText::_( $top ) );
		}

		$citems = array_merge( $citems, $db->loadObjectList() );

		$list = JHTML::_('select.genericlist', $citems, $name, $attribs, 'value', 'text', $active );
		//		$lists['parent'] = JHTML::_('select.genericlist',   $mitems, 'parent', 'class="inputbox" size="1"', 'value', 'text', $active );
		return $list;
	}

	function listItem( $name, $catid, $active = 0, $order = 'name' )
	{
		$db =& JFactory::getDBO();

		$and = '';
		if($catid>0) {
			$and = ' AND catid = '.$catid;
		}
		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__'._JC_DB.' '
		. ' WHERE published >= 0'
		. $and
		. ' ORDER BY '. $order
		;
		$db->setQuery( $query );
		$items = array();
		$items[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Select item' ) .' -' );
		$items = array_merge( $items, $db->loadObjectList() );

		$items = JHTML::_('select.genericlist',   $items, $name, 'class="inputbox" size="1"', 'value', 'text', $active );

		return $items;
	}

	function listInfo( $name, $itemid, $active = 0, $order = 'name', $js = '' )
	{
		$db =& JFactory::getDBO();

		$and = '';
		if($itemid>0) {
			$and = ' AND itemid = '.$itemid;
		}
		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__'._JC_DB.'_info '
		. ' WHERE published >= 0'
		. $and
		. ' ORDER BY '. $order
		;
		$db->setQuery( $query );
		$items = array();
		$items[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Select info' ) .' -' );
		$items = array_merge( $items, $db->loadObjectList() );

		$items = JHTML::_('select.genericlist',   $items, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', $active );

		return $items;
	}

	function filterAccess( $name, $defaccess = -1 )
	{
		if ($defaccess === '') {
			$defaccess = -1;
		}
		$db =& JFactory::getDBO();

		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__groups'
		. ' ORDER BY id'
		;
		$db->setQuery( $query );
		$groups = array();
		$groups[] = JHTML::_('select.option', -1, '- '.JText::_('Select access level').' -');
		$groups = array_merge( $groups, $db->loadObjectList() );
		$access = JHTML::_('select.genericlist', $groups, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', intval( $defaccess ), '', 1 );
		return $access;
	}

	function filterCategory( $name, $active = NULL )
	{
		$cats = JCollectionHelper::categoryList( $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', $active, null, 'Select Category' );
		return $cats;
	}

	function filterAuthor( $name, $active = 0, $reg = false, $order = 'name' )
	{
		$db =& JFactory::getDBO();

		$and = '';
		if ( $reg ) {
			// does not include registered users in the list
			$and = ' AND gid > 18';
		}

		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__users'
		. ' WHERE block = 0'
		. $and
		. ' ORDER BY '. $order
		;
		$db->setQuery( $query );
		$users = array();
		$users[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Select author' ) .' -' );
		$users = array_merge( $users, $db->loadObjectList() );

		$users = JHTML::_('select.genericlist',   $users, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $users;
	}

	function filterItem( $name, $active = 0, $catid = 0, $subcats = false, $order = 'name' )
	{
		$db =& JFactory::getDBO();

		$and = '';
		if($catid>0) {
			if($subcats) {
				$catids = array();
				$catids[] = $catid;
				$new_cats = $catids;
				while($new_cats) {
					$query = 'SELECT i.id'
						.' FROM #__'._JC_DB.'_cat AS i '
						."\n WHERE i.parent IN ( ".implode(',',$new_cats).' )';
					$db->setQuery($query);
					$new_cats = $db->loadResultArray();
					$catids = array_merge( $catids, $new_cats);
				}
				$and = ' AND catid IN ( '.implode(',',$catids).' )';
			} else {
				$and = ' AND catid = '.(int)$catid;
			}
		}
		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__'._JC_DB.' '
		. ' WHERE published >= 0'
		.$and
		. ' ORDER BY '. $order
		;
		$db->setQuery( $query );
		$items = array();
		$items[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Select item' ) .' -' );
		$items = array_merge( $items, $db->loadObjectList() );

		$items = JHTML::_('select.genericlist',   $items, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $items;
	}

	function filterListCategory( $name, $active = 0, $order = 'name' )
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__'._JC_DB.'_listcat '
		. ' WHERE published >= 0'
		. ' ORDER BY '. $order
		;
		$db->setQuery( $query );
		$items = array();
		$items[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Select list category' ) .' -' );
		$items = array_merge( $items, $db->loadObjectList() );

		$items = JHTML::_('select.genericlist',   $items, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $items;
	}

	function filterApproved( $name, $active = 0 )
	{
		$db =& JFactory::getDBO();
		$app = array();
		$app[] = JHTML::_('select.option',  '-1', '- '. JText::_( 'Select approval status' ) .' -' );
		$app[] = JHTML::_('select.option',  '1', JText::_( 'Approved' ) );
		$app[] = JHTML::_('select.option',  '0', JText::_( 'Disapproved' ) );
		$app = JHTML::_('select.genericlist',   $app, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $app;
	}

	function filterState( $name, $active = '', $published='Published', $unpublished='Unpublished', $archived=NULL, $trashed=NULL )
	{
		$state[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select State' ) .' -' );
		$state[] = JHTML::_('select.option',  'P', JText::_( $published ) );
		$state[] = JHTML::_('select.option',  'U', JText::_( $unpublished ) );

		if ($archived) {
			$state[] = JHTML::_('select.option',  'A', JText::_( $archived ) );
		}

		if ($trashed) {
			$state[] = JHTML::_('select.option',  'T', JText::_( $trashed ) );
		}

		return JHTML::_('select.genericlist',   $state, $name, 'class="inputbox" size="1" onchange="submitform( );"', 'value', 'text', $active );
	}

	function approved( &$row, $i, $link = true )
	{
		$img    = $row->approved ? 'tick.png' : 'publish_x.png';
		$task   = $row->approved ? 'disapprove' : 'approve';
		$alt    = $row->approved ? JText::_( 'Approved' ) : JText::_( 'Disapproved' );
		$action = $row->approved ? JText::_( 'Disapprove Category' ) : JText::_( 'Approve Category' );

		if($link) {
			$approved = '<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''.$task .'\')" title="'. $action .'">
                <img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>';
		} else {
			$approved = '<img src="images/'. $img .'" border="0" alt="'. $alt .'" />';
		}
		return $approved;
	}

	function published( &$row, $i, $link = true )
	{
		$img    = $row->published ? 'tick.png' : 'publish_x.png';
		$task   = $row->published ? 'unpublish' : 'publish';
		$alt    = $row->published ? JText::_( 'Published' ) : JText::_( 'Unpublished' );
		$action = $row->published ? JText::_( 'Unpublish Category' ) : JText::_( 'Publish Category' );

		if($link) {
			$published = '<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''.$task .'\')" title="'. $action .'">
                <img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>';
		} else {
			$published = '<img src="images/'. $img .'" border="0" alt="'. $alt .'" />';
		}
		return $published;
	}

	function filterSearchindex( $name, $active = 0 )
	{
		$db =& JFactory::getDBO();
		$searchindex = array();
		$searchindex[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select Amazon SearchIndex' ) .' -' );
		$searchindex[] = JHTML::_('select.option',  'All', JText::_( 'All (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'Apparel', JText::_( 'Apparel (US,UK,DE,JP)' ) );
		$searchindex[] = JHTML::_('select.option',  'Automotive', JText::_( 'Automotive (US,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'Baby', JText::_( 'Baby (US,UK,DE,JP)' ) );
		$searchindex[] = JHTML::_('select.option',  'Beauty', JText::_( 'Beauty (US,JP)' ) );
		$searchindex[] = JHTML::_('select.option',  'Blended', JText::_( 'Blended (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'Books', JText::_( 'Books (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'Classical', JText::_( 'Classical (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'DigitalMusic', JText::_( 'DigitalMusic (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'DVD', JText::_( 'DVD (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'Electronics', JText::_( 'Electronics (US,UK,DE,JP,FR)' ) );
		$searchindex[] = JHTML::_('select.option',  'ForeignBooks', JText::_( 'ForeignBooks (DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'GourmetFood', JText::_( 'GourmetFood (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'Grocery', JText::_( 'Grocery (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'HealthPersonalCare', JText::_( 'HealthPersonalCare (US,UK,DE,JP)' ) );
		$searchindex[] = JHTML::_('select.option',  'Hobbies', JText::_( 'Hobbies (JP)' ) );
		$searchindex[] = JHTML::_('select.option',  'HomeGarden', JText::_( 'HomeGarden (US,UK,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'HomeImprovement', JText::_( 'HomeImprovement (UK,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'Industrial', JText::_( 'Industrial (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'Jewelry', JText::_( 'Jewelry (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'KindleStore', JText::_( 'KindleStore (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'Kitchen', JText::_( 'Kitchen (US,UK,DE,JP,FR)' ) );
		$searchindex[] = JHTML::_('select.option',  'Magazines', JText::_( 'Magazines (US,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'Merchants', JText::_( 'Merchants (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'Miscellaneous', JText::_( 'Miscellaneous (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'MP3Downloads', JText::_( 'MP3Downloads (US,UK)' ) );
		$searchindex[] = JHTML::_('select.option',  'Music', JText::_( 'Music (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'MusicalInstruments', JText::_( 'MusicalInstruments (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'MusicTracks', JText::_( 'MusicTracks (US,UK,DE,JP,FR)' ) );
		$searchindex[] = JHTML::_('select.option',  'OfficeProducts', JText::_( 'OfficeProducts (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'OutdoorLiving', JText::_( 'OutdoorLiving (US,UK,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'PCHardware', JText::_( 'PCHardware (US,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'PetSupplies', JText::_( 'PetSupplies (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'Photo', JText::_( 'Photo (US,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'Shoes', JText::_( 'Shoes (US,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'SilverMerchant', JText::_( 'SilverMerchant (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'Software', JText::_( 'Software (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'SoftwareVideoGames', JText::_( 'SoftwareVideoGames (UK,DE,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'SportingGoods', JText::_( 'SportingGoods (US,UK,DE,JP)' ) );
		$searchindex[] = JHTML::_('select.option',  'Tools', JText::_( 'Tools (US,UK,DE)' ) );
		$searchindex[] = JHTML::_('select.option',  'Toys', JText::_( 'Toys (US,UK,DE,JP,FR)' ) );
		$searchindex[] = JHTML::_('select.option',  'VHS', JText::_( 'VHS (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'Video', JText::_( 'Video (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'VideoGames', JText::_( 'VideoGames (US,UK,DE,JP,FR,CA)' ) );
		$searchindex[] = JHTML::_('select.option',  'Watches', JText::_( 'Watches (US,UK,DE,FR)' ) );
		$searchindex[] = JHTML::_('select.option',  'Wireless', JText::_( 'Wireless (US)' ) );
		$searchindex[] = JHTML::_('select.option',  'WirelessAccessories', JText::_( 'WirelessAccessories (US)' ) );

		$searchindex = JHTML::_('select.genericlist',   $searchindex, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $searchindex;
	}

	function filterCountryAmazon( $name, $active = '' )
	{
		$country = array();
		$country[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select country' ) .' -' );
		$country[] = JHTML::_('select.option',  'us', JText::_( 'USA' ) );
		$country[] = JHTML::_('select.option',  'uk', JText::_( 'UK' ) );
		$country[] = JHTML::_('select.option',  'de', JText::_( 'Germany' ) );
		$country[] = JHTML::_('select.option',  'jp', JText::_( 'Japan' ) );
		$country[] = JHTML::_('select.option',  'fr', JText::_( 'France' ) );
		$country[] = JHTML::_('select.option',  'ca', JText::_( 'Canada' ) );
		$country = JHTML::_('select.genericlist',   $country, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $country;
	}

	function filterCountryYahoomusic( $name, $active = '' )
	{
		$country = array();
		$country[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select country' ) .' -' );
		$country[] = JHTML::_('select.option',  'us', JText::_( 'USA' ) );
		$country[] = JHTML::_('select.option',  'uk', JText::_( 'UK' ) );
		$country[] = JHTML::_('select.option',  'de', JText::_( 'Germany' ) );
		$country[] = JHTML::_('select.option',  'ca', JText::_( 'Canada' ) );
		$country[] = JHTML::_('select.option',  'fr', JText::_( 'France' ) );
		$country[] = JHTML::_('select.option',  'it', JText::_( 'Italy' ) );
		$country[] = JHTML::_('select.option',  'mx', JText::_( 'Mexico' ) );
		$country[] = JHTML::_('select.option',  'es', JText::_( 'Spain' ) );
		$country[] = JHTML::_('select.option',  'nz', JText::_( 'New Zealand' ) );
		$country[] = JHTML::_('select.option',  'au', JText::_( 'Australia' ) );
		$country = JHTML::_('select.genericlist',   $country, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $country;
	}

	function filterCountryWikipedia( $name, $active = 0 )
	{
		$country = array();
		$country[] = JHTML::_('select.option',  '', '- '. JText::_( 'Select language' ) .' -' );
		$country[] = JHTML::_('select.option',  'en', JText::_( 'English' ) );
		$country[] = JHTML::_('select.option',  'de', JText::_( 'German' ) );
		$country[] = JHTML::_('select.option',  'fr', JText::_( 'French' ) );
		$country[] = JHTML::_('select.option',  'it', JText::_( 'Italian' ) );
		$country[] = JHTML::_('select.option',  'ru', JText::_( 'Russian' ) );
		$country[] = JHTML::_('select.option',  'ja', JText::_( 'Japanese' ) );
		$country[] = JHTML::_('select.option',  'es', JText::_( 'Spanish' ) );
		$country[] = JHTML::_('select.option',  'pl', JText::_( 'Polish' ) );
		$country[] = JHTML::_('select.option',  'pt', JText::_( 'Portuguese' ) );
		$country[] = JHTML::_('select.option',  'nl', JText::_( 'Dutch' ) );
		$country = JHTML::_('select.genericlist',   $country, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $country;
	}

	function filterCountryEBay( $name, $active = '-1' )
	{
		$country = array();
		$country[] = JHTML::_('select.option',  '-1', '- '. JText::_( 'Select country' ) .' -' );
		$country[] = JHTML::_('select.option',  '15', JText::_( 'Australia' ) );
		$country[] = JHTML::_('select.option',  '16', JText::_( 'Austria' ) );
		$country[] = JHTML::_('select.option',  '123', JText::_( 'Belgium (Dutch)' ) );
		$country[] = JHTML::_('select.option',  '23', JText::_( 'Belgium (French)' ) );
		$country[] = JHTML::_('select.option',  '2', JText::_( 'Canada (English)' ) );
		$country[] = JHTML::_('select.option',  '210', JText::_( 'Canada (French)' ) );
		$country[] = JHTML::_('select.option',  '223', JText::_( 'China' ) );
		$country[] = JHTML::_('select.option',  '100', JText::_( 'eBay Motors' ) );
		$country[] = JHTML::_('select.option',  '71', JText::_( 'France' ) );
		$country[] = JHTML::_('select.option',  '77', JText::_( 'Germany' ) );
		$country[] = JHTML::_('select.option',  '201', JText::_( 'Hong Kong' ) );
		$country[] = JHTML::_('select.option',  '203', JText::_( 'India' ) );
		$country[] = JHTML::_('select.option',  '205', JText::_( 'Ireland' ) );
		$country[] = JHTML::_('select.option',  '101', JText::_( 'Italy' ) );
		$country[] = JHTML::_('select.option',  '207', JText::_( 'Malaysia' ) );
		$country[] = JHTML::_('select.option',  '146', JText::_( 'Netherlands' ) );
		$country[] = JHTML::_('select.option',  '211', JText::_( 'Philippines' ) );
		$country[] = JHTML::_('select.option',  '212', JText::_( 'Poland' ) );
		$country[] = JHTML::_('select.option',  '216', JText::_( 'Singapore' ) );
		$country[] = JHTML::_('select.option',  '186', JText::_( 'Spain' ) );
		$country[] = JHTML::_('select.option',  '218', JText::_( 'Sweden' ) );
		$country[] = JHTML::_('select.option',  '193', JText::_( 'Switzerland' ) );
		$country[] = JHTML::_('select.option',  '196', JText::_( 'Taiwan' ) );
		$country[] = JHTML::_('select.option',  '3', JText::_( 'United Kingdom' ) );
		$country[] = JHTML::_('select.option',  '0', JText::_( 'USA' ) );
		$country = JHTML::_('select.genericlist',   $country, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

		return $country;
	}

	function filterTypeJs( &$types )
	{
		$js = "";
		if(count($types)) {
			$js = "var types = new Array;\n";
			foreach ($types as $k=>$type) {
				$js .= "types[".$k."] = new Array( '".addslashes( ($type->info1label?$type->info1label:JText::_('Info #1')) )."',"
				."'".addslashes( ($type->info2label?$type->info2label:JText::_('Info #2')) )."',"
				."'".addslashes( ($type->info3label?$type->info3label:JText::_('Info #3')) )."',"
				."'".addslashes( ($type->info4label?$type->info4label:JText::_('Info #4')) )."',"
				."'".addslashes( ($type->info5label?$type->info5label:JText::_('Info #5')) )."',"
				."'".addslashes( ($type->info6label?$type->info6label:JText::_('Info #6')) )."',"
				."'".addslashes( ($type->info7label?$type->info7label:JText::_('Info #7')) )."',"
				."'".addslashes( ($type->info8label?$type->info8label:JText::_('Info #8')) )."',"
				."'".addslashes( ($type->info9label?$type->info9label:JText::_('Info #9')) )."',"
				."'".addslashes( ($type->info10label?$type->info10label:JText::_('Info #10')) )."' );\t";
			}

			$js .= "\nfunction changeType() {
			var newtype = document.getElementById(\"typeid\").selectedIndex;
			var info1 = types[newtype][0];
			var info2 = types[newtype][1];
			var info3 = types[newtype][2];
			var info4 = types[newtype][3];
			var info5 = types[newtype][4];
			var info6 = types[newtype][5];
			var info7 = types[newtype][6];
			var info8 = types[newtype][7];
			var info9 = types[newtype][8];
			var info10 = types[newtype][9];
			document.getElementById(\"info1label\").innerHTML = info1+\":\";
			document.getElementById(\"info2label\").innerHTML = info2+\":\";
			document.getElementById(\"info3label\").innerHTML = info3+\":\";
			document.getElementById(\"info4label\").innerHTML = info4+\":\";
			document.getElementById(\"info5label\").innerHTML = info5+\":\";
			document.getElementById(\"info6label\").innerHTML = info6+\":\";
			document.getElementById(\"info7label\").innerHTML = info7+\":\";
			document.getElementById(\"info8label\").innerHTML = info8+\":\";
			document.getElementById(\"info9label\").innerHTML = info9+\":\";
			document.getElementById(\"info10label\").innerHTML = info10+\":\";
			}";
		}
		return $js;
	}

	function filterType( $name, $active = 0, $add_js = true )
	{
		$db =& JFactory::getDBO();
		$query = "SELECT id AS value,name AS text,"
		."info1label,info2label,info3label,info4label,info5label,info6label,info7label,info8label,info9label,info10label"
		."\n FROM #__"._JC_DB."_type ";
		$db->setQuery($query);

		$typeid = (int)$active;
		$types = array();
		$types[] = JHTML::_('select.option', '0', '- '.JText::_('Select type').' -' );
		$types[0]->info1label = '';
		$types[0]->info2label = '';
		$types[0]->info3label = '';
		$types[0]->info4label = '';
		$types[0]->info5label = '';
		$types[0]->info6label = '';
		$types[0]->info7label = '';
		$types[0]->info8label = '';
		$types[0]->info9label = '';
		$types[0]->info10label = '';
		$types = array_merge($types, $db->loadObjectList());

		if($add_js) {
			$js = JCollectionHelper::filterTypeJs( $types );
			$document = &JFactory::getDocument();
			$document->addScriptDeclaration( $js );
		}

		return JHTML::_('select.genericlist', $types, $name, 'class="inputbox" size="1" onchange="changeType();"', 'value', 'text', $typeid );

	}

	function filterInfo( $name, $itemid = 0, $active = 0, $js = '' )
	{
		$db =& JFactory::getDBO();
		$query = "SELECT id AS value,name AS text FROM #__"._JC_DB."_info "
		."\n WHERE itemid=".(int) $itemid
		."\n ORDER BY ordering";
		$db->setQuery( $query );

		$infos = array();
		$infos[] = JHTML::_('select.option', '0', '- '.JText::_('New info set').' -' );
		$infos = array_merge($infos, $db->loadObjectList());
		//return JHTML::_('select.genericlist', $infos, $name, 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', (int)$active );
		return JHTML::_('select.genericlist', $infos, $name, 'class="inputbox" size="1" '.$js, 'value', 'text', (int)$active );
	}

	function getISBNdbAccessKey()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$access_key = $params->get( 'isbndbaccesskey' );
		if(!$access_key) { // use the JCollection access key
			$access_key = '6GYUIUDN';
		}
		return $access_key;
	}

	function getAmazonAccessKey()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$access_key = $params->get( 'amazonaccesskey' );
		if(!$access_key) { // use the JCollection access key
			// this will only work until August 15, 2009
			// after that date, all request must be signed
			$access_key = 'AKIAIGL3LJIRLGYOSQUA';
		}
		return $access_key;
	}

	function getAmazonSecretAccessKey()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$access_key = $params->get( 'amazonsecretaccesskey' );
		return $access_key;
	}

	function getAmazonAssociateTag( $country )
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		switch( $country ) {
			case 'de':
				$tag = $params->get( 'amazonpartnerid_de', 'com_collection-21' );
				break;
			case 'uk':
				$tag = $params->get( 'amazonpartnerid_uk', 'com_collectionuk-21' );
				break;
			case 'fr':
				$tag = $params->get( 'amazonpartnerid_fr', '' );
				break;
			case 'jp':
				$tag = $params->get( 'amazonpartnerid_jp', '' );
				break;
			case 'ca':
				$tag = $params->get( 'amazonpartnerid_ca', 'com_collectionca-20' );
				break;
			case 'us':
			default:
				$tag = $params->get( 'amazonpartnerid_us', 'com_collection-20' );
				break;
		}
		$per = (int)$params->get('amazonpartnerid_percentage');
		$r = rand(0,100);
		if( $r<=$per || !$tag ) {
			switch($c) {
				case 'de':
					$tag = 'com_collection-21';
					break;
				case 'uk':
					$tag = 'com_collectionuk-21';
					break;
				case 'ca':
					$tag = 'com_collectionca-20';
					break;
				case 'fr':
				case 'jp':
					$tag = '';
					break;
				case 'us':
				default:
					$tag = 'com_collection-20';
					break;
			}
		}
		return $tag;
	}

	function getYahooAccessKey()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$access_key = $params->get( 'yahooaccesskey' );
		return $access_key;
	}

	function getEbayAccessKey()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$access_key = $params->get( 'ebayaccesskey' );
		if(!$access_key) { // use the JCollection access key
			$access_key = 'Thorsten-3021-4414-8867-f9658e71c17c';
		}
		return $access_key;
	}

	function getZanoxAccessKey()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$access_key = $params->get( 'zanoxaccesskey' );
		$per = (int)$params->get('zanoxaccesskey_percentage');
		$r = rand(0,100);
		if( $r<=$per || !$access_key ) {
			// use the JCollection access key
			$access_key = '7658EAF40789DA7B3174';
		}
		return $access_key;
	}

	function getGoogleAccessKey()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$access_key = $params->get( 'googleaccesskey' );
		return $access_key;
	}

	function getLastfmAccessKey()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$access_key = $params->get( 'lastfmaccesskey' );
		if(!$access_key) { // use the JCollection access key
			$access_key = '2d357535456dd35c19a3cd880bbec5aa';
		}
		return $access_key;
	}

	function getAmazonDefaultCountry()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$country = $params->get( 'amazoncountry' );
		if(!$country) {
			$country = 'us';
		}
		return $country;
	}

	function getYahoomusicDefaultCountry()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$country = $params->get( 'yahoomusiccountry' );
		if(!$country) {
			$country = 'us';
		}
		return $country;
	}

	function getWikipediaDefaultCountry()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$country = $params->get( 'wikipediacountry' );
		if(!$country) {
			$country = 'en';
		}
		return $country;
	}

	function getEBayDefaultCountry()
	{
		$params = &JComponentHelper::getParams( 'com_jcollection' );
		$country = $params->get( 'ebaycountry' );
		if(!$country) {
			$country = '0';
		}
		return $country;
	}

	function getWebservices()
	{
		$array = array();
		$array[] = 'amazon';
		$array[] = 'googlebook';
		$array[] = 'wikipedia';
		$array[] = 'isbndb';
		$array[] = 'imdb';
		$array[] = 'yahoomap';
		$array[] = 'ebay';
		$array[] = 'zanox';
		$array[] = 'googlemap';
		$array[] = 'yahoo';
		$array[] = 'yahoomusic';
		$array[] = 'lastfm';
		return $array;
	}

	function sign( $signstring )
	{
		$secretkey = JCollectionHelper::getAmazonSecretAccessKey();
		$signature = '';
		if($secretkey && function_exists( 'hash_hmac' ) )
		{
			$signature_raw = hash_hmac( 'sha256', $signstring, $secretkey, true );
			$signature = base64_encode( $signature_raw );
		}
		return $signature;
	}

	/**
	 * Sign a REST call to Amazon
	 * Requires hash_hmac!
	 *
	 * @param string $base The base url (f.e. http://ecs.amazon.com)
	 * @param array $params The REST parameters (will be altered here!)
	 * @param string $secretkey The signature secret key
	 *
	 */
	function signRestCall( $base, &$params, $secretkey )
	{
		if( function_exists( 'hash_hmac' ) )
		{
			// add the timestamp if it is not set yet
			if( !key_exists( 'Timestamp', $params ) )
			{
				$nowdate = new JDate();
				$params[ 'Timestamp' ] = $nowdate->toISO8601();
			}
			if( !key_exists( 'Version', $params ) )
			{
				//$params[ 'Version' ] = '2009-03-31';
				$params[ 'Version' ] = '2009-01-06';
			}
			// sort the array by keys
			ksort( $params );
			$query_string = '';
			foreach ($params as $key => $value) {
				$query_string .= "&$key=".urlencode( $value );
			}
			// delete the first &
			$query_string = substr($query_string, 1);
			$url = substr( $base, 7 );
			$url = substr( $url, 0, strpos( $url, '/' ) );
			$sign_string = "GET\n$url\n/onca/xml\n".$query_string;
			$signature_raw = hash_hmac( 'sha256', $sign_string, $secretkey, true );
			$signature = base64_encode( $signature_raw );
			$params['Signature'] = $signature;
		}
	}

	/**
	 *
	 * Executes a webservice call and returns the XML string
	 *
	 * @param string $base The base url
	 * @param array $params The parameters as an associative array
	 * @param sign boolean $sign Sign the REST request if true (for Amazon webservice)
	 * @return string XML return of the webservice call (or empty string)
	 *
	 */
	function callWebservice( $base, $params, $sign = false, $useragent = '' )
	{
		if( $sign ) {
			$secretkey = JCollectionHelper::getAmazonSecretAccessKey();
			if($secretkey) {
				JCollectionHelper::signRestCall( $base, $params, $secretkey );
			}
		}
		$query_string = '';
		foreach ($params as $key => $value) {
			$query_string .= "&$key=".urlencode($value);
		}
		// delete the first &
		$query_string = substr($query_string, 1);

		$url = "$base?$query_string";
		$xmlstr = '';
		if( function_exists( 'curl_init' ) ) {
			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
			if( $useragent ) {
				curl_setopt( $ch, CURLOPT_USERAGENT, $useragent);
			}
			$xmlstr = @curl_exec( $ch );
			curl_close( $ch );
		}
		if( !$xmlstr && function_exists( 'file_get_contents' ) ) {
			if( $useragent ) {
				ini_set( "user_agent", $useragent );
			}
			$xmlstr = @file_get_contents( $url );
		}
		if( !$xmlstr ) {
			if( $useragent ) {
				ini_set( "user_agent", $useragent );
			}
			$xmlstr = @JFile::read( $url );
		}
		return $xmlstr;
	}

	/**
	 *
	 * Convert PHP object recursively to associative array(s)
	 * *Do not use this function on large objects*
	 *
	 * @param object The object to convert
	 * @return array The resulting associative array
	 *
	 */
	function object2array_rec( $obj ) {
		$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
		foreach ($_arr as $key => $val) {
			$val = (is_array($val) || is_object($val)) ? JCollectionHelper::object2array_rec($val) : $val;
			$arr[$key] = $val;
		}
		return $arr;
	}

	/**
	 *
	 * Convert PHP object to associative array (not recursive)
	 *
	 * @param object The object to convert
	 * @return array The resulting associative array
	 *
	 */
	function object2array( $obj ) {
		$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
		foreach ($_arr as $key => $val) {
			$arr[$key] = $val;
		}
		return $arr;
	}

}

?>
