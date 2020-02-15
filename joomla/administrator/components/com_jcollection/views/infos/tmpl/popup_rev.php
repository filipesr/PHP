<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php global $option; ?>
<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100%"><?php echo JText::_( 'Filter' ); ?>: <input
			type="text" name="search" id="search"
			value="<?php echo $this->lists['search'];?>" class="text_area"
			onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button
			onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
		<td nowrap="nowrap"><?php
		echo JText::_( 'State:' ).$this->lists['state'];
		echo "&#160;";
		echo JText::_( 'Approved:' ).$this->lists['approved'];
		echo "&#160;";
		?></td>
	</tr>
	<tr>
		<td align="left" nowrap="nowrap"><?php
		echo JText::_( 'Category:' ).$this->lists['catid'];
		echo "&#160;";
		echo JText::_( 'Item:' ).$this->lists['item'];
		echo "&#160;";
		?></td>
		<td nowrap="nowrap"><?php
		echo JText::_( 'Access:' ).$this->lists['access'];
		echo "&#160;";
		echo JText::_( 'Author:' ).$this->lists['author'];
		?></td>
	</tr>
	<tr>
		<td align="left" nowrap="nowrap"><?php
		echo JText::_( 'Include subcategories:' ).$this->lists['subcats'];
		?></td>
		<td></td>
	</tr>
</table>
<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
			<th width="20"><?php echo JHTML::_('grid.sort',  'ID', 'i.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Name', 'i.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Item', 'm.name', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th><?php echo JHTML::_('grid.sort',  'Category', 'c.name', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Published', 'i.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Approved', 'i.approved', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="8%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Order', 'i.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="8"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$published = JCollectionHelper::published($row, $i, false);
		$approved = JCollectionHelper::approved($row, $i, false);
		$ordering = ($this->lists['order'] == 'i.ordering');
		?>
	<tr class="<?php echo "row$k"; ?>">
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $row->id; ?></td>
		<td><a style="cursor: pointer;"
			onclick="window.parent.jSelectInfo('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->itemname); ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->catname); ?>','<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->rating1label); ?>','<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->rating2label); ?>','<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->rating3label); ?>','<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->rating4label); ?>','<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->rating5label); ?>');"><?php echo htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8'); ?></a>
		</td>
		<td><?php echo $row->itemname; ?></td>
		<td><?php echo $row->catname; ?></td>
		<td align="center"><?php echo $published; ?></td>
		<td align="center"><?php echo $approved; ?></td>
		<td class="order">
		<?php $disabled = 'disabled="disabled"'; ?> <input
			type="text" name="order[]" size="5"
			value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?>
			class="text_area" style="text-align: center" /></td>
	</tr>
	<?php
	$k = 1 - $k;
	}
	?>
</table>
</div>
<input type="hidden" name="option" value="<?php echo $option; ?>" /> <input
	type="hidden" name="task" value="popup_rev" /> <input type="hidden"
	name="tmpl" value="component" /> <input
	type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="controller" value="infos" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->lists['order']; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir']; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
