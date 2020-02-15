<?php
/**
 * (admin) entry point file for JCollection Component
 *
 * @version $Id$
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// create correct authorization
$auth =& JFactory::getACL();
$auth->addACL('com_jcollection', 'manage', 'users', 'super administrator');
$auth->addACL('com_jcollection', 'manage', 'users', 'administrator');
$auth->addACL('com_jcollection', 'manage', 'users', 'manager');

// Make sure the user is authorized to view this page
$user = & JFactory::getUser();
if (!$user->authorize( 'com_jcollection', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

// include helper
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'jcollection.php' );
// Set the helper directory
JHTML::addIncludePath( JPATH_COMPONENT.DS.'helpers' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection'.DS.'tables');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

$controller = JRequest::getCmd('controller', 'items');
$task = JRequest::getVar('task');

switch($controller) {
	case 'categories':
		JSubMenuHelper::addEntry(JText::_('Items'), 'index.php?option=com_jcollection&controller=items&view=items');
        JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_jcollection&controller=categories&view=categories', true );
        JSubMenuHelper::addEntry(JText::_('Reviews'), 'index.php?option=com_jcollection&controller=revs&view=revs' );
        JSubMenuHelper::addEntry(JText::_('Lists'), 'index.php?option=com_jcollection&controller=lists&view=lists' );
        JSubMenuHelper::addEntry(JText::_('List categories'), 'index.php?option=com_jcollection&controller=listcats&view=listcats' );
		JSubMenuHelper::addEntry(JText::_('Types'), 'index.php?option=com_jcollection&controller=types&view=types' );
		JSubMenuHelper::addEntry(JText::_('Webservice types'), 'index.php?option=com_jcollection&controller=webservicetypes&view=webservicetypes' );
		break;
	case 'revs':
		JSubMenuHelper::addEntry(JText::_('Items'), 'index.php?option=com_jcollection&controller=items&view=items');
        JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_jcollection&controller=categories&view=categories' );
        JSubMenuHelper::addEntry(JText::_('Reviews'), 'index.php?option=com_jcollection&controller=revs&view=revs', true );
        JSubMenuHelper::addEntry(JText::_('Lists'), 'index.php?option=com_jcollection&controller=lists&view=lists' );
        JSubMenuHelper::addEntry(JText::_('List categories'), 'index.php?option=com_jcollection&controller=listcats&view=listcats' );
		JSubMenuHelper::addEntry(JText::_('Types'), 'index.php?option=com_jcollection&controller=types&view=types' );
		JSubMenuHelper::addEntry(JText::_('Webservice types'), 'index.php?option=com_jcollection&controller=webservicetypes&view=webservicetypes' );
		break;
	case 'lists':
		JSubMenuHelper::addEntry(JText::_('Items'), 'index.php?option=com_jcollection&controller=items&view=items');
        JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_jcollection&controller=categories&view=categories' );
        JSubMenuHelper::addEntry(JText::_('Reviews'), 'index.php?option=com_jcollection&controller=revs&view=revs' );
        JSubMenuHelper::addEntry(JText::_('Lists'), 'index.php?option=com_jcollection&controller=lists&view=lists', true );
        JSubMenuHelper::addEntry(JText::_('List categories'), 'index.php?option=com_jcollection&controller=listcats&view=listcats' );
		JSubMenuHelper::addEntry(JText::_('Types'), 'index.php?option=com_jcollection&controller=types&view=types' );
		JSubMenuHelper::addEntry(JText::_('Webservice types'), 'index.php?option=com_jcollection&controller=webservicetypes&view=webservicetypes' );
		break;
	case 'listcats':
		JSubMenuHelper::addEntry(JText::_('Items'), 'index.php?option=com_jcollection&controller=items&view=items');
        JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_jcollection&controller=categories&view=categories' );
        JSubMenuHelper::addEntry(JText::_('Reviews'), 'index.php?option=com_jcollection&controller=revs&view=revs' );
        JSubMenuHelper::addEntry(JText::_('Lists'), 'index.php?option=com_jcollection&controller=lists&view=lists' );
        JSubMenuHelper::addEntry(JText::_('List categories'), 'index.php?option=com_jcollection&controller=listcats&view=listcats', true );
		JSubMenuHelper::addEntry(JText::_('Types'), 'index.php?option=com_jcollection&controller=types&view=types' );
		JSubMenuHelper::addEntry(JText::_('Webservice types'), 'index.php?option=com_jcollection&controller=webservicetypes&view=webservicetypes' );
		break;
	case 'types':
		JSubMenuHelper::addEntry(JText::_('Items'), 'index.php?option=com_jcollection&controller=items&view=items');
        JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_jcollection&controller=categories&view=categories' );
        JSubMenuHelper::addEntry(JText::_('Reviews'), 'index.php?option=com_jcollection&controller=revs&view=revs' );
        JSubMenuHelper::addEntry(JText::_('Lists'), 'index.php?option=com_jcollection&controller=lists&view=lists' );
        JSubMenuHelper::addEntry(JText::_('List categories'), 'index.php?option=com_jcollection&controller=listcats&view=listcats' );
		JSubMenuHelper::addEntry(JText::_('Types'), 'index.php?option=com_jcollection&controller=types&view=types', true );
		JSubMenuHelper::addEntry(JText::_('Webservice types'), 'index.php?option=com_jcollection&controller=webservicetypes&view=webservicetypes' );
		break;
	case 'webservicetypes':
		JSubMenuHelper::addEntry(JText::_('Items'), 'index.php?option=com_jcollection&controller=items&view=items');
        JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_jcollection&controller=categories&view=categories' );
        JSubMenuHelper::addEntry(JText::_('Reviews'), 'index.php?option=com_jcollection&controller=revs&view=revs' );
        JSubMenuHelper::addEntry(JText::_('Lists'), 'index.php?option=com_jcollection&controller=lists&view=lists' );
        JSubMenuHelper::addEntry(JText::_('List categories'), 'index.php?option=com_jcollection&controller=listcats&view=listcats' );
		JSubMenuHelper::addEntry(JText::_('Types'), 'index.php?option=com_jcollection&controller=types&view=types' );
		JSubMenuHelper::addEntry(JText::_('Webservice types'), 'index.php?option=com_jcollection&controller=webservicetypes&view=webservicetypes', true );
		break;
	default:
	case 'items':
		JSubMenuHelper::addEntry(JText::_('Items'), 'index.php?option=com_jcollection&controller=items&view=items', true );
        JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_jcollection&controller=categories&view=categories' );
        JSubMenuHelper::addEntry(JText::_('Reviews'), 'index.php?option=com_jcollection&controller=revs&view=revs' );
        JSubMenuHelper::addEntry(JText::_('Lists'), 'index.php?option=com_jcollection&controller=lists&view=lists' );
        JSubMenuHelper::addEntry(JText::_('List categories'), 'index.php?option=com_jcollection&controller=listcats&view=listcats' );
		JSubMenuHelper::addEntry(JText::_('Types'), 'index.php?option=com_jcollection&controller=types&view=types' );
		JSubMenuHelper::addEntry(JText::_('Webservice types'), 'index.php?option=com_jcollection&controller=webservicetypes&view=webservicetypes' );
		break;
}

// Require specific controller if requested
if($controller) {
	require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
	// Create the controller
	$classname = 'JCollectionController'.$controller;
	$controller = new $classname( );

	if(!JRequest::getVar( 'view' )) {
		JRequest::setVar( 'view', 'items' );
	}

	// Perform the Request task
	$controller->execute( JRequest::getVar('task') );

	// Redirect if set by the controller
	$controller->redirect();
} else {
	// no controller set -> redirect to items controller/view
	$controller = new JCollectionController();
	$controller->setRedirect( 'index.php?option='.$option.'&controller=items&view=items', '' );
	$controller->redirect();
}

?>
