<?php
/**
      Fix TopPanel Module for Joomla 1.5
      -----------------------------------------------------------------------
      Fix TopPanel show a fixed toppanel with inside text or a module position. 
      Created bt Andrea S. of www.joomlovers.net 
      Hide/Show Script by Justin Barlow | http://www.netlobo.com
      -----------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modfix_toppanelHelper {
	function getContent(&$params) {
		$str = $params->get( 'content' );
		return $str;
	}
}
