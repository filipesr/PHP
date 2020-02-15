<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<div class="reviewcontent"><?php echo $review['date_added']; ?>&nbsp;&nbsp;<b><?php echo $review['author']; ?></b>&nbsp;<div class="reviewstars"><img src="catalog/view/theme/theia/image/stars-<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['reviews']; ?>" /></div><br />
  <br />
  <span class="reviewtext"><?php echo $review['text']; ?></div></span>
<?php } ?>
<div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
<div class="content"><?php echo $text_no_reviews; ?></div>
<?php } ?>
