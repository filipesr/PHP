<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JFilterOutput::objectHTMLSafe( $this->info, ENT_QUOTES, 'description' );
$item = &$this->info;
$params = &$this->params;
$editor =& JFactory::getEditor();
if ($this->info->img == '') {
	$this->info->img = 'blank.png';
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
		return alert ( "<?php echo JText::_( 'Info set must have a name', true ); ?>" );
	} else if (form.typeid && getSelectedValue('adminForm','typeid') < 1) {
		return alert ( "<?php echo JText::_( 'Please select a type', true ); ?>" );
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
			value="<?php echo $this->escape($this->info->name); ?>" /> <input
			class="inputbox" type="hidden" id="alias" name="alias"
			value="<?php echo $this->escape($this->info->alias); ?>" /></div>
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
				<td width="100" align="right" class="key"><label for="typeid"><?php echo JText::_( 'Type' ); ?>:</label>
				</td>
				<td><?php echo $this->lists['typeid']; ?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="infotitle"
					id="infotitlelabel"><?php echo JText::_( 'Info title' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="infotitle"
					id="infotitle" size="32" maxlength="250"
					value="<?php echo $row->title; ?>" /></td>
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
				if ($this->info->img != 'blank.png') {
					$path .= 'jcollection/';
				}
				?> <img src="<?php echo $path;?><?php echo $this->info->img;?>"
					name="imagelib" width="80" height="80" border="2"
					alt="<?php echo JText::_( 'Preview' ); ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="description"><?php echo JText::_( 'Decription' ); ?></label>
				</td>
				<td><?php
				// parameters : areaname, content, width, height, cols, rows
				echo $editor->display( 'description',  $this->info->description , '100%', '300', '75', '10' ) ;
				?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="infourl"
					id="infourllabel"><?php echo JText::_( 'Info URL' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="infourl" id="infourl"
					size="32" maxlength="250" value="<?php echo $this->info->url; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info1"
					id="info1label"><?php echo JText::_( 'Info #1' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info1" id="info1"
					size="32" maxlength="250" value="<?php echo $this->info->info1; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info2"
					id="info2label"><?php echo JText::_( 'Info #2' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info2" id="info2"
					size="32" maxlength="250" value="<?php echo $this->info->info2; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info3"
					id="info3label"><?php echo JText::_( 'Info #3' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info3" id="info3"
					size="32" maxlength="250" value="<?php echo $this->info->info3; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info4"
					id="info4label"><?php echo JText::_( 'Info #4' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info4" id="info4"
					size="32" maxlength="250" value="<?php echo $this->info->info4; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info5"
					id="info5label"><?php echo JText::_( 'Info #5' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info5" id="info5"
					size="32" maxlength="250" value="<?php echo $this->info->info5; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info6"
					id="info6label"><?php echo JText::_( 'Info #6' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info6" id="info6"
					size="32" maxlength="250" value="<?php echo $this->info->info6; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info7"
					id="info7label"><?php echo JText::_( 'Info #7' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info7" id="info7"
					size="32" maxlength="250" value="<?php echo $this->info->info7; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info8"
					id="info8label"><?php echo JText::_( 'Info #8' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info8" id="info8"
					size="32" maxlength="250" value="<?php echo $this->info->info8; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info9"
					id="info9label"><?php echo JText::_( 'Info #9' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info9" id="info9"
					size="32" maxlength="250" value="<?php echo $this->info->info9; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info10"
					id="info10label"><?php echo JText::_( 'Info #10' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info10" id="info10"
					size="32" maxlength="250" value="<?php echo $this->info->info10; ?>" /></td>
			</tr>
		</table>
		</fieldset>
		</div>
		</td>
	</tr>
	<tr>
	<td>
		<div class="col100">
		<fieldset class="adminform"><legend><?php echo JText::_( 'Parameters' ); ?></legend>
		<table class="admintable">
			<tr><td><?php echo $this->infoparams->render( 'params' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'Amazon' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'Google' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'Wikipedia' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'ISBNdb' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'imdb' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'Yahoo' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'EBay' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'Zanox' ); ?></td></tr>
			<tr><td><?php echo $this->infoparams->render( 'params', 'Lastfm' ); ?></td></tr>
		</table>
		</fieldset></div>
	</td>
	</tr>
</table>
</div>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" />
<input type="hidden" name="infoid" id="infoid" value="<?php echo $this->info->id; ?>" />
<input type="hidden" name="id" id="id" value="<?php echo $this->info->id; ?>" />
<input type="hidden" name="itemid" id="itemid" value="<?php echo $this->info->itemid; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="info" />
<input type="hidden" name="view" value="info" />
<input type="hidden" name="created_by" value="<?php echo $this->info->created_by; ?>" />
<input type="hidden" name="referer" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php echo JHTML::_( 'behavior.keepalive' ); ?>
