<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$css_file = "components/com_jcollection/views/item/tmpl/default.css";
$this->doc->addStyleSheet($css_file);
//JFilterOutput::objectHTMLSafe($this->item,ENT_QUOTES);
$item = &$this->item;
$params = &$this->item->params;
$infosetsas = $item->params->get( 'showinfosetsas', 'lists' );
?>
<?php
echo $item->event->beforeDisplayItem;
?>
<?php
if( $this->access->canEdit || ( $this->access->canEditOwn && $this->item->created_by == $this->access->uid ) )
{
	$icon = 'edit.png';
	$text = JHTML::_( 'image.site', $icon, '/images/M_images/', NULL, NULL, JText::_( 'Edit' ) );
	$uri =& JFactory::getURI();
	$ret = $uri->toString();
	$url = 'index.php?option=com_jcollection&view=item&controller=item&task=edit&ret='.base64_encode( $ret ).'&id='.$this->item->slug;
	$button = JHTML::_( 'link', JRoute::_( $url ), $text );
	$overlib = '';
	echo '<br /><span class="hasTip" title="'.JText::_( 'Edit Item' ).' :: '.$overlib.'">'.$button.'</span>';
}
?>
<h1 class="item"><?php echo htmlspecialchars( $this->item->name ); ?></h1>
<?php
echo $item->event->afterDisplayItemTitle;
?>
<div class="item">
<?php
if($this->item->image) {
?>
<p><img class="item" src="<?php echo $this->item->image; ?>" /></p>
<?php
}
?>
<?php
if( $description = $this->item->description ) {
	echo "<p>".$description."</p>\n";
}
?>
</div>
<div class="infos">
<?php
if( $this->access->canEdit || $this->access->canEditOwn )
{
	$icon = 'new.png';
	$text = JHTML::_( 'image.site', $icon, '/images/M_images/', NULL, NULL, JText::_( 'New' ) );
	$uri =& JFactory::getURI();
	$ret = $uri->toString();
	$url = 'index.php?option=com_jcollection&view=info&controller=info&task=edit&ret='.base64_encode( $ret ).'&infoid=0&itemid='.$this->item->id;
	$button = JHTML::_( 'link', JRoute::_( $url ), $text );
	$overlib = '';
	echo '<span class="hasTip" title="'.JText::_( 'New info set' ).' :: '.$overlib.'">'.$button.'</span>';
}
?>
<?php
$pane = $this->pane;
if( $pane ) {
	echo $pane->startPane( 'content-pane' );
} else {
	echo "<ul>\n";
}
$i = 1;
foreach($this->item->infos as $info) {
	if( $pane ) {
		echo $pane->startPanel( htmlspecialchars( $info->name ), 'info'.$i.'-page' );
	} else {
		echo "<li>";
	}
	echo "<div class=\"info\">";

	if( $this->access->canEdit || ( $this->access->canEditOwn && $info->created_by == $this->access->uid ) )
	{
		$icon = 'edit.png';
		$text = JHTML::_( 'image.site', $icon, '/images/M_images/', NULL, NULL, JText::_( 'Edit' ) );
		$uri =& JFactory::getURI();
		$ret = $uri->toString();
		$url = 'index.php?option=com_jcollection&view=info&controller=info&task=edit&ret='.base64_encode( $ret ).'&infoid='.$info->id;
		$button = JHTML::_( 'link', JRoute::_( $url ), $text );
		$overlib = '';
		echo '<span class="hasTip" title="'.JText::_( 'Edit Info' ).' :: '.$overlib.'">'.$button.'</span>';
	}

	echo $info->event->beforeDisplayInfo;

	if( $title = htmlspecialchars( $info->title ) ) {
		if( $url = $info->url ) {
			echo "<h1 class=\"info\"><a href=\"$url\" target=\"_blank\">".$title."</a></h1>\n";
		} else {
			echo "<h1 class=\"info\">".$title."</h1>\n";
		}
	}

	echo $info->event->afterDisplayInfoTitle;

	if( $img = $info->img ) {
		echo "<p><img class=\"info\" src=\"".$img."\" /></p>\n";
	}

	if( $description = $info->description ) {
		echo "<p>".$description."</p>\n";
	}

	echo "<ul>\n";

	for( $j = 1; $j <= 10; $j++ )
	{
		$infoname = 'info'.$j;
		$in = trim( $info->$infoname );
		if( $in )
		{
			$infolabelname = $infoname.'label';
			$label = $info->$infolabelname;
			if( $label )
			{
				echo "<li><b>".$label."</b>:".$in."</li>\n";
			} else {
				echo "<li>".$in."</li>\n";
			}
		}
	}

	echo "</ul>\n";

	if(isset($info->additional_fields_sets) && count($info->additional_fields_sets)) {
		echo "<b>".JText::_( 'Additional fields' ).":</b><br />";
		foreach( $info->additional_fields_sets as $fieldset ) {
			if(count($fieldset->additional_fields)) {
				echo "<b>".$fieldset->source.":</b> \n";
				echo "<ul>\n";
				foreach($fieldset->additional_fields as $field) {
					echo "<li>".$field->name.": ".$field->value."</li>\n";
				}
				echo "</ul>\n";
			}
		}
	}

	if(isset($info->offers_sets) && count($info->offers_sets)) {
		echo "<b>".JText::_( 'Offers' ).":</b><br />";
		foreach( $info->offers_sets as $offerset ) {
			if(count($offerset->offers)) {
				echo "<b>".$offerset->source.":</b>\n";
				echo "<ul>";
				foreach($offerset->offers as $offer) {
					echo "<li>";
					if($offer->url) {
						echo '<a target="_blank" href="'.$offer->url.'">';
					}
					echo $offer->title.": ".$offer->price;
					if($offer->condition) {
						echo " (".$offer->condition.")";
					}
					if($offer->url) {
						echo "</a>";
					}
					if($offer->updated) {
						echo " <small>".JText::_( 'updated' ).": ".$offer->updated."</small>";
					}
					if($offer->expires) {
						echo " <small>".JText::_( 'expires' ).": ".$offer->expires."</small>";
					}
					echo "</li>\n";
				}
				echo "</ul>\n";
			}
		}
	}

	if(isset($info->similar_items_sets) && count($info->similar_items_sets)) {
		echo "<b>".JText::_( 'Similar items' ).":</b><br />\n";
		foreach( $info->similar_items_sets as $itemset ) {
			if(count($itemset->similar_items)) {
				echo "<b>".$itemset->source.":</b>\n";
				echo "<ul>";
				foreach($itemset->similar_items as $sitem) {
					echo "<li><a target=\"_blank\" href=\"".$sitem->url."\">".$sitem->title."</a></li>";
				}
				echo "</ul>";
			}
		}
	}

	if( $this->access->canEditRev || $this->access->canEditOwnRev )
	{
		$icon = 'new.png';
		$text = JHTML::_( 'image.site', $icon, '/images/M_images/', NULL, NULL, JText::_( 'New' ) );
		$uri =& JFactory::getURI();
		$ret = $uri->toString();
		$url = 'index.php?option=com_jcollection&view=rev&controller=rev&task=edit&ret='.base64_encode( $ret ).'&reviewid=0&infoid='.$info->id;
		$button = JHTML::_( 'link', JRoute::_( $url ), $text );
		$overlib = '';
		echo '<span class="hasTip" title="'.JText::_( 'New Review' ).' :: '.$overlib.'">'.$button.'</span>';
	}
	if( isset( $info->revs ) && count( $info->revs ) ) {
		echo "<b>".JText::_( 'Reviews' ).":</b>\n";
		echo "<ul>";
		foreach( $info->revs as $rev ) {
			if( $this->access->canEditRev || ( $this->access->canEditOwnRev && $rev->created_by == $this->access->uid ) )
			{
				$icon = 'edit.png';
				$text = JHTML::_( 'image.site', $icon, '/images/M_images/', NULL, NULL, JText::_( 'Edit' ) );
				$uri =& JFactory::getURI();
				$ret = $uri->toString();
				$url = 'index.php?option=com_jcollection&view=rev&controller=rev&task=edit&ret='.base64_encode( $ret ).'&reviewid='.$rev->id;
				$button = JHTML::_( 'link', JRoute::_( $url ), $text );
				$overlib = '';
				echo '<span class="hasTip" title="'.JText::_( 'Edit Review' ).' :: '.$overlib.'">'.$button.'</span>';
			}

			echo $rev->event->beforeDisplayRev;
			echo "<li>";
			echo "<b>".$rev->name."</b><br />";
			echo $rev->event->afterDisplayRevTitle;
			echo $rev->description."</li>";
			echo $rev->event->afterDisplayRev;
		}
		echo "</ul>";
	}

	if(isset($info->reviews_sets) && count($info->reviews_sets)) {
		echo "<b>".JText::_( 'External reviews' ).":</b><br />\n";

		foreach( $info->reviews_sets as $reviewset ) {
			if(count($reviewset->reviews)) {
				echo "<b>".$reviewset->source.":</b>";
				echo "<ul>";
				foreach($reviewset->reviews as $rev) {
					echo "<li>";
					echo "<b>".JText::_( 'Summary' ).":</b> ".$rev->title."<br />";
					echo $rev->review."</li>";
				}
				echo "</ul>";
			}
		}
	}

	if(isset($info->disclaimer) && count($info->disclaimer)) {
		echo "<b>".JText::_( 'Disclaimers' ).":</b><br />\n";
		foreach($info->disclaimer as $dis) {
			echo $dis->text."<br />\n";
		}
	}

	echo "</div>";

	echo $info->event->afterDisplayInfo;

	if( $pane ) {
		echo $pane->endPanel();
	} else {
		echo "</li>";
	}
	$i++;
}
if( $pane ) {
	echo $pane->endPane();
} else {
	echo "</ul>\n";
}
echo "</div>";

echo $item->event->afterDisplayItem;
?>

