<?php
/**
 * JCollection Webserviceitem Table class
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

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

/**
 * Amazonitem Table class
 *
 * @package com_collection
 */
class TableWebserviceitem extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * Webservice-dependent id
	 * @var string
	 */
	var $ws_id = null;

	/**
	 * references the info id
	 * @var int
	 */
	var $infoid = null;

	/**
	 * webservice (amazon,googlebook,isbndb,wikipedia,imdb)
	 *
	 * @var string
	 */
	var $webservice = null;

	/**
	 * webservice item type (references webservicetype)
	 * @var int
	 */
	var $type = null;

	/**
	 * xml source
	 * @var string
	 */
	var $xml = null;

	/**
	 * @var datetime
	 */
	var $updated = null;

	/**
	 * @var int
	 */
	var $expires = null;

	/**
	 * @var int
	 */
	var $checked_out = null;

	/**
	 * @var datetime
	 */
	var $checked_out_time = null;

	/**
	 * @var string
	 */
	var $params = null;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableWebserviceitem(& $db) {
		parent::__construct('#__'._JC_DB.'_webserviceitem', 'id', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array named array
	* @return null|string   null on success, otherwise returns an error
	*/
	function bind($array, $ignore = '')
	{
		if(!is_array($array)) {
			$array = JCollectionHelper::object2array( $array );
		}
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			$params = $array['params'];
			foreach ( $params as $k=>$v) {
				if( key_exists( $k, $this ) ) {
					$this->$k = $v;
					unset( $array['params'][$k] );
				} else if( empty($v) ) {
					unset( $array['params'][$k] );
				}
			}
			$registry = new JRegistry();
			$registry->loadArray($array['params']);

			$array['params'] = $registry->toString();
		}

		return parent::bind($array, $ignore);
	}

	/**
	* Overloaded delete method to delete a webservice item row
	*
	* @access public
	* @param cid the ids of the items to be deleted. If empty, use current id.
	* @return boolean True on success
	*/
	/*
	function delete( $cid = null )
	{
		if($cid === null && $this->id) {
			$cid = array($this->id);
		} else if(!is_array($cid)) {
			$cid = array($cid);
		}
		JArrayHelper::toInteger( $cid );
		if(count($cid)) {
			$query = "DELETE FROM #__"._JC_DB."_webserviceitem WHERE id IN ( ".implode(",",$cid)." )";
			$this->_db->setQuery($query);
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}
	*/
}
?>
