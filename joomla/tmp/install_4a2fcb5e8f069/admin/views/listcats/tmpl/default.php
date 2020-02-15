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
		<td nowrap="nowrap"><?php
		echo JText::_( 'State:' ).$this->lists['state'];
		echo "&#160;";
		echo JText::_( 'Approved:' ).$this->lists['approved'];
		echo "&#160;";
		?></td>
	</tr>
	<tr>
		<td align="left" nowrap="nowrap"><?php
		echo "&#160;";
		?></td>
		<td nowrap="nowrap"><?php
		echo JText::_( 'Access:' ).$this->lists['access'];
		echo "&#160;";
		echo JText::_( 'Author:' ).$this->lists['author'];
		?></td>
	</tr>
</table>
<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?php echo count( $this->cats ); ?>);" /></th>
			<th width="20"><?php echo JHTML::_('grid.sort',  'ID', 'c.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Name', 'c.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Approved', 'c.approved', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Published', 'c.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Access', 'c.access', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="8%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Order', 'c.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			<?php echo JHTML::_('grid.order',  $this->cats ); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="8"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
	<?php
	$k = 0;
	$i = 0;
	//for ($i=0, $n=count( $this->cats ); $i < $n; $i++)
	foreach( $this->listcats as $row )
	{
		//		$row = &$this->cats[$i];
		$checked = JHTML::_('grid.id',   $i, $row->id );
		$published = JCollectionHelper::published( $row, $i );
		$approved = JCollectionHelper::approved( $row, $i );

		$ordering = ($this->lists['order'] == 'c.ordering');
		$link = JRoute::_( 'index.php?option='.$option.'&controller=listcat&view=listcat&task=edit&cid[]='.$row->id );
		?>
	<tr class="<?php echo "row$k"; ?>">
	<!-- <tr>  -->
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $checked; ?></td>
		<td><?php echo $row->id; ?></td>
		<td><?php
		if (  JTable::isCheckedOut($this->user->get ('id'), $row->checked_out ) ) {
			echo $row->name;
		} else {
			?> <span class="editlinktip hasTip"
			title="<?php echo JText::_( 'Edit category' );?>::<?php echo $row->name; ?>"><a
			href="<?php echo $link; ?>"><?php echo $row->name; ?></a></span>
			<?php } ?></td>
		<td align="center"><?php echo $approved; ?></td>
		<td align="center"><?php echo $published; ?></td>
		<td align="center"><?php echo JHTML::_( 'grid.access', $row, $i ); ?>
		</td>
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
<input type="hidden" name="view" value="listcats" /> <input
	type="hidden" name="option" value="<?php echo $option; ?>" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="boxchecked" value="0" /> <input type="hidden" name="controller"
	value="listcats" /> <input type="hidden" name="filter_order"
	value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir']; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
