<?php
defined('_JEXEC') or die('Restricted access');
global $option;
$editor =& JFactory::getEditor();
if ($this->list->img == '') {
	$this->list->img = 'blank.png';
}
JFilterOutput::objectHTMLSafe( $this->list, ENT_QUOTES, 'description' );
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

<form action="index.php?ret=<?php echo JRequest::getVar( 'ret' ); ?>" method="post" name="adminForm" id="adminForm">

<table class="adminform" width="100%">
	<tr>
		<td>
		<div style="float: left;"><label for="title"> <?php echo JText::_( 'Name' ); ?>:
		</label> <input class="inputbox" type="text" id="name" name="name"
			size="50" maxlength="100"
			value="<?php echo $this->escape($this->list->name); ?>" /> <input
			class="inputbox" type="hidden" id="alias" name="alias"
			value="<?php echo $this->escape($this->list->alias); ?>" /></div>
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
<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td>
		<div class="col100">
		<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
			<tr>
				<td class="key"><label for="img"> <?php echo JText::_( 'Image' ); ?>:
				</label></td>
				<td><?php echo $this->lists['image']; ?></td>
			</tr>
			<tr>
				<td class="key" align="right" width="100" valign="top"><label for="img_preview"> <?php echo JText::_( 'Preview' ); ?>:</label></td>
				<td><?php
				$path = JURI::root() . 'images/';
				if ($this->list->img != 'blank.png') {
					$path.= 'jcollection/';
				}
				?> <img src="<?php echo $path;?><?php echo $this->list->img;?>"
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
				echo $editor->display( 'description',  $this->list->description, '550', '300', '60', '20', true, array('image','pagebreak','readmore') ) ;
				?></td>
			</tr>
			<tr><td width="100" align="right" valign="top" class="key"><label for="sort"><?php echo JText::_( 'Sort' ); ?>: </label></td>
			<td>
				<div class="button2-left">
				<div class="blank"><a class="modal"
					title="<?php echo JText::_('Sort'); ?>"
					href="index.php?option=com_jcollection&amp;controller=list&amp;view=list&amp;task=popup_sort&amp;listid=<?php echo $this->list->id; ?>&amp;tmpl=component"
					rel="{handler: 'iframe', size: {x: 650, y: 375}}"><?php echo JText::_('Sort'); ?></a></div>
				</div>
				</td>
			</tr>
			<tr><td width="100" align="right" valign="top" class="key"><label for="add"><?php echo JText::_( 'Add' ); ?>: </label></td>
			<td>
				<div class="button2-left">
				<div class="blank"><a class="modal"
					title="<?php echo JText::_('Add'); ?>"
					href="index.php?option=com_jcollection&amp;controller=list&amp;view=items&amp;task=popup_listadd&amp;listid=<?php echo $this->list->id; ?>&amp;tmpl=component"
					rel="{handler: 'iframe', size: {x: 650, y: 375}}"><?php echo JText::_('Add'); ?></a></div>
				</div>
				</td>
			</tr>
		</table>
		</fieldset>
		</div>
		</td>
	</tr>
</table>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" />
<input type="hidden" name="id" value="<?php echo $this->list->id; ?>" />
<input type="hidden" name="cid[]" value="<?php echo $this->list->id; ?>" />
<input type="hidden" name="listid" value="<?php echo $this->list->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="list" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
