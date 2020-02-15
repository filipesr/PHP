<?php
/**
 * JCollection Isbndbitems Model class
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
 * ISBNdb Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelIsbndbitems extends JModel
{
	/**
	 * Amazon data array
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
		//$limit = $mainframe->getUserStateFromRequest( $option.'.limit', 'limit', 10, 'int' );
		$limit = 10;
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}


	/**
	 * Retrieves the amazon data
	 * @return array Array of objects containing the data from the webservice
	 */
	function &getData()
	{
		global $mainframe, $option;

		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$search = $mainframe->getUserStateFromRequest( $option.'.search', 'search', '','string' );
			$search = JString::strtolower( $search );

			//$limit = $this->getState( 'limit' );
			$limit = 10;
			$limitstart = $this->getState( 'limitstart' );

			$this->_total = 0;
			$this->_data = array();
			$access_key = JCollectionHelper::getISBNdbAccessKey();
			if($search && $access_key) {
				$base = 'https://isbndb.com/api/books.xml';
				if($limitstart) {
					$page = (int) $limitstart/10 + 1;
					$params = array(
					'access_key' => $access_key,
					'index1' => 'full',
					'value1' => $search,
					'page_number' => "$page" );
				} else {
					$params = array(
					'access_key' => $access_key,
					'index1' => 'full',
					'value1' => $search );
				}

				$xmlstr = JCollectionHelper::callWebservice( $base, $params );

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );
				$doc = $xml->documentElement;

				$bookdataels = $doc->getElementsByPath( 'BookList/BookData' );
				$bookdataels = $bookdataels->toArray();
				foreach( $bookdataels as $bookdatael )
				{
					$newrow = new stdClass();
					$isbn = $bookdatael->getAttribute( 'isbn' );
					$newrow->id = $isbn;
					$titleel = $bookdatael->getElementsByPath( 'Title', 1 );
					if( $titleel ) {
						$title = $titleel->getText();
					} else {
						$title = JText::_( 'unknown' );
					}
					$newrow->name = $title;
					$authorsel = $bookdatael->getElementsByPath( 'AuthorsText', 1 );
					if( $authorsel ) {
						$authors = $authorsel->getText();
					} else {
						$authors = JText::_( 'unknown' );
					}
					$newrow->author = $authors;
					$this->_data[] = $newrow;
				}

				$booklistel = $doc->getElementsByPath( 'BookList', 1 );
				if( $booklistel ) {
					$this->_total = (int)$booklistel->getAttribute( 'total_results' );
				} else {
					$this->_total = count( $this->_data );
				}
			}

			//$this->_total = count($this->_data);
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
			$this->_total = 0;
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

}
?>
