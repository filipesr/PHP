<?php
defined('_JEXEC') or die('Restricted access');
global $option;
JFilterOutput::objectHTMLSafe($this->type,ENT_QUOTES);
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
					size="32" maxlength="250" value="<?php echo $this->type->name; ?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info1label"> <?php echo JText::_( 'Info 1' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info1label"
					id="info1label" size="32" maxlength="250"
					value="<?php echo $this->type->info1label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info1html"> <?php echo JText::_( 'Info 1 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info1html"
					id="info1html" size="32" maxlength="250"
					value="<?php echo $this->type->info1html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info2label"> <?php echo JText::_( 'Info 2' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info2label"
					id="info2label" size="32" maxlength="250"
					value="<?php echo $this->type->info2label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info2html"> <?php echo JText::_( 'Info 2 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info2html"
					id="info2html" size="32" maxlength="250"
					value="<?php echo $this->type->info2html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info3label"> <?php echo JText::_( 'Info 3' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info3label"
					id="info3label" size="32" maxlength="250"
					value="<?php echo $this->type->info3label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info3html"> <?php echo JText::_( 'Info 3 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info3html"
					id="info3html" size="32" maxlength="250"
					value="<?php echo $this->type->info3html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info4label"> <?php echo JText::_( 'Info 4' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info4label"
					id="info4label" size="32" maxlength="250"
					value="<?php echo $this->type->info4label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info4html"> <?php echo JText::_( 'Info 4 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info4html"
					id="info4html" size="32" maxlength="250"
					value="<?php echo $this->type->info4html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info5label"> <?php echo JText::_( 'Info 5' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info5label"
					id="info5label" size="32" maxlength="250"
					value="<?php echo $this->type->info5label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info5html"> <?php echo JText::_( 'Info 5 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info5html"
					id="info5html" size="32" maxlength="250"
					value="<?php echo $this->type->info5html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info6label"> <?php echo JText::_( 'Info 6' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info6label"
					id="info6label" size="32" maxlength="250"
					value="<?php echo $this->type->info6label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info6html"> <?php echo JText::_( 'Info 6 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info6html"
					id="info6html" size="32" maxlength="250"
					value="<?php echo $this->type->info6html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info7label"> <?php echo JText::_( 'Info 7' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info7label"
					id="info7label" size="32" maxlength="250"
					value="<?php echo $this->type->info7label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info7html"> <?php echo JText::_( 'Info 7 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info7html"
					id="info7html" size="32" maxlength="250"
					value="<?php echo $this->type->info7html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info8label"> <?php echo JText::_( 'Info 8' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info8label"
					id="info8label" size="32" maxlength="250"
					value="<?php echo $this->type->info8label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info8html"> <?php echo JText::_( 'Info 8 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info8html"
					id="info8html" size="32" maxlength="250"
					value="<?php echo $this->type->info8html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info9label"> <?php echo JText::_( 'Info 9' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info9label"
					id="info9label" size="32" maxlength="250"
					value="<?php echo $this->type->info9label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info9html"> <?php echo JText::_( 'Info 9 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info9html"
					id="info9html" size="32" maxlength="250"
					value="<?php echo $this->type->info9html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info10label">
				<?php echo JText::_( 'Info 10' ); ?>: </label></td>
				<td><input class="text_area" type="text" name="info10label"
					id="info10label" size="32" maxlength="250"
					value="<?php echo $this->type->info10label; ?>" /></td>
				<td width="100" align="right" class="key"><label for="info10html"> <?php echo JText::_( 'Info 10 HTML' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info10html"
					id="info10html" size="32" maxlength="250"
					value="<?php echo $this->type->info10html; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="rating1label"> <?php echo JText::_( 'Rating 1' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="rating1label"
					id="rating1label" size="32" maxlength="250"
					value="<?php echo $this->type->rating1label; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="rating2label"> <?php echo JText::_( 'Rating 2' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="rating2label"
					id="rating2label" size="32" maxlength="250"
					value="<?php echo $this->type->rating2label; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="rating3label"> <?php echo JText::_( 'Rating 3' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="rating3label"
					id="rating3label" size="32" maxlength="250"
					value="<?php echo $this->type->rating3label; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="rating4label"> <?php echo JText::_( 'Rating 4' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="rating4label"
					id="rating4label" size="32" maxlength="250"
					value="<?php echo $this->type->rating4label; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="rating5label"> <?php echo JText::_( 'Rating 5' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="rating5label"
					id="rating5label" size="32" maxlength="250"
					value="<?php echo $this->type->rating5label; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="ordering"> <?php echo JText::_( 'Ordering' ); ?>:
				</label></td>
				<td><?php echo $this->lists['ordering']; ?></td>
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
		echo $pane->startPanel( JText::_( 'Parameters - Type' ), 'params-page' );
		// Display the parameters defined in the <params> group with no 'group' attribute
		echo $this->params->render( 'params' );
		echo $pane->endPanel();
		echo $pane->endPane();
		?></td>
	</tr>
</table>
<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" /> <input
	type="hidden" name="id" value="<?php echo $this->type->id; ?>" /> <input
	type="hidden" name="cid[]" value="<?php echo $this->type->id; ?>" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="controller" value="type" /> <input type="hidden" name="view"
	value="type" /> <?php echo JHTML::_( 'form.token' ); ?></form>
