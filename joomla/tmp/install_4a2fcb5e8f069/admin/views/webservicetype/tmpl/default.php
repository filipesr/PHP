<?php
defined('_JEXEC') or die('Restricted access');
global $option;
$editor =& JFactory::getEditor();
JFilterOutput::objectHTMLSafe( $this->type, ENT_QUOTES, array('disclaimer') );
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
				<td width="100" align="right" valign="top" class="key"><label for="disclaimer">
				<?php echo JText::_( 'Disclaimer' ); ?>: </label></td>
				<td><?php
				// parameters : areaname, content, width, height, cols, rows
				echo $editor->display( 'disclaimer',  $this->type->disclaimer, '550', '300', '60', '20' ) ;
				?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="webservice"> <?php echo JText::_( 'Webservice' ); ?>:
				</label></td>
				<td><?php echo $this->lists['webservice']; ?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="typeid"> <?php echo JText::_( 'Type' ); ?>:
				</label></td>
				<td><?php echo $this->lists['typeid']; ?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info1xpath"> <?php echo JText::_( 'Info 1 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info1xpath"
					id="info1xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info1xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info2xpath"> <?php echo JText::_( 'Info 2 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info2xpath"
					id="info2xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info2xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info3xpath"> <?php echo JText::_( 'Info 3 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info3xpath"
					id="info3xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info3xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info4xpath"> <?php echo JText::_( 'Info 4 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info4xpath"
					id="info4xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info4xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info5xpath"> <?php echo JText::_( 'Info 5 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info5xpath"
					id="info5xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info5xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info6xpath"> <?php echo JText::_( 'Info 6 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info6xpath"
					id="info6xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info6xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info7xpath"> <?php echo JText::_( 'Info 7 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info7xpath"
					id="info7xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info7xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info8xpath"> <?php echo JText::_( 'Info 8 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info8xpath"
					id="info8xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info8xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info9xpath"> <?php echo JText::_( 'Info 9 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info9xpath"
					id="info9xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info9xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info10xpath"> <?php echo JText::_( 'Info 10 XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="info10xpath"
					id="info10xpath" size="32" maxlength="250"
					value="<?php echo $this->type->info10xpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="titlexpath"> <?php echo JText::_( 'Title XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="titlexpath"
					id="titlexpath" size="32" maxlength="250"
					value="<?php echo $this->type->titlexpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="descriptionxpath"> <?php echo JText::_( 'Description XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="descriptionxpath"
					id="descriptionxpath" size="32" maxlength="250"
					value="<?php echo $this->type->descriptionxpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="imgxpath"> <?php echo JText::_( 'Image XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="imgxpath"
					id="imgxpath" size="32" maxlength="250"
					value="<?php echo $this->type->imgxpath; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="urlxpath"> <?php echo JText::_( 'URL XPath' ); ?>:
				</label></td>
				<td><input class="text_area" type="text" name="urlxpath"
					id="urlxpath" size="32" maxlength="250"
					value="<?php echo $this->type->urlxpath; ?>" /></td>
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
		echo $pane->startPanel( JText::_( 'Parameters - Type (webservice)' ), 'params-page' );
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
	name="controller" value="webservicetype" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
