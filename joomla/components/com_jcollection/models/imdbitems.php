<?php
/**
 * JCollection Imdbitems Model class
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

jimport( 'joomla.application.component.model' );

/**
 * Imdbitems Model
 *
 * @package JCollection
 * @subpackage com_jJcollection
 */
class JCollectionModelImdbitems extends JModel
{
	/**
	 * Amazon data array
	 *
	 * @var array
	 */
	var $_data;

	/**
	 * Total number
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

	var $_imdbphp = null;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		global $mainframe, $option;

		// Get the pagination request variables
		$limit = $mainframe->getUserStateFromRequest( $option.'.limit', 'limit', 10, 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}


	/**
	 * Retrieves the amazon data
	 * @return array Array of objects containing the data from the webservice
	 */
	function &getData()
	{
		global $mainframe, $option;

		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			// check for imdbphp in /administrator/components/com_jcollection/imdbphp
			define('_JC_IMDBPHP_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection'.DS.'imdbphp');
			if( file_exists(_JC_IMDBPHP_PATH.DS.'imdb_base.class.php')) {
				require_once (_JC_IMDBPHP_PATH.DS.'imdb_base.class.php');
				require_once (_JC_IMDBPHP_PATH.DS.'imdb.class.php');
				$this->_imdbphp = true;
			} else {
				$this->_imdbphp = false;
				return;
			}
			$search = $mainframe->getUserStateFromRequest( $option.'.search_wsm', 'search_wsm', '','string' );
			$search = JString::strtolower( $search );

			$limit = $this->getState( 'limit' );
			$limitstart = $this->getState( 'limitstart' );

			$this->_total = 0;
			$this->_data = array();

			if($search) {
				$imdbsearch = new imdbsearch();     // eine Instanz der Such-Klasse erstellen
				$imdbsearch->setsearchname($search);  // der Klasse mitteilen, wonach wir suchen
                                // (keine Groß-kleinschreibungs-Unterscheidung)
				$results = $imdbsearch->results();

				$list = array();
				foreach ($results as $entry) {
					$newrow = new stdClass();
					$newrow->id = $entry->imdbid();
					$newrow->name = $entry->title();
					$newrow->year = $entry->year();
					$cast = $entry->cast();
					$actors = array();
					foreach ( $cast as $actor ) {
						$actors[] = $actor['name'];
					}
					$actors = array_slice($actors,0,10);
					$actors = implode(', ',$actors);
					$newrow->actor = $actors;
					$director = $entry->director();
					$directors = array();
					foreach($director as $dir) {
						$directors[] = $dir['name'];
					}
					$directors = array_slice($directors,0,10);
					$directors = implode(', ',$directors);
					$newrow->director = $directors;
					$list[] = $newrow;
				}

				$this->_total = count($list);

				if($limit) {
					$this->_data = array_slice($list, $limitstart, $limit);
				} else {
					$this->_data = $list;
				}
			}

			//$this->_total = count($this->_data);
		}

		return $this->_data;
	}

	/**
	 * Method to get the total number of items
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			//if (empty($this->_data )) { // fetch data to $this->_data
			//	$this->getData();
			//}
			$this->_total = 0;
			//$this->_total = count($this->_data);
		}

		return $this->_total;
	}

	/**
	 * Method to get a pagination object for the categories
	 *
	 * @access public
	 * @return object
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}

	function getImdbphp()
	{
		if(empty($this->_imdbphp)) {
			if( file_exists(_JC_IMDBPHP_PATH.DS.'imdb_base.class.php')) {
				$this->_imdbphp = true;
			} else {
				$this->_imdbphp = false;
			}
		}
		return $this->_imdbphp;
	}

}
?>
