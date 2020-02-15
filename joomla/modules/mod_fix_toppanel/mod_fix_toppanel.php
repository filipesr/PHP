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
require_once (dirname(__FILE__).DS.'helper.php');

$is_ie7 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 7') !== false;
$is_ie6 = !$is_ie7 && strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6') !== false;

$str = modfix_toppanelHelper::getContent($params);
$document =& JFactory::getDocument();
$document->addStyleSheet( JURI::base() . 'modules/mod_fix_toppanel/css/fix_toppanel.css' );
if ($is_ie6) {
	$document->addScript( JURI::base() . 'modules/mod_fix_toppanel/js/fixed.js' );
}
$document->addScript( JURI::base() . 'modules/mod_fix_toppanel/js/jb.js' );
require(JModuleHelper::getLayoutPath('mod_fix_toppanel'));

?>
