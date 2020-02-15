<?php
/**
*
* info_acp_attached_images [Turkish]
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
	'RANDOM_IMAGES_BLOCK_ENABLE'			=> 'Enable module',
	'RANDOM_IMAGES_BLOCK_ENABLE_EXPLAIN'	=> 'If enable the module it displays attached images as a block on index page that contain the random images attached.',
	'RANDOM_IMAGES_BLOCK_SAVED'				=> 'The changes has been saved succesful!',
	'RANDOM_IMAGES_BLOCK'					=> 'Random Images Block',
	'ACP_RANDOM'							=> 'Random Images Block',
	'RANDOM_IMAGES_BLOCK_CONFIG'			=> 'Random Images',
	'MAX_RANDOM_IMAGES'						=> 'Maximum images number',
	'MAX_RANDOM_IMAGES_EXPLAIN'				=> 'Maximum image number to display on block',
	'EXCLUDE_FORUM'							=> 'Forum to Exclude ',
	'EXCLUDE_FORUM_EXPLAIN'					=> 'Choose a Forum name for exclude it from block. For several forums, you can choise multiforum name while touching ctrl button ',
	'MAXIMUM_IM_WIDTH'						=> 'Maximum image width ',
	'MAXIMUM_IM_WIDTH_EXPLAIN'				=> 'Set maximum width for images to display',
	'RESIZE_IM_AFTER'						=> 'Resize after ',
	'RESIZE_IM_AFTER_EXPLAIN'				=> 'No resize until this dimension. (pixel)',
	'RND_NUMBER_CHARS'						=> 'Number of Characters ',
	'RND_NUMBER_CHARS_EXPLAIN'				=> 'Will allow to define the number of characters for random images block topic titles ',

));

?>