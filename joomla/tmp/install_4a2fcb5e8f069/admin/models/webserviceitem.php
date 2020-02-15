<?php
/**
 * JCollection Webserviceitem Model
 *
 * @version $Id$
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2008 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport('joomla.application.component.model');

/**
 * Collection Webserviceitem Model
 *
 */
class JCollectionModelWebserviceitem extends JModel
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

	/**
	* Constructor that retrieves the ID from the request
	*
	* @access	public
	* @return	void
	*/
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
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


	/**
	* Method to get an item
	* @return object with data
	*/
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query =	 " SELECT i.* FROM #__"._JC_DB." AS i "
						."\n LEFT JOIN #__"._JC_DB."_rating AS r ON r.itemid=i.id"
						."\n WHERE i.id=".intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

			$query = ' SELECT * FROM #__'._JC_DB.'_info '
					.' WHERE itemid='.intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data->infos = $this->_db->loadObjectList();

		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->catid = null;
			$this->_data->name = null;
			$this->_data->name_alias = null;
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
			$this->_data->checked_out = null;
			$this->_data->checked_out_time = null;
			$this->_data->ordering = null;
			$this->_data->params = null;
			$this->_data->hits = null;

			$this->_data->infos = null;
		}
		return $this->_data;
	}

	/**
	* Method to store an item including the info fields
	*
	* @access public
	* @return boolean true on success
	*/
	function store( $data = null )
	{
		$row =& $this->getTable();

		if(!$data) {
			$data = JRequest::get( 'post' );
		}

		// Bind the form fields to the item table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the item record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the item to the database
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

		if(is_array($data['infoid'])) {
			$row = &JTable::getInstance('info','Table');
			$n = count( $data['infoid'] );
			for($i = 0; $i<$n; $i++) {
				$tmpdata = array();
				$tmpdata['id'] = $data['infoid'][$i];
				$tmpdata['itemid'] = $data['id'];
				$tmpdata['typeid'] = $data['typeid'][$i];
				$tmpdata['info1'] = $data['info1'][$i];
				$tmpdata['info2'] = $data['info2'][$i];
				$tmpdata['info3'] = $data['info3'][$i];
				$tmpdata['info4'] = $data['info4'][$i];
				$tmpdata['info5'] = $data['info5'][$i];
				$tmpdata['info6'] = $data['info6'][$i];
				$tmpdata['info7'] = $data['info7'][$i];
				$tmpdata['info8'] = $data['info8'][$i];
				$tmpdata['info9'] = $data['info9'][$i];
				$tmpdata['info10'] = $data['info10'][$i];
				if (!$row->bind($tmpdata)) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
				if (!$row->check()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
				if (!$row->store()) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		} else if(isset($data['typeid'])) {
			$row = &JTable::getInstance('info', 'Table');
			$tmpdata = array();
			$tmpdata['id'] = 0;
			$itemid = $this->_db->insertid();
			$tmpdata['itemid'] = $itemid;//$data['id'];
			$tmpdata['typeid'] = $data['typeid'];
			$tmpdata['info1'] = $data['info1'];
			$tmpdata['info2'] = $data['info2'];
			$tmpdata['info3'] = $data['info3'];
			$tmpdata['info4'] = $data['info4'];
			$tmpdata['info5'] = $data['info5'];
			$tmpdata['info6'] = $data['info6'];
			$tmpdata['info7'] = $data['info7'];
			$tmpdata['info8'] = $data['info8'];
			$tmpdata['info9'] = $data['info9'];
			$tmpdata['info10'] = $data['info10'];
			if (!$row->bind($tmpdata)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			if (!$row->check()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			if (!$row->store()) {
				$this->setError( $row->getErrorMsg() );
				return false;
			}
//$this->setError("not an array");
//return false;
		}

		return true;
	}

	/**
	* Method to delete item(s) (including ratings and info fields
	*
	* @access public
	* @param cids array with item ids to be deleted. If empty, use the current _id
	* @return boolean True on success
	*/
	function delete( $cids=null )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$row =& $this->getTable();
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
	* Method to publish item(s) (_not_ including info fields!)
	*
	* @access public
	* @param cids array with item ids to be published. If empty, use the current _id
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

}
?>
