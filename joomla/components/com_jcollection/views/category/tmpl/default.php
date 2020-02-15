<?php
defined('_JEXEC') or die('Restricted access');
global $option;
$params = &$this->params;
?>

<?php
if( $this->access->canAdd )
{
	$icon = 'new.png';
	$text = JHTML::_( 'image.site', $icon, '/images/M_images/', NULL, NULL, JText::_( 'New' ) );
	$uri =& JFactory::getURI();
	$ret = $uri->toString();
	$url = 'index.php?option=com_jcollection&view=item&controller=item&task=edit&ret='.base64_encode( $ret ).'&catid='.(int)$this->cat->id.'&id=0';
	$button = JHTML::_( 'link', JRoute::_( $url ), $text );
	//$button = JHTML::_( 'link', $url, $text );
	$overlib = '';
	echo '<br /><span class="hasTip" title="'.JText::_( 'New Item' ).' :: '.$overlib.'">'.$button.'</span>';
}
?>

<?php
if($this->cat->id && $params->get('show_breadcrumbs')) {
	$catlink = JRoute::_('index.php?option=com_jcollection');
	echo '<a href="'.$catlink.'">'.JText::_('Root').'</a>';
	$ccats = count($this->cat->cats);
	for($i=0; $i<$ccats-1; $i++)
	{
		$cat = &$this->cat->cats[$i];
		$catlink = JRoute::_('index.php?option=com_jcollection&view=category&catid='.$cat->slug);
		echo ' / ';
		echo '<a href="'.$catlink.'">'.htmlspecialchars($cat->name).'</a>';
	}
}
?>
<h1><?php echo $this->cat->name; ?></h1>
<?php
if($this->cat->image) {
?>
<img src="<?php echo $this->cat->image; ?>" />
<?php
}
?>
<p><?php echo $this->cat->description; ?></p>
<?php
if(count($this->cat->subcategories)) {
?>
	<p><b><?php echo JText::_('Subcategories'); ?></b></p>
	<ul>
	<?php
		foreach( $this->cat->subcategories as $subcat ) {
			echo "<li>";
			$link = JRoute::_("index.php?option=com_jcollection&view=category&catid=".$subcat->slug);
			if($subcat->image) {
				echo "<img src=\"".$subcat->image."\" />";
			}
			echo "<a href=\"".$link."\">".$subcat->name."</a>";
			echo "</li>\n";
		}
	?>
</ul>
<?php
}
if(count($this->cat->items)) {
?>
	<b>Items:</b>
	<ul>
	<?php
		foreach( $this->cat->items as $item ) {
			echo "<li>";
			if($item->image) {
				echo "<img src=\"".$item->image."\" />";
			}
			$link = JRoute::_("index.php?option=com_jcollection&view=item&id=".$item->slug);
			echo "<a href=\"".$link."\">".$item->name."</a></li>\n";
		}
	?>
	</ul>
<?php
}
?>
<?php
echo $this->pagination->getPagesLinks();
?>

