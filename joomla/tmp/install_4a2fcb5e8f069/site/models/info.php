<?php
/**
 * JCollection Info Model
 *
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
 */
class JCollectionModelInfo extends JModel
{

	var $_id = null;

	var $_itemid = null;

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
		$this->loadIdFromRequest();
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
		if( !$this->_id ) {
			$this->loadIdFromRequest();
		}
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
		$id = JRequest::getInt( 'infoid',  0 );
		$this->setId( $id );
	}


	/**
	 * @return object with data
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__'._JC_DB.'_info '
			.'  WHERE id = '.intval( $this->_id );
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if ( !$this->_data ) {
			$user = &JFactory::getUser();
			$uid = $user->get( 'id', 0 );
			$itemid = JRequest::getInt( 'itemid',  0 );
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->itemid = $itemid;
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
			$this->_data->created_by = $uid;
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
	function store( &$data )
	{
		$row =& $this->getTable();

		$user = &JFactory::getUser();

		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			if( !( $user->authorize( 'com_jcollection', 'edit', 'item', 'own' ) && ( $data['infoid'] == 0 || $data['created_by'] == $uid ) ) )
			{
				JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
				return;
			}
		}

		$datenow = & JFactory::getDate();
		if( empty( $data['date'] ) ) {
			$data['date'] = $datenow->toMySQL();
		} else {
			$data['modified'] = $datenow->toMySQL();
			$data['modified_by'] = $uid;
		}

		// Bind the form fields to the hello table
		if ( !$row->bind( $data ) ) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}

		// Make sure the hello record is valid
		if ( !$row->check() ) {
			$this->setError( $row->getError() );
			return false;
		}

		// Store the web link table to the database
		if ( !$row->store() ) {
			$this->setError( $row->getError() );
			return false;
		}

		// Set the correct id if the item is new
		if( $data['infoid'] == 0 ) {
			$this->_data->id = $row->id;
			$this->_id = $row->id;
			$data['infoid'] = $row->id;
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
		//else {
		//	JError::raiseWarning( 0, 'Unable to Load Data');
		//	return false;
		//}

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
			$item = & JTable::getInstance( 'info', 'Table' );
			return $item->checkout( $uid, $this->_id );
		}
		return false;
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

			if ( $row->ordering != $order[$i] )
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError( $this->_db->getErrorMsg() );
					return false;
				}
			}
		}

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ( $groupings as $group ) {
			$row->reorder( 'itemid = '.(int) $group );
		}

		return true;
	}

}
?>
