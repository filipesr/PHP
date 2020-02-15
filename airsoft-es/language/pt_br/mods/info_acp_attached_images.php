<?php
/**
*
* info_acp_attached_images [English]
*
* @package language
* @version $Id: info_acp_attached_images.php 2009-11-30 15:31022Z irdem $
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ATTACHED_IMAGES_BLOCK'					=> 'Attached Images Block',
	'ACP_MODULE_NAME'						=> 'Attached Images Block',
	'ATTACHED_IMAGES_BLOCK_CONFIG'			=> 'Latest Images',
	'ATTACHED_IMAGES_BLOCK_ENABLE'			=> 'Enable module',
	'ATTACHED_IMAGES_BLOCK_ENABLE_EXPLAIN'	=> 'If enable the module it displays attached images as a block on index page that contain the latest images attached.',
	'ATTACHED_IMAGES_BLOCK_SAVED'			=> 'The changes has been saved succesful!',
	'FORUM_IDS_TO_SHOW'						=> 'Forum IDs to show. ',
	'FORUM_IDS_TO_SHOW_EXPLAIN'				=> 'Enter a forum ID. For several forums, separate ID \'s by commas (Example: 1,3,5)',
	'MAXIMUM_NUMBER_IMAGE'					=> 'Maximum image number ',
	'MAXIMUM_NUMBER_IMAGE_EXPLAIN'			=> 'Maximum image number to display on block',
	'MAXIMUM_WIDTH_IMAGE'					=> 'Maximum image width ',
	'MAXIMUM_WIDTH_IMAGE_EXPLAIN'			=> 'Set maximum width for images to display from a forum ID(s) (pixel)',
	'RESIZE_AFTER_THIS_PIXEL'				=> 'Resize after ',
	'RESIZE_AFTER_THIS_PIXEL_EXPLAIN'		=> 'No resize until this dimension. (pixel)',
	'LST_NUMBER_CHARS'						=> 'Number of Characters ',
	'LST_NUMBER_CHARS_EXPLAIN'				=> 'Will allow to define the number of characters for attached images block topic titles ',
	
));

?>