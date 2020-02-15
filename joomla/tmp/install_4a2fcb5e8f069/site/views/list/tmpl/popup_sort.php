<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php global $option; ?>
<form action="index.php" method="post" name="adminForm">
<fieldset>
<div style="float: right">
<button type="button"
	onclick="submitbutton('delete');">
Delete</button>
<button type="button"
	onclick="window.parent.document.getElementById('sbox-window').close();">
Cancel</button>
</div>

<div class="configuration">JCollection - Sort/delete items</div>
</fieldset>

<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?php echo count( $this->list->items ); ?>);" /></th>
			<th><?php echo JHTML::_('grid.sort',  'Name', 'i.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Published', 'i.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Approved', 'i.approved', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="8%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Order', 'i.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			<?php echo JHTML::_('grid.order',  $this->list->items ); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="9"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->list->items ); $i < $n; $i++)
	{
		$row = &$this->list->items[$i];
		$checked = JHTML::_('grid.id', $i, $row->id );
		$published = JCollectionHelper::published($row, $i, false );
		$approved = JCollectionHelper::approved($row, $i, false );
		$ordering = ($this->lists['order_sort'] == 'i.ordering');
		?>
	<tr class="<?php echo "row$k"; ?>">
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $checked; ?></td>
		<td><?php echo $row->name; ?></td>
		<td align="center"><?php echo $published; ?></td>
		<td align="center"><?php echo $approved; ?></td>
		<td class="order"><span> <?php echo $this->pagination->orderUpIcon( $i, true,'orderup', 'Move Up', $ordering ); ?></span><span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
		<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?> <input
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
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="listid" value="<?php echo $this->list->id; ?>" />
<input
	type="hidden" name="task" value="popup_sort" />
	<input
	type="hidden" name="ptask" value="popup_sort" />
	<input type="hidden"
	name="tmpl" value="component" />  <input
	type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="controller" value="list" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->lists['order_sort']; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir_sort']; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
