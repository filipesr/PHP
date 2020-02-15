<?php
/**
 * JCollection Zanoxitems Model class
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
 * Zanoxitems Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelZanoxitems extends JModel
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
			$appid = JCollectionHelper::getZanoxAccessKey();
			if($search && $appid) {
				//$default_country = JCollectionHelper::getEBayDefaultCountry();
				//$filter_country = $mainframe->getUserStateFromRequest( $option.'.filter_country_wse', 'filter_country_wse', $default_country,'int' );

				$page = (int) $limitstart/20;

				$base = 'api.zanox.com/xml/products';
				$params = array(
				'applicationId' => $appid,
				'q' => $search,
				'items' => $limit,
				'page' => strval($page)
				);

				$xmlstr = JCollectionHelper::callWebservice( $base, $params );

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );

				$doc = $xml->documentElement;

				$products = $doc->getElementsByPath('productsResult/productItem');
				$products = $products->toArray();
				$arr = array();
				foreach( $products as $product )
				{
					$newrow = new stdClass();
					$id = $product->getAttribute('id');
					$newrow->id = $id;
					$nameel = $product->getElementsByPath('name', 1);
					if($nameel) {
						$name = $nameel->getText();
					} else {
						$name = $product->getText();
					}
					$newrow->name = $name;
					$descel = $product->getElementsByPath('description', 1);
					if($descel) {
						$desc = substr( $descel->getText(), 0, 50 );
					} else {
						$desc = "";
					}
					$newrow->desc = $desc;
					$manuel = $product->getElementsByPath('manufacturer', 1);
					if($manuel) {
						$manu = $manuel->getText();
					} else {
						$manu = "";
					}
					$newrow->manu = $manu;
					$progel = $product->getElementsByPath('program', 1);
					if($progel) {
						$prog = $progel->getText();
					} else {
						$prog = "";
					}
					$newrow->prog = $prog;
					$arr[] = $newrow;
				}
				$this->_data = $arr;
				$totalproducts = $doc->getElementsByPath('total',1);
				$this->_total = $totalproducts->getText();
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
