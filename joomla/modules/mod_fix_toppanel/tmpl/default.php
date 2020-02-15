<?php
/**
      Fix TopPanel Module for Joomla 1.5
      -----------------------------------------------------------------------
      Fix TopPanel show a fixed toppanel with inside text or a module position. 
      Created bt Andrea S. of www.joomlovers.net 
      Hide/Show Script by Justin Barlow | http://www.netlobo.com
      -----------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$doc = &Jfactory::getDocument();
$show	= $params->get('show');
$shtext	= $params->get('shtext');
$bgcolor	= $params->get('bgcolor');
$txtcolor	= $params->get('txtcolor');
$linkcolor	= $params->get('linkcolor');
$bttcolor	= $params->get('linkcolor');
?>

<style>
#jbpanel {position: fixed;top:0px;left:0px; background: <?php echo "$bgcolor" ?>;	width: 100%;color:<?php echo "$txtcolor" ?>;  padding:3px;z-index:999;}
#pulsante, #pulsante a:link, #pulsante a:visited, #pulsante a:hover {color:<?php echo "$bttcolor" ?>;padding:0px 10px 0px 0px;float:right;z-index:999;}
#jbpanel a:link, #jbpanel a:visited, #jbpanel a:hover { color:<?php echo "$linkcolor" ?>;}
</style>

<?php
 
$a = new stdClass;
$dispatcher	=& JDispatcher::getInstance();
JPluginHelper::importPlugin('content');
$a->text = $str;
$results = $dispatcher->trigger('onPrepareContent', array (&$a, $a->params, 0));

echo '<div id="jbpanel">';
echo '<div id="commentForm">';
echo $a->text;
echo '</div>';
echo '<div id="pulsante">';

if($show=='1') {
echo '<div>';
?>
<a class="commentLink" title="" href="javascript:toggleLayer('commentForm');"><?php echo "$shtext" ?></a>
<?php
echo '</div>';
	}
if ($show=='2') {
	}
echo '</div>';
echo '</div>';
?>
