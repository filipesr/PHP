<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$i = $j = 0;

foreach ($cat as $group) :

	$listCondition = $group->cond;
	$list  = modGlobalNewsHelper::getGN_List($params,$listCondition);

	if (count($list) || $empty != 0) :

		$more  = $params->get('more', 1);

		$i++; $j++; ?>

<div style="float:left;" class="<?php echo $mclass; ?>">
<?php if ( $module->showtitle != 0 ) : ?>
<div class="TitAzul"><?php echo $module->title; ?></div> 
<?php endif; ?>
  <div class="globalnews" style="margin:<?php echo $params->get('margin', '2px'); ?>">
    <?php 
  		if ( $show_cat != 0 ) : ?>
    <div class="gn_header_<?php echo $globalnews_id; ?>"> <?php echo $group->image . $group->title; ?>
      <br style="clear:both;" />
    </div>
    <?php endif;
		if ( count ( $list) > 0 ) :
        	require(JModuleHelper::getLayoutPath('mod_globalnews', $layout));
        endif; ?>
  </div>
</div>
<?php 
		if ( $i == $cols && $j != $total ) : ?>
<div style="clear:both; height:0;"></div>
<?php
			$i=0; 
		endif;
	endif;
endforeach; ?>
<div style="clear:both; height:0;"></div>
