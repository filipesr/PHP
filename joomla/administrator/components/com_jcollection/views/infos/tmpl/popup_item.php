<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php global $option; ?>
<form action="index.php" method="post" name="adminForm">
<fieldset>
<div style="float: right">
<button type="button"
	onclick="submitbutton('delete');">
Delete</button>
<button type="button"
	onclick="window.parent.updateList();window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 700);">
Close</button>
</div>

<div class="configuration">JCollection - Sort/delete info sets</div>
</fieldset>
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
	</tr>
</table>
<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
			<th width="20"><?php echo JHTML::_('grid.sort',  'ID', 'i.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Name', 'i.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="8%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Order', 'i.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			<?php echo JHTML::_('grid.order',  $this->items ); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="9"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$checked = JHTML::_('grid.id',   $i, $row->id );
		$published = JCollectionHelper::published($row, $i, false );
		$approved = JCollectionHelper::approved($row, $i, false );
		$ordering = ($this->lists['order'] == 'i.ordering');
		?>
	<tr class="<?php echo "row$k"; ?>">
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $checked; ?></td>
		<td><?php echo $row->id; ?></td>
		<td><?php echo $row->name; ?></td>
		<td class="order"><span> <?php echo $this->pagination->orderUpIcon( $i, ($row->itemid == @$this->items[$i-1]->itemid),'orderup', 'Move Up', $ordering ); ?></span><span><?php echo $this->pagination->orderDownIcon( $i, $n, ($row->itemid == @$this->items[$i+1]->itemid), 'orderdown', 'Move Down', $ordering ); ?></span>
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
<input type="hidden" name="option" value="<?php echo $option; ?>" /> <input type="hidden" name="itemid" id="itemid" value="<?php echo $this->itemid; ?>" />
<input type="hidden" name="filter_itemid" id="filter_itemid" value="<?php echo $this->itemid; ?>" />
<input
	type="hidden" name="task" value="popup_item" />
	<input
	type="hidden" name="ptask" value="popup_item" />
	<input type="hidden"
	name="tmpl" value="component" />  <input
	type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="controller" value="infos" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->lists['order']; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir']; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
