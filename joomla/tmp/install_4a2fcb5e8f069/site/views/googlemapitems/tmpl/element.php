<?php defined('_JEXEC') or die('Restricted access');
global $option;
// <a style="cursor: pointer;"onclick="window.parent.jSelectItem(' echo $row->id; ', ' echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ', ' echo JRequest::getVar('object'); ');"> echo $row->name; </a>
?>
<fieldset>
	<div style="float: right">
		<button type="button" onclick="savePosition();window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 700);">
			Save</button>
		<button type="button" onclick="window.parent.document.getElementById('sbox-window').close();">
			Cancel</button>
	</div>

	<div class="configuration" >
		Google map</div>
</fieldset>

Address: <input type="text" name="address" id="address" size="30" value="" />
<button type="button" onclick="searchAddress()">Search</button>

<div id="googlemap" style="width: 500px; height: 300px"></div>
