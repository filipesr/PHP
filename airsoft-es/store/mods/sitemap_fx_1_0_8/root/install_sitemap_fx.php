<?php
/**
*
* @author FladeX (Max Istlyaev) fladex@yandex.ru
* @package umil
* @version $Id install_sitemap_fx.php 1.0.8 2010-04-25 20:21:34GMT FladeX $
* @copyright (c) 2010 FladeX
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('mods/info_acp_sitemap');

if (!file_exists($phpbb_root_path . 'umil/umil.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// We only allow a founder to install this MOD
if ($user->data['user_type'] != USER_FOUNDER)
{
	if ($user->data['user_id'] == ANONYMOUS)
	{
		login_box('', 'LOGIN');
	}
	trigger_error('NOT_AUTHORISED');
}

if (!class_exists('umil'))
{
	include($phpbb_root_path . 'umil/umil.' . $phpEx);
}

$umil = new umil(true);

$mod = array(
	'name'		=> 'Sitemap FX',
	'version'	=> '1.0.8',
	'config'	=> 'sitemap_fx_version',
	'enable'	=> 'sitemap_fx_enable',
);

if (confirm_box(true))
{
	// Install the base 1.0.6 version
	if (!$umil->config_exists($mod['config']))
	{
		// Lets add a config setting for enabling/disabling the MOD and set it to true
		$umil->config_add($mod['enable'], true);

		// We must handle the version number ourselves.
		$umil->config_add($mod['config'], $mod['version']);

		$umil->config_add('sitemap_enable', '1', '1');

		$umil->config_add('sitemap_cache_time', '96', '1');

		$umil->config_add('sitemap_priority_0', '0.5', '1');

		$umil->config_add('sitemap_priority_1', '0.5', '1');

		$umil->config_add('sitemap_priority_2', '0.5', '1');

		$umil->config_add('sitemap_priority_3', '0.5', '1');

		$umil->config_add('sitemap_freq_0', 'daily', '1');

		$umil->config_add('sitemap_freq_1', 'daily', '1');

		$umil->config_add('sitemap_freq_2', 'daily', '1');

		$umil->config_add('sitemap_freq_3', 'daily', '1');

		$umil->module_add(array(

			array('acp', 'ACP_BOARD_CONFIGURATION',
				array('module_basename'	=> 'sitemap'),
			),

		));

		// Our final action, we purge the board cache
		$umil->cache_purge();
	}

	// We are done
	trigger_error('INSTALL_SITEMAP_FX_MOD_DONE');
}
else
{
	confirm_box(false, 'INSTALL_SITEMAP_FX_MOD');
}

// Shouldn't get here.
redirect($phpbb_root_path . $user->page['page_name']);

?>
