<?php
/**
 * JCollection Yahoomusicitems Model class
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
 * Yahoomusicitems Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelYahoomusicitems extends JModel
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
			$appid = JCollectionHelper::getYahooAccessKey();
			if($search && $appid) {

				if($limitstart == 0) {
					$limitstart = 1;
				}
				$filter_country = $mainframe->getUserStateFromRequest( $option.'.filter_country_wsm', 'filter_country_wsm', $default_country, 'word' );

				switch( $filter_country )
				{
					case 'de':
						$base = 'http://de.music.yahooapis.com';
						break;
					case 'ca':
						$base = 'http://ca.music.yahooapis.com';
						break;
					case 'mx':
						$base = 'http://mx.music.yahooapis.com';
						break;
					case 'au':
						$base = 'http://au.music.yahooapis.com';
						break;
					case 'nz':
						$base = 'http://nz.music.yahooapis.com';
						break;
					case 'uk':
						$base = 'http://uk.music.yahooapis.com';
						break;
					case 'es':
						$base = 'http://es.music.yahooapis.com';
						break;
					case 'it':
						$base = 'http://it.music.yahooapis.com';
						break;
					case 'fr':
						$base = 'http://fr.music.yahooapis.com';
						break;
					case 'us':
					default:
						$base = 'http://us.music.yahooapis.com';
						$filter_country = 'us';
						break;
				}

				$base = $base.'/release/v1/list/search/all/'.urlencode( $search );
				$params = array(
					'appid' => $appid,
					'start' => strval( $limitstart ),
					'count' => strval( $limit )
				);

				$xmlstr = JCollectionHelper::callWebservice( $base, $params );

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );

				$doc = $xml->documentElement;

				$releaseels = $doc->getElementsByPath( 'Release' );
				$releaseels = $releaseels->toArray();
				$arr = array();
				foreach( $releaseels as $releaseel )
				{
					$newrow = new stdClass();
					$id = $releaseel->getAttribute( 'id' );
					$name = $releaseel->getAttribute( 'title' );
					$artistel = $releaseel->getElementsByPath( 'Artist', 1 );
					if( $artistel ) {
						$artist = $artistel->getAttribute( 'name' );
					} else {
						$artist = '';
					}
					$newrow->id = $filter_country.'_'.$id;
					$newrow->name = $name;
					$newrow->artist = $artist;
					$arr[] = $newrow;
				}
				$this->_data = $arr;
				$this->_total = (int)$doc->getAttribute( 'total' );
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
