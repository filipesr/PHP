<?php
/**
 * JCollection Info table class
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
 * Info Table class
 */
class TableInfo extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var int
	 */
	var $itemid = null;

	/**
	 * @var int
	 */
	var $typeid = null;

	/**
	 * @var string
	 */
	var $name = null;

	/**
	 * @var string
	 */
	var $title = null;

	/**
	 * @var string
	 */
	var $description = null;

	/**
	 * @var string
	 */
	var $info1 = null;

	/**
	 * @var string
	 */
	var $info2 = null;

	/**
	 * @var string
	 */
	var $info3 = null;

	/**
	 * @var string
	 */
	var $info4 = null;

	/**
	 * @var string
	 */
	var $info5 = null;

	/**
	 * @var string
	 */
	var $info6 = null;

	/**
	 * @var string
	 */
	var $info7 = null;

	/**
	 * @var string
	 */
	var $info8 = null;

	/**
	 * @var string
	 */
	var $info9 = null;

	/**
	 * @var string
	 */
	var $info10 = null;

	/**
	 * @var string
	 */
	var $img = null;

	/**
	 * @var string
	 */
	var $url = null;

	/**
	 * @var int
	 */
	var $checked_out = null;

	/**
	 * @var datetime
	 */
	var $checked_out_time = null;

	/**
	 * @var datetime
	 */
	var $date = null;

	/**
	 * @var int
	 */
	var $created_by = null;

	/**
	 * @var string
	 */
	var $created_by_alias = null;

	/**
	 * @var datetime
	 */
	var $modified = null;

	/**
	 * @var int
	 */
	var $modified_by = null;

	/**
	 * @var int
	 */
	var $published = null;

	/**
	 * @var int
	 */
	var $approved = null;

	/**
	 * @var int
	 */
	var $access = null;

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
	function TableInfo(& $db) {
		parent::__construct('#__'._JC_DB.'_info', 'id', $db);
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
		//if (JFilterInput::checkAttribute(array ('href', $this->url))) {
		//  $this->setError( JText::_('Please provide a valid URL'));
		//  return false;
		//}

		/** check for valid name */
		if (trim($this->name) == '') {
			$this->setError(JText::_('The info set must have a name.'));
			return false;
		}

		//if (!(eregi('http://', $this->url) || (eregi('https://', $this->url)) || (eregi('ftp://', $this->url)))) {
		//  $this->url = 'http://'.$this->url;
		//}

		/** check for existing name */
		//$query = 'SELECT id FROM #__weblinks WHERE title = '.$this->_db->Quote($this->title).' AND catid = '.(int) $this->catid;
		//$this->_db->setQuery($query);

		//$xid = intval($this->_db->loadResult());
		//if ($xid && $xid != intval($this->id)) {
		//  $this->setError(JText::sprintf('WARNNAMETRYAGAIN', JText::_('Web Link')));
		//  return false;
		//}

		//if(empty($this->alias)) {
		//  $this->alias = $this->title;
		//}
		//$this->alias = JFilterOutput::stringURLSafe($this->alias);
		//if(trim(str_replace('-','',$this->alias)) == '') {
		//  $datenow = new JDate();
		//  $this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		//}
		if($this->itemid == 0) {
			$this->setError(JText::_('No item selected.'));
			return false;
		}

		return true;
	}

	/**
	 * Overloaded delete method to delete an info row
	 *
	 * @access public
	 * @param cid the id of the item to be deleted. If empty, use current id. Also change all the subcategories and items one step up.
	 * @return boolean True on success
	 */
	function delete( $cid = null )
	{
		if($cid === null && $this->id) {
			$cid = array( $this->id );
		} else if( !is_array( $cid ) ) {
			$cid = array( $cid );
		}
		JArrayHelper::toInteger( $cid );

		if(count($cid)) {
			$query = "DELETE FROM #__"._JC_DB."_info WHERE id IN ( ".implode(",",$cid)." )";
			$this->_db->setQuery($query);
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			$query = "DELETE FROM #__"._JC_DB."_rating WHERE infoid IN ( ".implode(",",$cid)." )";
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
