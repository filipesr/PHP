<?php defined('_JEXEC') or die('Restricted access');
global $option; ?>
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
	</tr>
</table>
<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?php echo count( $this->types ); ?>);" /></th>
			<th width="20"><?php echo JHTML::_('grid.sort',  'ID', 'i.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Name', 'i.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Webservice', 'i.webservice', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="8%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Order', 'i.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
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
	$i = 0;
	//for ($i=0, $n=count( $this->cats ); $i < $n; $i++)
	foreach( $this->types as $row )
	{
		//		$row = &$this->cats[$i];
		$checked = JHTML::_('grid.id',   $i, $row->id );

		$ordering = ($this->lists['order'] == 'i.ordering');
		$link = JRoute::_( 'index.php?option='.$option.'&controller=webservicetype&view=webservicetype&task=edit&cid[]='.$row->id );
		?>
	<!--	<tr class="<?php echo "row$k"; ?>"> -->
	<tr>
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $checked; ?></td>
		<td><?php echo $row->id; ?></td>
		<td><?php
		if (  JTable::isCheckedOut($this->user->get ('id'), $row->checked_out ) ) {
			echo $row->name;
		} else {
			?> <span class="editlinktip hasTip"
			title="<?php echo JText::_( 'Edit type (webservices)' );?>::<?php echo $row->name; ?>"><a
			href="<?php echo $link; ?>"><?php echo $row->name; ?></a></span>
			<?php } ?></td>
		<td><?php echo $row->webservice; ?></td>
		<td class="order"><span> <?php echo $this->pagination->orderUpIcon( $i, true,'orderup', 'Move Up', $ordering ); ?>
		</span> <span> <?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?>
		</span> <?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
		<input type="text" name="order[]" size="5"
			value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?>
			class="text_area" style="text-align: center" /></td>
	</tr>
	<?php
	$k = 1 - $k;
	$i++;
	}
	?>
</table>
</div>
<input type="hidden" name="view" value="webservicetypes" /> <input
	type="hidden" name="option" value="<?php echo $option; ?>" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="boxchecked" value="0" /> <input type="hidden" name="controller"
	value="webservicetypes" /> <input type="hidden" name="filter_order"
	value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir']; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
