<?php
/**
 * JCollection ImportExport controller class
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

/**
 * JCollection ImportExport Controller
 *
 * @package JCollection
 * @subpackage com_jcollection
 */
class JCollectionControllerImportexport extends JCollectionController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * import from Collection Manager 0.4.x
	 */
	function import_cm()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$db = &JFactory::getDBO();
		$tables = $db->getTableList();

		// stores the ids of the new categories
		$translate_cats = array();
		// stores the ids of the newly created info field that refers to the item
		$translate_items_info = array();
		// stores the ids of the new items
		$translate_items = array();
		// stores the ids of the new types
		$translate_types = array();
		// stores the ids of the new lists
		$translate_lists = array();

		if(in_array($db->getPrefix().'collection_cat', $tables) )
		{
			$query = "SELECT * FROM #__collection_cat ";
			$db->setQuery( $query );
			$cats = $db->loadObjectList();
			$cattable = &JTable::getInstance( 'category', 'Table' );

			// array stores the catids where the parent entry must be updated
			$translate_parents = array();

			// check if category with the same name exists or create new category
			foreach( $cats as $cat )
			{
				// check if category with the same name already exists
				$query = "SELECT * FROM #__"._JC_DB."_cat "
				."\n WHERE name = ".$db->Quote( $cat->name );
				$db->setQuery( $query );
				// fetch the first result
				$existingcat = $db->loadObject();
				if( $existingcat ) {
					// use the existing category
					$translate_cats[ $cat->id ] = $existingcat->id;
				} else {
					// create new row
					$oldid = $cat->id;
					$cat->id = 0;
					$cattable->reset();
					$cattable->bind( $cat );
					$cattable->store();
					$translate_cats[ $oldid ] = $cattable->id;
					$translate_parents[] = $cattable->id;
				}
			}

			// translate the parent ids
			foreach( $translate_parents as $catid )
			{
				$cattable->load( $catid );
				if( $cattable->parent && isset( $translate_cats[ $cattable->parent ] ) )
				{
					$cattable->parent = $translate_cats[ $cattable->parent ];
					$cattable->store();
				}
			}
		}

		if(in_array($db->getPrefix().'collection_type', $tables) )
		{
			$query = "SELECT * FROM #__collection_type ";
			$db->setQuery( $query );
			$types = $db->loadObjectList();
			$typetable = &JTable::getInstance( 'type', 'Table' );
			foreach( $types as $type )
			{
				$query = "SELECT * FROM #__"._JC_DB."_type "
				."\n WHERE name = ".$db->Quote( $type->name );
				$db->setQuery( $query );
				// fetch the first result
				$existingtype = $db->loadObject();
				if( $existingtype ) {
					$translate_types[ $type->id ] = $existingtype->id;
				} else {
					$type->info1label = $type->info1;
					$type->info2label = $type->info2;
					$type->info3label = $type->info3;
					$type->info4label = $type->info4;
					$type->info5label = $type->info5;
					$oldid = $type->id;
					$type->id = 0;
					$typetable->reset();
					$typetable->bind( $type );
					$typetable->store();
					$translate_types[ $oldid ] = $typetable->id;
				}
			}
		}

		$stdcountry = JCollectionHelper::getAmazonDefaultCountry();

		if(in_array($db->getPrefix().'collection_conf', $tables) )
		{
			$query = "SELECT value FROM #__collection_conf WHERE name='DefaultCountry' ";
			$db->setQuery( $query );
			$c = $db->loadResult();
			if($c) {
				$stdcountry = $c;
			}
		}

		if(in_array($db->getPrefix().'collection', $tables) )
		{
			$query = "SELECT * FROM #__collection ";
			$db->setQuery( $query );
			$items = $db->loadObjectList();
			$itemtable = &JTable::getInstance( 'item', 'Table' );
			$infotable = &JTable::getInstance( 'info', 'Table' );
			foreach( $items as $item )
			{
				$item->name = $item->title;
				if( $item->catid && isset( $translate_cats[ $item->catid ] ) ) {
					$item->catid = $translate_cats[ $item->catid ];
				}
				$oldid = $item->id;
				$item->id = 0;
				$itemtable->reset();
				$itemtable->bind( $item );
				$itemtable->store();
				$translate_items[ $oldid ] = $itemtable->id;
				$info = array();
				$info['name'] = $item->name;
				$info['itemid'] = $itemtable->id;
				$info['info1'] = $item->info1;
				$info['info2'] = $item->info2;
				$info['info3'] = $item->info3;
				$info['info4'] = $item->info4;
				$info['info5'] = $item->info5;
				if($item->asin) {
					$asin = ( $item->country ? $item->country : $stdcountry ).'_'.$item->asin;
					$info['params'] = 'amazonitem='.$asin;
					if(is_numeric($item->asin)) {
						$info['params'] .= "\nisbndbitem=".$item->asin;
					}
				}
				if( $item->typeid && isset( $translate_types[ $item->typeid ] ) ) {
					$info['typeid'] = $translate_types[ $item->typeid ];
				}
				$infotable->reset();
				$infotable->bind( $info );
				$infotable->store();
				$translate_items_info[ $itemtable->id ] = $infotable->id;
			}
		}

		if(in_array($db->getPrefix().'collection_review', $tables) )
		{
			$query = "SELECT * FROM #__collection_review ";
			$db->setQuery( $query );
			$reviews = $db->loadObjectList();
			$reviewtable = &JTable::getInstance( 'rev', 'Table' );
			foreach( $reviews as $review )
			{
				$review->name = $review->title;
				if( $review->itemid && isset( $translate_items_info[ $review->itemid ] ) ) {
					$review->infoid = $translate_items_info[ $review->itemid ];
				}
				$review->id = 0;
				$reviewtable->reset();
				$reviewtable->bind( $review );
				$reviewtable->store();
			}
		}

		if(in_array($db->getPrefix().'collection_list', $tables) )
		{
			$query = "SELECT * FROM #__collection_list ";
			$db->setQuery( $query );
			$lists = $db->loadObjectList();
			$listtable = &JTable::getInstance( 'list', 'Table' );
			foreach( $lists as $list )
			{
				$query = "SELECT * FROM #__"._JC_DB."_list "
				."\n WHERE name = ".$db->Quote( $list->title );
				$db->setQuery( $query );
				// fetch the first result
				$existinglist = $db->loadObject();
				if( $existinglist ) {
					$translate_lists[ $list->id ] = $existinglist->id;
				} else {
					$list->name = $list->title;
					$oldid = $list->id;
					$list->id = 0;
					$listtable->reset();
					$listtable->bind( $list );
					$listtable->store();
					$translate_lists[ $oldid ] = $listtable->id;
				}
			}
		}

		if(in_array($db->getPrefix().'collection_item2list', $tables) )
		{
			$query = "SELECT * FROM #__collection_item2list ";
			$db->setQuery( $query );
			$item2lists = $db->loadObjectList();
			$item2listtable = &JTable::getInstance( 'item2list', 'Table' );
			foreach( $item2lists as $item2list )
			{
				if( $item2list->itemid && isset( $translate_items[ $item2list->itemid ] ) ) {
					$item2list->itemid = $translate_items[ $item2list->itemid ];
				}
				if( $item2list->listid && isset( $translate_lists[ $item2list->listid ] ) ) {
					$item2list->listid = $translate_lists[ $item2list->listid ];
				}
				$item2list->id = 0;
				$item2listtable->reset();
				$item2listtable->bind( $list );
				$item2listtable->store();
			}
		}

		$link = 'index.php?option=com_jcollection&view=importexport&layout=popup&tmpl=component';
		$this->setRedirect( $link );
	}

	/**
	 * Export as XML
	 */
	function export_xml()
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$link = 'index.php?option=com_jcollection&view=importexport&controller=importexport&task=output_xml&format=raw';
		$this->setRedirect( $link );
	}

	function output_xml()
	{
		//JRequest::checkToken() or die( 'Invalid Token' );

		$doc = &JFactory::getDocument();
		$db = &JFactory::getDBO();
		$query = "SELECT id FROM #__"._JC_DB." ";
		$db->setQuery( $query );
		$ids = $db->loadResultArray();
		JArrayHelper::toInteger( $ids );
		if(count($ids))
		{
			$row = &JTable::getInstance( 'item', 'Table' );
			$xml = '';
			foreach( $ids as $id )
			{
				$row->load( $id );
				$xml .= $row->toXML();
			}
		}
		$doc->setMimeEncoding('text/xml');
		//$doc->setMimeEncoding('application/octet-stream');
		JResponse::setHeader('Content-Disposition', 'attachment; filename="export.xml');

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>\n";
		echo "<document>\n";
		echo $xml;
		echo "</document>";
	}
}
?>
