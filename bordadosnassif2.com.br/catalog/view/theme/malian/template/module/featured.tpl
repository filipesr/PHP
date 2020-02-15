<div class="box">
  <div class="box-heading"><span><?php echo $heading_title; ?></span></div>
  <div class="box-content">
    <div class="box-product" >
      <?php foreach ($products as $product) { ?>
    
      <div class="box-product-in">
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
       
        <?php if ($product['price']) { ?>
        <?php if ($product['special']) { ?>   <span class="special-pro"></span>  <?php } ?> 
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
       
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?> 
         <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
         <div class="rating"><img src="catalog/view/theme/malian/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
          <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
         <div class="wishlist"><a class="wish-icon" title="Add to Wishlist" onclick="addToWishList('<?php echo $product['product_id']; ?>');"></a></div>
         <div class="compare"><a class="compare-icon" title="Add to Compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');"></a></div>  
               
      
      </div>
      <?php } ?>
     </div>
      
  </div>
</div>

