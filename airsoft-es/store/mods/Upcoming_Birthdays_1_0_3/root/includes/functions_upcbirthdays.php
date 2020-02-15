<?php
/**
*
* @package phpBB3
* @version $Id: functions_upcbirthdays.php 257 2009-11-24 20:59:44Z lefty74 $
* @copyright (c) 2008,2009 lefty74
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* Obtain Upcoming Birthday List
**/
function get_upcbirthdays()
{
	global $cache, $config, $db, $user, $auth;
	global $template, $phpbb_root_path, $phpEx;

	$birthday_ahead_list = '';
	$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_birthday
		FROM ' . USERS_TABLE . ' u
		LEFT JOIN ' . BANLIST_TABLE . " b ON (u.user_id = b.ban_userid)
		WHERE (b.ban_id IS NULL
			OR b.ban_exclude = 1)
			AND	user_birthday NOT LIKE '%- 0-%'
			AND user_birthday NOT LIKE '0-%'
			AND	user_birthday NOT LIKE '0- 0-%'
			AND	user_birthday NOT LIKE ''
			AND user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')';
	$result = $db->sql_query($sql);
	//delete the above line and uncomment below line if you want to cache the query for an hour
	//$result = $db->sql_query($sql,3600);

	$now = getdate(time() + $user->timezone + $user->dst - date('Z'));
    $today = (mktime(0, 0, 0, $now['mon'], $now['mday'], $now['year']));
    $tomorrow = (mktime(0, 0, 0, $now['mon'], $now['mday']+1, $now['year']));
	
	$ucbirthdayrow = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$bdday = $bdmonth = 0;
		list($bdday, $bdmonth) = explode('-', $row['user_birthday']);
		$birthdaycheck = strtotime(gmdate('Y') . '-' . (int) trim($bdmonth) . '-' . (int) trim($bdday) );
		$birthdayyear = ( $birthdaycheck < $today ) ? gmdate('Y') + 1 : gmdate('Y');
		$birthdaydate = ($birthdayyear . '-' . (int) trim($bdmonth) . '-' . (int) trim($bdday) );
		$ucbirthdayrow[] = array(
							'user_birthday_tstamp' 	=> 	strtotime($birthdaydate), 
							'username'				=>	$row['username'], 
							'user_birthdayyear' 	=> 	$birthdayyear, 
							'user_birthday' 		=> 	$row['user_birthday'], 
							'user_id'				=>	$row['user_id'], 
							'user_colour'			=>	$row['user_colour']);
		
	}
	$db->sql_freeresult($result);
	sort($ucbirthdayrow);

	for ($i = 0, $end = sizeof($ucbirthdayrow); $i < $end; $i ++)
	{
		if ( $ucbirthdayrow[$i]['user_birthday_tstamp'] >= $tomorrow && $ucbirthdayrow[$i]['user_birthday_tstamp'] <= ($today + ((($config['allow_birthdays_ahead'] >365) ? 365 : $config['allow_birthdays_ahead']) * 86400) ) )
		{
			$user_link = get_username_string('full', $ucbirthdayrow[$i]['user_id'], $ucbirthdayrow[$i]['username'], $ucbirthdayrow[$i]['user_colour']);

			//lets add to the birthday_ahead list.
			$birthday_ahead_list .= (($birthday_ahead_list != '') ? ', ' : '') . '<span title="' . $user->format_dateucb(($ucbirthdayrow[$i]['user_birthday_tstamp']), 'D, j. M') . '">' . $user_link . '</span>';
			if ( $age = (int) substr($ucbirthdayrow[$i]['user_birthday'], -4) )
			{
				$birthday_ahead_list .= ' (' . ($ucbirthdayrow[$i]['user_birthdayyear'] - $age) . ')';
			}
		}
	}
	
	// Assign index specific vars
	$template->assign_vars(array(
		'BIRTHDAYS_AHEAD_LIST'	=> $birthday_ahead_list,
		'L_BIRTHDAYS_AHEAD'	=> sprintf($user->lang['BIRTHDAYS_AHEAD'], ($config['allow_birthdays_ahead'] >365) ? 365 : $config['allow_birthdays_ahead']),
		));
}

?>