<?php defined('_JEXEC') or die('Restricted access');
global $option;
?>
<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100%"><?php echo JText::_( 'Filter' ); ?>: <input
			type="text" name="search_c" id="search_c"
			value="<?php echo $this->lists['search'];?>" class="text_area"
			onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button
			onclick="document.getElementById('search_c').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
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
		echo JText::_( 'Parent:' ).$this->lists['parent'];
		echo "&#160;";
		echo JText::_( 'Level:' ).$this->lists['levellist'];
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
			<td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
	<?php
	$k = 0;
	$i = 0;
	//for ($i=0, $n=count( $this->cats ); $i < $n; $i++)
	foreach( $this->cats as $row )
	{
		$published = JCollectionHelper::approved( $row, $i, false );

		$approved = JCollectionHelper::approved( $row, $i, false );
		$ordering = ($this->lists['order'] == 'c.ordering');
		$link = JRoute::_( 'index.php?option='.$option.'&controller=category&view=category&task=edit&cid[]='.$row->id );
		?>
	<tr>
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $row->id; ?></td>
		<td><a style="cursor: pointer;"
			onclick="window.parent.jSelectItem('<?php echo $row->slug; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', '<?php echo JRequest::getVar('object'); ?>');"><?php echo $row->treename; ?></a>
		</td>
		<td align="center"><?php echo $approved; ?></td>
		<td align="center"><?php echo $published; ?></td>
		<td align="center"><?php echo JHTML::_( 'grid.access', $row, $i, -1 ); ?>
		</td>
		<td class="order"><span> <?php echo $this->pagination->orderUpIcon( $i, true,'orderup', 'Move Up', $ordering ); ?>
		</span> <span> <?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?>
		</span> <?php $disabled = 'disabled="disabled"'; ?>
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
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="category" />
<input type="hidden" name="tmpl" value="component" />
<input type="hidden" name="object" value="<?php echo JRequest::getVar('object'); ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="elements" />
<input type="hidden" name="filter_order_c" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir_c" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
