<?php
/**
 * JCollection Yahoomapitems View class
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

jimport( 'joomla.application.component.view' );

/**
 * Yahoomapitems View
 *
 * @package JCollection
 * @subpackage com_collection
 */
class JCollectionViewYahoomapitems extends JView
{
	/**
	* Wikipediaitems view display method
	* @return void
	**/
	function display($tpl = null)
	{
		JHTML::_('behavior.tooltip');

		global $mainframe, $option;

		/*
		$default_country = JCollectionHelper::getWikipediaDefaultCountry();
		// build filters
		$search = $mainframe->getUserStateFromRequest( $option.'.search_wsw', 'search_wsw', '', 'string' );
		$search = JString::strtolower( $search );
		$filter_country = $mainframe->getUserStateFromRequest( $option.'.filter_country_wsw', 'filter_country_wsw', $default_country, 'word' );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		$lists['country'] = JCollectionHelper::filterCountryWikipedia( 'filter_country', $filter_country);
		*/

		// Get data from the model
		$items = & $this->get( 'Data' );

		$pagination = &$this->get('Pagination');

		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('lists', $lists);
		$this->assignRef('user', JFactory::getUser());

		$access_key = JCollectionHelper::getYahooAccessKey();
		if($access_key) {
			$js_file = "http://api.maps.yahoo.com/ajaxymap?v=3.8&appid=".$access_key;
			$doc = &JFactory::getDocument();
			$doc->addScript($js_file);

			$currentloc = JRequest::getVar('position');
			$js = "
				var currentGeoPoint = new YGeoPoint(\"San Francisco\");
				var clickEvent = false;
				var map = null;
				window.addEvent('domready', function() {
					//Create a map object
					map = new YMap(document.getElementById('yahoomap'));

					// Add the ability to change between Sat, Hybrid, and Regular Maps
					map.addTypeControl();
					// Set map type to either of: YAHOO_MAP_SAT, YAHOO_MAP_HYB, YAHOO_MAP_REG
					map.setMapType(YAHOO_MAP_REG);
					// Add the zoom control. Long specifies a Slider versus a \"+\" and \"-\" zoom control
					map.addZoomLong();
					// Add the Pan control to have North, South, East and West directional control
					map.addPanControl();

					var currentloc = window.parent.getLocationYahoo();
					//var currentGeoPoint = new YGeoPoint(\"San Francisco\");
					if(currentloc!='') {
						var pos = currentloc.split(',');
						currentGeoPoint.Lat = pos[0];
						currentGeoPoint.Lon = pos[1];
						map.addMarker(currentGeoPoint);
						map.drawZoomAndCenter(currentGeoPoint, 3);
					}
					map.drawZoomAndCenter(currentGeoPoint, 3);
					// Add an event to report to our Logger
					//YEvent.Capture(map, EventsList.MouseClick, reportPosition);
					YEvent.Capture(map, EventsList.MouseDown, mDown);
					YEvent.Capture(map, EventsList.MouseUp, reportPosition);
					YEvent.Capture(map, EventsList.onPan, noClick);
					YEvent.Capture(map, EventsList.changeZoom, noClick);

					function mDown(_e,_c) {
						clickEvent = true;
					}
					function noClick(_e,_c) {
						clickEvent = false;
					}

					function reportPosition(_e, _c){
						if(clickEvent) {
							currentGeoPoint.Lat = _c.Lat;
							currentGeoPoint.Lon = _c.Lon;
							map.removeMarkersAll();
							map.addMarker(currentGeoPoint);
						}
					}

					//function savePosition() {
					//	window.parent.jSelectItem(currentGeoPoint.Lat+','+currentGeoPoint.Lon, currentGeoPoint.Lat+','+currentGeoPoint.Lon, '".JRequest::getVar('object')."');
					//}

					// Add map type control
					//map.addTypeControl();

					// Set map type to either of: YAHOO_MAP_SAT, YAHOO_MAP_HYB, YAHOO_MAP_REG
					//map.setMapType(YAHOO_MAP_REG);

					// Display the map centered on a geocoded location
					//map.drawZoomAndCenter(\"San Francisco\", 3);
				});
				function savePosition() {
					window.parent.jSelectItem(currentGeoPoint.Lat+','+currentGeoPoint.Lon, currentGeoPoint.Lat+','+currentGeoPoint.Lon, '".JRequest::getVar('object')."');
				}
				function searchAddress() {
					var addr = document.getElementById('address').value;
					map.drawZoomAndCenter(addr, 3);
				}
				";
			$doc->addScriptDeclaration($js);
		}

		parent::display($tpl);
	}
}
?>
