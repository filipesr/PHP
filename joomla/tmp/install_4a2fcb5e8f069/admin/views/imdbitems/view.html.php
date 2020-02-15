<?php
/**
 * JCollection Imdbitems View class
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
 * Imdbitems View
 *
 * @package Collection.Manager
 * @subpackage com_collection
 */
class JCollectionViewImdbitems extends JView
{
	/**
	* Googleitems view display method
	* @return void
	**/
	function display($tpl = null)
	{
		JHTML::_('behavior.tooltip');

		global $mainframe, $option;

		// build filters
		$search = $mainframe->getUserStateFromRequest( $option.'.search_wsm', 'search_wsm', '', 'string' );
		$search = JString::strtolower( $search );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		// Get data from the model
		$items = & $this->get( 'Data' );

		$imdbphp = $this->get( 'Imdbphp' );

		$pagination = &$this->get('Pagination');

		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('lists', $lists);
		$this->assignRef('user', JFactory::getUser());
		$this->assignRef('imdbphp', $imdbphp);

		parent::display($tpl);
	}
}
?>
