<?php
/**
 * Category Model for Collection Manager Component
 *
 * @package com_collection
 * @license GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport('joomla.application.component.model');

/**
 * Collection Category Model
 *
 * @package com_collection
 */
class JCollectionModelCategory extends JModel
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
	 * retrieve all items (including subcategories)
	 * @var int
	 */
	var $_all = null;

	/**
	 * total number of subcategories/items
	 * @var int
	 */
	var $_total = null;

	/**
	 * total number of subcategories
	 * @var int
	 */
	var $_totalsubcats = null;

	/**
	 * total number of items
	 */
	var $_totalitems = null;

	/**
	 * pagination object
	 * @var object
	 */
	var $_pagination = null;

	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		global $option, $mainframe;

		parent::__construct();

		// Get the pagination request variables
		$limit = JRequest::getVar('limit', $mainframe->getCfg('list_limit'), '', 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

		$id = JRequest::getInt('catid',  0);
		$this->setId($id);
		$all = JRequest::getInt('all', 0);
		$this->_all = $all;
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
	 * Method to reload id from the request variable
	 */
	function reload()
	{
		$id = JRequest::getInt('catid',  0);
		$this->setId($id);
		$all = JRequest::getInt('all', 0);
		$this->_all = $all;
	}

	/**
	 * Method to get a category
	 * @return object with data
	 */
	function &getData()
	{
		global $option, $mainframe;
		// Load the data
		if (empty( $this->_data )) {
			$limitstart = $this->getState('limitstart');
			$limit = $this->getState('limit');
			if($this->_id>0) {
				$user = & JFactory::getUser();
				$aid = $user->get('aid', 0);
				$uid = $user->get('id', 0);

				$query = $this->_buildQuery();
				$this->_db->setQuery( $query );
				$this->_data = $this->_db->loadObject();

				$params = &JComponentHelper::getParams( $option );

				$cats = array();
				$actcat = $this->_id;
				while($actcat) {
					$query = 'SELECT *, '
					."\n CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\":\", id, alias) ELSE id END AS slug"
					."\n FROM #__"._JC_DB.'_cat '
					."\n WHERE id=".(int)$actcat;
					$this->_db->setQuery( $query );
					$cat = $this->_db->loadObject();
					if ( ( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) ) && ( !$user->authorize( 'com_jcollection', 'edit', 'cat', 'all' ) ) && ( !$cat->published || !$cat->approved ) && $cat->created_by != $uid )
					{
						JError::raiseError( 404, JText::_( "Resource Not Found" ) );
						return false;
					}
					if( $cat->access > $aid ) {
						JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
						return false;
					}
					$cats[] = $cat;
					$actcat = $cat->parent;
				}
				$cats = array_reverse( $cats );
				$this->_data->cats = $cats;
				foreach($cats as $cat) {
					$catparamsdata = $cat->params;
					$catparamsdefs = _JC_PATH.DS.'models'.DS.'category.xml';
					$catparams = new JParameter( $catparamsdata, $catparamsdefs );
					$params->merge( &$catparams );
				}
				$this->_data->params = $params;

			} else {
				$this->_data = new stdClass();
				$this->_data->id = 0;
				$this->_data->name = JText::_( 'JCOLLECTIONROOT' );
				$this->_data->parent = null;
				$this->_data->description = JText::_( 'JCOLLECTIONROOTDESC' );
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

				$this->_data->subcategories = array();
				$this->_data->items = array();
				$this->_data->cats = array();
			}

			$totalsubcats = $this->getTotalsubcats();
			if( $totalsubcats > $limitstart ) {
				$query = $this->_buildSubcatsQuery();
				$this->_db->setQuery( $query, $limitstart, $limit );
				$this->_data->subcategories = $this->_db->loadObjectList();
			} else {
				$this->_data->subcategories = array();
			}

			if( $this->_all>0 ) { // get all items in all subcategories
				if( $totalsubcats < $limitstart + $limit ) {
					/* there are items to display */
					// compute the new limit and limitstart
					$limitstart = max( $limitstart - $totalsubcats, 0 );
					if( $totalsubcats >= $limitstart ) {
						$limit = $limit - $totalsubcats%$limit;
					}
					$query = $this->_buildAllItemsQuery();
					$this->_db->setQuery( $query, $limitstart, $limit );
					$this->_data->items = $this->_db->loadObjectList();
				} else {
					$this->_data->items = array();
				}

			} else {
				if( $this->_id ) {
					if( $totalsubcats < $limitstart + $limit ) {
						/* there are items to display */
						// compute the new limit and limitstart
						$limitstart = max( $limitstart - $totalsubcats, 0 );
						if( $totalsubcats >= $limitstart ) {
							$limit = $limit - $totalsubcats%$limit;
						}
						$query = $this->_buildItemsQuery();
						$this->_db->setQuery( $query, $limitstart, $limit );
						$this->_data->items = $this->_db->loadObjectList();
						if( $params->get( 'overwrite_cats' ) )
						{
							$conf = &JFactory::getConfig();
							$lifetime = $params->get( 'item_cache_time', $conf->getValue( 'config.cachetime' ) ) * 60;
							$itemmodel = &JModel::getInstance( 'item', 'jcollectionmodel' );
							$cache = &JFactory::getCache( 'com_jcollection_item' );
							$cache->setCaching( 1 );
							$cache->setLifeTime( $lifetime );
							$citems = count( $this->_data->items );
							for( $i = 0; $i < $citems; $i++ )
							{
								$item = &$this->_data->items[$i];
								$itemmodel->setId( $item->id );
								$item = $cache->get( array( $itemmodel, 'getData' ), array(), (int)$item->id );
								// $item = $itemmodel->getData();
							}

						}
					} else {
						$this->_data->items = array();
					}
				}
			}
		}
		if ( !$this->_data ) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->name = null;
			$this->_data->name_alias = null;
			$this->_data->parent = null;
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

			$this->_data->slug = null;

			$this->_data->subcategories = array();
			$this->_data->items = array();
		}
		return $this->_data;
	}

	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$totalsubcats = $this->getTotalsubcats();
			$totalitems = $this->getTotalitems();
			$this->_total = $totalsubcats + $totalitems;
		}
		return $this->_total;
	}

	function getTotalsubcats()
	{
		if (empty($this->_totalsubcats))
		{
			$query = $this->_buildSubcatsQuery();
			$this->_totalsubcats = $this->_getListCount( $query );
		}
		return $this->_totalsubcats;
	}

	function getTotalitems()
	{
		if (empty($this->_totalitems))
		{
			if( !$this->_all )
			{
				$query = $this->_buildItemsQuery();
			} else {
				$catids = $this->_getAllCatids();
				$query = $this->_buildAllItemsQuery();
			}
			$this->_totalitems = $this->_getListCount( $query );
		}
		return $this->_totalitems;
	}

	/**
	 * Method to get a pagination object for the category
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

	function _getAllCatids()
	{
		$user    =& JFactory::getUser();
		$aid = (int) $user->get( 'aid', 0 );
		$uid = (int) $user->get( 'id', 0 );
		$catids = array();
		$catids[] = intval( $this->_id );
		$actcats = array();
		$actcats[] = intval( $this->_id );
		do {
			$query = "SELECT id "
			."\n FROM #__"._JC_DB."_cat"
			."\n WHERE parent IN (".implode( ",", $actcats ).")"
			."\n AND access <= ".$aid
			;
			if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
			{
				$query .= "\n AND ( ( published = 1 AND approved = 1 ) OR ( created_by = ".$uid.' ) )';
			}
			$this->_db->setQuery($query);
			$allcats = $this->_db->loadResultArray();
			$actcats = array();
			if(count($allcats)) {
				foreach($allcats as $c) {
					if($c>0) {
						$catids[] = $c;
					}
					$actcats[] = $c;
				}
			}
		} while(count($actcats)>0);
		return $catids;
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

	function _buildQuery()
	{
		$where = $this->_buildWhere();
		$order = $this->_buildOrder();
		$url = JURI::root() . 'images/jcollection/';
		$query = " SELECT *,"
		."\n CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\":\", id, alias) ELSE id END as slug, "
		."\n CASE WHEN ( ( LENGTH(img)>0 ) AND ( SUBSTRING( img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", img ) ELSE img END AS image "
		."\n FROM #__"._JC_DB."_cat "
		.$where
		.$order
		;
		return $query;
	}

	function _buildWhere()
	{
		$user =& JFactory::getUser();
		$aid = (int) $user->get( 'aid', 0 );
		$uid = (int) $user->get( 'id', 0 );
		$where = array();
		$where[] = '( id = '.(int)$this->_id.' )';
		if( !$user->authorize( 'com_jcollection', 'edit', 'cat', 'all' ) )
		{
			$where[] = '( ( published = 1 AND approved = 1 ) OR ( created_by = '.$uid.' ) )';
		}
		$where[] = '( access <= '.$aid.' )';

		return (count($where)?' WHERE '.implode(' AND ',$where):'');
	}

	function _buildOrder()
	{
		$order = ' ORDER BY ordering ASC ';
		return $order;
	}

	function _buildSubcatsQuery()
	{
		$where = $this->_buildSubcatsWhere();
		$order = $this->_buildSubcatsOrder();
		$url = JURI::root() . 'images/jcollection/';
		$query = "SELECT *,"
		."\n CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\":\", id, alias) ELSE id END as slug, "
		."\n CASE WHEN ( ( LENGTH(img)>0 ) AND ( SUBSTRING( img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", img ) ELSE img END AS image "
		."\n FROM #__"._JC_DB."_cat "
		.$where
		.$order
		;
		return $query;
	}

	function _buildSubcatsWhere()
	{
		$user =& JFactory::getUser();
		$aid = (int) $user->get('aid', 0);
		$uid = (int) $user->get( 'id', 0 );
		$where = array();
		$where[] = '( parent = '.(int)$this->_id.' )';
		if( !$user->authorize( 'com_jcollection', 'edit', 'cat', 'all' ) )
		{
			$where[] = '( ( published = 1 AND approved = 1 ) OR ( created_by = '.$uid.' ) )';
		}
		$where[] = '( access <= '.$aid.' )';

		return (count($where)?' WHERE '.implode(' AND ',$where):'');
	}

	function _buildSubcatsOrder()
	{
		$order = ' ORDER BY ordering ASC ';
		return $order;
	}

	function _buildItemsQuery()
	{
		$where = $this->_buildItemsWhere();
		$order = $this->_buildItemsOrder();
		$url = JURI::root() . 'images/jcollection/';
		$query = "SELECT *,"
		."\n CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\":\", id, alias) ELSE id END AS slug, "
		."\n CASE WHEN ( ( LENGTH(img)>0 ) AND ( SUBSTRING( img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", img ) ELSE img END AS image "
		."\n FROM #__"._JC_DB
		.$where
		.$order
		;
		return $query;
	}

	function _buildItemsWhere()
	{
		$user =& JFactory::getUser();
		$aid = (int) $user->get('aid', 0);
		$uid = (int) $user->get( 'id', 0 );
		$where = array();
		$where[] = '( catid = '.(int)$this->_id.' )';
		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			$where[] = '( ( published = 1 AND approved = 1 ) OR ( created_by = '.$uid.' ) )';
		}
		$where[] = '( access <= '.$aid.' )';

		return ( count($where) ? ' WHERE '.implode(' AND ',$where) : '' );
	}

	function _buildItemsOrder()
	{
		$order = ' ORDER BY ordering ASC ';
		return $order;
	}

	function _buildAllItemsQuery()
	{
		$where = $this->_buildAllItemsWhere();
		$order = $this->_buildItemsOrder();
		$url = JURI::root() . 'images/jcollection/';
		$query = "SELECT *,"
		."\n CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\":\", id, alias) ELSE id END AS slug, "
		."\n CASE WHEN ( ( LENGTH(img)>0 ) AND ( SUBSTRING( img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", img ) ELSE img END AS image "
		."\n FROM #__"._JC_DB
		.$where
		.$order
		;
		return $query;
	}

	function _buildAllItemsWhere()
	{
		$user =& JFactory::getUser();
		$aid = (int) $user->get( 'aid', 0 );
		$uid = (int) $user->get( 'id', 0 );
		$catids = &$this->_getAllCatids();
		$where = array();
		if(count($catids)) {
			$where[] = '( catid IN ( '.implode( ',', $catids ).' )';
		} else {
			$where[] = '( catid = -1 )';
		}
		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			$where[] = '( ( published = 1 AND approved = 1 ) OR ( created_by = '.$uid.' ) )';
		}
		$where[] = '( access <= '.$aid.' )';

		return (count($where)?' WHERE '.implode(' AND ',$where):'');
	}

}
?>
