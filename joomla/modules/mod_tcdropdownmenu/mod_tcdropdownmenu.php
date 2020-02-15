<?php
/**
* @version		$Id: mod_tcdropdownmenu.php 10381 2008-08-27$
* @package		Joomla
* @copyright	Copyright (C) 2008 Tobacamp <http://www.tobacamp.com> . All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*
* mod_tcdropdownmenu is a free extension for Joomla 1.5. It's based on Sliding JavaScript Dropdown Menu created by Michael (http://www.leigeber.com). 
* This lightweight JavaScript drop down menu script (~1.6kb) allows you to easily add smooth transitioning dropdowns to your joomla website. 
* This can be used for navigation, dropdown lists, info panels, etc. The script has been tested working in IE6, IE7, IE8, Firefox, Opera and Safari.
*
* Sliding JavaScript Dropdown Menu is ported to Joomla 1.5 by Dani Gunawan <dani.gunawan@yahoo.com>. With some CSS hack of course.. :).
*
* Note: some templates may cause this module doesn't work well. If it happens, please consider to change your template or edit CSS. Thank you.
*
* Enjoy it!
*/

/**
 * CHANGELOG
 *
 * Addition:
 * - Compatible with Joomla! SEO
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
global $mainframe;

$sef = $mainframe->getCfg('sef');
$sef_rewrite = $mainframe->getCfg('sef_rewrite');
$sef_suffix = $mainframe->getCfg('sef_suffix');

$modulename = 'mod_tcdropdownmenu';

$menutype = $params->get('menutype', 1);
$separator = $params->get('separator', '');
$separatorcolor = $params->get('separatorcolor', '#000');

// link color
$a = $params->get('a', '');
$aactive = $params->get('aactive', '');
$ahover = $params->get('ahover', '');
$avisited = $params->get('avisited', '');

if ($a != '') 
	$a = 'color:' . $a . ';';
	
if ($aactive != '') 
	$aactive = 'color:' . $aactive . ';';
	
if ($ahover != '') 
	$ahover = 'color:' . $ahover . ';';
	
if ($avisited != '') 
	$avisited = 'color:' . $avisited . ';';


$submenubg = $params->get('submenubg', '#FFF');
$sidebordercolor = $params->get('sidebordercolor', '#9ac1c9');
$bottombordercolor = $params->get('bottombordercolor', '#b9d6dc');


$document =&JFactory::getDocument();

// style for dropdown menu
$styles='
	.dropdown {
		font-size: 11px;
		font-weight: normal;
		margin-top: 0px;
		margin-left: 0px;
		float: left;
	}
	.dropdown dt {border:0px solid #9ac1c9; padding:0px; font-weight:bold; cursor:pointer; }
	.dropdown dt:hover {}
	.dropdown dd {padding:0px; margin: 0px; position:absolute; overflow:hidden; display:none; background:' . $submenubg . '; z-index:200; opacity:1.0}
	.dropdown ul {padding:0px; margin: 0px;border:1px solid ' . $sidebordercolor . '; list-style:none; border-top:none; border-bottom: none;}
	.dropdown li {display:inline}
	.dropdown a {display:block; padding:5px; text-decoration:none; ' . $a . '}
	.dropdown a:active {display:block; padding:5px; text-decoration:none; ' . $aactive . '}
	.dropdown a:visited {display:block; padding:5px; text-decoration:none; ' . $avisited . '}
	.dropdown a:hover {text-decoration: none; ' . $ahover . '}
	.dropdown .underline {border-bottom:1px solid ' . $bottombordercolor . '}
	.separator {
		font-size: 11px;
		font-weight: normal;
		margin-top: 5px;
		margin-left: 0px;
		float: left;
		color: ' . $separatorcolor . ';
	}';
	
$js = '
	var DDSPEED = 10;
	var DDTIMER = 15;
	
	// main function to handle the mouse events //
	function ddMenu(id,d){
	  var h = document.getElementById(id + \'-ddheader\');
	  var c = document.getElementById(id + \'-ddcontent\');
	  clearInterval(c.timer);
	  if(d == 1){
		clearTimeout(h.timer);
		if(c.maxh && c.maxh <= c.offsetHeight){return}
		else if(!c.maxh){
		  c.style.display = \'block\';
		  c.style.height = \'auto\';
		  c.maxh = c.offsetHeight;
		  c.style.height = \'0px\';
		}
		c.timer = setInterval(function(){ddSlide(c,1)},DDTIMER);
	  }else{
		h.timer = setTimeout(function(){ddCollapse(c)},50);
	  }
	}
	
	// collapse the menu //
	function ddCollapse(c){
	  c.timer = setInterval(function(){ddSlide(c,-1)},DDTIMER);
	}
	
	// cancel the collapse if a user rolls over the dropdown //
	function cancelHide(id){
	  var h = document.getElementById(id + \'-ddheader\');
	  var c = document.getElementById(id + \'-ddcontent\');
	  clearTimeout(h.timer);
	  clearInterval(c.timer);
	  if(c.offsetHeight < c.maxh){
		c.timer = setInterval(function(){ddSlide(c,1)},DDTIMER);
	  }
	}
	
	// incrementally expand/contract the dropdown and change the opacity //
	function ddSlide(c,d){
	  var currh = c.offsetHeight;
	  var dist;
	  if(d == 1){
		dist = (Math.round((c.maxh - currh) / DDSPEED));
	  }else{
		dist = (Math.round(currh / DDSPEED));
	  }
	  if(dist <= 1 && d == 1){
		dist = 1;
	  }
	  c.style.height = currh + (dist * d) + \'px\';
	  c.style.opacity = currh / c.maxh;
	  c.style.filter = \'alpha(opacity=\' + (currh * 100 / c.maxh) + \')\';
	  if((currh < 2 && d != 1) || (currh > (c.maxh - 2) && d == 1)){
		clearInterval(c.timer);
	  }
	}';

// javascript for sliding menu
$document->addScriptDeclaration($js);
$document->addStyleDeclaration($styles);

$db =& JFactory::getDBO();
$query = "SELECT id, name, link, type, browsernav, alias FROM #__menu WHERE published = '1' AND parent = '0' AND menutype = '$menutype' ORDER BY ordering";
$db->setQuery( $query );
$rows = $db->loadObjectList();

$i = 0;
echo '<table align="center" border="0"><tr><td>';
foreach($rows as $row)
{
	echo '<dl class="dropdown">';
	echo '<dt id="menu' . $i . '-ddheader" onmouseover="ddMenu(\'menu' . $i . '\',1)" onmouseout="ddMenu(\'menu' . $i . '\',-1)">';

	$datah = '';
	$datah .= '<li><a href="';
	if ($row->type == 'url') {
		$datah .= $row->link;
	} else {
		$link = '';
		if ($sef == 1) {
			$link .= 'index.php/' . $row->alias;
		}
		
		if ($sef_rewrite == 1) {
			$link .= $row->alias;
		}
		
		if ($sef_suffix == 1) {
			$link .= '.html';
		}
		
		if ($sef == 0 && $sef_rewrite == 0 && sef_suffix == 0) {
			$link = JRoute::_($row->link);
		}
		$datah .= $link;
	}

	switch ($row->browserNav)
	{
		default:
		case 0:
			// _top
			$datah .= '">'.$row->name.'</a>';
			break;
		case 1:
			// _blank
			$datah .= '" target="_blank">'.$row->name.'</a>';
			break;
		/* ntar aja lah
		case 2:
			// window.open
			$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$this->_params->get('window_open');

			// hrm...this is a bit dickey
			$link = str_replace('index.php', 'index2.php', $tmp->url);
			$data = '<a href="'.$link.'" onclick="window.open(this.href,\'targetWindow\',\''.$attribs.'\');return false;">'.$image.$tmp->name.'</a>';
			break;
		*/
	}
	echo $datah;
	echo '</dt>';
	
	echo '<dd id="menu' . $i . '-ddcontent" onmouseover="cancelHide(\'menu' . $i . '\')" onmouseout="ddMenu(\'menu' . $i . '\',-1)">';
	echo '<ul>';
	$query = "SELECT id, name, link, type, alias, browsernav FROM #__menu WHERE published = '1' AND parent = '" . $row->id . "' AND menutype = '$menutype' ORDER BY ordering";
	$db->setQuery( $query );
	$crows = $db->loadObjectList();
	if (count($crows)>0) {
		$data = '';
		foreach($crows as $crow)
		{
			$data .= '<li><a class="underline" href="';
			if ($crow->type == 'url') {
				$data .= $crow->link;
			} else {
				$link = '';
				if ($sef == 1) {
					$link .= 'index.php/' . $row->alias . '/' . $crow->alias;
				}
				
				if ($sef_rewrite == 1) {
					$link .= $row->alias . '/' . $crow->alias;
				}
				
				if ($sef_suffix == 1) {
					$link .= '.html';
				}
				
				if ($sef == 0 && $sef_rewrite == 0 && sef_suffix == 0) {
					$link = JRoute::_($crow->link);
				}
				$data .= $link;
			}
		
			switch ($crow->browsernav)
			{
				default:
				case 0:
					// _top
					$data .= '">'.$crow->name.'</a>';
					break;
				case 1:
					// _blank
					$data .= '" target="_blank">'.$crow->name.'</a>';
					break;
				/* ntar aja lah
				case 2:
					// window.open
					$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$this->_params->get('window_open');
		
					// hrm...this is a bit dickey
					$link = str_replace('index.php', 'index2.php', $tmp->url);
					$data = '<a href="'.$link.'" onclick="window.open(this.href,\'targetWindow\',\''.$attribs.'\');return false;">'.$image.$tmp->name.'</a>';
					break;
				*/
			}
			$data .= '</li><div class="clr"></div>';
		}
		echo $data;
	}
	echo '</ul></dd></dl>';
	
	// separator 
	if ($i < (count($rows)-1)) {
		echo '<div class="separator">' . $separator . '</div>';
	}
	$i++;
}
echo '</td></tr></table>';
?>