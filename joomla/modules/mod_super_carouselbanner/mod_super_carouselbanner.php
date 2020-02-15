<?php
/**
* Module Super Carousel Banner For Joomla 1.5
* Version		: 1.2
* Created by	: Rony Sandra Yofa Zebua And Camp26.Com Team
* Email			: camp26team@gmail.com
* Created on 	: 20 May 2008
* Last update on: 09 January 2009
* URL			: www.camp26.com
* http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$headerText	= trim( $params->get( 'header_text' ) );
$footerText	= trim( $params->get( 'footer_text' ) );

$list = modSuperCarouselBannersHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_super_carouselbanner'));
