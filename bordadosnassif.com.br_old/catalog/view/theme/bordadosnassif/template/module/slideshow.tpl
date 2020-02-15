<div class="slideshow">
  <div id="slideshow<?php echo $module; ?>" class="nivoSlider" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;">
    <?php foreach ($banners as $banner) { ?>
      <?php if ($banner['link']) { ?>
        <a href="<?php echo $banner['../../../bordadosnassif/template/module/link']; ?>">
          <img src="<?php echo $banner['../../../bordadosnassif/template/module/image']; ?>" alt="<?php echo $banner['title']; ?>" />
        </a>
      <?php
      }
      else {
        ?>
        <img src="<?php echo $banner['../../../bordadosnassif/template/module/image']; ?>" alt="<?php echo $banner['title']; ?>" />
      <?php } ?>
<?php } ?>
  </div>
</div>
<script type="text/javascript">
  <!--
  $(document).ready(function() {
    $('#slideshow<?php echo $module; ?>').nivoSlider();
  });
  -->
</script>