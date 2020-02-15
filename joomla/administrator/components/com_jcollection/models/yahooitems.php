<?php
/**
 * JCollection Yahooitems Model class
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
 * Yahooitems Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelYahooitems extends JModel
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
				$base = 'http://shopping.yahooapis.com/ShoppingService/V3/productSearch';
				$params = array(
					'appid' => $appid,
					'query' => $search,
					'results' => strval( $limit ),
					'start' => strval( $limitstart )
				);

				// Yahoo shopping webservice requires fake user agent string
				$xmlstr = JCollectionHelper::callWebservice( $base, $params, false, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.1) Gecko/20060111 Firefox/1.5.0.1' );
				//die(htmlspecialchars($xmlstr));

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );

				$doc = $xml->documentElement;

				$products = $doc->getElementsByPath( 'Products/Product' );
				$products = $products->toArray();
				$arr = array();
				foreach( $products as $product )
				{
					$newrow = new stdClass();
					$ptype = $product->getAttribute( 'type' );
					if( $ptype == "Offer" )
					{
						$offerel = $product->getElementsByPath( 'Offer', 1 );
						if( $offerel )
						{
							$id = 'O_'.$offerel->getAttribute( 'ID' );
							$newrow->id = $id;
							$nameel = $offerel->getElementsByPath( 'ProductName', 1 );
							if( $nameel ) {
								$name = $nameel->getText();
							} else {
								$name = $product->getText();
							}
							$newrow->name = $name;
							$descel = $offerel->getElementsByPath('Summary', 1);
							if( $descel ) {
								$desc = $descel->getText();
							} else {
								$desc = '';
							}
							$newrow->desc = $desc;
							$arr[] = $newrow;
						}
					} else if( $ptype == "Catalog" )
					{
						$catel = $product->getElementsByPath( 'Catalog', 1 );
						if( $catel )
						{
							$id = 'C_'.$catel->getAttribute( 'ID' );
							$newrow->id = $id;
							$nameel = $catel->getElementsByPath( 'ProductName', 1 );
							if( $nameel ) {
								$name = $nameel->getText().' (Catalog)';
							} else {
								$name = $product->getText();
							}
							$newrow->name = $name;
							$descel = $catel->getElementsByPath('Description', 1);
							if( $descel ) {
								$desc = $descel->getText();
							} else {
								$desc = '';
							}
							$newrow->desc = $desc;
							$arr[] = $newrow;
						}
					}
				}
				$this->_data = $arr;
				$products = $doc->getElementsByPath( 'Products', 1 );
				if( $products ) {
					$this->_total = $products->getAttribute( 'totalResultsAvailable' );
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
