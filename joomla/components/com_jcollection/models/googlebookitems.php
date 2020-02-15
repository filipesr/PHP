<?php
/**
 * JCollection Googlebookitems Model class
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
 * Google book items Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelGooglebookitems extends JModel
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
		$limit = $mainframe->getUserStateFromRequest( $option.'.limit', 'limit', 10, 'int' );
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
			$search = $mainframe->getUserStateFromRequest( $option.'.search_wsg', 'search_wsg', '','string' );
			$search = JString::strtolower( $search );

			$limit = $this->getState( 'limit' );
			$limitstart = $this->getState( 'limitstart' );

			$this->_total = 0;
			$this->_data = array();
			if($search) {

				$base = 'http://books.google.com/books/feeds/volumes';
				if($limitstart) {
					$params = array( 'q' => $search, 'max-results' => "$limit", 'start-index' => "$limitstart" );
				} else {
					$params = array( 'q' => $search, 'max-results' => "$limit" );
				}

				$xmlstr = JCollectionHelper::callWebservice( $base, $params );

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );
				$doc = $xml->documentElement;

				$entryels = $doc->getElementsByPath( 'entry' );
				$entryels = $entryels->toArray();

				foreach( $entryels as $entryel )
				{
					$idel = $entryel->getElementsByPath( 'dc:identifier', 1 );
					if( $idel )
					{
						$newrow = new stdClass();
						$newrow->id = $idel->getText();
						$titleel = $entryel->getElementsByPath( 'title', 1 );
						if( $titleel ) {
							$title = $titleel->getText();
						} else {
							$title = JText::_("unknown");
						}
						$newrow->name = $title;
						$creatorels = $entryel->getElementsByPath( 'dc:creator' );
						$creatorels = $creatorels->toArray();
						$creators = array();
						foreach( $creatorels as $creatorel ) {
							$creators[] = $creatorel->getText();
						}
						$newrow->author = implode( ',', $creators );
						$this->_data[] = $newrow;
					}
				}
				$totalel = $doc->getElementsByPath( 'openSearch:totalResults', 1 );
				if( $totalel ) {
					$this->_total = (int)$totalel->getText();
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
			if (empty($this->_data )) { // fetch data to $this->_data
				$this->getData();
			}
			$this->_total = count($this->_data);
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
