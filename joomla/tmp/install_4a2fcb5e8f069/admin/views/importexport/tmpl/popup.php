<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php global $option; ?>
<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm">
<fieldset>
<div style="float: right">
<button type="button"
	onclick="window.parent.document.getElementById('sbox-window').close();">
Close</button>
</div>
<div class="configuration">JCollection - Import/export data</div>
</fieldset>

<div class="col100">
<fieldset class="adminform"><legend><?php echo JText::_( 'Import options' ); ?></legend>

<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><label for="import_cm"> <?php echo JText::_( 'Collection Manager 0.4' ); ?>:
		</label></td>
		<td>
		<button type="button" onclick="submitbutton('import_cm');" id="import_cm">Import!</button>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><label for="import_asin"> <?php echo JText::_( 'File with ASINs/ISBNs' ); ?>:
		</label></td>
		<td>
		<input name="asin_file" type="file" />
		<button type="button" onclick="submitbutton('import_asin');" id="import_asin">Import!</button>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><label for="import_gc"> <?php echo JText::_( 'Garys Cookbook' ); ?>:
		</label></td>
		<td>
		<button type="button" onclick="submitbutton('import_gc');"  id="import_gc">Import!</button>
		</td>
	</tr>
</table>

</fieldset>

<div class="col100">
<fieldset class="adminform"><legend><?php echo JText::_( 'Export options' ); ?></legend>

<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><label for="export_db"> <?php echo JText::_( 'Database dump' ); ?>:
		</label></td>
		<td>
		<button type="button" onclick="submitbutton('export_db');" id="export_db">Export!</button>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><label for="export_xml"> <?php echo JText::_( 'XML' ); ?>:
		</label></td>
		<td>
		<button type="button" onclick="submitbutton('export_xml');" id="export_xml">Export!</button>
		</td>
	</tr>
</table>

</fieldset>

<input type="hidden" name="option" value="<?php echo $option; ?>" /> <input
	type="hidden" name="task" value="" /> <input type="hidden" name="view"
	value="importexport" /> <input type="hidden" name="tmpl"
	value="component" /> <input type="hidden" name="layout" value="popup" />
<input type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="controller" value="importexport" /> <?php echo JHTML::_( 'form.token' ); ?>

</form>
