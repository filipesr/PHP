<?php
/**
 * JCollection Elements controller class
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

/**
 * JCollection Elements Controller
 *
 * @package Collection.Manager
 * @subpackage com_collection
 */
class JCollectionControllerElements extends JCollectionController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	}

	function item()
	{
		$model  = &$this->getModel( 'items' );
		$view = &$this->getView( 'items', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function category()
	{
		$model  = &$this->getModel( 'categories' );
		$view = &$this->getView( 'categories', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function amazonitem()
	{
		$model  = &$this->getModel( 'amazonitems' );
		$view = &$this->getView( 'amazonitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function googlebookitem()
	{
		$model  = &$this->getModel( 'googlebookitems' );
		$view = &$this->getView( 'googlebookitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function wikipediaitem()
	{
		$model  = &$this->getModel( 'wikipediaitems' );
		$view = &$this->getView( 'wikipediaitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function isbndbitem()
	{
		$model  = &$this->getModel( 'isbndbitems' );
		$view = &$this->getView( 'isbndbitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function imdbitem()
	{
		$model  = &$this->getModel( 'imdbitems' );
		$view = &$this->getView( 'imdbitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function yahoomapitem()
	{
		$model  = &$this->getModel( 'yahoomapitems' );
		$view = &$this->getView( 'yahoomapitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function ebayitem()
	{
		$model  = &$this->getModel( 'ebayitems' );
		$view = &$this->getView( 'ebayitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function zanoxitem()
	{
		$model  = &$this->getModel( 'zanoxitems' );
		$view = &$this->getView( 'zanoxitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function googlemapitem()
	{
		$model  = &$this->getModel( 'googlemapitems' );
		$view = &$this->getView( 'googlemapitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function yahoomusicitem()
	{
		$model  = &$this->getModel( 'yahoomusicitems' );
		$view = &$this->getView( 'yahoomusicitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function yahooitem()
	{
		$model  = &$this->getModel( 'yahooitems' );
		$view = &$this->getView( 'yahooitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

	function lastfmitem()
	{
		$model  = &$this->getModel( 'lastfmitems' );
		$view = &$this->getView( 'lastfmitems', 'html' );
		$view->setModel( $model, true );
		$view->setLayout('element');
		$view->display();
	}

}
?>
