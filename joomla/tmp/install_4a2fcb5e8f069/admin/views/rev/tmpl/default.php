<?php
defined('_JEXEC') or die('Restricted access');
global $option;
$editor =& JFactory::getEditor();
if ($this->review->img == '') {
	$this->review->img = 'blank.png';
}
JFilterOutput::objectHTMLSafe( $this->review, ENT_QUOTES, 'description' );
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td>
		<div class="col100">
		<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key"><label for="name"> <?php echo JText::_( 'Name' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="name" id="name"
					size="32" maxlength="250" value="<?php echo $this->review->name; ?>" />
				</td>
			</tr>
			<tr>
			<td width="100" align="right" class="key"><label for="infoid_name"> <?php echo JText::_( 'Info set' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="infoid_name"
					id="infoid_name" size="32" maxlength="250"
					value="<?php echo $this->review->infoname; ?>" disabled="disabled" /><input type="hidden" name="infoid"
					id="infoid" value="<?php echo $this->review->infoid; ?>" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					(<?php echo JText::_('Item: '); ?>
					<input class="text_area" type="text" name="itemname"
					id="itemname" size="32" maxlength="250"
					value="<?php echo $this->review->itemname; ?>" disabled="disabled" />
					<?php echo JText::_('Category: '); ?>
					<input class="text_area" type="text" name="catname"
					id="catname" size="32" maxlength="250"
					value="<?php echo $this->review->catname; ?>" disabled="disabled" />)
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
		<td valign="top"><?php
		$pane =& JPane::getInstance( 'sliders' );
		echo $pane->startPane( 'content-pane' );
		// First slider panel
		// Create a slider panel with a title of SLIDER_PANEL_1_TITLE and a title id attribute of SLIDER_PANEL_1_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Review' ), 'params-page' );
		// Display the parameters defined in the <params> group with no 'group' attribute
		echo $this->params->render( 'params' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		echo $pane->endPane();
		?></td>
	</tr>
</table>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" /> <input
	type="hidden" name="id" value="<?php echo $this->review->id; ?>" /> <input
	type="hidden" name="cid[]" value="<?php echo $this->review->id; ?>" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="controller" value="rev" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
