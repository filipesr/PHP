<?php
/**
 * JCollection main entry point
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
$auth->addACL( 'com_jcollection', 'manage', 'users', 'super administrator' );
$auth->addACL( 'com_jcollection', 'manage', 'users', 'administrator' );
$auth->addACL( 'com_jcollection', 'manage', 'users', 'manager' );

$auth->addACL( 'com_jcollection', 'add', 'users', 'super administrator', 'item', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'administrator', 'item', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'manager', 'item', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'publisher', 'item', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'editor', 'item', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'author', 'item', 'all' );

$auth->addACL( 'com_jcollection', 'add', 'users', 'super administrator', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'administrator', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'manager', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'publisher', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'editor', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'author', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'registered', 'list', 'all' );

$auth->addACL( 'com_jcollection', 'add', 'users', 'super administrator', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'administrator', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'manager', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'publisher', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'editor', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'author', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'add', 'users', 'registered', 'rev', 'all' );

$auth->addACL( 'com_jcollection', 'approve', 'users', 'super administrator');
$auth->addACL( 'com_jcollection', 'approve', 'users', 'administrator');
$auth->addACL( 'com_jcollection', 'approve', 'users', 'manager');
$auth->addACL( 'com_jcollection', 'approve', 'users', 'publisher');

$auth->addACL( 'com_jcollection', 'publish', 'users', 'super administrator');
$auth->addACL( 'com_jcollection', 'publish', 'users', 'administrator');
$auth->addACL( 'com_jcollection', 'publish', 'users', 'manager');
$auth->addACL( 'com_jcollection', 'publish', 'users', 'publisher');

$auth->addACL( 'com_jcollection', 'edit', 'users', 'super administrator', 'item', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'administrator', 'item', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'manager', 'item', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'publisher', 'item', 'own' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'editor', 'item', 'own' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'author', 'item', 'own' );

$auth->addACL( 'com_jcollection', 'edit', 'users', 'super administrator', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'administrator', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'manager', 'list', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'publisher', 'list', 'own' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'editor', 'list', 'own' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'author', 'list', 'own' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'registered', 'list', 'own' );

$auth->addACL( 'com_jcollection', 'edit', 'users', 'super administrator', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'administrator', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'manager', 'rev', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'publisher', 'rev', 'own' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'editor', 'rev', 'own' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'author', 'rev', 'own' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'registered', 'rev', 'own' );

$auth->addACL( 'com_jcollection', 'edit', 'users', 'super administrator', 'cat', 'all' );
$auth->addACL( 'com_jcollection', 'edit', 'users', 'administrator', 'cat', 'all' );

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

// include helper
require_once( _JC_PATH.DS.'helpers'.DS.'jcollection.php' );
// Set the helper directory
JHTML::addIncludePath( _JC_PATH.DS.'helpers' );

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Require specific controller if requested
if($controller = JRequest::getVar('controller')) {
	require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

// Create the controller
$classname = 'JCollectionController'.$controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar('task') );

// Redirect if set by the controller
$controller->redirect();

?>
