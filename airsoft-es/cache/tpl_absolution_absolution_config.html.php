<?php if (!defined('IN_PHPBB')) exit; if ($this->_tpldata['DEFINE']['.']['ABSOLUTION']) {  ?>


####################################################
ABSOLUTION Configuation file for Forum Administrators
####################################################

Variables you can configure below. Definitions and options are below:

$ABSOLUTION_BOARD_WIDTH = The board's width. Can use fixed width (eg: '1000px' or fluid width eg: '80%').
$USE_IMAGESET_LOGO = If you have a logo image, change '0' to '1' use ACP to set the board logo (ACP -> Styles -> Imagesets)
$COLLAPSIBLE_CATEGORIES = The feature to minimise categories on the forum index page. '1' = enabled, '0' = disabled. 
<?php } $this->_tpldata['DEFINE']['.']['ABSOLUTION_BOARD_WIDTH'] = '1000px'; $this->_tpldata['DEFINE']['.']['USE_IMAGESET_LOGO'] = '0'; $this->_tpldata['DEFINE']['.']['COLLAPSIBLE_CATEGORIES'] = '1'; ?>