<?php
/**
 * Uninstall script for com_jcollection, wipe the database
 *
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

/*
 * Joomla 1.0 ignores this file, hence for this version it does not really matter what goes on here.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// at uninstall time, the option variable is not set, hence we need the component name here
define('_JC_NAME', 'com_jcollection');

// this is for the definition of _CM_DB
require_once (JPATH_ADMINISTRATOR.DS.'components'.DS._JC_NAME.DS.'config.jcollection.php');

function com_uninstall()
{
	$database = & JFactory::getDBO();

	if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection.xml')) {
		@unlink( JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."jcollection.xml" );
	}
	if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection_cat.xml')) {
		@unlink( JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."jcollection_cat.xml" );
	}
	if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'translationJC_categoryFilter.php')) {
		@unlink( JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."translationJC_categoryFilter.php" );
	}
	if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection_review.xml')) {
		@unlink( JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."jcollection_review.xml" );
	}
	if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection_list.xml')) {
		@unlink( JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."jcollection_list.xml" );
	}
	if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection_type.xml')) {
		@unlink( JPATH_ADMINISTRATOR.DS."components".DS."com_joomfish".DS."contentelements".DS."jcollection_type.xml" );
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB.";";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_info;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_rating;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_cat;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_cat;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_type;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_review;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_reviewrating;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_webservicetype;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_webserviceitem;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_listcat;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_list;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_item2list;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

}
?>
