<?php
defined('_JEXEC') or die('Restricted access');
global $option;
$editor =& JFactory::getEditor();
if ($this->l->img == '') {
	$this->l->img = 'blank.png';
}
JFilterOutput::objectHTMLSafe( $this->l, ENT_QUOTES, 'description' );
?>
<script language="javascript" type="text/javascript">
                function submitbutton(pressbutton) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        if ( form.name.value == '' ){
                                alert("<?php echo JText::_( 'List must have a name', true ); ?>");
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
					size="32" maxlength="250" value="<?php echo $this->l->name; ?>" />
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
				if ($this->l->img != 'blank.png') {
					$path.= 'jcollection/';
				}
				?> <img src="<?php echo $path;?><?php echo $this->l->img;?>"
					name="imagelib" width="80" height="80" border="2"
					alt="<?php echo JText::_( 'Preview' ); ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="catid"> <?php echo JText::_( 'List category' ); ?>:
				</label></td>
				<td><?php echo $this->lists['cat']; ?></td>
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
				echo $editor->display( 'description',  $this->l->description, '550', '300', '60', '20', true, array('image','pagebreak','readmore') ) ;
				?></td>
			</tr>
			<tr><td width="100" align="right" valign="top" class="key"><label for="sort"><?php echo JText::_( 'Sort' ); ?>: </label></td>
			<td>
				<div class="button2-left">
				<div class="blank"><a class="modal"
					title="<?php echo JText::_('Sort'); ?>"
					href="index.php?option=com_jcollection&amp;controller=list&amp;task=popup_sort&amp;cid[]=<?php echo $this->l->id; ?>&amp;tmpl=component"
					rel="{handler: 'iframe', size: {x: 650, y: 375}}"><?php echo JText::_('Sort'); ?></a></div>
				</div>
				</td>
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
		echo $pane->startPanel( JText::_( 'Parameters - List' ), 'params-page' );
		// Display the parameters defined in the <params> group with no 'group' attribute
		echo $this->params->render( 'params' );
		echo $pane->endPanel();
		echo $pane->endPane();
		?></td>
	</tr>
</table>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" /> <input
	type="hidden" name="id" value="<?php echo $this->l->id; ?>" /> <input
	type="hidden" name="cid[]" value="<?php echo $this->l->id; ?>" />
	<input
	type="hidden" name="listid" value="<?php echo $this->l->id; ?>" />
	 <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="controller" value="list" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
