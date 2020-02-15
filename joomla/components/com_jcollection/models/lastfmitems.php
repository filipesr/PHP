<?php
/**
 * JCollection Lastfmitems Model class
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
 * Lastfmitems Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelLastfmitems extends JModel
{
	/**
	 * data array
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
		//$limit = 20;
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

			$limit = $this->getState( 'limit' );
			$limitstart = $this->getState( 'limitstart' );

			$this->_total = 0;
			$this->_data = array();
			$access_key = JCollectionHelper::getLastfmAccessKey();
			if($search && $access_key) {
				if( $limit == 0 ) {
					$limit = 30;
				}
				$page = (int) $limitstart/$limit + 1;

				$base = 'http://ws.audioscrobbler.com/2.0/';
				$params = array(
					'method' => 'album.search',
					'limit' => strval( $limit ),
					'page' => strval( $page ),
					'album' => $search,
					'api_key' => $access_key
				);

				$xmlstr = JCollectionHelper::callWebservice( $base, $params );

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );

				$doc = $xml->documentElement;

				$albumels = $doc->getElementsByPath( 'results/albummatches/album' );
				$albumels = $albumels->toArray();
				$arr = array();
				foreach( $albumels as $albumel )
				{
					$idel = $albumel->getElementsByPath( 'id', 1 );
					if( $idel )
					{
						$newrow = new stdClass();
						$id = $idel->getText();
						$nameel = $albumel->getElementsByPath( 'name', 1 );
						if( $nameel ) {
							$name = $nameel->getText();
						} else {
							$name = JText::_( 'unknown' );
						}
						$artistel = $albumel->getElementsByPath( 'artist', 1 );
						if( $artistel ) {
							$artist = $artistel->getText();
						} else {
							$artist = JText::_( 'unknown' );
						}
						$newrow->id = addslashes( $name.'{,}'.$artist );
						$newrow->name = $name;
						$newrow->artist = $artist;
						$arr[] = $newrow;
					}
				}
				$this->_data = $arr;

				$totalel = $doc->getElementsByPath( 'results/opensearch:totalResults', 1 );
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
