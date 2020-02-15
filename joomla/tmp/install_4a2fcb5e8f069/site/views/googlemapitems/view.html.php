<?php
/**
 * JCollection Googlemapitems View class
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
 * Googlemapitems View
 *
 * @package JCollection
 * @subpackage com_collection
 */
class JCollectionViewGooglemapitems extends JView
{
	/**
	* Googlemapitems view display method
	* @return void
	**/
	function display($tpl = null)
	{
		JHTML::_( 'behavior.tooltip' );

		global $mainframe, $option;

		// Get data from the model
		$items = & $this->get( 'Data' );

		$pagination = &$this->get('Pagination');

		$this->assignRef( 'items', $items );
		$this->assignRef( 'pagination', $pagination );
		$this->assignRef( 'lists', $lists );
		$this->assignRef( 'user', JFactory::getUser() );

		$access_key = JCollectionHelper::getGoogleAccessKey();
		if($access_key) {
			$js_file = "http://www.google.com/jsapi?key=".$access_key;
			$doc = &JFactory::getDocument();
			$doc->addScript($js_file);

			$js = "
				google.load(\"maps\", \"2\");

				var map = null;
				var geocoder = null;
				var marker = null;

  				// Diese Funktion aufrufen, wenn die Seite geladen ist
				function initialize() {
					if (google.maps.BrowserIsCompatible()) {
						map = new google.maps.Map2(document.getElementById(\"googlemap\"));
						var currentloc = window.parent.getLocationGoogle();
						if(currentloc!='') {
							var pos = currentloc.split(',');
							var lat = pos[0];
							var lng = pos[1];
							var latlng = new google.maps.LatLng(lat,lng);
							marker = new google.maps.Marker(latlng);
							map.addOverlay(marker);
							map.setCenter(latlng,13);
						} else {
							map.setCenter(new google.maps.LatLng(37.4419, -122.1419), 13);
						}
						map.addControl(new google.maps.SmallMapControl());
        				map.addControl(new google.maps.MapTypeControl());
						geocoder = new google.maps.ClientGeocoder();
						google.maps.Event.addListener(map, \"click\", function(overlay,latlng) {
							map.setCenter(latlng, 13);
							map.clearOverlays();
							marker = new google.maps.Marker(latlng);
							map.addOverlay(marker);
						});
					}
				}
				google.setOnLoadCallback(initialize);


				function savePosition() {
					if(marker) {
						var latlng = marker.getLatLng();
						var lat = latlng.lat();
						var lng = latlng.lng();
						window.parent.jSelectItem(lat+','+lng, lat+','+lng, '".JRequest::getVar( 'object' )."');
					}
				}
				function searchAddress() {
					var address = document.getElementById('address').value;
					if (geocoder) {
						geocoder.getLatLng(
						address,
						function(point) {
							if (!point) {
								alert(address + \"".JText::_( 'not found' )."\");
							} else {
								map.setCenter(point, 13);
							}
						}
						);
      				}
				}
				";
			$doc->addScriptDeclaration($js);
		}

		parent::display($tpl);
	}
}
?>
