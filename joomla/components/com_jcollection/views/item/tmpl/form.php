<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JFilterOutput::objectHTMLSafe( $this->item, ENT_QUOTES, 'description' );
$item = &$this->item;
$params = &$this->params;
$editor =& JFactory::getEditor();
if ($this->item->img == '') {
	$this->item->img = 'blank.png';
}
if ($this->item->info->img == '') {
	$this->item->info->img = 'blank.png';
}
?>

<script language="javascript" type="text/javascript">
<!--
function submitbutton(pressbutton)
{
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	try {
		//form.onsubmit();
	} catch( e ) {
		alert( e );
	}

	// do field validation
	if ( form.name.value == '' ) {
		return alert ( "<?php echo JText::_( 'Item must have a name', true ); ?>" );
	} else if (form.catid && getSelectedValue('adminForm','catid') < 1) {
		return alert ( "<?php echo JText::_( 'Please select a category', true ); ?>" );
	}
    <?php echo $editor->save( 'description' ); ?>
    submitform( pressbutton );
}
//-->
</script>


<form action="index.php?ret=<?php echo JRequest::getVar( 'ret' ); ?>"
	method="post" name="adminForm" id="adminForm">

<table class="adminform" width="100%">
	<tr>
		<td>
		<div style="float: left;"><label for="title"> <?php echo JText::_( 'Name' ); ?>:
		</label> <input class="inputbox" type="text" id="name" name="name"
			size="50" maxlength="100"
			value="<?php echo $this->escape($this->item->name); ?>" /> <input
			class="inputbox" type="hidden" id="alias" name="alias"
			value="<?php echo $this->escape($this->item->alias); ?>" /></div>
		<div style="float: right;">
		<button type="button" onclick="submitbutton('save')"><?php echo JText::_('Save') ?>
		</button>
		<button type="button" onclick="submitbutton('cancel')"><?php echo JText::_('Cancel') ?>
		</button>
		</div>
		</td>
	</tr>
</table>


<div class="col100">
<table class="admintable">
	<tr>
		<td>

		<div class="col100">
		<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key"><label for="catid"><?php echo JText::_( 'Category' ); ?>:</label>
				</td>
				<td><?php echo $this->lists['catid']; ?></td>
			</tr>
			<tr>
				<td class="key"><label for="img"> <?php echo JText::_( 'Image' ); ?>:
				</label></td>
				<td><?php echo $this->lists['image']; ?></td>
			</tr>
			<tr>
				<td class="key" align="right" width="100" valign="top"><label
					for="img_preview"> <?php echo JText::_( 'Preview' ); ?>:</label></td>
				<td><?php
				$path = JURI::root() . 'images/';
				if ($this->item->img != 'blank.png') {
					$path .= 'jcollection/';
				}
				?> <img src="<?php echo $path;?><?php echo $this->item->img;?>"
					name="imagelib" width="80" height="80" border="2"
					alt="<?php echo JText::_( 'Preview' ); ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="description"><?php echo JText::_( 'Decription' ); ?></label>
				</td>
				<td><?php
				// parameters : areaname, content, width, height, cols, rows
				echo $editor->display( 'description',  $this->item->description , '100%', '300', '75', '10' ) ;
				?></td>
			</tr>
		</table>
		</fieldset>
		</div>
		</td>
	</tr>
</table>
</div>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" />
<input type="hidden" name="id" id="id" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="item" />
<input type="hidden" name="view" value="item" />
<input type="hidden" name="created_by" value="<?php echo $this->item->created_by; ?>" />
<input type="hidden" name="referer" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php echo JHTML::_( 'behavior.keepalive' ); ?>
