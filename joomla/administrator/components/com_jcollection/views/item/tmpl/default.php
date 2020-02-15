<?php defined('_JEXEC') or die('Restricted access');
global $option;
JFilterOutput::objectHTMLSafe( $this->item, ENT_QUOTES, 'description' );
$editor =& JFactory::getEditor();
if ($this->item->img == '') {
	$this->item->img = 'blank.png';
}
if ($this->item->info->img == '') {
	$this->item->info->img = 'blank.png';
}
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">

<div class="col100">
<table class="admintable">
	<tr>
		<td>

		<div class="col100">
		<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key"><label for="name"><?php echo JText::_( 'Name' ); ?>:</label>
				</td>
				<td><input class="text_area" type="text" name="name" id="name"
					size="32" maxlength="250" value="<?php echo $this->item->name; ?>" />
				</td>
			</tr>
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
				echo $this->editor->display( 'description',  $this->item->description , '100%', '300', '75', '10' ) ;
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
		echo $pane->startPanel( JText::_( 'Parameters - Item' ), 'params-page' );
		// Display the parameters defined in the <params> group with no 'group' attribute
		echo $this->params->render( 'params' );
		echo $pane->endPanel();
		//Second slider panel
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Overwrites' ), 'overwrites-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->params->render( 'params', 'Overwrites' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Amazon' ), 'amazon-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->params->render( 'params', 'Amazon' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		echo $pane->endPane();
		?></td>
	</tr>
</table>
</div>

<div class="clr"></div>

<input type="hidden" name="option" value="<? echo $option; ?>" /> <input
	type="hidden" name="id" id="id" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" /> <input type="hidden"
	name="controller" value="item" /> <input type="hidden" name="view"
	value="item" /> <?php echo JHTML::_( 'form.token' ); ?></form>

		<?php
		$row = &$this->item->info;
		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'description' );
		?>

<form action="index.php" method="post" name="adminFormInfo"
	id="adminFormInfo">

<div class="col100">
<fieldset class="adminform"><legend><?php echo JText::_( 'Info fields' ); ?></legend>

<table class="admintable">
	<tr>
		<td colspan="2">
		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key"><label for="infoid"><?php echo JText::_( 'Info set' ); ?>:</label>
				</td>
				<td nowrap="nowrap"><span id="infoid_div"><?php echo $this->lists['infoid']; ?></span>&#160;
				<div class="button2-left">
				<div class="blank"><a class="modal"
					title="<?php echo JText::_('Sort'); ?>"
					href="index.php?option=com_jcollection&amp;controller=infos&amp;task=popup_item&amp;filter_item=<?php echo $this->item->id; ?>&amp;tmpl=component"
					rel="{handler: 'iframe', size: {x: 650, y: 375}}"><?php echo JText::_('Sort'); ?></a></div>
				</div>
				</td>
				<td width="100" align="right" class="key"><label for="infoname"><?php echo JText::_( 'Current info set name' ); ?>:</label>
				</td>
				<td><input class="text_area" type="text" name="infoname"
					id="infoname" size="32" maxlength="250"
					value="<?php echo $row->name; ?>" /></td>
				<td align="right">
				<button id="saveinfo" name="saveinfo">save</button>
				</td>
				<td>
				<div id="infostatus" name="infostatus"></div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
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
				<td width="100" align="right" class="key"><label
					for="infodescription" id="infodescriptionlabel"><?php echo JText::_( 'Info description' ); ?>:</label></td>
				<td><?php
					echo $this->editor->display( 'infodescription',  $this->item->info->description , '100%', '300', '75', '10' ) ;
					?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="infoimg"
					id="infoimglabel"><?php echo JText::_( 'Info image' ); ?>:</label></td>
				<td><?php echo $this->lists['infoimg']; ?></td>
			</tr>
			<tr>
				<td class="key" align="right" width="100" valign="top"><label
					for="infoimg_preview"> <?php echo JText::_( 'Preview' ); ?>:</label></td>
				<td><?php
				$path = JURI::root() . 'images/';
				if ($row->img != 'blank.png') {
					$path .= 'jcollection/';
				}
				?> <img src="<?php echo $path; ?><?php echo $row->img;?>"
					name="imagelib2" width="80" height="80" border="2"
					alt="<?php echo JText::_( 'Preview' ); ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="infourl"
					id="infourllabel"><?php echo JText::_( 'Info URL' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="infourl" id="infourl"
					size="32" maxlength="250" value="<?php echo $row->url; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info1"
					id="info1label"><?php echo JText::_( 'Info #1' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info1" id="info1"
					size="32" maxlength="250" value="<?php echo $row->info1; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info2"
					id="info2label"><?php echo JText::_( 'Info #2' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info2" id="info2"
					size="32" maxlength="250" value="<?php echo $row->info2; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info3"
					id="info3label"><?php echo JText::_( 'Info #3' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info3" id="info3"
					size="32" maxlength="250" value="<?php echo $row->info3; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info4"
					id="info4label"><?php echo JText::_( 'Info #4' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info4" id="info4"
					size="32" maxlength="250" value="<?php echo $row->info4; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info5"
					id="info5label"><?php echo JText::_( 'Info #5' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info5" id="info5"
					size="32" maxlength="250" value="<?php echo $row->info5; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info6"
					id="info6label"><?php echo JText::_( 'Info #6' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info6" id="info6"
					size="32" maxlength="250" value="<?php echo $row->info6; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info7"
					id="info7label"><?php echo JText::_( 'Info #7' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info7" id="info7"
					size="32" maxlength="250" value="<?php echo $row->info7; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info8"
					id="info8label"><?php echo JText::_( 'Info #8' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info8" id="info8"
					size="32" maxlength="250" value="<?php echo $row->info8; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info9"
					id="info9label"><?php echo JText::_( 'Info #9' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info9" id="info9"
					size="32" maxlength="250" value="<?php echo $row->info9; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="info10"
					id="info10label"><?php echo JText::_( 'Info #10' ); ?>:</label></td>
				<td><input class="text_area" type="text" name="info10" id="info10"
					size="32" maxlength="250" value="<?php echo $row->info10; ?>" /></td>
			</tr>
		</table>
		</td>
		<td valign="top"><?php
		$pane =& JPane::getInstance( 'sliders' );
		echo $pane->startPane( 'content-pane' );
		// First slider panel
		// Create a slider panel with a title of SLIDER_PANEL_1_TITLE and a title id attribute of SLIDER_PANEL_1_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Info' ), 'infoparams-page' );
		// Display the parameters defined in the <params> group with no 'group' attribute
		echo $this->infoparams->render( 'infoparams' );
		echo $pane->endPanel();
		//Second slider panel
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Amazon' ), 'infoamazon-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'Amazon' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Google' ), 'infogoogle-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'Google' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Wikipedia' ), 'infowikipedia-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'Wikipedia' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - ISBNdb' ), 'infoisbndb-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'ISBNdb' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - imdb' ), 'infoimdb-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'imdb' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Yahoo' ), 'infoyahoo-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'Yahoo' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - EBay' ), 'infoebay-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'EBay' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - Zanox' ), 'infozanox-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'Zanox' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		// Create a slider panel with a title of SLIDER_PANEL_2_TITLE and a title id attribute of SLIDER_PANEL_2_NAME
		echo $pane->startPanel( JText::_( 'Parameters - last.fm' ), 'infolastfm-page' );
		// Display the parameters defined in the <params> group with the 'group' attribute of 'GROUP_NAME'
		echo $this->infoparams->render( 'infoparams', 'Lastfm' );
		echo $pane->endPanel();
		// Repeat for each additional slider panel required
		echo $pane->endPane();
		?></td>
	</tr>
</table>
</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="format" value="raw" /> <input type="hidden"
	name="option" value="<? echo $option; ?>" /> <input type="hidden"
	name="itemid" id="itemid" value="<?php echo $this->item->id; ?>" /> <input
	type="hidden" name="task" value="ajaxsaveinfo" /> <input type="hidden"
	name="controller" value="item" /> <input type="hidden" name="view"
	value="item" /> <?php echo JHTML::_( 'form.token' ); ?></form>
