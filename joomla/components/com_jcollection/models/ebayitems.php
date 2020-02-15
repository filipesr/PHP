<?php
/**
 * JCollection Ebayitems Model class
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
 * Ebayitems Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelEbayitems extends JModel
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
		$limit = 20;
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
			$search = $mainframe->getUserStateFromRequest( $option.'.search_wse', 'search_wse', '','string' );
			$search = JString::strtolower( $search );

			//$limit = $this->getState( 'limit' );
			$limit = 20;
			$limitstart = $this->getState( 'limitstart' );

			$this->_total = 0;
			$this->_data = array();
			$appid = JCollectionHelper::getEbayAccessKey();
			if($search && $appid) {
				$default_country = JCollectionHelper::getEBayDefaultCountry();
				$filter_country = $mainframe->getUserStateFromRequest( $option.'.filter_country_wse', 'filter_country_wse', $default_country,'int' );

				$page = (int) $limitstart/20 + 1;

				$base = 'http://open.api.ebay.com/shopping';
				$params = array(
				'callname' => 'FindProducts',
				'responseencoding' => 'XML',
				'appid' => $appid,
				'siteid' => strval((int)$filter_country),
				'version' => '581',
				'QueryKeywords' => $search,
				'MaxEntries' => '20',
				'PageNumber' => strval($page)
				);

				$xmlstr = JCollectionHelper::callWebservice( $base, $params );

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );

				$doc = $xml->documentElement;

				$products = $doc->getElementsByPath('Product');
				$products = $products->toArray();
				$arr = array();
				foreach( $products as $product )
				{
					$newrow = new stdClass();
					$idel = $product->getElementsByPath('ProductID',1);
					$newrow->id = strval((int)$filter_country).'_'.$idel->firstChild->nodeValue;
					$nameel = $product->getElementsByPath('Title',1);
					$newrow->name = $nameel->firstChild->nodeValue;
					$arr[] = $newrow;
				}
				$this->_data = $arr;
				$totalproducts = $doc->getElementsByPath('TotalProducts',1);
				$this->_total = $totalproducts->firstChild->nodeValue;
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
