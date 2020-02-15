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
	'ATTACHED_IMAGES_BLOCK'							=> 'Attached Images Block',
	'ATTACHED_IMAGES_BLOCK_EXPLAIN'					=> 'Install mod Attached Images Block database changes with UMIL auto method.',
	'INSTALL_ATTACHED_IMAGES_BLOCK'					=> 'Install mod Attached Images Block',
	'INSTALL_ATTACHED_IMAGES_BLOCK_CONFIRM'			=> 'Are you ready to install the Attached Images Block?',
	'UNINSTALL_ATTACHED_IMAGES_BLOCK'				=> 'Uninstall Attached Images Block',
	'UNINSTALL_ATTACHED_IMAGES_BLOCK_CONFIRM'		=> 'Are you ready to uninstall the Attached Images Block? All settings and data saved by this mod will be removed!',
	'UPDATE_ATTACHED_IMAGES_BLOCK'					=> 'Update Attached Images Block Mod',
	'UPDATE_ATTACHED_IMAGES_BLOCK_CONFIRM'			=> 'Are you ready to update the Attached Images Block mod?',	
));

?>