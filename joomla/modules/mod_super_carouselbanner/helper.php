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

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_banners'.DS.'helpers'.DS.'banner.php');

class modSuperCarouselBannersHelper
{
	function getList(&$params)
	{
		$model		= modSuperCarouselBannersHelper::getModel();

		// Model Variables
		$vars['cid']		= (int) $params->get( 'cid' );
		$vars['catid']		= (int) $params->get( 'catid' );
		$vars['limit']		= (int) $params->get( 'count', 3 );
		$vars['ordering']	= $params->get( 'ordering' );
		$banneralt			= $params->get( 'banneralt', 'Advertisement' );
		
		if ($params->get( 'tag_search' ))
		{
			$document		=& JFactory::getDocument();
			$keywords		=  $document->getMetaData( 'keywords' );

			$vars['tag_search'] = BannerHelper::getKeywords( $keywords );
		}

		$banners = $model->getList( $vars );
		$model->impress( $banners );

		return $banners;
	}

	function getModel()
	{
		if (!class_exists( 'BannersModelBanner' ))
		{
			// Build the path to the model based upon a supplied base path
			$path = JPATH_SITE.DS.'components'.DS.'com_banners'.DS.'models'.DS.'banner.php';
			$false = false;

			// If the model file exists include it and try to instantiate the object
			if (file_exists( $path )) {
				require_once( $path );
				if (!class_exists( 'BannersModelBanner' )) {
					JError::raiseWarning( 0, 'Model class BannersModelBanner not found in file.' );
					return $false;
				}
			} else {
				JError::raiseWarning( 0, 'Model BannersModelBanner not supported. File not found.' );
				return $false;
			}
		}

		$model = new BannersModelBanner();
		return $model;
	}

	function renderBanner($params, &$item)
	{
		$link = JRoute::_( 'index.php?option=com_banners&task=click&bid='. $item->bid );
		$baseurl = JURI::base();

		$html = '';
		if (trim($item->custombannercode))
		{
			// template replacements
			$html = str_replace( '{CLICKURL}', $link, $item->custombannercode );
			$html = str_replace( '{NAME}', $item->name, $html );
		}
		else if (BannerHelper::isImage( $item->imageurl ))
		{
			$image 	= '<img src="'.$baseurl.'images/banners/'.$item->imageurl.'" alt="'.$banneralt.'" />';
			if ($item->clickurl)
			{
				switch ($params->get( 'target', 1 ))
				{
					// cases are slightly different
					case 1:
						// open in a new window
						$a = '<a href="'. $link .'" target="_blank">';
						break;

					case 2:
						// open in a popup window
						$a = "<a href=\"javascript:void window.open('". $link ."', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\">";
						break;

					default:	// formerly case 2
						// open in parent window
						$a = '<a href="'. $link .'">';
						break;
					}

				$html = '<li>' . $a . $image . '</a></li>';
			}
			else
			{
				$html = $image;
			}
		}
		else if (BannerHelper::isFlash( $item->imageurl ))
		{
			//echo $item->params;
			$banner_params = new JParameter( $item->params );
			$width = $banner_params->get( 'width');
			$height = $banner_params->get( 'height');

			$imageurl = $baseurl."images/banners/".$item->imageurl;
			$html =	"<li><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" border=\"0\" width=\"$width\" height=\"$height\">
						<param name=\"movie\" value=\"$imageurl\"><embed src=\"$imageurl\" loop=\"false\" pluginspage=\"http://www.macromedia.com/go/get/flashplayer\" type=\"application/x-shockwave-flash\" width=\"$width\" height=\"$height\"></embed>
					</object></li>";
		}

		return $html;
	}
}
