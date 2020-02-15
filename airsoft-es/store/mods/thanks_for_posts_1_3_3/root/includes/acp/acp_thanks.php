<?php
/**
*
* @package acp
* @version $Id: acp_thanks.php,v 133 2011-12-04 10:02:51 Палыч$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/
class acp_thanks
{
	var $u_action;
	var $new_config = array();

	function main($id, $mode)
	{
		global $db, $user, $auth, $template;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$action	= request_var('action', '');
		$submit = (isset($_POST['submit'])) ? true : false;

		$form_key = 'acp_thanks';
		add_form_key($form_key);
		/**
		*	Validation types are:
		*		string, int, bool,
		*		script_path (absolute path in url - beginning with / and no trailing slash),
		*		rpath (relative), rwpath (realtive, writable), path (relative path, but able to escape the root), wpath (writable)
		*/
		$display_vars = array(
			'title'	=> 'ACP_THANKS_SETTINGS',
			'vars'	=> array(
			'legend'					=> 'GENERAL_OPTIONS',
			'remove_thanks'				=> array('lang' => 'REMOVE_THANKS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
			'thanks_only_first_post'	=> array('lang' => 'THANKS_ONLY_FIRST_POST', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
			'thanks_notice_on'			=> array('lang' => 'THANKS_NOTICE_ON', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
			'thanks_info_page'			=> array('lang' => 'THANKS_INFO_PAGE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
			'thanks_postlist_view'		=> array('lang' => 'THANKS_POSTLIST_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
			'thanks_number_post'		=> array('lang' => 'THANKS_NUMBER_POST', 'validate' => 'int:1:250', 'type' => 'text:4:6', 'explain' => true),	
			'thanks_time_view'			=> array('lang' => 'THANKS_TIME_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),			
			'thanks_counters_view'		=> array('lang' => 'THANKS_COUNTERS_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),			
			'thanks_profilelist_view'	=> array('lang' => 'THANKS_PROFILELIST_VIEW', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
			'thanks_number'				=> array('lang' => 'THANKS_NUMBER', 'validate' => 'int:1',	'type' => 'text:4:4', 'explain' => false),		
			'thanks_top_number'			=> array('lang' => 'THANKS_TOP_NUMBER', 'validate' => 'int:0', 'type' => 'text:4:6', 'explain' => true),
			)
		);

		if (isset($display_vars['lang']))
		{
			$user->add_lang($display_vars['lang']);
		}

		$this->new_config = $config;
		$cfg_array = (isset($_REQUEST['config'])) ? utf8_normalize_nfc(request_var('config', array('' => ''), true)) : $this->new_config;
		$error = array();

		// We validate the complete config if whished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if ($submit && !check_form_key($form_key))
		{
			$error[] = $user->lang['FORM_INVALID'];
		}
		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}
			
			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if ($submit)
			{
				set_config($config_name, $config_value);

			}
		}

		if ($submit)
		{
			add_log('admin', 'LOG_CONFIG_' . strtoupper($mode));

			trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}

		$this->tpl_name = 'acp_thanks';
		$this->page_title = $display_vars['title']; 

		$template->assign_vars(array(
			'L_TITLE'			=> $user->lang[$display_vars['title']],
			'L_TITLE_EXPLAIN'	=> $user->lang[$display_vars['title'] . '_EXPLAIN'],
			'L_ACP_THANKS_MOD_VER'	=> $user->lang['ACP_THANKS_MOD_VER'],
			'THANKS_MOD_VERSION'	=> $config['thanks_mod_version'],

			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),

			'U_ACTION'			=> $this->u_action)
		);

		// Output relevant page
		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
				);

				continue;
			}
			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
			}
			else if ($vars['explain'])
			{
				$l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
			}

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', array(
				'KEY'			=> $config_key,
				'TITLE'			=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'		=> $vars['explain'],
				'TITLE_EXPLAIN'	=> $l_explain,
				'CONTENT'		=> $content,
				)
			);

			unset($display_vars['vars'][$config_key]);
		}
	}
}

?>