<div id="carousel<?php echo $module; ?>">
  <ul class="jcarousel-skin-opencart">
    <?php foreach ($banners as $banner) { ?>
    <li><a href="<?php echo $banner['../../../bordadosnassif/template/module/link']; ?>"><img src="<?php echo $banner['../../../bordadosnassif/template/module/image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></li>
    <?php } ?>
  </ul>
</div>
<script type="text/javascript"><!--
$('#carousel<?php echo $module; ?> ul').jcarousel({
	vertical: false,
	visible: <?php echo $limit; ?>,
	scroll: <?php echo $scroll; ?>
});
//--></script>