<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JFilterOutput::objectHTMLSafe( $this->rev, ENT_QUOTES, array( 'description', 'review' ) );
$item = &$this->review;
$params = &$this->params;
$editor =& JFactory::getEditor();
if ($this->review->img == '') {
	$this->review->img = 'blank.png';
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
		return alert ( "<?php echo JText::_( 'Review must have a name', true ); ?>" );
	}
    <?php echo $editor->save( 'description' ); ?>
    <?php echo $editor->save( 'review' ); ?>
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
			value="<?php echo $this->escape( $this->review->name ); ?>" /> <input
			class="inputbox" type="hidden" id="alias" name="alias"
			value="<?php echo $this->escape( $this->review->alias ); ?>" /></div>
		<div style="float: right;">
		<button type="button" onclick="submitbutton('save')"><?php echo JText::_('Save') ?>
		</button>
		<button type="button" onclick="submitbutton('cancel')"><?php echo JText::_('Cancel') ?>
		</button>
		</div>
		</td>
	</tr>
</table>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td>
		<div class="col100">
		<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
			<tr>
			<td width="100" align="right" class="key"><label for="infoid_name"> <?php echo JText::_( 'Info set' ); ?>:
				</label></td>
				<td><?php echo $this->review->infoname; ?><input type="hidden" name="infoid"
					id="infoid" value="<?php echo $this->review->infoid; ?>" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					(<?php echo JText::_('Item: '); ?>
					<?php echo $this->review->itemname; ?>;
					<?php echo JText::_('Category: '); ?>
					<?php echo $this->review->catname; ?>)
					</td>
			</tr>
			<tr>
				<td class="key"><label for="img"> <?php echo JText::_( 'Image' ); ?>:
				</label></td>
				<td><?php echo $this->lists['image']; ?></td>
			</tr>
			<tr>
				<td class="key" align="right" width="100" valign="top"><label for="img_preview"> <?php echo JText::_( 'Preview' ); ?>:</label></td>
				<td><?php
				$path = JURI::root() . 'images/';
				if ($this->review->img != 'blank.png') {
					$path.= 'jcollection/';
				}
				?> <img src="<?php echo $path;?><?php echo $this->review->img;?>"
					name="imagelib" width="80" height="80" border="2"
					alt="<?php echo JText::_( 'Preview' ); ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="ordering"> <?php echo JText::_( 'Ordering' ); ?>:
				</label></td>
				<td><?php echo $this->lists['ordering']; ?></td>
			</tr>
			<?php
			for( $i = 1; $i<=5; $i++ ) {
				$ratinglabelname = 'rating'.$i.'label';
				$ratinglabel = $this->review->$ratinglabelname;
			?>
			<tr>
				<td>
					<div id="rating<?php echo $i; ?>label"><?php echo $ratinglabel; ?></div>
				</td>
				<td><?php
					$ratingname = 'rating'.$i;
					$checked0 = ( $this->review->$ratingname == 0 ? 'checked="checked"' : '' );
					$checked1 = ( $this->review->$ratingname == 1 ? 'checked="checked"' : '' );
					$checked2 = ( $this->review->$ratingname == 2 ? 'checked="checked"' : '' );
					$checked3 = ( $this->review->$ratingname == 3 ? 'checked="checked"' : '' );
					$checked4 = ( $this->review->$ratingname == 4 ? 'checked="checked"' : '' );
					$checked5 = ( $this->review->$ratingname == 5 ? 'checked="checked"' : '' );
					?>
				<span class="content_vote">
					Not set
					<input type="radio" alt="<?php echo JText::_( 'unset vote' ); ?>" name="rating<?php echo $i; ?>" value="0" <?php echo $checked0; ?> />
					Poor
					<input type="radio" alt="<?php echo JText::_( 'vote 1 star' ); ?>" name="rating<?php echo $i; ?>" value="1" <?php echo $checked1; ?> />
					<input type="radio" alt="<?php echo JText::_( 'vote 2 star' ); ?>" name="rating<?php echo $i; ?>" value="2" <?php echo $checked2; ?> />
					<input type="radio" alt="<?php echo JText::_( 'vote 3 star' ); ?>" name="rating<?php echo $i; ?>" value="3" <?php echo $checked3; ?> />
					<input type="radio" alt="<?php echo JText::_( 'vote 4 star' ); ?>" name="rating<?php echo $i; ?>" value="4" <?php echo $checked4; ?> />
					<input type="radio" alt="<?php echo JText::_( 'vote 5 star' ); ?>" name="rating<?php echo $i; ?>" value="5" <?php echo $checked5; ?> />
					Best</td>
				</span>
			</tr>
			<?php } ?>
			<tr>
				<td width="100" align="right" valign="top" class="key"><label for="description">
				<?php echo JText::_( 'Review' ); ?>: </label></td>
				<td><?php
				// parameters : areaname, content, width, height, cols, rows
				echo $editor->display( 'description',  $this->review->description, '550', '300', '60', '20', true, array('image', 'pagebreak', 'readmore') ) ;
				?></td>
			</tr>
		</table>
		</fieldset>
		</div>
		</td>
	</tr>
</table>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" />
<input type="hidden" name="infoid" id="infoid" value="<?php echo $this->review->infoid; ?>" />
<input type="hidden" name="reviewid" id="reviewid" value="<?php echo $this->review->id; ?>" />
<input type="hidden" name="id" id="id" value="<?php echo $this->review->id; ?>" />
<input type="hidden" name="itemid" id="itemid" value="<?php echo $this->review->itemid; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="rev" />
<input type="hidden" name="view" value="rev" />
<input type="hidden" name="created_by" value="<?php echo $this->review->created_by; ?>" />
<input type="hidden" name="referer" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php echo JHTML::_( 'behavior.keepalive' ); ?>
