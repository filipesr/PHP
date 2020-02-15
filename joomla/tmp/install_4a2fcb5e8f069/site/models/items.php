<?php
/**
 * Items Model for Collection Manager Component
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
class JCollectionModelItems extends JModel
{

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

		// Get the pagination request variables
		$limit = $mainframe->getUserStateFromRequest( $option.'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ( $limit != 0 ? ( floor( $limitstart / $limit ) * $limit ) : 0  );

		$this->setState( 'limit', $limit );
		$this->setState( 'limitstart', $limitstart );
	}

	/**
	* Method to get a category
	* @return object with data
	*/
	function &getData()
	{
		// Load the data
		if ( empty( $this->_data )) {
			$limit = $this->getState( 'limit' );
			$limitstart = $this->getState( 'limitstart' );
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query, $limitstart, $limit );
		}
		if (!$this->_data) {
			$this->_data = array();
		}
		return $this->_data;
	}

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

	function _buildQuery()
	{
		$where = $this->_buildWhere();
		$order = $this->_buildOrder();
		$url = JURI::root() . 'images/jcollection/';
		$query = " SELECT i.*, "
		."\n CASE WHEN CHAR_LENGTH(i.alias) THEN CONCAT_WS(\":\", i.id, i.alias) ELSE i.id END as slug, "
		."\n CASE WHEN ( ( LENGTH(i.img)>0 ) AND ( SUBSTRING( i.img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( i.img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", i.img ) ELSE i.img END AS image "
		."\n FROM #__"._JC_DB." AS i"
		."\n ".$where
		."\n ".$order
		;
		return $query;
	}

	function _buildWhere()
	{
		global $mainframe, $option;

		$user =& JFactory::getUser();
		$aid = (int) $user->get( 'aid', 0);
		$uid = (int) $user->get( 'id', 0 );

		$where = array();
		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			$where[] = "( ( i.published = 1 AND i.approved = 1 ) OR ( i.created_by = ".$uid.' ) )';
		}
		$where[] = "( i.access <= ".$aid." )";

		$search = $mainframe->getUserStateFromRequest( $option.'.search', 'search', '','string' );
		$search = JString::strtolower( $search );

		// filter state = "P" or "U"
		$filter_state = $mainframe->getUserStateFromRequest( $option.'.filter_state', 'filter_state', '', 'word' );

		$filter_access = $mainframe->getUserStateFromRequest( $option.'.filter_access', 'filter_access', -1, 'int' );
		$filter_catid = $mainframe->getUserStateFromRequest( $option.'filter_catid', 'filter_catid', 0, 'int' );
		$filter_author = $mainframe->getUserStateFromRequest( $option.'filter_author', 'filter_author', 0, 'int' );
		$filter_approved = $mainframe->getUserStateFromRequest( $option.'.filter_approved', 'filter_approved', -1, 'int' );
		$filter_subcats = $mainframe->getUserStateFromRequest( $option.'filter_subcats', 'filter_subcats', 0, 'int' );

		if( $search ) {
			$where[] = '( LOWER( i.name ) LIKE '.$this->_db->Quote( '%'.$this->_db->getEscaped( $search, true ).'%', false ).' )';
		}
		if( $filter_access != -1 ) {
			$where[] = '( i.access = '.(int)$filter_access.' )';
		}
		if( $filter_approved != -1 ) {
			$where[] = '( i.approved = '.(int)$filter_approved.' )';
		}
		if( $filter_catid ) {
			if( $filter_subcats ) {
				$filter_catids = array();
				$filter_catids[] = $filter_catid;
				$new_catids = $filter_catids;
				while( $new_catids ) {
					$query = 'SELECT c.id '
					."\n FROM #__"._JC_DB.'_cat AS c '
					."\n WHERE c.parent IN ( ".implode(',',$new_catids).' )'
					;
					$this->_db->setQuery( $query );
					$new_catids = $this->_db->loadResultArray();
					$filter_catids = array_merge( $filter_catids, $new_catids);
				}
				$where[] = '( i.catid IN ( '.implode(',',$filter_catids).' ) )';
			} else {
				$where[] = '( i.catid = '.(int) $filter_catid.' )';
			}
		}

		if( $filter_state == "P" ) {
			$where[] = '( i.published > 0 )';
		} else if( $filter_state == "U" ) {
			$where[] = '( i.published = 0 )';
		} else if( $filter_state == "A" ) {
			$where[] = '( i.published = -1 )';
		} else if( $filter_state == "T" ) {
			$where[] = '( i.published = -2 )';
		} else {
			$where[] = '( i.published >= 0 )';
		}
		if( $filter_author ) {
			$where[] = '( i.created_by = '.(int) $filter_author.' )';
		}

		return ( count( $where ) ? ' WHERE '.implode( ' AND ', $where ) : '' );
	}

	function _buildOrder()
	{
		$order = " ORDER BY i.catid, i.ordering ";
		return $order;
	}


}
?>
