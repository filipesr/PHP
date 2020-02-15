<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
if( $this->access->canEdit || ( $this->access->canEditOwn && $this->list->created_by == $this->access->uid ) )
{
	$icon = 'edit.png';
	$text = JHTML::_( 'image.site', $icon, '/images/M_images/', NULL, NULL, JText::_( 'Edit' ) );
	$uri =& JFactory::getURI();
	$ret = $uri->toString();
	$url = 'index.php?option=com_jcollection&view=list&controller=list&task=edit&ret='.base64_encode( $ret ).'&listid='.$this->list->slug;
	$button = JHTML::_( 'link', JRoute::_( $url ), $text );
	$overlib = '';
	echo '<br /><span class="hasTip" title="'.JText::_( 'Edit Item' ).' :: '.$overlib.'">'.$button.'</span>';
}
?>
<h1><?php echo $this->list->name; ?></h1>
<?php
if($this->list->image) {
?>
<img src="<?php echo $this->list->image; ?>" />
<?php
}
?>
<?php
if(count($this->list->items)) {
?>
	<b>Items:</b>
	<ul>
	<?php
		foreach( $this->list->items as $item ) {
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