<?php
/**
 * Review Model for JCollection Component
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

jimport('joomla.application.component.model');

/**
 * JCollection Review Model
 *
 * @package com_collection
 */
class JCollectionModelRev extends JModel
{
	/**
	 * The current item id
	 * @var int
	 */
	var $_id = null;

	/**
	 * The data (i.e. item row plus corresponsing rating and info field(s)
	 * @var object
	 */
	var $_data = null;

	var $_itemid = null;

	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();
		$this->loadIdFromRequest();
	}

	/**
	 * Method to set the hello identifier
	 *
	 * @access	public
	 * @param	int Hello identifier
	 * @return	void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id = $id;
		$this->_data = null;
	}

	function getId()
	{
		return $this->_id;
	}

	function getItemid()
	{
		if( !$this->_id ) {
			$this->loadIdFromRequest();
		}
		if( !$this->_data ) {
			$this->getData();
		}
		if( $this->_data ) {
			return $this->_data->itemid;
		} else {
			return null;
		}
	}

	function getCreated_by()
	{
		if( !$this->_id ) {
			$this->loadIdFromRequest();
		}
		if( !$this->_data ) {
			$this->getData();
		}
		if( $this->_data ) {
			return $this->_data->created_by;
		} else {
			return null;
		}
	}

	/**
	 * Method to reload id from the request variable
	 */
	function loadIdFromRequest()
	{
		$id = JRequest::getInt( 'reviewid',  0 );
		$this->setId( $id );
	}


	/**
	 * Method to get a category
	 * @return object with data
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$url = JURI::root() . 'images/jcollection/';
			$query = " SELECT e.*,r.rating1,r.rating2,r.rating3,r.rating4,r.rating5,i.name AS infoname,m.name AS itemname,c.name AS catname, "
			."\n t.rating1label, t.rating2label, t.rating3label, t.rating4label, t.rating5label, "
			."\n CASE WHEN CHAR_LENGTH(e.alias) THEN CONCAT_WS(\":\", e.id, e.alias) ELSE e.id END AS slug, "
			."\n CASE WHEN ( ( LENGTH(e.img)>0 ) AND ( SUBSTRING( e.img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( e.img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", e.img ) ELSE e.img END AS image "
			."\n FROM #__"._JC_DB."_review AS e "
			."\n LEFT JOIN #__"._JC_DB."_info AS i ON i.id = e.infoid "
			."\n LEFT JOIN #__"._JC_DB." AS m ON m.id = i.itemid "
			."\n LEFT JOIN #__"._JC_DB."_cat AS c ON c.id = m.catid "
			."\n LEFT JOIN #__"._JC_DB."_type AS t ON t.id = i.typeid "
			."\n LEFT JOIN #__"._JC_DB."_reviewrating AS r ON r.reviewid = e.id "
			."\n WHERE e.id=".intval( $this->_id );
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$user = &JFactory::getUser();
			$uid = $user->get( 'id', 0 );
			$infoid = JRequest::getInt( 'infoid', 0 );
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->infoid = $infoid;
			$this->_data->itemid = null;
			$this->_data->name = null;
			$this->_data->description = null;
			$this->_data->img = null;
			$this->_data->alias = null;
			$this->_data->date = null;
			$this->_data->created_by = $uid;
			$this->_data->created_by_alias = null;
			$this->_data->modified = null;
			$this->_data->modified_by = null;
			$this->_data->published = null;
			$this->_data->approved = null;
			$this->_data->access = null;
			$this->_data->checked_out = null;
			$this->_data->checked_out_time = null;
			$this->_data->ordering = null;
			$this->_data->params = null;
			if( $infoid )
			{
				$query = " SELECT i.name AS infoname,m.name AS itemname,c.name AS catname, "
				."\n t.rating1label, t.rating2label, t.rating3label, t.rating4label, t.rating5label "
				."\n FROM #__"._JC_DB."_info AS i "
				."\n LEFT JOIN #__"._JC_DB." AS m ON m.id = i.itemid "
				."\n LEFT JOIN #__"._JC_DB."_cat AS c ON c.id = m.catid "
				."\n LEFT JOIN #__"._JC_DB."_type AS t ON t.id = i.typeid "
				."\n WHERE i.id=".intval( $infoid );
				$this->_db->setQuery( $query );
				$info = $this->_db->loadObject();
				$this->_data->infoname = $info->infoname;
				$this->_data->itemname = $info->itemname;
				$this->_data->catname = $info->catname;
				$this->_data->rating1label = $info->rating1label;
				$this->_data->rating2label = $info->rating2label;
				$this->_data->rating3label = $info->rating3label;
				$this->_data->rating4label = $info->rating4label;
				$this->_data->rating5label = $info->rating5label;
			}
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{
		$row =& $this->getTable();

		$data = JRequest::get( 'post' );

		$desc = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$desc = str_replace( '<br>', '<br />', $desc );
		$data['description'] = $desc;

		$datenow = & JFactory::getDate();
		if(key_exists( 'params', $data ) && is_array( $data['params'] )) {
			$registry = new JRegistry();
			$registry->loadArray($data['params']);
			if($registry->getValue('date') == '') {
				$registry->setValue('date', $datenow->toMySQL());
			} else {
				$user = &JFactory::getUser();
				$registry->setValue('modified', $datenow->toMySQL());
				$registry->setValue('modified_by', $user->get( 'id' ));
			}
			$data['params'] = $registry->toArray();
		} else {
			if(empty($data['date'])) {
				$data['date'] = $datenow->toMySQL();
			} else {
				$data['modified'] = $datenow->toMySQL();
				$user = &JFactory::getUser();
				$data['modified_by'] = $user->get( 'id' );
			}
		}

		// Bind the form fields to the hello table
		if ( !$row->bind( $data ) ) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the hello record is valid
		if ( !$row->check() ) {
			$this->setError($row->getError());
			return false;
		}

		// Store the web link table to the database
		if ( !$row->store() ) {
			$this->setError( $row->getError() );
			return false;
		}

		// Set the correct id if the item is new
		if( $data['id'] == 0 ) {
			$this->_data->id = $row->id;
			$this->_id = $row->id;
			$data['id'] = $row->id;
		}

		$id = $data['id'];

		$query = "SELECT * FROM #__"._JC_DB."_reviewrating WHERE reviewid=".(int)$id;
		$this->_db->setQuery( $query );
		$rating = $this->_db->loadObject();
		if( !$rating )
		{
			$query = "INSERT INTO #__"._JC_DB."_reviewrating (`reviewid`,`rating1`,`rating2`,`rating3`,`rating4`,`rating5`) "
			."\n VALUES ('".(int)$id."','".(int)$data['rating1']."','".(int)$data['rating2']."','".(int)$data['rating3']."','".(int)$data['rating4']."','".(int)$data['rating5']."') "
			;
			$this->_db->setQuery( $query );
			$this->_db->query();
		} else {
			$query = "UPDATE #__"._JC_DB."_reviewrating SET `rating1`=".(int)$data['rating1'].",`rating2`=".(int)$data['rating2'].",`rating3`=".(int)$data['rating3'].",`rating4`=".(int)$data['rating4'].",`rating5`=".(int)$data['rating5']
			."\n WHERE reviewid=".(int)$id;
			$this->_db->setQuery( $query );
			$this->_db->query();
		}

		$this->saveorder( array($row->get('id')),array((int)$data['ordering']) );

		return true;
	}

	function isCheckedOut( $uid = null )
	{
		if ( !$this->_data->id )
		{
			$this->loadIdFromRequest();
			$this->getData();
			if ( $uid ) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		} else {
			return false;
		}
	}

	function checkout( $uid = null )
	{
		if ( $this->_id )
		{
			// Make sure we have a user id to checkout the article with
			if ( is_null( $uid ) ) {
				$user =& JFactory::getUser();
				$uid = $user->get( 'id' );
			}
			// Lets get to it and checkout the thing...
			$item = & JTable::getInstance( 'rev', 'Table' );
			return $item->checkout( $uid, $this->_id );
		}
		return false;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function delete( $cids = null )
	{
		//		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Method to publish category/-ies
	 *
	 * @access public
	 * @param cids array with category ids to be published. If empty, use the current _id
	 * @param publish 0 - unpublish, 1 - publish
	 * @return boolean True on success
	 */
	function publish( $cids=null, $publish = 1 )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$user =& JFactory::getUser();
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->publish( $cid, $publish, $user->id )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Method to archive category/-ies
	 *
	 * @access public
	 * @param cids array with category ids to be archived. If empty, use the current _id
	 * @return boolean True on success
	 */
	function archive( $cids=null )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$user =& JFactory::getUser();
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->archive( $cid, $user->id )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Method to approve category/-ies
	 *
	 * @access public
	 * @param cids array with category ids to be approved. If empty, use the current _id
	 * @return boolean True on success
	 */
	function approve( $cids=null, $approved = 1 )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}
		$approved = (int)$approved;

		if (count( $cids ))
		{
			$user =& JFactory::getUser();
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->approve( $cid, $approved, $user->id )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Method to trash category/-ies
	 *
	 * @access public
	 * @param cids array with category ids to be trashed. If empty, use the current _id
	 * @return boolean True on success
	 */
	function trash( $cids=null )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$user =& JFactory::getUser();
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->trash( $cid, $user->id )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Method to change access to category/-ies
	 *
	 * @access public
	 * @param cids array with category ids to be published. If empty, use the current _id
	 * @param access 0 - public, 1 - registered, 2 - special
	 * @return boolean True on success
	 */
	function access( $cids=null, $access )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$user =& JFactory::getUser();
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->access( $cid, $access, $user->id )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Method to change order
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @return boolean True on success
	 */
	function saveorder( $cid = array(), $order )
	{
		$row =& $this->getTable();
		$groupings = array();

		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row->load( (int) $cid[$i] );

			// track parents
			$groupings[] = $row->infoid;

			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group) {
			$row->reorder('infoid = '.(int) $group);
		}

		return true;
	}

	function move( $cid, $direction )
	{
		if( count($cid) == 1 ) {
			$row =& $this->getTable();
			if (!$row->load($cid[0])) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}

			if (!$row->move( $direction, ' infoid = '.(int) $row->infoid.' AND published >= 0 ' )) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}
}
?>
