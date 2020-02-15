<?php
/**
 * JCollection Info Model
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

jimport('joomla.application.component.model');

/**
 * JCollection Info Model
 *
 * @package com_jcollection
 */
class JCollectionModelInfo extends JModel
{
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
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the hello identifier
	 *
	 * @access	public
	 * @param	int identifier
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
	 * Method to get a hello
	 * @return object with data
	 */
	function &getData()
	{
		// Load the data
		if ( empty( $this->_data ) ) {
			$query = " SELECT * FROM #__"._JC_DB."_info "
			."\n WHERE id = ".intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if ( !$this->_data ) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->itemid = null;
			$this->_data->typeid = null;
			$this->_data->name = null;
			$this->_data->title = null;
			$this->_data->description = null;
			$this->_data->info1 = null;
			$this->_data->info2 = null;
			$this->_data->info3 = null;
			$this->_data->info4 = null;
			$this->_data->info5 = null;
			$this->_data->info6 = null;
			$this->_data->info7 = null;
			$this->_data->info8 = null;
			$this->_data->info9 = null;
			$this->_data->info10 = null;
			$this->_data->img = null;
			$this->_data->url = null;
			$this->_data->checked_out = null;
			$this->_data->checked_out_time = null;
			$this->_data->date = null;
			$this->_data->created_by = null;
			$this->_data->created_by_alias = null;
			$this->_data->modified = null;
			$this->_data->modified_by = null;
			$this->_data->ordering = null;
			$this->_data->params = null;
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
		if( $data['id'] == 0 ) {
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
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

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
			$groupings[] = $row->itemid;

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
			$row->reorder('itemid = '.(int) $group);
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

			if (!$row->move( $direction, 'itemid = '.(int)$row->itemid.' AND published >= 0 ' )) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}

}
?>
