<?php
/**
 * List Model for Collection Manager Component
 *
 * @package JCollection
 * @license GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport('joomla.application.component.model');

/**
 * Collection List Model
 *
 * @package JCollection
 */
class JCollectionModelList extends JModel
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
	 * total number of subcategories/items
	 * @var int
	 */
	var $_total = null;

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
		global $mainframe;
		parent::__construct();
		$this->loadIdFromRequest();

		// Get the pagination request variables
		$limit = $mainframe->getUserStateFromRequest( $option.'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
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

	function getId()
	{
		if( !$this->_id ) {
			$this->loadIdFromRequest();
		}
		return $this->_id;
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
		$id = JRequest::getInt( 'listid',  0 );
		$this->setId( $id );
	}

	/**
	* Method to get a category
	* @return object with data
	*/
	function &getData()
	{
		// Load the data
		if ( empty( $this->_data )) {
			if( $this->_id>0 ) {
				$user =& JFactory::getUser();
				$aid = (int) $user->get( 'aid', 0 );
				$uid = (int) $user->get( 'id', 0 );
				$limit = $this->getState( 'limit' );
				$limitstart = $this->getState( 'limitstart' );
				$url = JURI::root() . 'images/jcollection/';
				$query = $this->_buildQuery();
				$this->_db->setQuery( $query );
				$this->_data = $this->_db->loadObject();

				if ( ( !$user->authorize( 'com_jcollection', 'edit', 'list', 'all' ) ) && ( !$this->_data->published || !$this->_data->approved ) && $this->_data->created_by != $uid )
				{
					JError::raiseError( 404, JText::_( "Resource Not Found" ) );
					return false;
				}

				if( $this->_data->access > $aid ) {
					JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
					return false;
				}

				$query = $this->_buildItemsQuery();
				$this->_data->items = $this->_getList( $query, $limitstart, $limit );
				global $option;
				$params = &JComponentHelper::getParams( $option );
				$listparamsdata = $this->_data->params;
				$listparamsdefs = _JC_PATH.DS.'models'.DS.'list.xml';
				$listparams = new JParameter( $listparamsdata, $listparamsdefs );
				$params->merge( &$listparams );
				$task = JRequest::getVar( 'task', null, 'default', 'cmd' );
				if( $params->get( 'overwrite_cats' ) && $task != 'edit' && $task != 'popup_sort' && $task != 'orderup' && $task != 'orderdown' && $task != 'saveorder' )
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
						$itemmodel->setId( $item->itemid );
						$item = $cache->get( array( $itemmodel, 'getData' ), array(), (int)$item->itemid );
						// $item = $itemmodel->getData();
					}

				}

			} else {
				$this->_data = new stdClass();
				$this->_data->id = 0;
				$this->_data->name = "Root";
				$this->_data->name_alias = null;
				$this->_data->catid = null;
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

		}
		if (!$this->_data) {
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
			$item = & JTable::getInstance( 'list', 'Table' );
			return $item->checkout( $uid, $this->_id );
		}
		return false;
	}

	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildItemsQuery();
			$this->_total = $this->_getListCount( $query );
		}
		return $this->_total;
	}

	/**
	 * Method to get a pagination object for the list
	 *
	 * @access public
	 * @return object
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if ( empty( $this->_pagination ) )
		{
			jimport( 'joomla.html.pagination' );
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
		}

		return $this->_pagination;
	}

	/**
	 * Method to change order
	 * array
	 * @access public
	 * @param cids array with id numbers
	 * @return boolean True on success
	 */
	function saveorder_sort( $cid = array(), $order )
	{
		$row = &JTable::getInstance( 'item2list', 'Table' );
		$groupings = array();

		// update ordering values
		for( $i=0; $i < count( $cid ); $i++ )
		{
			$row->load( (int) $cid[$i] );

			// track parents
			$groupings[] = $row->listid;

			if ( $row->ordering != $order[$i] )
			{
				$row->ordering = $order[$i];
				if ( !$row->store() ) {
					$this->setError( $this->_db->getErrorMsg() );
					return false;
				}
			}
		}

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ( $groupings as $group ) {
			$row->reorder( 'listid = '.(int) $group );
		}

		return true;
	}

	function move_sort( $cid, $direction )
	{
		if( count( $cid ) == 1 ) {
			$row = &JTable::getInstance( 'item2list', 'Table' );

			if ( !$row->load( $cid[0] ) ) {
				$this->setError( $this->_db->getErrorMsg() );
				return false;
			}

			if ( !$row->move( $direction, ' listid = '.(int) $row->listid ) ) {
				$this->setError( $this->_db->getErrorMsg() );
				return false;
			}
		}

		return true;
	}

	function delete_sort( $cids )
	{
		if (count( $cids ))
		{
			$row = &JTable::getInstance( 'item2list', 'Table' );
			foreach( $cids as $cid ) {
				if ( !$row->delete( $cid ) ) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
	}

	function addItems( $cids, $listid )
	{
		if( count( $cids ) && $listid ) {
			$query = "INSERT INTO #__"._JC_DB."_item2list (`listid`,`itemid`) VALUES ";
			$query .= '('.(int)$listid.','.implode('),('.(int)$listid.',',$cids).')';
			$this->_db->setQuery($query);
			$this->_db->query();
		}
	}

	function _buildQuery()
	{
		$where = $this->_buildWhere();
		$url = JURI::root() . 'images/jcollection/';
		$query = " SELECT *,"
		."\n CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\":\", id, alias) ELSE id END as slug, "
		."\n CASE WHEN ( ( LENGTH(img)>0 ) AND ( SUBSTRING( img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", img ) ELSE img END AS image "
		."\n FROM #__"._JC_DB."_list "
		.$where
		;
		return $query;
	}

	function _buildWhere()
	{
		$where = array();
		$where[] = '( id = '.intval( $this->_id ).' )';

		return ( count( $where ) ? ' WHERE '.implode( ' AND ', $where ) : '' );
	}

	function _buildItemsQuery()
	{
		$where = $this->_buildItemsWhere();
		$order = $this->_buildItemsOrder();
		$query = " SELECT i.*, l.*, "
		."\n CASE WHEN CHAR_LENGTH(i.alias) THEN CONCAT_WS(\":\", i.id, i.alias) ELSE i.id END as slug, "
		."\n CASE WHEN ( ( LENGTH(i.img)>0 ) AND ( SUBSTRING( i.img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( i.img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", i.img ) ELSE i.img END AS image "
		."\n FROM #__"._JC_DB."_item2list AS l"
		."\n LEFT JOIN #__"._JC_DB." AS i ON i.id=l.itemid "
		.$where
		.$order
		;
		return $query;
	}

	function _buildItemsWhere()
	{
		$user =& JFactory::getUser();
		$aid = (int) $user->get( 'aid', 0);
		$uid = (int) $user->get( 'id', 0 );
		$where = array();
		$where[] = "( l.listid=".intval( $this->_id ).' )';
		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			$where[] = "( ( i.published = 1 AND i.approved = 1 ) OR ( i.created_by = ".$uid.' ) )';
		}
		$where[] = "( i.access <= ".$aid." )";
		return ( count( $where ) ? ' WHERE '.implode( ' AND ', $where ) : '' );
	}

	function _buildItemsOrder()
	{
		$order = " ORDER BY l.ordering ";
		return $order;
	}


}
?>
