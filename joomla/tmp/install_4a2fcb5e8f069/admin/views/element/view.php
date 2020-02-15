<?php
/**
 * JCollection Element View class
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

jimport( 'joomla.application.component.view' );

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

/**
 * Element View
 *
 */
class JCollectionViewElement extends JView
{
	function display()
	{
		global $mainframe, $option;

		// Initialize variables
		$db = &JFactory::getDBO();
		$nullDate = $db->getNullDate();

		$document = & JFactory::getDocument();
		$document->setTitle('Item Selection');

		JHTML::_('behavior.modal');

		$template = $mainframe->getTemplate();
		$document->addStyleSheet("templates/$template/css/general.css");

		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');

		$lists = $this->_getLists();

		//Ordering allowed ?
		$ordering = ($lists['order'] == 'section_name' && $lists['order_Dir'] == 'ASC');

		//$rows = &$this->get('List');
		$rows = &$this->get('Data');
		$page = &$this->get('Pagination');
		JHTML::_('behavior.tooltip');
		?>
		<form action="index.php?option=<?php echo $option; ?>&amp;controller=elements&amp;task=item&amp;tmpl=component&amp;object=id" method="post" name="adminForm">

			<table>
			<tr>
				<td width="100%"><?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
				</td>
				<td nowrap="nowrap">
					<?php echo $lists['catid']; ?>
				</td>
			</tr>
			</table>
			<table class="adminlist" cellspacing="1">
			<thead>
			<tr>
				<th width="5"><?php echo JText::_( 'Num' ); ?></th>
				<th class="title"><?php echo JHTML::_('grid.sort',   'Title', 'c.title', @$lists['order_Dir'], @$lists['order'] ); ?></th>
				<th width="7%"><?php echo JHTML::_('grid.sort',   'Access', 'groupname', @$lists['order_Dir'], @$lists['order'] ); ?></th>
				<th width="2%" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'c.id', @$lists['order_Dir'], @$lists['order'] ); ?></th>
				<th  class="title" width="15%" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Category', 'cc.title', @$lists['order_Dir'], @$lists['order'] ); ?>
				</th>
				<th align="center" width="10"><?php echo JHTML::_('grid.sort',   'Date', 'c.created', @$lists['order_Dir'], @$lists['order'] ); ?></th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="15"><?php echo $page->getListFooter(); ?></td>
			</tr>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++)
			{
				$row = &$rows[$i];

				$link   = '';
				$date   = JHTML::_('date',  $row->created, JText::_('DATE_FORMAT_LC4') );
				$access = JHTML::_('grid.access',   $row, $i ); //, $row->state );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $page->getRowOffset( $i ); ?>
					</td>
					<td>
						<a style="cursor: pointer;" onclick="window.parent.jSelectItem('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', '<?php echo JRequest::getVar('object'); ?>');"><?php echo htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8'); ?></a>
					</td>
					<td align="center">
						<?php echo $row->groupname;?>
					</td>
					<td>
						<?php echo $row->id; ?>
					</td>
					<td>
						<?php echo $row->category; ?>
					</td>
					<td nowrap="nowrap">
						<?php echo $date; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>

			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		</form>
	<?php
	}

	function _getLists()
	{
		global $mainframe, $option;

		// Initialize variables
		$db = &JFactory::getDBO();

		// Get some variables from the request
		$redirect                       = $sectionid;
		$option = JRequest::getCmd( 'option' );
		$filter_order = $mainframe->getUserStateFromRequest('itemelement.filter_order', 'filter_order', '', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest('itemelement.filter_order_Dir', 'filter_order_Dir', '', 'word');
		$filter_state = $mainframe->getUserStateFromRequest('itemelement.filter_state', 'filter_state', '', 'word');
		$catid = $mainframe->getUserStateFromRequest('itemelement.catid', 'catid', 0, 'int');
		$filter_authorid = $mainframe->getUserStateFromRequest('itemelement.filter_authorid', 'filter_authorid', 0, 'int');
		//$filter_sectionid = $mainframe->getUserStateFromRequest('itemelement.filter_sectionid', 'filter_sectionid', -1, 'int');
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest('itemelement.limitstart', 'limitstart', 0, 'int');
		$search = $mainframe->getUserStateFromRequest('itemelement.search', 'search', '', 'string');
		$search = JString::strtolower($search);

		// get list of categories for dropdown filter
		$filter = ''; //($filter_sectionid >= 0) ? ' WHERE cc.section = '.$db->Quote($filter_sectionid) : '';

		// get list of categories for dropdown filter
		$query = 'SELECT c.id AS value, c.name AS text ' .
						' FROM #__'._JC_DB.'_cat AS c' .
//						' INNER JOIN #__sections AS s ON s.id = cc.section' .
						$filter .
//						' ORDER BY s.ordering, cc.ordering';
						' ORDER BY c.ordering';

		$lists['catid'] = JCollectionHelper::filterCategory(/* $query, */ 'catid', $catid);

		// get list of sections for dropdown filter
		$javascript = 'onchange="document.adminForm.submit();"';
		//$lists['sectionid'] = JHTML::_('list.section', 'filter_sectionid', $filter_sectionid, $javascript);

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search'] = $search;

		return $lists;
	}

}
?>