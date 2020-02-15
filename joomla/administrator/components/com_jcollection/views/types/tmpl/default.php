<?php
defined('_JEXEC') or die('Restricted access');
global $option;
?>
<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100%"><?php echo JText::_( 'Filter' ); ?>: <input
			type="text" name="search_t" id="search_t"
			value="<?php echo $this->lists['search'];?>" class="text_area"
			onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button
			onclick="document.getElementById('search_t').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
	</tr>
</table>
<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
			<th width="5"><?php echo JText::_( 'ID' ); ?></th>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?php echo count( $this->types ); ?>);" /></th>
			<th><?php echo JText::_( 'Name' ); ?></th>
			<th width="8%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Order', 't.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			<?php echo JHTML::_('grid.order',  $this->types ); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->types ); $i < $n; $i++)
	{
		$row = &$this->types[$i];
		$checked = JHTML::_('grid.id', $i, $row->id, $row->checked_out );
		$ordering = ($this->lists['order'] == 't.ordering');
		$link = JRoute::_( 'index.php?option='.$option.'&amp;controller=type&amp;view=type&amp;task=edit&cid[]='. $row->id );
		?>
	<tr class="<?php echo "row$k"; ?>">
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $row->id; ?></td>
		<td><?php echo $checked; ?></td>
		<td><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></td>
		<td class="order"><span> <?php echo $this->pagination->orderUpIcon( $i, true,'orderup', 'Move Up', $ordering ); ?>
		</span> <span> <?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?>
		</span> <?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
		<input type="text" name="order[]" size="5"
			value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?>
			class="text_area" style="text-align: center" /></td>
	</tr>
	<?php
	$k = 1 - $k;
	}
	?>
</table>
</div>

<input type="hidden" name="option" value="<? echo $option; ?>" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="boxchecked" value="0" /> <input type="hidden" name="controller"
	value="types" /> <input type="hidden" name="view" value="types" />
	<input type="hidden" name="filter_order_t"
	value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir_t"
	value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
