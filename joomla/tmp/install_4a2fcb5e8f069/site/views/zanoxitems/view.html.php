<?php
/**
 * JCollection Zanoxitems View class
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

jimport( 'joomla.application.component.view' );

/**
 * Zanoxitems View
 *
 * @package JCollection
 * @subpackage com_collection
 */
class JCollectionViewZanoxitems extends JView
{
	/**
	* Wikipediaitems view display method
	* @return void
	**/
	function display($tpl = null)
	{
		JHTML::_('behavior.tooltip');

		global $mainframe, $option;

		// build filters
		$search = $mainframe->getUserStateFromRequest( $option.'.search', 'search', '', 'string' );
		$search = JString::strtolower( $search );
		//$default_country = JCollectionHelper::getEBayDefaultCountry();
		//$filter_country = $mainframe->getUserStateFromRequest( $option.'.filter_country_wse', 'filter_country_wse', $default_country, 'int' );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		//$lists['country'] = JCollectionHelper::filterCountryEBay( 'filter_country_wse', $filter_country);

		// Get data from the model
		$items = & $this->get( 'Data' );

		$pagination = &$this->get('Pagination');

		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('lists', $lists);
		$this->assignRef('user', JFactory::getUser());

		parent::display($tpl);
	}
}
?>
