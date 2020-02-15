<?php 
/**
* Module Super Carousel Banner For Joomla 1.5
* Version		: 1.2
* Created by	: Rony Sandra Yofa Zebua And Camp26.Com Team
* Email			: camp26team@gmail.com
* Created on 	: 20 May 2008
* Last update on: 09 January 2009
* URL			: www.camp26.com
* http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access'); 


// clientids must be an integer
$animax    	= $params->get( 'animax', '1000' );
$automator 	= $params->get( 'automator', '3' );

?>
<script type="text/javascript" src="modules/mod_super_carouselbanner/super_carouselbanner/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="modules/mod_super_carouselbanner/super_carouselbanner/jquery.jcarousel.pack.js"></script>
<link rel="stylesheet" href="modules/mod_super_carouselbanner/super_carouselbanner/jquery.jcarousel.css" type="text/css" />
<link rel="stylesheet" href="modules/mod_super_carouselbanner/super_carouselbanner/skin.css" type="text/css" />
<script type="text/javascript">

function mycarousel_initCallback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};



jQuery.easing['BounceEaseOut'] = function(p, t, b, c, d) {
	if ((t/=d) < (1/2.75)) {
		return c*(7.5625*t*t) + b;
	} else if (t < (2/2.75)) {
		return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
	} else if (t < (2.5/2.75)) {
		return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
	} else {
		return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
	}
};

jQuery.noConflict();
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        auto: <?php echo $automator; ?>,
        wrap: 'last',
		easing: 'BounceEaseOut',
		animation: <?php echo $animax; ?>,
        initCallback: mycarousel_initCallback
    });
});

</script>

<div class="bannergroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if ($headerText) : ?>
	<div class="bannerheader"><?php echo $headerText ?></div>
<?php endif;

?><!-- Super Carousel Banner From www.camp26.com -->
<ul id="mycarousel" class="jcarousel-skin-camp26">
	<?php 
foreach($list as $item) :
	echo modSuperCarouselBannersHelper::renderBanner($params, $item);
	?>
<?php endforeach; ?>
<ul>
<?php if ($footerText) : ?>
	<div class="bannerfooter<?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>