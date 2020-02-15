<?php
defined('_JEXEC') or die('Restricted access');
global $option;
$editor =& JFactory::getEditor();
if ($this->cat->img == '') {
	$this->cat->img = 'blank.png';
}
JFilterOutput::objectHTMLSafe( $this->cat, ENT_QUOTES, 'description' );
?>
<script language="javascript" type="text/javascript">
                function submitbutton(pressbutton) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        if ( form.name.value == '' ){
                                alert("<?php echo JText::_( 'Category must have a name', true ); ?>");
                        } else {
                                <?php
                                echo $editor->save( 'description' ) ; ?>
                                submitform(pressbutton);
                        }
                }
                </script>

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
					size="32" maxlength="250" value="<?php echo $this->cat->name; ?>" />
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
				if ($this->cat->img != 'blank.png') {
					$path .= 'jcollection/';
				}
				?> <img src="<?php echo $path;?><?php echo $this->cat->img;?>"
					name="imagelib" width="80" height="80" border="2"
					alt="<?php echo JText::_( 'Preview' ); ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="parent"> <?php echo JText::_( 'Parent' ); ?>:
				</label></td>
				<td><?php echo $this->lists['parent']; ?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="ordering"> <?php echo JText::_( 'Ordering' ); ?>:
				</label></td>
				<td><?php echo $this->lists['ordering']; ?></td>
			</tr>
			<tr>
				<td width="100" align="right" valign="top" class="key"><label for="description">
				<?php echo JText::_( 'Description' ); ?>: </label></td>
				<td><?php
				// parameters : areaname, content, width, height, cols, rows
				echo $editor->display( 'description',  $this->cat->description, '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;
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
		echo $pane->startPanel( JText::_( 'Parameters - Category' ), 'params-page' );
		// Display the parameters defined in the <params> group with no 'group' attribute
		echo $this->params->render( 'params' );
		echo $pane->endPanel();
		//Second slider panel
		echo $pane->endPane();
		?></td>
	</tr>
</table>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" /> <input
	type="hidden" name="id" value="<?php echo $this->cat->id; ?>" /> <input
	type="hidden" name="cid[]" value="<?php echo $this->cat->id; ?>" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="controller" value="category" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
