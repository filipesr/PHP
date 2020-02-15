<?php
/**
 * JCollection Item Model
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
 * Collection Item Model
 *
 */
class JCollectionModelItem extends JModel
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

		$array = JRequest::getVar( 'cid', array(0), '', 'array' );
		$this->setId( (int)$array[0] );
	}

	/**
	 * Method to set the hello identifier
	 *
	 * @access	public
	 * @param	int Hello identifier
	 * @return	void
	 */
	function setId( $id )
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
	 * Method to get an item
	 * @return object with data
	 */
	function &getData()
	{
		global $mainframe;
		if (empty( $this->_data )) {
			$infoid = $mainframe->getUserStateFromRequest( $option.'.infoid', 'infoid', 0,'int' );

			$query = " SELECT i.*, "
			."\n CASE WHEN CHAR_LENGTH(i.alias) THEN CONCAT_WS(\":\", i.id, i.alias) ELSE i.id END AS slug "
			."\n FROM #__"._JC_DB." AS i "
			//			."\n LEFT JOIN #__"._JC_DB."_rating AS r ON r.itemid=i.id"
			."\n WHERE i.id=".intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

			$cur_infoid = $mainframe->getUserStateFromRequest( $option.'.cur_infoid', 'cur_infoid', 0,'int' );

			if($cur_infoid == 0) {
				$query = " SELECT n.* FROM #__"._JC_DB."_info AS n "
					."\n WHERE n.itemid=".intval($this->_id)
					."\n ORDER BY n.ordering"
					;
				$this->_db->setQuery( $query );
				$infos = $this->_db->loadObjectList();

				if(count($infos)) {
					$infoid = $infos[0]->id;
				}
			}
			$this->_data->infoid = $infoid;

			if ($infoid) {
				$query = " SELECT n.* FROM #__"._JC_DB."_info AS n "
				."\n WHERE n.id=".intval($infoid);
				$this->_db->setQuery( $query );
				$this->_data->info = $this->_db->loadObject();
			} else {
				$this->_data->info = new stdClass();
				$this->_data->info->id = 0;
				$this->_data->info->itemid = $this->_id;
				$this->_data->info->typeid = 0;
				$this->_data->info->title = null;
				$this->_data->info->description = null;
				$this->_data->info->url = null;
				$this->_data->info->info1 = null;
				$this->_data->info->info2 = null;
				$this->_data->info->info3 = null;
				$this->_data->info->info4 = null;
				$this->_data->info->info5 = null;
				$this->_data->info->info6 = null;
				$this->_data->info->info7 = null;
				$this->_data->info->info8 = null;
				$this->_data->info->info9 = null;
				$this->_data->info->info10 = null;
				$this->_data->info->img = null;
				$this->_data->info->checked_out = null;
				$this->_data->info->checked_out_time = null;
				$this->_data->info->date = null;
				$this->_data->info->created_by = null;
				$this->_data->info->created_by_alias = null;
				$this->_data->info->modified = null;
				$this->_data->info->modified_by = null;
				$this->_data->info->ordering = null;
				$this->_data->info->params = null;
			}
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->catid = null;
			$this->_data->name = null;
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
			$this->_data->infoid = 0;
			$this->_data->info = new StdClass();
			$this->_data->info->id = 0;
			$this->_data->info->itemid = $this->_id;
			$this->_data->info->typeid = 0;
			$this->_data->info->title = null;
			$this->_data->info->description = null;
			$this->_data->info->info1 = null;
			$this->_data->info->info2 = null;
			$this->_data->info->info3 = null;
			$this->_data->info->info4 = null;
			$this->_data->info->info5 = null;
			$this->_data->info->info6 = null;
			$this->_data->info->info7 = null;
			$this->_data->info->info8 = null;
			$this->_data->info->info9 = null;
			$this->_data->info->info10 = null;
			$this->_data->info->img = null;
			$this->_data->info->url = null;
			$this->_data->info->checked_out = null;
			$this->_data->info->checked_out_time = null;
			$this->_data->info->date = null;
			$this->_data->info->created_by = null;
			$this->_data->info->created_by_alias = null;
			$this->_data->info->modified = null;
			$this->_data->info->modified_by = null;
			$this->_data->info->ordering = null;
			$this->_data->info->params = null;
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

			$desc = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
			$desc = str_replace( '<br>', '<br />', $desc );
			$data['description'] = $desc;
		}

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

		// Bind the form fields to the item table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the item record is valid
		if (!$row->check()) {
			$this->setError($row->getError());
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

		$this->saveorder( array($row->get('id')),array((int)$data['ordering']) );

		return true;
	}

	/**
	 * Method to delete item(s) (including ratings and info fields
	 *
	 * @access public
	 * @param cids array with item ids to be deleted. If empty, use the current _id
	 * @return boolean True on success
	 */
	function delete( $cids = null )
	{
		if( is_integer( $cids ) ) {
			$cids = array( $cids );
		} else if( !$cids && $this->_id ) {
			$cids = array( $this->_id );
		}

		if ( count( $cids ) )
		{
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if ( !$row->delete( $cid ) ) {
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

			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}

		$row->reorder('');

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

}
?>
