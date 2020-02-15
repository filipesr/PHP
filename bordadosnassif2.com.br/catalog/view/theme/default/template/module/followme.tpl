<?php
// -----------------------------------------------------
// Follow Me for Opencart v1.5.1    
// Modified by villagedefrance                             
// contact@villagedefrance.net                                      
// -----------------------------------------------------
?>

<style type="text/css" media="screen">
.box .box-heading img {float: left; margin-right: 8px;}
</style>

<link href="https://plus.google.com/102902780678101373134" rel="publisher" />

	<?php if($box) { ?>
		<div class="box">
			<div class="box-heading">
				<?php if($icon) { ?>
					<img src="catalog/view/theme/default/image/connect.png" alt="" />
				<?php } ?>
				<?php if($title) { ?>
					<?php echo $title; ?>
				<?php } ?>
			</div>		
			<div class="box-content">
				<table width="100%">
					<tr>
					<?php if($face) { ?>
						<td width="33%" align="center">
						<a href="http://www.facebook.com/<?php echo $facebook_url; ?>" title="Follow <?php echo $store; ?> on facebook" target="_blank"><img src="catalog/view/theme/default/image/logo_facebook.gif" alt="" /></a>
						</td>
					<?php } ?>
					<?php if($twit) { ?>
						<td width="33%" align="center">
						<a href="http://www.twitter.com/#!/<?php echo $twitter_url; ?>" title="Follow <?php echo $store; ?> on twitter" target="_blank"><img src="catalog/view/theme/default/image/logo_twitter.gif" alt="" /></a>
						</td>
					<?php } ?>
					<?php if($gplus) { ?>
						<td width="33%" align="center">
						<a href="https://plus.google.com/<?php echo $google_url; ?>?prsrc=3" title="Follow <?php echo $store; ?> on google+" target="_blank"><img src="catalog/view/theme/default/image/logo_google.gif" alt=""/></a>
						</td>
					<?php } ?>
					</tr>
				</table>
			</div>
		</div>
	<?php } else { ?>	
			<table width="100%">
				<tr>
				<?php if($face) { ?>
					<td width="33%" align="center">
					<a href="http://www.facebook.com/<?php echo $facebook_url; ?>" title="Follow <?php echo $store; ?> on facebook" target="_blank"><img src="catalog/view/theme/default/image/logo_facebook.gif" alt="" /></a>
					</td>
				<?php } ?>
				<?php if($twit) { ?>
					<td width="33%" align="center">
					<a href="http://www.twitter.com/#!/<?php echo $twitter_url; ?>" title="Follow <?php echo $store; ?> on twitter" target="_blank"><img src="catalog/view/theme/default/image/logo_twitter.gif" alt="" /></a>
					</td>
				<?php } ?>
				<?php if($gplus) { ?>
					<td width="33%" align="center">
					<a href="https://plus.google.com/<?php echo $google_url; ?>?prsrc=3" title="Follow <?php echo $store; ?> on google+" target="_blank"><img src="catalog/view/theme/default/image/logo_google.gif" alt=""/></a>
					</td>
				<?php } ?>
				</tr>
			</table>
			<div style="margin-bottom:5px;">&nbsp;</div>
	<?php } ?>
	
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>