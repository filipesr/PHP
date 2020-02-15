<?php defined('_JEXEC') or die('Restricted access');
global $option;
if($this->imdbphp) {
	?>
<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100%"><?php echo JText::_( 'Filter' ); ?>: <input
			type="text" name="search_wsm" id="search_wsm"
			value="<?php echo $this->lists['search'];?>"
			onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button
			onclick="document.getElementById('search_wsm').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
	</tr>
</table>
<div id="editcell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
			<th width="20"><?php echo JText::_( 'ID' ); ?>
			</th>
			<th><?php echo JText::_( 'Name' ); ?>
			</th>
			<th><?php echo JText::_( 'Year' ); ?>
			</th>
			<th><?php echo JText::_( 'Director' ); ?>
			</th>
			<th><?php echo JText::_( 'Actor' ); ?>
			</th>
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
	foreach( $this->items as $row )
	{
		$ordering = ($this->lists['order'] == 'c.ordering');
		?>
	<!--	<tr class="<?php echo "row$k"; ?>"> -->
	<tr>
		<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
		<td><?php echo $row->id; ?></td>
		<td><a style="cursor: pointer;"
			onclick="window.parent.jSelectItem('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', '<?php echo JRequest::getVar('object'); ?>');"><?php echo $row->name; ?></a>
		</td>
		<td><?php echo $row->year; ?></td>
		<td><?php echo $row->director; ?></td>
		<td><?php echo $row->actor; ?></td>
	</tr>
	<?php
	$k = 1 - $k;
	$i++;
	}
	?>
</table>
</div>
<input type="hidden" name="option" value="<?php echo $option; ?>" /> <input
	type="hidden" name="task" value="imdbitem" /> <input type="hidden"
	name="tmpl" value="component" /> <input type="hidden" name="object"
	value="<?php echo JRequest::getVar('object'); ?>" /> <input
	type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="controller" value="elements" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->lists['order']; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir']; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
	<?php
} else {
	echo '<b>'.JText::_('imdbphp not found!').'</b><br />';
	echo JText::_("IMDBPHPINSTALL");
}?>