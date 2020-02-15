<?php
/**
 * JCollection Infos Model class
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
 * Infos Model
 *
 * @package JCollection
 * @subpackage com_jcollection
 */
class JCollectionModelInfos extends JModel
{
	/**
	 * Categories data array
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
		$model = &JModel::getInstance('info','JCollectionModel');
		return $model->delete($cids);
	}

	/**
	 * Method to publish record(s)
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @param publish 0 = unpublish, 1 = publish
	 * @return boolean True on success
	 */
	function publish($cids, $publish = 1)
	{
		$model = &JModel::getInstance('info','JCollectionModel');
		return $model->publish($cids, $publish);
	}

	/**
	 * Method to archiv record(s)
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @return boolean True on success
	 */
	function archive($cids)
	{
		$model = &JModel::getInstance('info','JCollectionModel');
		return $model->archive($cids);
	}

	/**
	 * Method to trash record(s)
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @return boolean True on success
	 */
	function trash($cids)
	{
		$model = &JModel::getInstance('info','JCollectionModel');
		return $model->trash($cids);
	}

	/**
	 * Method to approve record(s)
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @return boolean True on success
	 */
	function approve($cids)
	{
		$model = &JModel::getInstance('info','JCollectionModel');
		return $model->approve($cids);
	}

	/**
	 * Method to disapprove record(s)
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @return boolean True on success
	 */
	function disapprove($cids)
	{
		$model = &JModel::getInstance('info','JCollectionModel');
		return $model->approve($cids, 0);
	}

	/**
	 * Method to change access
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @param access 0 = public, 1 = registered, 2 = special
	 * @return boolean True on success
	 */
	function access($cids, $access)
	{
		$model = &JModel::getInstance('info','JCollectionModel');
		return $model->access($cids, $access);
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
		$model = &JModel::getInstance('info','JCollectionModel');
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
		$model = &JModel::getInstance('info','JCollectionModel');
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
			$this->_data = $this->_getList( $query, $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
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
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount( $query );
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

		$query = " SELECT i.*, m.name AS itemname, c.name AS catname, u.name AS uname, u.username, g.name AS groupname, "
		."\n t.rating1label, t.rating2label, t.rating3label, t.rating4label, t.rating5label "
		."\n FROM #__"._JC_DB."_info AS i "
		."\n LEFT JOIN #__"._JC_DB." AS m ON m.id = i.itemid "
		."\n LEFT JOIN #__"._JC_DB."_cat AS c ON c.id = m.catid "
		."\n LEFT JOIN #__"._JC_DB."_type AS t ON t.id = i.typeid "
		."\n LEFT JOIN #__users AS u ON u.id = i.created_by "
		."\n LEFT JOIN #__groups AS g ON g.id = i.access "
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
			$orderby = ' ORDER BY i.itemid, i.ordering '.$filter_order_Dir;
		} else {
			if( trim($filter_order)!='')
			$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , i.itemid, i.ordering ';
			else
			$orderby = ' ORDER BY i.itemid, i.ordering ';
		}

		return $orderby;
	}

	function _buildContentWhere()
	{
		global $mainframe, $option;
		$db =& JFactory::getDBO();

		$search = $mainframe->getUserStateFromRequest( $option.'.search', 'search', '','string' );
		$search = JString::strtolower( $search );

		// filter state = "P" or "U"
		$filter_state = $mainframe->getUserStateFromRequest( $option.'.filter_state', 'filter_state', '', 'word' );

		$filter_access = $mainframe->getUserStateFromRequest( $option.'.filter_access', 'filter_access', -1, 'int' );
		$filter_item = $mainframe->getUserStateFromRequest( $option.'filter_item', 'filter_item', 0, 'int' );

		$filter_cat = $mainframe->getUserStateFromRequest( $option.'filter_catid', 'filter_catid', 0, 'int' );

		$filter_subcats = $mainframe->getUserStateFromRequest( $option.'filter_subcats', 'filter_subcats', 0, 'int' );
		$filter_author = $mainframe->getUserStateFromRequest( $option.'filter_author', 'filter_author', 0, 'int' );

		$filter_approved = $mainframe->getUserStateFromRequest( $option.'.filter_approved', 'filter_approved', -1, 'int' );


		$where = array();
		if($search) {
			$where[] = '( LOWER( i.name ) LIKE '.$this->_db->Quote( '%'.$this->_db->getEscaped( $search, true ).'%', false ).' )';
		}
		if($filter_access != -1) {
			$where[] = '( i.access = '.(int)$filter_access.' )';
		}
		if($filter_approved != -1) {
			$where[] = '( i.approved = '.(int)$filter_approved.' )';
		}
		if($filter_item) {
			$where[] = '( i.itemid = '.(int)$filter_item.' )';
		}
		if($filter_cat) {
			if($filter_subcats) {
				$filter_cats = array();
				$filter_cats[] = $filter_cat;
				$new_cats = $filter_cats;
				while($new_cats) {
					$query = 'SELECT i.id'
						.' FROM #__'._JC_DB.'_cat AS i '
						."\n WHERE i.parent IN ( ".implode(',',$new_cats).' )';
					$this->_db->setQuery($query);
					$new_cats = $this->_db->loadResultArray();
					$filter_cats = array_merge( $filter_cats, $new_cats);
				}
				$where[] = '( c.id IN ( '.implode(',',$filter_cats).' ) )';
			} else {
				$where[] = '( c.id = '.$filter_cat.' )';
			}
		}
		if($filter_state == "P") {
			$where[] = '( i.published > 0 )';
		} else if($filter_state == "U") {
			$where[] = '( i.published = 0 )';
		} else if($filter_state == "A") {
			$where[] = '( i.published = -1 )';
		} else if($filter_state == "T") {
			$where[] = '( i.published = -2 )';
		} else {
			$where[] = '( i.published >= 0 )';
		}
		if($filter_author) {
			$where[] = '( i.created_by = '.(int) $filter_author.' )';
		}

		return (count($where) ? 'WHERE '.implode(' AND ',$where) : '' );
	}
}
?>
