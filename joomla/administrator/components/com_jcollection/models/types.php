<?php
/**
 * JCollection Types Model
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

jimport( 'joomla.application.component.model' );

/**
 * Types Model
 *
 */
class JCollectionModelTypes extends JModel
{
	/**
	 * Hellos data array
	 *
	 * @var array
	 */
	var $_data;

	/**
	 * Total number
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		global $mainframe, $option;

		// Get the pagination request variables
		$limit = $mainframe->getUserStateFromRequest( $option.'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	/**
	 * Method to delete record(s)
	 * array
	 * @access public
	 * @return boolean True on success
		*/
	function delete($cids)
	{
		$model = &JModel::getInstance('type','JCollectionModel');
		return $model->delete($cids);
	}

	/**
	 * Method to change order
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @param access 0 = public, 1 = registered, 2 = special
	 * @return boolean True on success
	 */
	function saveorder($cid = array(), $order)
	{
		$model = &JModel::getInstance('type','JCollectionModel');
		return $model->saveorder( $cid, $order );
	}

	/**
	 * Method to change order (move up/down)
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @param access 0 = public, 1 = registered, 2 = special
	 * @return boolean True on success
	 */
	function move($cid = array(), $direction)
	{
		$model = &JModel::getInstance('type','JCollectionModel');
		return $model->move( $cid, $direction );
	}

	/**
	 * Retrieves the categories data
	 * @return array Array of objects containing the data from the database
	 */
	function &getData()
	{
		global $mainframe, $option;

		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$query = $this->_buildQuery();
			$limit = $this->getState('limit');
			$limitstart = $this->getState('limitstart');
			$this->_data = $this->_getList( $query, $limitstart, $limit );
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
			$query = $this->_buildQuery( );
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}

	/**
	 * Method to get a pagination object for the categories
	 *
	 * @access public
	 * @return object
	 */
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
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildQuery()
	{
		// Get the WHERE and ORDER BY clauses for the query
		$where = $this->_buildContentWhere();
		$orderby = $this->_buildContentOrderBy();
		$query = " SELECT i.* "
		."\n FROM #__"._JC_DB."_type AS i "
		."\n ".$where
		."\n ".$orderby
		;
		return $query;
	}

	function _buildContentOrderBy()
	{
		global $mainframe, $option;

		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'i.ordering',   'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', '', 'word' );

		if ($filter_order == 'i.ordering') {
			$orderby = ' ORDER BY i.ordering '.$filter_order_Dir;
		} else {
			if( trim($filter_order)!='')
			$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , i.ordering ';
			else
			$orderby = ' ORDER BY i.ordering ';
		}

		return $orderby;
	}

	function _buildContentWhere()
	{
		global $mainframe, $option;
		$db =& JFactory::getDBO();

		$search = $mainframe->getUserStateFromRequest( $option.'.search', 'search', '','string' );
		$search = JString::strtolower( $search );

		$where = array();
		if($search) {
			$where[] = '( LOWER( i.name ) LIKE '.$this->_db->Quote( '%'.$this->_db->getEscaped( $search, true ).'%', false ).' )';
		}

		return (count($where) ? 'WHERE '.implode(' AND ',$where) : '' );
	}

}
?>
