<?php
/**
 * JCollection Wikipediaitems Model class
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
 * Wikipediaitems Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelWikipediaitems extends JModel
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
		$limit = 0;
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
			$limit = 0;
			$limitstart = $this->getState( 'limitstart' );

			$this->_total = 0;
			$this->_data = array();
			if($search) {
				$filter_country = $mainframe->getUserStateFromRequest( $option.'.filter_country', 'filter_country', 'en','word' );

				$base = 'http://'.$filter_country.'.wikipedia.org/w/api.php';
				$params = array( 'action' => 'opensearch',
					'search' => $search,
					'limit' => '100',
					'format' => 'xml' );

				$xmlstr = JCollectionHelper::callWebservice( $base, $params );

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );

				$doc = $xml->documentElement;

				$entryels = $doc->getElementsByPath('/SearchSuggestion/Section/Item');
				$entryels = $entryels->toArray();
				foreach( $entryels as $entryel ) {
					$newrow = new stdClass();
					$urlel = $entryel->getElementsByPath('Url', 1);
					if( $urlel ) {
						$url = $urlel->getText();
						$id = $url;
						$descel = $entryel->getElementsByPath('Description', 1);
						if( $descel ) {
							$desc = $descel->getText();
						} else {
							$desc = '';
						}
						$textel = $entryel->getElementsByPath('Text', 1);
						if( $textel ) {
							$text = $textel->getText();
						} else {
							$text = JText::_( 'unknown' );
						}
						$newrow->name = $text;
						$newrow->description = $desc;
						$newrow->id = $id;
						$this->_data[] = $newrow;
					}
				}
				$totalel = $doc->getElementsByPath( 'openSearchtotalResults', 1 );
				if($totalel) {
					$total = intval( $total->getText() );
				} else {
					$total = count($this->_data);
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
