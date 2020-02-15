<?php
/**
 * JCollection Webservicetype Table class
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
 * Webservicetype Table class
 *
 * @package com_collection
 */
class TableWebservicetype extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * webservice item type name
	 * @var int
	 */
	var $name = null;

	/**
	 * webservice
	 * @var string
	 */
	var $webservice = null;

	/**
	 * type id
	 * @var int
	 */
	var $typeid = null;

	/**
	 * disclaimer
	 * @var string
	 */
	var $disclaimer = null;

	/**
	 * Info 1 XPath
	 * @var string
	 */
	var $info1xpath = null;

	/**
	 * Info 2 XPath
	 * @var string
	 */
	var $info2xpath = null;

	/**
	 * Info 3 XPath
	 * @var string
	 */
	var $info3xpath = null;

	/**
	 * Info 4 XPath
	 * @var string
	 */
	var $info4xpath = null;

	/**
	 * Info 5 XPath
	 * @var string
	 */
	var $info5xpath = null;

	/**
	 * Info 6 XPath
	 * @var string
	 */
	var $info6xpath = null;

	/**
	 * Info 7 XPath
	 * @var string
	 */
	var $info7xpath = null;

	/**
	 * Info 8 XPath
	 * @var string
	 */
	var $info8xpath = null;

	/**
	 * Info 9 XPath
	 * @var string
	 */
	var $info9xpath = null;

	/**
	 * Info 10 XPath
	 * @var string
	 */
	var $info10xpath = null;

	/**
	 * Title XPath
	 * @var string
	 */
	var $titlexpath = null;

	/**
	 * Description XPath
	 * @var string
	 */
	var $descriptionxpath = null;

	/**
	 * Image XPath
	 * @var string
	 */
	var $imgxpath = null;

	/**
	 * URL XPath
	 * @var string
	 */
	var $urlxpath = null;

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
	function TableWebservicetype(& $db) {
		parent::__construct('#__'._JC_DB.'_webservicetype', 'id', $db);
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
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check()
	{
		/** check for valid name */
		if (trim($this->name) == '') {
			$this->setError(JText::_('The webservice type must have a name.'));
			return false;
		}

		/** check for existing name */
		$query = 'SELECT id FROM #__'._JC_DB.'_webservicetype WHERE name = '.$this->_db->Quote($this->name)
		."\n AND webservice = ".$this->_db->Quote($this->webservice);
		$this->_db->setQuery($query);

		$xid = intval($this->_db->loadResult());
		if ($xid && $xid != intval($this->id)) {
			$this->setError(JText::sprintf('WARNNAMETRYAGAIN', JText::_('JCollection webservice type')));
			return false;
		}

		return true;
	}
}
?>
