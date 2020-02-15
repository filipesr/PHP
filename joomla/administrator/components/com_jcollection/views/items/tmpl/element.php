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
			onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
		<td nowrap="nowrap"><?php
		echo $this->lists['catid'];
		echo $this->lists['published'];
		?></td>
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
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Published', 'i.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="8%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Order', 'i.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			<?php echo JHTML::_('grid.order',  $this->items ); ?></th>
			<th width="15%" class="title"><?php echo JHTML::_('grid.sort',  'Category', 'category', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%"><?php echo JHTML::_('grid.sort',  'Hits', 'i.hits', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
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
		$published = JHTML::_('grid.published', $row, $i );
		$ordering = ($this->lists['order'] == 'i.ordering');
		?>
	<tr class="<?php echo "row$k"; ?>">
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $row->id; ?></td>
		<td><a style="cursor: pointer;"
			onclick="window.parent.jSelectItem('<?php echo $row->slug; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', '<?php echo JRequest::getVar('object'); ?>');"><?php echo htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8'); ?></a>
		</td>
		<td align="center"><?php echo $published; ?></td>
		<td class="order"><span> <?php echo $this->pagination->orderUpIcon( $i, ($row->catid == @$this->items[$i-1]->catid),'orderup', 'Move Up', $ordering ); ?></span><span><?php echo $this->pagination->orderDownIcon( $i, $n, ($row->catid == @$this->items[$i+1]->catid), 'orderdown', 'Move Down', $ordering ); ?></span>
		<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?> <input
			type="text" name="order[]" size="5"
			value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?>
			class="text_area" style="text-align: center" /></td>
		<td><?php echo $row->category; ?></td>
		<td align="center"><?php echo $row->hits; ?></td>
	</tr>
	<?php
	$k = 1 - $k;
	}
	?>
</table>
</div>
<input type="hidden" name="option" value="<?php echo $option; ?>" /> <input
	type="hidden" name="task" value="item" /> <input type="hidden"
	name="tmpl" value="component" /> <input type="hidden" name="object"
	value="<?php echo JRequest::getVar('object'); ?>" /> <input
	type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="controller" value="elements" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->lists['order']; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir']; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
