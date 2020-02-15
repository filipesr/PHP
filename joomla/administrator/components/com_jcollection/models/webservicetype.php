<?php
/**
 * JCollection Webservicetype Model
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
 * JCollection Webservicetype Model
 *
 */
class JCollectionModelWebservicetype extends JModel
{
	/**
	 * The current item id
	 * @var int
	 */
	var $_id = null;

	/**
	 * The data
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

		$array = JRequest::getVar('cid', array(0), '', 'array');
		$this->setId((int)$array[0]);
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
		if (empty( $this->_data )) {
			$query = " SELECT * FROM #__"._JC_DB."_webservicetype "
			."\n  WHERE id=".intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		} else {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->name = null;
			$this->_data->webservice = null;
			$this->_data->typeid = null;
			$this->_data->disclaimer = null;
			$this->_data->info1xpath = null;
			$this->_data->info2xpath = null;
			$this->_data->info3xpath = null;
			$this->_data->info4xpath = null;
			$this->_data->info5xpath = null;
			$this->_data->info6xpath = null;
			$this->_data->info7xpath = null;
			$this->_data->info8xpath = null;
			$this->_data->info9xpath = null;
			$this->_data->info10xpath = null;
			$this->_data->titlexpath = null;
			$this->_data->descriptionxpath = null;
			$this->_data->imgxpath = null;
			$this->_data->urlxpath = null;
			$this->_data->checked_out = null;
			$this->_data->checked_out_time = null;
			$this->_data->ordering = null;
			$this->_data->params = null;
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
			$dis = JRequest::getVar( 'disclaimer', '', 'post', 'string', JREQUEST_ALLOWRAW );
			$dis = str_replace( '<br>', '<br />', $dis );
			$data['disclaimer'] = $dis;
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

}
?>
