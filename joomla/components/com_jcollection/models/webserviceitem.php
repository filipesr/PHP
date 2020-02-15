<?php
/**
 * JCollection Webserviceitem Model
 *
 * @version $Id$
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2008 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport('joomla.application.component.model');

/**
 * Collection Webserviceitem Model
 *
 */
class JCollectionModelWebserviceitem extends JModel
{
	/**
	 * The current item id
	 * @var int
	 */
	var $_id = null;

	/**
	 * The data (i.e. item row plus corresponsing rating and info field(s)
	 * @var object
	 */
	var $_data = null;

	var $_imdbphp = null;

	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid', array(0), '', 'array');
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the hello identifier
	 *
	 * @access	public
	 * @param	int Hello identifier
	 * @return	void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id = $id;
		$this->_data = null;
	}

	function findId( $infoid, $ws_id, $webservice, $typeid )
	{
		$query = "SELECT * FROM #__"._JC_DB."_webserviceitem "
		."\n WHERE ws_id=".$this->_db->Quote( $ws_id )." AND infoid=".(int)$infoid." AND webservice=".$this->_db->Quote( $webservice );
		$this->_db->setQuery( $query );
		$this->_data = $this->_db->loadObject();
		$datenow = &JFactory::getDate();
		$acttime = $datenow->toUnix();
		$refresh = false;
		if( isset( $this->_data->updated ) ) {
			$up = new JDate( $this->_data->updated );
			$diff = $acttime - $up->toUnix();
			if( isset( $this->_data->expires ) ) {
				$expires = (int)$this->_data->expires * 60;
			} else {
				$expires = 3600;
			}
			if( ( $expires >= 0 ) && ( $diff > $expires ) ) {
				$refresh = true;
			}
		}
		if( empty( $this->_data ) || $refresh ) {
			if(!$this->_data) {
				$this->_data = new stdClass();
				$this->_data->id = 0;
				$this->_data->ws_id = strval($ws_id);
				$this->_data->infoid = (int)$infoid;
				$this->_data->webservice = strval($webservice);
				$this->_data->xml = '';
				$this->_data->xmlobj = null;
				$this->_data->params = null;
				$this->_data->expires = null;
				$this->_data->updated = null;
				$this->_data->additional_fields = array();
				$this->_data->offers_sets = array();
				$this->_data->similar_items_sets = array();
				$this->_data->reviews_sets = array();
				$this->_data->disclaimer = array();
				$this->_data->errors = array();
			}
			$datenow = &JFactory::getDate();
			switch ( $webservice )
			{
				case 'amazon':
					$access_key = JCollectionHelper::getAmazonAccessKey();
					$country = substr( $ws_id, 0, 2 );
					$asin = substr( $ws_id, 3 );
					$associate_tag = JCollectionHelper::getAmazonAssociateTag( $country );
					switch( $country ) {
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
					if( $associate_tag ) {
						$params = array( 'Service' => 'AWSECommerceService',
                     		'AWSAccessKeyId' => strval($access_key),
                        	'Operation' => 'ItemLookup',
                        	'ItemId' => strval($asin),
                        	'ResponseGroup' => 'Large',
							'AssociateTag' => strval( $associate_tag )
						);
					} else {
						$params = array( 'Service' => 'AWSECommerceService',
                     		'AWSAccessKeyId' => strval($access_key),
                        	'Operation' => 'ItemLookup',
                        	'ItemId' => strval($asin),
                        	'ResponseGroup' => 'Large'
                        	);
					}
					$xmlstr = JCollectionHelper::callWebservice( $base, $params );
					$xml = &JFactory::getXMLParser( 'dom' );
					$domitResult = $xml->parseXML( $xmlstr );
					if($domitResult) {
						$isvalid = $xml->documentElement->getElementsByPath( 'Items/Request/IsValid', 1 );
						if( $isvalid ) {
							$isvalid = $isvalid->getText();
							if( $isvalid == "True" ) {
								$this->_data->xml = $xmlstr;
								$this->_data->xmlobj = $xml;
								$this->_data->updated = $datenow->toMySQL();
								$this->_data->expires = 60; // one hour
							}
						}
					}
					break;

				case 'googlebook':
					$base = 'http://books.google.com/books/feeds/volumes/'.$ws_id;
					$params = array();
					$xmlstr = JCollectionHelper::callWebservice($base, $params);
					$xml = &JFactory::getXMLParser( 'dom' );
					$domitResult = $xml->parseXML($xmlstr);
					if($domitResult) {
						$this->_data->xmlobj = $xml;
						$this->_data->xml = $xmlstr;
						$this->_data->updated = $datenow->toMySQL();
						$this->_data->expires = 60*24; // one day
					}
					break;

				case 'wikipedia':
					$xmlstr = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
					$xmlstr .= '<document>';
					$xmlstr .= '<url>'.$ws_id.'</url>';
					$xmlstr .= '</document>';
					$xml = &JFactory::getXMLParser( 'dom' );
					$domitResult = $xml->parseXML($xmlstr);
					if($domitResult) {
						$this->_data->xmlobj = $xml;
						$this->_data->xml = $xmlstr;
						$this->_data->updated = $datenow->toMySQL();
						$this->_data->expires = -1; // never expires
					}
					break;
				case 'isbndb':
					$access_key = JCollectionHelper::getISBNdbAccessKey();
					$base = 'https://isbndb.com/api/books.xml';
					$params = array(
					'access_key' => $access_key,
					'index1' => 'isbn',
					'value1' => strval($ws_id) );
					$xmlstr = JCollectionHelper::callWebservice( $base, $params );
					$xml = &JFactory::getXMLParser( 'dom' );
					$domitResult = $xml->parseXML($xmlstr);
					if($domitResult) {
						$this->_data->xmlobj = $xml;
						$this->_data->xml = $xmlstr;
						$this->_data->updated = $datenow->toMySQL();
						$this->_data->expires = 24*60*30; // one month
					}
					break;

				case 'imdb':
					// check for imdbphp in /administrator/components/com_jcollection/imdbphp
					define('_JC_IMDBPHP_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection'.DS.'imdbphp');
					if( file_exists(_JC_IMDBPHP_PATH.DS.'imdb_base.class.php')) {
						require_once (_JC_IMDBPHP_PATH.DS.'imdb_base.class.php');
						require_once (_JC_IMDBPHP_PATH.DS.'imdb.class.php');
						$search = new imdbsearch();
						$this->_imdbphp = true;
						$imdb = new imdb($ws_id);
						$xmlstr = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
						$xmlstr .= '<document>';
						$url = utf8_encode( 'http://'.$search->imdbsite."/title/tt".$imdb->imdbid() );
						$xmlstr .= '<url><![CDATA['.$url.']]></url>';
						$title = utf8_encode( $imdb->title() );
						$xmlstr .= '<title><![CDATA['.$title.']]></title>';
						$year = utf8_encode( $imdb->year() );
						$xmlstr .= '<year><![CDATA['.$year.']]></year>';
						$xmlstr .= '<cast>';
						$cast = $imdb->cast();
						foreach ( $cast as $actor ) {
							$xmlstr .= '<actor>';
							$xmlstr .= '<name><![CDATA['.utf8_encode( $actor['name'] ).']]></name>';
							$xmlstr .= '<role><![CDATA['.utf8_encode( $actor['role'] ).']]></role>';
							$xmlstr .= '<id><![CDATA['.utf8_encode( $actor['imdb'] ).']]></id>';
							$xmlstr .= '<namerole><![CDATA['.utf8_encode( $actor['name'] ).' ('.utf8_encode( $actor['role'] ).')]]></namerole>';
							$xmlstr .= '</actor>';
						}
						$xmlstr .= '</cast>';
						$xmlstr .= '<directors>';
						$directors = $imdb->director();
						foreach ( $directors as $director ) {
							$xmlstr .= '<director>';
							$xmlstr .= '<name><![CDATA['.utf8_encode( $director['name'] ).']]></name>';
							$xmlstr .= '<role><![CDATA['.utf8_encode( $director['role'] ).']]></role>';
							$xmlstr .= '<id><![CDATA['.utf8_encode( $director['imdb'] ).']]></id>';
							$xmlstr .= '<namerole><![CDATA['.utf8_encode( $director['name'] ).' ('.utf8_encode( $director['role'] ).')]]></namerole>';
							$xmlstr .= '</director>';
						}
						$xmlstr .= '</directors>';
						$xmlstr .= '<producers>';
						$producers = $imdb->producer();
						foreach ( $producers as $producer ) {
							$xmlstr .= '<producer>';
							$xmlstr .= '<name><![CDATA['.utf8_encode( $producer['name'] ).']]></name>';
							$xmlstr .= '<role><![CDATA['.utf8_encode( $producer['role'] ).']]></role>';
							$xmlstr .= '<id><![CDATA['.utf8_encode( $producer['imdb'] ).']]></id>';
							$xmlstr .= '<namerole><![CDATA['.utf8_encode( $producer['name'] ).' ('.utf8_encode( $producer['role'] ).')]]></namerole>';
							$xmlstr .= '</producer>';
						}
						$xmlstr .= '</producers>';
						$synopsis = utf8_encode( $imdb->synopsis() );
						$xmlstr .= '<synopsis><![CDATA['.$synopsis.']]></synopsis>';
						$tagline = utf8_encode( $imdb->tagline() );
						$xmlstr .= '<tagline><![CDATA['.$tagline.']]></tagline>';
						$photo = utf8_encode( $imdb->photo() );
						$xmlstr .= '<photo><![CDATA['.$photo.']]></photo>';
						$photo_local = $imdb->photo_localurl( true );
						if($photo_local) {
							$photo_local = utf8_encode( $photo_local );
							$xmlstr .= '<photolocal><![CDATA['.$photo_local.']]></photolocal>';
						}
						$xmlstr .= '</document>';

						$xml = &JFactory::getXMLParser( 'dom' );
						$domitResult = $xml->parseXML($xmlstr);
						if($domitResult) {
							$this->_data->xml = $xmlstr;
							$this->_data->xmlobj = $xml;
							$this->_data->updated = $datenow->toMySQL();
							$this->_data->expires = 24*60; // one day
						}
					} else {
						$this->_imdbphp = false;
					}
					break;

				case 'yahoomap':
					$pos = explode(',',$ws_id);
					$lat = $pos[0];
					$lon = $pos[1];
					$access_key = JCollectionHelper::getYahooAccessKey();
					$base = 'http://local.yahooapis.com/MapsService/V1/mapImage';
					$params = array(
						'appid' => $access_key,
						'latitude' => $lat,
						'longitude' => $lon,
						'zoom' => '2'
					);
					$xmlstr = JCollectionHelper::callWebservice($base, $params);

					$xml = &JFactory::getXMLParser( 'dom' );
					$domitResult = $xml->parseXML($xmlstr);
					if($domitResult) {
						$xmlstr = $xml->getText();
						// Yahoo delivers "raw" XML data for the image URL
						$xmlstr = '<Document><Url>'.$xmlstr.'</Url></Document>';
						$this->_data->xml = $xmlstr;
						$xml = &JFactory::getXMLParser( 'dom' );
						$domitResult = $xml->parseXML( $xmlstr );
						if($domitResult) {
							$this->_data->xmlobj = $xml;
							$this->_data->updated = $datenow->toMySQL();
							$this->_data->expires = 24*60*30; // one moth
						}
					}
					break;
				case 'ebay':
					$appid = JCollectionHelper::getEbayAccessKey();
					$country = substr($ws_id,0,strpos($ws_id,'_'));
					$productid = substr($ws_id,strpos($ws_id,'_')+1);
					$base = 'http://open.api.ebay.com/shopping';
					$params = array(
						'callname' => 'FindProducts',
						'responseencoding' => 'XML',
						'appid' => $appid,
						'siteid' => strval((int)$country),
						'version' => '581',
						'ProductID.type' => 'Reference',
						'ProductID.Value' => strval($productid),
						'HideDuplicateItems' => 'true',
						'IncludeSelector' => 'Details,Items',
						'MaxEntries' => '20'
						);

					$xmlstr = JCollectionHelper::callWebservice($base, $params);
					$xml = &JFactory::getXMLParser( 'dom' );
					$domitResult = $xml->parseXML($xmlstr);
					$this->_data->xmlobj = $xml;
					if($domitResult) {
						$isvalid = $xml->documentElement->getElementsByPath('Ack', 1);
						if($isvalid) {
							$isvalid = $isvalid->getText();
							if($isvalid == "Success") {
								$this->_data->xml = $xmlstr;
								$this->_data->xmlobj = $xml;
								$this->_data->updated = $datenow->toMySQL();
								$this->_data->expires = 30; // half an hour
							}
						}
					}
					break;
				case 'zanox':
					$appid = JCollectionHelper::getZanoxAccessKey();
					$base = 'http://api.zanox.com/xml/products/product/'.$ws_id;
					$params = array(
						'applicationId' => $appid
					);

					$xmlstr = JCollectionHelper::callWebservice($base, $params);
					$xml = &JFactory::getXMLParser( 'dom' );
					$domitResult = $xml->parseXML($xmlstr);
					$this->_data->xmlobj = $xml;
					if($domitResult) {
						$doc = $xml->documentElement;
						if( $doc->nodeName == "error" ) {
							$newerror = new stdClass();
							$newerror->code = '0';
							$newerror->message = 'Zanox webservice error';
							$errcodeel = $doc->getElementsByPath( 'code', 1 );
							if( $errcodeel ) {
								$newerror->code = $errcodeel->getText();
							}
							$errmessel = $doc->getElementsByPath( 'message', 1 );
							if( $errmessel ) {
								$newerror->message = $errcodeel->getText();
							}
							$this->_data->errors[] = $newerror;
						} else {
							$this->_data->xml = $xmlstr;
							$this->_data->xmlobj = $xml;
							$this->_data->updated = $datenow->toMySQL();
							$this->_data->expires = 60*24; // one day
						}
					}
					break;

				case 'googlemap':
					$pos = explode(',',$ws_id);
					$lat = $pos[0];
					$lon = $pos[1];
					$access_key = JCollectionHelper::getGoogleAccessKey();
					if( $access_key )
					{
						$base = 'http://maps.google.com/staticmap';
						$params = array(
							'size' => '512x512',
							'center' => strval( $ws_id ),
							'markers' => strval( $ws_id ),
							'key' => strval( $access_key )
						);
						$query_string = '';
						foreach ($params as $key => $value) {
							$query_string .= "&$key=".urlencode($value);
						}
						// delete the first &
						$query_string = substr($query_string, 1);
						$url = "$base?$query_string";
						$xmlstr = '<Document><Url>'.$url.'</Url></Document>';
						$this->_data->xml = $xmlstr;
						$xml = &JFactory::getXMLParser( 'dom' );
						$domitResult = $xml->parseXML( $xmlstr );
						if($domitResult) {
							$this->_data->xmlobj = $xml;
							$this->_data->updated = $datenow->toMySQL();
							$this->_data->expires = 24*60*30; // one month
						}
					}
					break;
				case 'yahoomusic':
					$appid = JCollectionHelper::getYahooAccessKey();
					if( $appid )
					{
						$country = substr($ws_id,0,2);
						$musicid = substr($ws_id,3);
						switch($country)
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

						$base = $base.'/release/v1/item/'.$musicid;
						$params = array(
							'appid' => strval( $appid )
						);

						$xmlstr = JCollectionHelper::callWebservice( $base, $params );
						$xml = &JFactory::getXMLParser( 'dom' );
						$domitResult = $xml->parseXML( $xmlstr );
						if( $domitResult ) {
							$this->_data->xml = $xmlstr;
							$this->_data->xmlobj = $xml;
							$this->_data->updated = $datenow->toMySQL();
							$this->_data->expires = 60*24; // one day
						}
					}
					break;
				case 'yahoo':
					$appid = JCollectionHelper::getYahooAccessKey();
					if( $appid )
					{
						$ptype = substr($ws_id,0,1);
						$pid = substr($ws_id,2);
						$base = 'http://shopping.yahooapis.com/ShoppingService/V2/catalogListing';
						if( $ptype == 'C' )
						{ // Catalog
							$params = array(
							'appid' => strval( $appid ),
							'catalogid' => strval( $pid ),
							'getreview' => '1',
							'getspec' => '1'
							);
						} else if( $ptype == 'O' )
						{ // Offer
							$params = array(
							'appid' => strval( $appid ),
							'idtype' => 'upc',
							'idvalue' => strval( $pid ),
							'getreview' => '1',
							'getspec' => '1'
							);
						}
						if( count( $params ) )
						{
							$xmlstr = JCollectionHelper::callWebservice( $base, $params, false, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.1) Gecko/20060111 Firefox/1.5.0.1' );
							$xml = &JFactory::getXMLParser( 'dom' );
							$domitResult = $xml->parseXML( $xmlstr );
							if( $domitResult ) {
								$this->_data->xml = $xmlstr;
								$this->_data->xmlobj = $xml;
								$this->_data->updated = $datenow->toMySQL();
								$this->_data->expires = 60; // one hour
							}
						}
					}
					break;
				case 'lastfm':
					$access_key = JCollectionHelper::getLastfmAccessKey();
					if( $access_key )
					{
						$ids = explode( '{,}', $ws_id );
						$base = 'http://ws.audioscrobbler.com/2.0/';
						$params = array(
							'method' => 'album.getInfo',
							'album' => $ids[0],
							'artist' => $ids[1],
							'api_key' => $access_key
						);
						$xmlstr = JCollectionHelper::callWebservice( $base, $params );
						$xml = &JFactory::getXMLParser( 'dom' );
						$domitResult = $xml->parseXML( $xmlstr );
						if( $domitResult ) {
							$doc = $xml->documentElement;
							$status = $doc->getAttribute( 'status' );
							if( $status == 'ok' )
							{
								$this->_data->xml = $xmlstr;
								$this->_data->xmlobj = $xml;
								$this->_data->updated = $datenow->toMySQL();
								$this->_data->expires = 24*60*30; // one month
							}
						}
					}
					break;
			}
			$data = array();
			$data['id'] = $this->_data->id;
			$data['ws_id'] = $this->_data->ws_id;
			$data['infoid'] = $this->_data->infoid;
			$data['webservice'] = $this->_data->webservice;
			$data['xml'] = $this->_data->xml;
			$data['updated'] = $this->_data->updated;
			$data['expires'] = $this->_data->expires;
			$this->store( $data );
		} else {
			$xml = &JFactory::getXMLParser( 'dom' );
			$domitResult = $xml->parseXML($this->_data->xml);
			if($domitResult) {
				$this->_data->xmlobj = $xml;
			}
		}
		$this->evaluateInfos( $typeid );

		return $this->_data;
	}

	/**
	 * Iterate through a XPath definition
	 * (recursive function)
	 * Implements a small subset of the proper XPath definition:
	 * node1/node2 -> collect all data values of the form /node1/node2
	 * @attr -> get attribute named attr
	 *
	 * Examples:
	 * <cast><actor><name>Name1</name></actor><actor><name>Name2></name></actor></cast>
	 * XPath: cast/actor/name collects Name1, Name2
	 *
	 * <link rel="http://xyz" href="http://abc">
	 * XPath: link[@rel="http://xyz"]/@href gives http://abc
	 *
	 * <namevaluepairs><name>name1</name><value>value1</value><value>value2</value><name>name2</name><value>value3</value></namevaluepairs>
	 * XPAth: /namevaluepairs[name=name1]/value gives (value1, value2)
	 *
	 */
	function iterateXPath( $xpath, $element, &$arr )
	{
		// implement a subset of XPath
		$actel = '';
		$xpathelement = '';
		$nextxpath = '';
		$k = 0;
		$j = 0;
		$l = 0;
		for($i = 0; $i<strlen($xpath);$i++) {
			$actchar = substr($xpath,$i,1);
			if($actchar == '"') {
				$k = 1-$k;
			}
			if($actchar == "'") {
				$j = 1-$j;
			}
			if($actchar == '[') {
				$l++;
			}
			if($actchar == ']') {
				$l--;
			}
			if($actchar == '/' && $k == 0 && $j == 0) {
				$nextxpath = substr($xpath,$i+1);
				break;
			} else {
				$actel .= $actchar;
			}
		}
		$xpathelement = $actel;

		// check if particular attribute value is requested
		$cond = '';
		if(strpos($xpathelement,'['))
		{
			$l = strpos($xpathelement,'[');
			$cond = substr($xpathelement,$l+1,strpos($xpathelement,']')-$l-1);
			$xpathelement = substr($xpathelement,0,$l);
		}
		$attr = '';
		$attrval = '';
		$nodecond = '';
		$nodeval = '';
		if( strpos( $cond, '@' ) === 0 )
		{
			$attr = substr($cond,1);
			$p = strpos($attr,'=');
			if($p) {
				$attrval = substr($attr,$p+1);
				$attr = substr($attr,0,$p);
				if(strpos($attrval,'"')===0 || strpos($attrval,"'")===0) {
					$attrval = substr($attrval,1,strlen($attrval)-2);
				}
			}
		} else if( !is_numeric( $cond ) ) {
			$p = strpos( $cond,  '=' );
			if( $p ) {
				$nodeval = substr($cond,$p+1);
				$nodecond = substr($cond,0,$p);
				if(strpos($nodeval,'"')===0 || strpos($nodeval,"'")===0) {
					$nodeval = substr($nodeval,1,strlen($nodeval)-2);
				}
			}
		}

		if( $nextxpath ) {
			if( $element->getElementsByPath( $xpathelement,1 ) )
			{
				if( !$cond ) {
					$elements = $element->getElementsByPath( $xpathelement );
					$elements = $elements->toArray();
				} else {
					if ( !$attr ) {
						if( !$nodecond ) {
							$elements = array( $element->getElementsByPath( $xpathelement,(int)$cond) );
						} else {
							$els = $element->getElementsByPath( $xpathelement.'/'.$nodecond );
							$els = $els->toArray();
							$elements = array();
							foreach($els as $e) {
								if($e->getText() == $nodeval) {
									$elements[] = $e->parentNode;
								}
							}
						}
					} else {
						if ( !$attrval ) {
							$els = $element->getElementsByPath( $xpathelement );
							$els = $els->toArray();
							$elements = array();
							foreach($els as $e) {
								if($e->getAttribute($attr)) {
									$elements[] = $e;
								}
							}
						} else {
							$els = $element->getElementsByPath( $xpathelement );
							$els = $els->toArray();
							$elements = array();
							foreach($els as $e) {
								if($e->getAttribute( $attr ) == $attrval) {
									$elements[] = $e;
								}
							}
						}
					}
				}
				foreach( $elements as $nextelement )
				{
					$this->iterateXPath( $nextxpath, $nextelement, $arr );
				}
			}
		} else {
			if(strpos($xpathelement,'@')===0) {
				$attr = substr($xpathelement,1);
				$arr[] = $element->getAttribute( $attr );
			} else {
				if( $element->getElementsByPath( $xpathelement, 1 ) )
				{
					$els = $element->getElementsByPath( $xpathelement );
					$els = $els->toArray();
					if( $attr && $attrval )
					{
						foreach($els as $el) {
							if( $el->getAttribute( $attr ) == $attrval ) {
								$arr[] = $el->getText();
							}
						}
					} else {
						if( $cond ) {
							$el = $element->getElementsByPath( $xpathelement,(int)$cond );
							if( $el ) {
								$arr[] = $el->getText();
							}
						} else {
							foreach($els as $el) {
								$arr[] = $el->getText();
							}
						}
					}
				}
			}
		}
	}

	function evaluateInfos( $typeid )
	{
		if($this->_data) {
			$webservice = $this->_data->webservice;
			$xmlobj = $this->_data->xmlobj;
			if($xmlobj) {
				$doc = $xmlobj->documentElement;
				$query = '';
				$query_fallback = '';
				switch($webservice) {
					case 'amazon':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Books' AND webservice='amazon'";
						$query_fallback = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Books' AND webservice='amazon'";
						$pg = $doc->getElementsByPath( 'Items/Item/ItemAttributes/ProductGroup', 1 );
						if($pg) {
							$pg = $this->_db->Quote( $pg->getText() );
							$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
							." WHERE name=".$pg." AND webservice='amazon'";
						}
						break;
					case 'googlebook':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Book' AND webservice='googlebook'";
						break;
					case 'isbndb':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Book' AND webservice='isbndb'";
						break;
					case 'imdb':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Movie' AND webservice='imdb'";
						break;
					case 'yahoomap':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Map' AND webservice='yahoomap'";
						break;
					case 'ebay':
						$query_fallback = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Item' AND webservice='ebay'";
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Item' AND webservice='ebay'";
						if($typeid) {
							$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
							." WHERE typeid=".(int)$typeid." AND webservice='ebay'";
						}
						break;
					case 'wikipedia':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='URL' AND webservice='wikipedia'";
						break;
					case 'zanox':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Item' AND webservice='zanox'";
						break;
					case 'googlemap':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Map' AND webservice='googlemap'";
						break;
					case 'yahoomusic':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Music' AND webservice='yahoomusic'";
						break;
					case 'yahoo':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Catalog' AND webservice='yahoo'";
						break;
					case 'lastfm':
						$query = "SELECT * FROM #__"._JC_DB."_webservicetype "
						." WHERE name='Album' AND webservice='lastfm'";
						break;
				}
				if($query) {
					$this->_db->setQuery( $query );
					$ws_type = $this->_db->loadObject();
					if(!$ws_type && $query_fallback) {
						$this->_db->setQuery( $query_fallback );
						$ws_type = $this->_db->loadObject();
					}
					if($ws_type) {
						$infonames = array();
						for($i = 1; $i<=10; $i++) {
							$infonames[] = 'info'.$i;
						}
						$infonames[] = 'title';
						$infonames[] = 'description';
						$infonames[] = 'img';
						$infonames[] = 'url';

						foreach ($infonames as $infoname) {
							$xpathname = $infoname.'xpath';
							$xpaths = explode(',',$ws_type->$xpathname);
							// iterate through the alternative xpaths (break if field is filled)
							foreach($xpaths as $xpath) {
								// clear the result
								$arr = array();
								// set current element
								$element = $doc;
								// iterate through all the possible xpath routes
								if(substr($xpath,0,1)=='/' && strpos(substr($xpath,1),'/')) { // absolute path - remove first node
									$xpath = substr($xpath,strpos(substr($xpath,1),'/')+2);
								}
								$this->iterateXPath($xpath,$element,$arr);
								if(count($arr)) {
									$this->_data->$infoname = implode(', ',$arr);
									break;
								}
							}
						}
						$newentry = new stdClass();
						$newentry->text = $ws_type->disclaimer;
						$this->_data->disclaimer[] = $newentry;

						/* create additional fields, offers, similar items
						 *  depending on the used webservice
						 *
						 * */
						switch($webservice)
						{
							case 'amazon':
								$xpath = 'Items/Item/SimilarProducts/SimilarProduct';
								$arr_list = $doc->getElementsByPath($xpath);
								$arr_list = $arr_list->toArray();
								$country = substr($this->_data->ws_id,0,2);
								$newset = new stdClass();
								$newset->source = "Amazon";
								$newset->similar_items = array();
								foreach($arr_list as $pairel) {
									$newentry = new stdClass();
									$titleel = $pairel->getElementsByPath('Title',1);
									$title = $titleel->getText();
									$asinel = $pairel->getElementsByPath('ASIN',1);
									$asin = $asinel->getText();
									$newentry->title = $title;
									switch($country) {
										case 'de':
											$newentry->url = 'http://amazon.de/dp/'.$asin.'?tag=ws';
											break;
										case 'uk':
											$newentry->url = 'http://amazon.co.uk/dp/'.$asin.'?tag=ws';
											break;
										case 'fr':
											$newentry->url = 'http://amazon.fr/dp/'.$asin.'?tag=ws';
											break;
										case 'jp':
											$newentry->url = 'http://amazon.co.jp/dp/'.$asin.'?tag=ws';
											break;
										case 'ca':
											$newentry->url = 'http://amazon.ca/dp/'.$asin.'?tag=ws';
											break;
										case 'us':
										default:
											$newentry->url = 'http://amazon.com/dp/'.$asin.'?tag=ws';
											break;
									}
									$newset->similar_items[] = $newentry;
								}
								$this->_data->similar_items_sets[] = $newset;

								$newset = new stdClass();
								$newset->source = "Amazon";
								$newset->offers = array();
								$xpath = 'Items/Item/DetailPageURL';
								$url = '';
								$urlel = $doc->getElementsByPath($xpath, 1);
								if($urlel) {
									$url = $urlel->getText();
								}
								$xpath = 'Items/Item/Offers/Offer';
								$arr_list = $doc->getElementsByPath($xpath);
								$arr_list = $arr_list->toArray();
								foreach($arr_list as $pairel) {
									$newentry = new stdClass();
									$condel = $pairel->getElementsByPath('OfferAttributes/Condition',1);
									$cond = $condel->getText();
									$title = $this->_data->title;
									$priceel = $pairel->getElementsByPath('OfferListing/Price/FormattedPrice',1);
									$price = $priceel->getText();
									$newentry->title = $title;
									$newentry->condition = $cond;
									$newentry->price = $price;
									$newentry->url = $url;
									$newset->offers[] = $newentry;
								}
								$this->_data->offers_sets[] = $newset;

								$newset = new stdClass();
								$newset->source = "Amazon Editorial Reviews";
								$newset->reviews = array();
								$xpath = 'Items/Item/EditorialReviews/Review';
								$arr_list = $doc->getElementsByPath( $xpath );
								$arr_list = $arr_list->toArray();
								foreach($arr_list as $pairel) {
									$newentry = new stdClass();
									$sumel = $pairel->getElementsByPath('Summary',1);
									$sum = $sumel->getText();
									$revel = $pairel->getElementsByPath('Content',1);
									$rev = $revel->getText();
									$dateel = $pairel->getElementsByPath('Date',1);
									$date = $dateel->getText();
									$ratel = $pairel->getElementsByPath('Rating',1);
									$rat = $ratel->getText();
									$newentry->title = $sum;
									$newentry->review = $rev;
									$newentry->date = $date;
									$newentry->rating = $rat;
									$newset->reviews[] = $newentry;
								}
								$this->_data->reviews_sets[] = $newset;

								$newset = new stdClass();
								$newset->source = "Amazon Customer Reviews";
								$newset->reviews = array();
								$xpath = 'Items/Item/CustomerReviews/Review';
								$arr_list = $doc->getElementsByPath($xpath);
								$arr_list = $arr_list->toArray();
								foreach($arr_list as $pairel) {
									$newentry = new stdClass();
									$sumel = $pairel->getElementsByPath('Summary',1);
									$sum = $sumel->getText();
									$revel = $pairel->getElementsByPath('Content',1);
									$rev = $revel->getText();
									$dateel = $pairel->getElementsByPath('Date',1);
									$date = $dateel->getText();
									$ratel = $pairel->getElementsByPath('Rating',1);
									$rat = $ratel->getText();
									$newentry->title = $sum;
									$newentry->review = $rev;
									$newentry->date = $date;
									$newentry->rating = $rat;
									$newset->reviews[] = $newentry;
								}
								$this->_data->reviews_sets[] = $newset;
							break;
							case 'googlebook':
							break;
							case 'isbndb':
							break;
							case 'imdb':
							break;
							case 'yahoomap':
							break;
							case 'ebay':
								$newset = new stdClass();
								$newset->source = "eBay";
								$newset->additional_fields = array();
								$xpath = 'Product/ItemSpecifics/NameValueList';
								$arr_list = $doc->getElementsByPath($xpath);
								$arr_list = $arr_list->toArray();
								foreach($arr_list as $pairel)
								{
									$nameel = $pairel->getElementsByPath('Name',1);
									$name = $nameel->getText();
									$valueels = $pairel->getElementsByPath('Value');
									$valueels = $valueels->toArray();
									$arr_value = array();
									foreach($valueels as $valueel)
									{
										$arr_value[] = $valueel->getText();
									}
									$value = implode(', ', $arr_value);
									$newentry = new stdClass();
									$newentry->name = $name;
									$newentry->value = $value;
									$newset->additional_fields[] = $newentry;
								}
								$this->_data->additional_fields_sets[] = $newset;

								$newset = new stdClass();
								$newset->source = "eBay";
								$newset->offers = array();
								$xpath = 'ItemArray/Item';
								$arr_list = $doc->getElementsByPath($xpath);
								$arr_list = $arr_list->toArray();
								foreach($arr_list as $pairel) {
									$activeel = $pairel->getElementsByPath('ListingStatus',1);
									if($activeel && $activeel->getText() == 'Active') {
										$newentry = new stdClass();
										$titleel = $pairel->getElementsByPath('Title',1);
										$title = $titleel->getText();
										$priceel = $pairel->getElementsByPath('CurrentPrice',1);
										$price = $priceel->getText();
										$cur = $priceel->getAttribute('currencyID');
										$urlel = $pairel->getElementsByPath('ViewItemURLForNaturalSearch',1);
										if($urlel) {
											$url = $urlel->getText();
										}
										$expel = $pairel->getElementsByPath('EndTime',1);
										if($expel) {
											$expires = new JDate( $expel->getText() );
											$expires = $expires->toFormat();
										}
										$newentry->title = $title;
										$newentry->price = $price." ".$cur;
										$newentry->url = $url;
										$newentry->expires = $expires;
										$newset->offers[] = $newentry;
									}
								}
								$this->_data->offers_sets[] = $newset;
							break;
							case 'zanox':
								$newset = new stdClass();
								$newset->source = "Zanox";
								$newset->offers = array();
								$xpath = 'productsResult/productItem';
								$offel = $doc->getElementsByPath($xpath, 1);
								if($offel) {
									$titleel = $offel->getElementsByPath('name', 1);
									$title = $titleel->getText();
									$priceel = $offel->getElementsByPath('price', 1);
									$price = $priceel->getText();
									$currencyel = $offel->getElementsByPath('currency', 1);
									$currency = $currencyel->getText();
									$progel = $offel->getElementsByPath('program', 1);
									if($progel) {
										$prog = $progel->getText();
										$newset->source .= ' - '.$prog;
									}
									$updatedel = $offel->getElementsByPath('modified', 1);
									if($updatedel) {
										$updated = new JDate( $updatedel->getText() );
										$updated = $updated->toFormat();
									}
									$urlels = $offel->getElementsByPath('url');
									$urlels = $urlels->toArray();
									foreach($urlels as $urlel) {
										$adel = $urlel->getElementsByPath('adspace',1);
										if($adel) {
											$url = $adel->getText();
											$newentry->title = $title;
											$newentry->price = $price." ".$currency;
											$newentry->url = $url;
											$newentry->updated = $updated;
											$newset->offers[] = $newentry;
										}
									}
									$this->_data->offers_sets[] = $newset;
								}
							break;
							case 'googlemap':
							break;
							case 'yahoomusic':
							break;
							case 'yahoo':
								$newset = new stdClass();
								$newset->source = "Yahoo";
								$newset->offers = array();
								$xpath = 'Catalog/Offers/Offer';
								$offerels = $doc->getElementsByPath( $xpath );
								$offerels = $offerels->toArray();
								foreach( $offerels as $offerel )
								{
									$nameel = $offerel->getElementsByPath( 'DisplayMerchant', 1 );
									if( $nameel ) {
										$newoffer = new stdClass();

										$newoffer->title = $nameel->getText();
										$urlel = $offerel->getElementsByPath( 'Url', 1 );
										if( $urlel ) {
											$newoffer->url = $urlel->getText();
										} else {
											$newoffer->url = '';
										}
										$priceel = $offerel->getElementsByPath( 'Price', 1 );
										if( $priceel ) {
											$newoffer->price = $priceel->getText();
										} else {
											$newoffer->price = '';
										}

										$newset->offers[] = $newoffer;
									}
								}
								$this->_data->offers_sets[] = $newset;
							break;
						}
					}
				}
			}
		}
	}


	/**
	 * Method to get an item
	 * @return object with data
	 */
	function &getData()
	{
		/*
		 // Load the data
		 //echo "Load data...";
		 if (empty( $this->_data )) {
		 //echo "data empty...";
		 //echo " this id: ".$this->_id;
		 //echo " getState id:".$this->getState('id');
		 //			$row = & $this->getTable( 'item','Table');
		 //			if( $id = $this->getState('id') ) {
		 //				$row->load($id);
		 //echo "row loaded...";
		 //			}
		 //echo "row:";
		 //var_dump($row);
		 //			$this->_data = $row;
			$query =	 " SELECT i.* FROM #__"._JC_DB." AS i "
			."\n LEFT JOIN #__"._JC_DB."_rating AS r ON r.itemid=i.id"
			."\n WHERE i.id=".intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

			//			$query = ' SELECT i.*,t.name AS typename FROM #__'._CM_DB.'_info AS i'
			//					.' LEFT JOIN #__'._CM_DB.'_type AS t ON t.id=i.typeid'
			//					.' WHERE i.itemid='.intval($this->_id);
			$query = ' SELECT * FROM #__'._JC_DB.'_info '
			.' WHERE itemid='.intval($this->_id);
			$this->_db->setQuery( $query );
			$this->_data->infos = $this->_db->loadObjectList();


			}
			if (!$this->_data) {
			//echo "data empty...";
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->catid = null;
			$this->_data->name = null;
			$this->_data->name_alias = null;
			$this->_data->description = null;
			$this->_data->img = null;
			$this->_data->alias = null;
			$this->_data->date = null;
			$this->_data->created_by = null;
			$this->_data->created_by_alias = null;
			$this->_data->modified = null;
			$this->_data->modified_by = null;
			$this->_data->published = null;
			$this->_data->approved = null;
			$this->_data->checked_out = null;
			$this->_data->checked_out_time = null;
			$this->_data->ordering = null;
			$this->_data->params = null;
			$this->_data->hits = null;

			$this->_data->infos = null;
			}
			*/
		return $this->_data;
	}

	/**
	 * Method to store an item including the info fields
	 *
	 * @access public
	 * @return boolean true on success
	 */
	function store( $data = null )
	{
		$row =& $this->getTable();

		/*
		 if(!$data) {
			$data = JRequest::get( 'post' );
			}
			*/

		// Bind the form fields to the item table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the item record is valid
		if (!$row->check()) {
			$this->setError($row->getError());
			return false;
		}

		// Store the item to the database
		if (!$row->store()) {
			$this->setError( $row->getError() );
			return false;
		}

		/*
		 // Set the correct id if the item is new
		 if($data['id'] == 0) {
			$this->_data->id = $row->id;
			$this->_id = $row->id;
			$data['id'] = $row->id;
			}
			*/

		return true;
	}

	/**
	 * Method to delete item(s) (including ratings and info fields
	 *
	 * @access public
	 * @param cids array with item ids to be deleted. If empty, use the current _id
	 * @return boolean True on success
	 */
	function delete( $cids=null )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Method to publish item(s) (_not_ including info fields!)
	 *
	 * @access public
	 * @param cids array with item ids to be published. If empty, use the current _id
	 * @param publish 0 - unpublish, 1 - publish
	 * @return boolean True on success
	 */
	function publish( $cids=null, $publish = 1 )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$user =& JFactory::getUser();
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->publish( $cid, $publish, $user->id )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

}
?>
