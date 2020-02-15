<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * JCollection Rating plugin
 */
class plgJCollectionRating extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatibility we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgJCollectionRating( &$subject, $config )
	{
		parent::__construct( $subject, $config );

		// Do some extra initialisation in this constructor if required
	}

	/**
	 * Do something onAfterInitialise
	 */
	function onAfterInitialise()
	{
		// Perform some action
	}

	function onAfterDisplayItemTitle( &$item, &$params )
	{
		$html = '';
		if( $this->params->get( 'show_item' ) && $params->get( 'show_vote' ) && count( $item->infos ) )
		{
			$info = &$item->infos[0];
			$html = $this->onAfterDisplayInfoTitle( $info, $params, true );
		}
		return $html;
	}

	/**
	 * Return the html source for the info rating
	 * @param $info object
	 * @param $params object
	 * @return string The html source
	 */
	function onAfterDisplayInfoTitle( &$info, &$params, $show = false )
	{
		$id = $info->id;
		$html = '';

		$show_vote = $info->params->get( 'show_vote', $params->get( 'show_vote' ) );

		if( $show_vote && ( $this->params->get( 'show_info' ) || $show ) ) {
			$uri = & JFactory::getURI();
			$user =& JFactory::getUser();
			$gid = (int) $user->get( 'aid', 0 );
			$starImageOn = JHTML::_('image.site',  'rating_star.png', '/images/M_images/' );
			$starImageOff = JHTML::_('image.site',  'rating_star_blank.png', '/images/M_images/' );
			for( $j = 1; $j<=5; $j++ )
			{
				$ratinglabelname = 'rating'.$j.'label';
				$ratinglabel = $info->$ratinglabelname;
				if( $ratinglabel )
				{
					$ratingcountname = 'ratingcount'.$j;
					$ratingcount = $info->$ratingcountname;
					$ratingname = 'rating'.$j;
					$rating = $info->$ratingname;
					if( $params->get( 'allow_rating' ) <= $gid ) {
						$html .= '<form method="post" action="'.$uri->toString().'">';
					}
					$img = '';
					for ($i=0; $i < $rating; $i++) {
						$img .= $starImageOn;
					}
					for ($i=$rating; $i < 5; $i++) {
						$img .= $starImageOff;
					}
					$html .= '<span class="content_rating">';
					$html .= $ratinglabel.':'. $img .'&nbsp;/&nbsp;';
					$html .= intval( $ratingcount );
					$html .= "</span>\n<br />\n";
					if( $params->get( 'allow_rating' ) <= $gid )
					{
						$html .= '<span class="content_vote">';
						$html .= JText::_( 'Poor' );
						$html .= '<input type="radio" alt="vote 1 star" name="user_rating" value="1" />';
						$html .= '<input type="radio" alt="vote 2 star" name="user_rating" value="2" />';
						$html .= '<input type="radio" alt="vote 3 star" name="user_rating" value="3" />';
						$html .= '<input type="radio" alt="vote 4 star" name="user_rating" value="4" />';
						$html .= '<input type="radio" alt="vote 5 star" name="user_rating" value="5" checked="checked" />';
						$html .= JText::_( 'Best' );
						$html .= '&nbsp;<input class="button" type="submit" name="submit_vote" value="'. JText::_( 'Rate' ) .'" />';
						$html .= '<input type="hidden" name="controller" value="info" />';
						$html .= '<input type="hidden" name="task" value="vote" />';
						$html .= '<input type="hidden" name="ratingno" value="'.$j.'" />';
						$html .= '<input type="hidden" name="option" value="com_jcollection" />';
						$html .= '<input type="hidden" name="id" value="'.(int)$info->id.'" />';
						$html .= '<input type="hidden" name="itemid" value="'.(int)$info->itemid.'" />';
						$html .= '<input type="hidden" name="url" value="'. $uri->toString().'" />';
						$html .= '</span>';
						$html .= '</form>';
					}
				}
			}
		}

		if( $html && $this->params->get( 'show_fieldset', 0 ) )
		{
			$html = '<fieldset><legend>'.JText::_( 'Rating' ).'</legend>'.$html."</fieldset>";
		}

		return $html;
	}

	function onAfterDisplayRevTitle( &$review, &$params )
	{
		$id = $review->id;
		$html = '';

		$show_vote = $review->params->get( 'show_vote', $params->get( 'show_vote' ) );

		if( $show_vote && $this->params->get( 'show_review' ) ) {
			$starImageOn = JHTML::_('image.site',  'rating_star.png', '/images/M_images/' );
			$starImageOff = JHTML::_('image.site',  'rating_star_blank.png', '/images/M_images/' );
			for( $j = 1; $j<=5; $j++ )
			{
				$ratinglabelname = 'rating'.$j.'label';
				$ratinglabel = $review->$ratinglabelname;
				$ratingname = 'rating'.$j;
				$rating = $review->$ratingname;
				if( $ratinglabel && $rating )
				{
					$img = '';
					for ($i=0; $i < $rating; $i++) {
						$img .= $starImageOn;
					}
					for ($i=$rating; $i < 5; $i++) {
						$img .= $starImageOff;
					}
					$html .= '<span class="content_rating">';
					$html .= $ratinglabel.':'.$img;
					$html .= "</span>\n<br />\n";
				}
			}
		}

		if( $html && $this->params->get( 'show_fieldset', 0 ) )
		{
			$html = '<fieldset><legend>'.JText::_( 'Rating' ).'</legend>'.$html."</fieldset>";
		}

		return $html;
	}

	function onAfterDisplayRev( &$review, &$params )
	{
		$html = '';

		$show_useful = $review->params->get( 'show_useful', $params->get( 'show_useful' ) );
		if( $show_useful && $this->params->get( 'show_useful' ) )
		{
			$uri = & JFactory::getURI();
			$user =& JFactory::getUser();
			$gid = (int) $user->get( 'aid', 0 );
			$useful_votes = (int)$review->useful_yes + (int)$review->useful_no;
			$html = (int)$review->useful_yes.'&nbsp;/&nbsp;'.(int)$useful_votes.'&nbsp;'.JText::_( 'find this review useful.' );
			if( $params->get( 'allow_useful' ) <= $gid )
			{
				$html .= '<form method="post" action="'.$uri->toString().'">';
				$html .= '<span class="content_rating">';
				$html .= '&nbsp;'.JText::_( 'Do you think this review is useful?' ).'&nbsp;';
				$html .= 'yes<input type="radio" alt="yes" name="useful" value="1" checked="checked" />';
				$html .= '&nbsp;no<input type="radio" alt="no" name="useful" value="0" />';
				$html .= '<input class="button" type="submit" name="submit_vote" value="'. JText::_( 'Rate' ) .'" />';
				$html .= '<input type="hidden" name="controller" value="rev" />';
				$html .= '<input type="hidden" name="task" value="vote_useful" />';
				$html .= '<input type="hidden" name="option" value="com_jcollection" />';
				$html .= '<input type="hidden" name="id" value="'.(int)$review->id.'" />';
				$html .= '<input type="hidden" name="itemid" value="'.(int)$review->itemid.'" />';
				$html .= '<input type="hidden" name="url" value="'.$uri->toString().'" />';
				$html .= '</span>';
				$html .= '</form>';
			}
		}

		return $html;
	}

}

?>
