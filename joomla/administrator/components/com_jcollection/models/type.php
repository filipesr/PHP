<?php
/**
 * JCollection Type Model
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
 * JCollection Type Model
 *
 */
class JCollectionModelType extends JModel
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

		$array = JRequest::getVar('cid',  array(0), '', 'array');
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the identifier
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
			$query = " SELECT * FROM #__"._JC_DB."_type "
			."\n  WHERE id=".intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->name = null;
			$this->_data->info1label = null;
			$this->_data->info2label = null;
			$this->_data->info3label = null;
			$this->_data->info4label = null;
			$this->_data->info5label = null;
			$this->_data->info6label = null;
			$this->_data->info7label = null;
			$this->_data->info8label = null;
			$this->_data->info9label = null;
			$this->_data->info10label = null;
			$this->_data->info1html = '{INFO1}';
			$this->_data->info2html = '{INFO2}';
			$this->_data->info3html = '{INFO3}';
			$this->_data->info4html = '{INFO4}';
			$this->_data->info5html = '{INFO5}';
			$this->_data->info6html = '{INFO6}';
			$this->_data->info7html = '{INFO7}';
			$this->_data->info8html = '{INFO8}';
			$this->_data->info9html = '{INFO9}';
			$this->_data->info10html = '{INFO10}';
			$this->_data->rating1label = JText::_( 'Overall' );
			$this->_data->rating2label = null;
			$this->_data->rating3label = null;
			$this->_data->rating4label = null;
			$this->_data->rating5label = null;
			$this->_data->img = null;
			$this->_data->checked_out = null;
			$this->_data->checked_out_time = null;
			$this->_data->ordering = null;
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

		for($j=1;$j<=10;$j++) {
			$infoname = 'info'.$j.'html';
			$info = JRequest::getVar( $infoname, '', 'post', 'string', JREQUEST_ALLOWRAW );
			$info = str_replace( '<br>', '<br />', $info );
			$data[$infoname] = $info;
		}

		// Bind the form fields to the hello table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the hello record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}

		$this->saveorder( array($row->id),array((int)$data['ordering']) );

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
	 * Method to change order
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @return boolean True on success
	 */
	function saveorder( $cid = array(), $order )
	{
		$row =& $this->getTable();

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
		$row->reorder();
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

			if (!$row->move( $direction, ' published >= 0 ' )) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}
}
?>
