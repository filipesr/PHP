<?php
/**
 * JCollection Category Table
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

/**
 * Category Table class
 *
 */
class TableCategory extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $name = null;

	/**
	 * @var int
	 */
	var $parent = null;

	/**
	 * @var string
	 */
	var $description = null;

	/**
	 * @var string
	 */
	var $img = null;

	/**
	 * @var string
	 */
	var $alias = null;

	/**
	 * @var datetime
	 */
	var $date = null;

	/**
	 * @var int
	 */
	var $created_by = null;

	/**
	 * @var string
	 */
	var $created_by_alias = null;

	/**
	 * @var datetime
	 */
	var $modified = null;

	/**
	 * @var int
	 */
	var $modified_by = null;

	/**
	 * Valid values:
	 * 0 - not published
	 * 1 - published
	 * -1 - archived
	 * -2 - trashed
	 * @var int
	 */
	var $published = null;

	/**
	 * Valid values:
	 * 0 - not approved
	 * 1 - approved
	 * @var int
	 */
	var $approved = null;

	/**
	 * Values:
	 * 0 - public
	 * 1 - registered
	 * 2 - special
	 * @var int
	 */
	var $access = null;

	/**
	 * @var int
	 */
	var $checked_out = null;

	/**
	 * @var datetime
	 */
	var $checked_out_time = null;

	/**
	 * @var int
	 */
	var $ordering = null;

	/**
	 * @var string
	 */
	var $params = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableCategory(& $db) {
		parent::__construct('#__'._JC_DB.'_cat', 'id', $db);
	}

	/**
	 * Overloaded bind function
	 *
	 * @acces public
	 * @param array $hash named array
	 * @return null|string   null is operation was satisfactory, otherwise returns an error
	 */
	function bind($array, $ignore = '')
	{
		if( !is_array( $array ) ) {
			$array = JCollectionHelper::object2array( $array );
		}
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			$params = $array['params'];
			foreach ( $params as $k=>$v) {
				if( key_exists( $k, $this ) ) {
					$this->$k = $v;
					unset( $array['params'][$k] );
				} else if( $v === '' ) {
					unset( $array['params'][$k] );
				}
			}
			$registry = new JRegistry();
			$registry->loadArray( $array['params'] );

			$array['params'] = $registry->toString();
		}

		return parent::bind( $array, $ignore );
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check()
	{
		/** check for valid name */
		if (trim($this->name) == '') {
			$this->setError(JText::_('The category must have a name.'));
			return false;
		}

		/** check for existing name */
		$query = 'SELECT id FROM #__'._JC_DB.'_cat WHERE name = '.$this->_db->Quote($this->name).' AND parent = '.(int) $this->parent;
		$this->_db->setQuery($query);

		$xid = intval($this->_db->loadResult());
		if ($xid && $xid != intval($this->id)) {
			$this->setError(JText::sprintf('WARNNAMETRYAGAIN', JText::_('JCollection Category')));
			return false;
		}

		/* check for existing alias */
		if(empty($this->alias)) {
			$this->alias = $this->name;
		}
		/* make alias url safe */
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		if(trim(str_replace('-','',$this->alias)) == '') { // no valid alias -> set to current date/time
			$datenow =& JFactory::getDate();
			$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}

		return true;
	}

	/**
	 * Overloaded delete method to delete a category row
	 *
	 * @access public
	 * @param cid the id of the item to be deleted. If empty, use current id. Also change all the subcategories and items one step up.
	 * @return boolean True on success
	 */
	function delete( $cid = null )
	{
		if($cid === null && $this->id) {
			$cid = array($this->id);
		} else if(!is_array($cid)) {
			$cid = array($cid);
		}
		JArrayHelper::toInteger( $cid );

		if(count($cid)) {
			// first, collect the parents into an array
			$query = "SELECT id,parent FROM #__"._JC_DB."_cat WHERE id IN ( ".implode(",",$cid)." )";
			$this->_db->setQuery($query);
			$parents = $this->_db->loadAssocList( 'id' );
			if ($this->_db->getErrorNum()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}

			foreach($parents as $id=>$parent) {
				$query = "UPDATE #__"._JC_DB."_cat SET parent = '".$parent['parent']."' WHERE parent = '".$id."'";
				$this->_db->setQuery($query);
				if(!$this->_db->query()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
				$query = "UPDATE #__"._JC_DB." SET catid = '".$parent['parent']."' WHERE catid = '".$id."'";
				$this->_db->setQuery($query);
				if(!$this->_db->query()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}

			$query = "DELETE FROM #__"._JC_DB."_cat WHERE id IN ( ".implode(",",$cid)." )";
			$this->_db->setQuery($query);
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * Overloaded publish method to publish an item row
	 *
	 * @access public
	 * @param cid array with ids of the categories to be published. If empty, use current id.
	 * @return boolean True on success
	 */
	function publish( $cid = null, $publish = 1, $user_id = 0 )
	{
		if($cid === null && $this->id) {
			$cid = array($this->id);
		} else if(!is_array($cid)) {
			$cid = array($cid);
		}

		return parent::publish($cid, $publish, $user_id);
	}

	/**
	 * Overloaded archive method to archive an item row
	 *
	 * @access public
	 * @param cid array with ids of the categories to be archived. If empty, use current id.
	 * @return boolean True on success
	 */
	function archive( $cid = null, $user_id = 0 )
	{
		if($cid === null && $this->id) {
			$cid = array($this->id);
		} else if(!is_array($cid)) {
			$cid = array($cid);
		}
		JArrayHelper::toInteger( $cid );
		$user_id = (int) $user_id;
		$k = $this->_tbl_key;

		if (count( $cid ) < 1)
		{
			if ($this->$k) {
				$cid = array( $this->$k );
			} else {
				$this->setError("No categories selected.");
				return false;
			}
		}

		$cids = $k . '=' . implode( ' OR ' . $k . '=', $cid );

		$query = 'UPDATE '. $this->_tbl
		. ' SET published = -1'
		. ' WHERE ('.$cids.')'
		;
		$checkin = in_array( 'checked_out', array_keys($this->getProperties()) );
		if ($checkin)
		{
			$query .= ' AND (checked_out = 0 OR checked_out = '.(int) $user_id.')';
		}

		$this->_db->setQuery( $query );
		if (!$this->_db->query())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (count( $cid ) == 1 && $checkin)
		{
			if ($this->_db->getAffectedRows() == 1) {
				$this->checkin( $cid[0] );
				if ($this->$k == $cid[0]) {
					$this->published = -1;
				}
			}
		}

		$this->setError('');

		return true;
	}

	/**
	 * Overloaded trash method to trash an item row
	 *
	 * @access public
	 * @param cid array with ids of the categories to be trashed. If empty, use current id.
	 * @return boolean True on success
	 */
	function trash( $cid = null, $user_id = 0 )
	{
		if($cid === null && $this->id) {
			$cid = array($this->id);
		} else if(!is_array($cid)) {
			$cid = array($cid);
		}
		JArrayHelper::toInteger( $cid );
		$user_id = (int) $user_id;
		$k = $this->_tbl_key;

		if (count( $cid ) < 1)
		{
			if ($this->$k) {
				$cid = array( $this->$k );
			} else {
				$this->setError("No categories selected.");
				return false;
			}
		}

		$cids = $k . '=' . implode( ' OR ' . $k . '=', $cid );

		$query = 'UPDATE '. $this->_tbl
		. ' SET published = -2'
		. ' WHERE ('.$cids.')'
		;
		$checkin = in_array( 'checked_out', array_keys($this->getProperties()) );
		if ($checkin)
		{
			$query .= ' AND (checked_out = 0 OR checked_out = '.(int) $user_id.')';
		}

		$this->_db->setQuery( $query );
		if (!$this->_db->query())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (count( $cid ) == 1 && $checkin)
		{
			if ($this->_db->getAffectedRows() == 1) {
				$this->checkin( $cid[0] );
				if ($this->$k == $cid[0]) {
					$this->published = -2;
				}
			}
		}

		$this->setError('');

		return true;
	}

	/**
	 * Overloaded approve method to trash an item row
	 *
	 * @access public
	 * @param cid array with ids of the categories to be approved. If empty, use current id.
	 * @return boolean True on success
	 */
	function approve( $cid = null, $approved = 1, $user_id = 0 )
	{
		if($cid === null && $this->id) {
			$cid = array($this->id);
		} else if(!is_array($cid)) {
			$cid = array($cid);
		}
		JArrayHelper::toInteger( $cid );
		$user_id = (int) $user_id;
		$approved = (int) $approved;
		$k = $this->_tbl_key;

		if (count( $cid ) < 1)
		{
			if ($this->$k) {
				$cid = array( $this->$k );
			} else {
				$this->setError("No categories selected.");
				return false;
			}
		}

		$cids = $k . '=' . implode( ' OR ' . $k . '=', $cid );

		$query = 'UPDATE '. $this->_tbl
		. ' SET approved = '.(int) $approved
		. ' WHERE ('.$cids.')'
		;
		$checkin = in_array( 'checked_out', array_keys($this->getProperties()) );
		if ($checkin)
		{
			$query .= ' AND (checked_out = 0 OR checked_out = '.(int) $user_id.')';
		}

		$this->_db->setQuery( $query );
		if (!$this->_db->query())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (count( $cid ) == 1 && $checkin)
		{
			if ($this->_db->getAffectedRows() == 1) {
				$this->checkin( $cid[0] );
				if ($this->$k == $cid[0]) {
					$this->approved = $approved;
				}
			}
		}

		$this->setError('');

		return true;
	}

	/**
	 * Overloaded access method to change access of a category
	 * shamelessly stolen from JTable::publish()
	 *
	 * @access public
	 * @param cid array with ids of the categories to be published. If empty, use current id.
	 * @return boolean True on success
	 */
	function access( $cid = null, $access, $user_id = 0 )
	{
		if($cid === null && $this->id) {
			$cid = array($this->id);
		} else if(!is_array($cid)) {
			$cid = array($cid);
		}

		JArrayHelper::toInteger( $cid );
		$user_id = (int) $user_id;
		$access = (int) $access;
		$k = $this->_tbl_key;

		if (count( $cid ) < 1)
		{
			if ($this->$k) {
				$cid = array( $this->$k );
			} else {
				$this->setError("No categories selected.");
				return false;
			}
		}

		$cids = $k . '=' . implode( ' OR ' . $k . '=', $cid );

		$query = 'UPDATE '. $this->_tbl
		. ' SET access = ' . (int) $access
		. ' WHERE ('.$cids.')'
		;
		$checkin = in_array( 'checked_out', array_keys($this->getProperties()) );
		if ($checkin)
		{
			$query .= ' AND (checked_out = 0 OR checked_out = '.(int) $user_id.')';
		}

		$this->_db->setQuery( $query );
		if (!$this->_db->query())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (count( $cid ) == 1 && $checkin)
		{
			if ($this->_db->getAffectedRows() == 1) {
				$this->checkin( $cid[0] );
				if ($this->$k == $cid[0]) {
					$this->access = $access;
				}
			}
		}

		$this->setError('');

		return true;
	}
}
?>
