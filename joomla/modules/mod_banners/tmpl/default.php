<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
if ($taging == 1) : ?>
	<div class="bannergroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">
<?php endif; 
 if (($headerText)&&($taging == 1)) : ?>
	<div class="bannerheader"><?php echo $headerText ?></div>
<?php endif;

foreach($list as $item) :
	if ($taging == 1) : ?>
		<div class="banneritem<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<?php endif;
	echo modBannersHelper::renderBanner($params, $item);
	if ($taging == 1) : ?>
	<div class="clr"></div>
	</div>
	<?php endif;
 endforeach;
 if (($footerText)&&($taging == 1)) : ?>
	<div class="bannerfooter<?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; 
if ($taging == 1) : ?>
</div>
<?php endif; ?>
