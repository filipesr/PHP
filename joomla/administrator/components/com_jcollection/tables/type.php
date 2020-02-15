<?php
/**
 * JCollection Type Table
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
 * Type Table class
 *
 * @package com_collection
 */
class TableType extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $name = null;

	/**
	 *
	 * @var string
	 */
	var $description = null;

	/**
	 * @var string
	 */
	var $img = null;

	/**
	 * @var string
	 */
	var $info1label = null;

	/**
	 * @var string
	 */
	var $info2label = null;

	/**
	 * @var string
	 */
	var $info3label = null;

	/**
	 * @var string
	 */
	var $info4label = null;

	/**
	 * @var string
	 */
	var $info5label = null;

	/**
	 * @var string
	 */
	var $info6label = null;

	/**
	 * @var string
	 */
	var $info7label = null;

	/**
	 * @var string
	 */
	var $info8label = null;

	/**
	 * @var string
	 */
	var $info9label = null;

	/**
	 * @var string
	 */
	var $info10label = null;

	/**
	 * @var string
	 */
	var $info1html = null;

	/**
	 * @var string
	 */
	var $info2html = null;

	/**
	 * @var string
	 */
	var $info3html = null;

	/**
	 * @var string
	 */
	var $info4html = null;

	/**
	 * @var string
	 */
	var $info5html = null;

	/**
	 * @var string
	 */
	var $info6html = null;

	/**
	 * @var string
	 */
	var $info7html = null;

	/**
	 * @var string
	 */
	var $info8html = null;

	/**
	 * @var string
	 */
	var $info9html = null;

	/**
	 * @var string
	 */
	var $info10html = null;

	/**
	 * @var string
	 */
	var $rating1label = null;

	/**
	 * @var string
	 */
	var $rating2label = null;

	/**
	 * @var string
	 */
	var $rating3label = null;

	/**
	 * @var string
	 */
	var $rating4label = null;

	/**
	 * @var string
	 */
	var $rating5label = null;

	/**
	 * @var int
	 */
	var $checked_out = null;

	/**
	 * @var datetime
	 */
	var $checked_out_time = null;

	/**
	 * @var int
	 */
	var $ordering = null;

	/**
	 * @var string
	 */
	var $params = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableType(& $db) {
		parent::__construct('#__'._JC_DB.'_type', 'id', $db);
	}

	/**
	 * Overloaded bind function
	 *
	 * @acces public
	 * @param array $hash named array
	 * @return null|string   null is operation was satisfactory, otherwise returns an error
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
				} else if( $v === '' ) {
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
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check()
	{
		/** check for valid name */
		if (trim($this->name) == '') {
			$this->setError(JText::_('The type must have a name.'));
			return false;
		}

		/** check for existing name */
		$query = 'SELECT id FROM #__'._JC_DB.'_type WHERE name = '.$this->_db->Quote($this->name);
		$this->_db->setQuery($query);

		$xid = intval($this->_db->loadResult());
		if ($xid && $xid != intval($this->id)) {
			$this->setError(JText::sprintf('WARNNAMETRYAGAIN', JText::_('Collection Manager Type')));
			return false;
		}
		return true;
	}

	/**
	 * Overloaded delete method to delete a category row
	 *
	 * @access public
	 * @param cid the id of the item to be deleted. If empty, use current id. Also change all the subcategories and items one step up.
	 * @return boolean True on success
	 */
	function delete( $cid = null )
	{
		if($cid === null && $this->id) {
			$cid = array($this->id);
		} else if(!is_array($cid)) {
			$cid = array($cid);
		}
		JArrayHelper::toInteger( $cid );

		if(count($cid)) {
			$query = "DELETE FROM #__"._JC_DB."_type WHERE id IN ( ".implode(",",$cid)." )";
			$this->_db->setQuery($query);
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}

}
?>
