<?php defined('_JEXEC') or die('Restricted access'); ?>

<h1><?php echo $this->cat->name; ?></h1>
<?php
	foreach( $this->cat->subcategories as $subcat ) {
		echo "Subcat: ".$subcat->name."<br />\n";
	}
	foreach( $this->cat->items as $item ) {
		echo "Item: ".$item->name."<br />\n";
	}
