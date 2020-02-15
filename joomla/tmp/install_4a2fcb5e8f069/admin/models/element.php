<?php
/**
 * JCollection Element Model
 *
 * @version $Id$
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport('joomla.application.component.model');


/**
 * Collection Element Model
 *
 */
class JCollectionModelElement extends JModel
{
	/**
	* Content data in category array
	*
	* @var array
	*/
	var $_list = null;

	var $_page = null;

	/**
	* Method to get content article data for the frontpage
	*
	*/
	function getList()
	{
		global $mainframe;

		if (!empty($this->_list)) {
			return $this->_list;
		}

		// Initialize variables
		$db =& $this->getDBO();
		$filter = null;

		// Get some variables from the request
		//$redirect = $sectionid;
		$option = JRequest::getCmd( 'option' );
		$filter_order = $mainframe->getUserStateFromRequest('itemelement.filter_order', 'filter_order', '', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest('itemelement.filter_order_Dir', 'filter_order_Dir', '', 'word');
		$catid = $mainframe->getUserStateFromRequest('itemelement.catid', 'catid', 0, 'int');
		$filter_authorid = $mainframe->getUserStateFromRequest('itemelement.filter_authorid', 'filter_authorid', 0, 'int');

		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest('itemelement.limitstart', 'limitstart', 0, 'int');
		$search = $mainframe->getUserStateFromRequest('itemelement.search', 'search', '', 'string');
		$search = JString::strtolower($search);

		//$where[] = "c.state >= 0";
//		$where[] = "c.state != -2";

		if (!$filter_order) {
			$filter_order = 'c.name';
		}
		$order = ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', c.name, c.ordering';
		$all = 1;

		/*
		* Add the filter specific information to the where clause
		*/
		// Section filter
		//if ($filter_sectionid >= 0) {
		//	$where[] = 'c.sectionid = '.(int) $filter_sectionid;
		//		}
		// Category filter
		if ($catid > 0) {
			$where[] = 'i.catid = '.(int) $catid;
		}
		// Author filter
		if ($filter_authorid > 0) {
			$where[] = 'c.created_by = '.(int) $filter_authorid;
		}

		// Only published articles
		//$where[] = 'c.state = 1';

		// Keyword filter
		if ($search) {
			$where[] = 'LOWER( c.name ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}

		// Build the where clause of the content record query
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');

		// Get the total number of records
		$query = 'SELECT COUNT(*)' .
						' FROM #__'._JC_DB.' AS i' .
						' LEFT JOIN #__'._JC_DB.'_cat AS c ON c.id = i.catid' .
						$where;
		$db->setQuery($query);
		$total = $db->loadResult();

		// Create the pagination object
		jimport('joomla.html.pagination');
		$this->_page = new JPagination($total, $limitstart, $limit);

		// Get the articles
		$query = 'SELECT i.*, c.name as category, u.name AS uname' .
						' FROM #__'._JC_DB.' AS i' .
						' LEFT JOIN #__'._JC_DB.'_cat AS c ON c.id = i.catid' .
						' LEFT JOIN #__users AS u ON u.id = i.created_by' .
						$where .
						$order;
		$db->setQuery($query, $this->_page->limitstart, $this->_page->limit);
		$this->_list = $db->loadObjectList();

		// If there is a db query error, throw a HTTP 500 and exit
		if ($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr() );
			return false;
		}

		return $this->_list;
	}

	function getPagination()
	{
		if (is_null($this->_list) || is_null($this->_page)) {
			$this->getList();
		}
		return $this->_page;
	}

}
