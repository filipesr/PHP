<?php
/**
 * JCollection Amazonitems Model class
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
 * Amazon Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelAmazonitems extends JModel
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
		//$limit = $mainframe->getUserStateFromRequest( $option.'.limit', 'limit', 0, 'int' );
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
			$page = (int) $limitstart/10 + 1;
			$this->_total = 0;
			$this->_data = array();
			$access_key = JCollectionHelper::getAmazonAccessKey();
			$default_country = JCollectionHelper::getAmazonDefaultCountry();
			if($search && $access_key) {
				$filter_searchindex = $mainframe->getUserStateFromRequest( $option.'.filter_searchindex_wsa', 'filter_searchindex_wsa', '','word' );
				if(!$filter_searchindex) {
					$filter_searchindex='Books';
				}
				$filter_country = $mainframe->getUserStateFromRequest( $option.'.filter_country_wsa', 'filter_country_wsa', $default_country, 'word' );

				switch($filter_country) {
					case 'de':
						$base = 'http://ecs.amazonaws.de/onca/xml';
						break;
					case 'uk':
						$base = 'http://ecs.amazonaws.co.uk/onca/xml';
						break;
					case 'fr':
						$base = 'http://ecs.amazonaws.fr/onca/xml';
						break;
					case 'jp':
						$base = 'http://ecs.amazonaws.co.jp/onca/xml';
						break;
					case 'ca':
						$base = 'http://ecs.amazonaws.ca/onca/xml';
						break;
					case 'us':
					default:
						$base = 'http://ecs.amazonaws.com/onca/xml';
						break;
				}

				$params = array(  'Service' => 'AWSECommerceService',
                     		'AWSAccessKeyId' => strval( $access_key ),
                        	'Operation' => 'ItemSearch',
							'SearchIndex' => strval( $filter_searchindex ),
							'ItemPage' => strval( $page ),
                        	'Keywords' => strval( $search ),
                        	'ResponseGroup' => 'Small' );
				$xmlstr = JCollectionHelper::callWebservice( $base, $params, true );

				$xml = &JFactory::getXMLParser( 'dom' );
				$domitResult = $xml->parseXML( $xmlstr );

				$doc = $xml->documentElement;

				$itemels = $doc->getElementsByPath('Items/Item');
				$itemels = $itemels->toArray();
				foreach( $itemels as $itemel )
				{
					$asinel = $itemel->getElementsByPath( 'ASIN', 1 );
					if( $asinel ) {
						$asin = $asinel->getText();
						$newrow = new stdClass();
						$newrow->id = $asin;
						$titleel = $itemel->getElementsByPath( 'ItemAttributes/Title', 1 );
						if( $titleel ) {
							$newrow->name = $titleel->getText();
						}
						$authorel = $itemel->getElementsByPath( 'ItemAttributes/Author', 1 );
						if( $authorel ) {
							$newrow->author = $authorel->getText();
						}
						$manuel = $itemel->getElementsByPath( 'ItemAttributes/Manufacturer', 1 );
						if( $manuel ) {
							$newrow->manu = $manuel->getText();
						}
						$this->_data[] = $newrow;
					}
				}
				$totalel = $doc->getElementsByPath('Items/TotalResults', 1 );
				if( $totalel ) {
					$this->_total = (int)$totalel->getText();
				}

				/*
				$xml = &JFactory::getXMLParser( 'simple' );
				$xml->loadString($xmlstr);
				$doc = $xml->document;

				if(key_exists('Items',$doc) ) {
					foreach ( $doc->Items[0]->children() as $child )
					{
						if ($child->name() == 'item' && key_exists( 'ASIN', $child ) )
						{
							$newrow = new stdClass();
							$newrow->id = $child->ASIN[0]->data();
							if( key_exists( 'ItemAttributes', $child ) )
							{
								if( key_exists( 'Title', $child->ItemAttributes[0] ) )
								{
									$newrow->name = $child->ItemAttributes[0]->Title[0]->data();
								} else {
									$newrow->name = JText::_("unknown");
								}
								if( key_exists('Author', $child->ItemAttributes[0]) )
								{
									$newrow->author = $child->ItemAttributes[0]->Author[0]->data();
								} else {
									$newrow->author = JText::_("unknown");
								}
							} else {
								$newrow->name = JText::_("unknown");
								$newrow->author = JText::_("unknown");
							}
							$this->_data[] = $newrow;
						}
					}
					if( key_exists('TotalResults',$doc->Items[0])) {
						$this->_total = $doc->Items[0]->TotalResults[0]->data();
					}
				}
				*/
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
