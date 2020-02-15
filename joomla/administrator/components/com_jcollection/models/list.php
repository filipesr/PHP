<?php
/**
 * List Model for JCollection Component
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
 * JCollection List Model
 *
 * @package com_collection
 */
class JCollectionModelList extends JModel
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

	var $_pagination = null;
	var $_total = null;

	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  array(0), '', 'array');
		if((int)$array[0]) {
			$this->setId((int)$array[0]);
		} else {
			$listid = JRequest::getVar('listid',  0, '', 'int');
			$this->setId((int)$listid);
		}

		global $mainframe, $option;

		// Get the pagination request variables
		$limit = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

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


	/**
	 * Method to get a category
	 * @return object with data
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = " SELECT * FROM #__"._JC_DB."_list "
			."\n  WHERE id=".intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

			$query = "SELECT l.*,i.name,i.published,i.approved FROM #__"._JC_DB."_item2list AS l "
			."\n LEFT JOIN #__"._JC_DB." AS i ON i.id=l.itemid"
			."\n WHERE l.listid=".intval($this->_id)
			."\n ORDER BY l.ordering"
			;
			$this->_db->setQuery( $query );
			$this->_data->items = $this->_db->loadObjectList();

		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->name = null;
			$this->_data->catid = null;
			$this->_data->description = null;
			$this->_data->img = null;
			$this->_data->alias = null;
			$this->_data->date = null;
			$this->_data->created_by = null;
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
			$this->_data->items = array();
		}
		return $this->_data;
	}

	/**
	* Method to get the total number of items
	*
	* @access public
	* @return integer
	*/
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$this->getData();
			$this->_total = count($this->_data->items);
		}

		return $this->_total;
	}

	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
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
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the hello record is valid
		if (!$row->check()) {
			$this->setError($row->getError());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getError() );
			return false;
		}

		// Set the correct id if the item is new
		if($data['id'] == 0) {
			$this->_data->id = $row->id;
			$this->_id = $row->id;
			$data['id'] = $row->id;
		}

		$this->saveorder( array($row->get('id')),array((int)$data['ordering']) );

		return true;
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
					$this->setError( $row->getErrorMsg() );
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
			$groupings[] = $row->parent;

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
			$row->reorder('catid = '.(int) $group);
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

			if (!$row->move( $direction, ' catid = '.(int) $row->catid.' AND published >= 0 ' )) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}

	function addItems( $cids, $listid )
	{
		if(count($cids) && $listid) {
			$query = "INSERT INTO #__"._JC_DB."_item2list (`listid`,`itemid`) VALUES ";
			$query .= '('.(int)$listid.','.implode('),('.(int)$listid.',',$cids).')';
			$this->_db->setQuery($query);
			$this->_db->query();
		}
	}

	/**
	 * Method to change order
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @return boolean True on success
	 */
	function saveorder_sort( $cid = array(), $order )
	{
		$row = &JTable::getInstance('item2list','Table');
		$groupings = array();

		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row->load( (int) $cid[$i] );

			// track parents
			$groupings[] = $row->listid;

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
			$row->reorder('listid = '.(int) $group);
		}

		return true;
	}

	function move_sort( $cid, $direction )
	{
		if( count($cid) == 1 ) {
			$row = &JTable::getInstance('item2list','Table');

			if (!$row->load($cid[0])) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}

			if (!$row->move( $direction, ' listid = '.(int) $row->listid )) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}

	function delete_sort( $cids )
	{
		if (count( $cids ))
		{
			$row = &JTable::getInstance('item2list','Table');
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
	}

}
?>
