<?php
/**
*
* info_acp_sitemap.php [Korean] translated by chopark3
*
* @package language
* @version $Id: sitemap.php,v 1.0.8 2010-07-12 03:25:58 FladeX Exp $
* @copyright (c) 2009 FladeX
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
	'ACP_SITEMAP_INDEX_TITLE'			=> 'Sitemap FX',
	'ACP_SITEMAP'						=> 'Sitemap FX',
	'ACP_SITEMAP_SETTINGS'				=> 'Sitemap FX 설정',
	'ACP_SITEMAP_SETTINGS_EXPLAIN'		=> '이 곳에서 Sitemap FX 의 설정을 바꾸실 수 있습니다',
	'INSTALL_SITEMAP_FX_MOD'			=> 'Installing Sitemap FX mod',
	'INSTALL_SITEMAP_FX_MOD_CONFIRM'	=> 'Sitemap FX 모드를 설치하시 겠습니까?',
	'INSTALL_SITEMAP_FX_MOD_DONE'		=> 'Done! Please, delete file <var>install_sitemap_fx.php</var>.',
	'LOG_SITEMAP_SETTINGS_CHANGED'		=> '<strong>사이트맵 설정이 바뀌었습니다</strong>',
	'SITEMAP_ENABLE'					=> '사이트맵  활성화',
	'SITEMAP_ENABLE_EXPLAIN'			=> '검색 엔진을 위한 사이트맵 사용 허락을 활성화 할 수 있습니다',
	'SITEMAP_SETTINGS_CHANGED'			=> 'Sitemap FX 설정이 바뀌었습니다',
	'SITEMAP_PRIORITY_0'				=> '일반 주제글의 우선권',
	'SITEMAP_PRIORITY_1'				=> '필독 주제글의 우선권',
	'SITEMAP_PRIORITY_2'				=> '공지사항의 우선권',
	'SITEMAP_PRIORITY_3'				=> '전체 공지사항의 우선권',
	'SITEMAP_PRIORITY_EXPLAIN'			=> '검색을 위한 우선권 값을 설정 하십시오. 값은 0에서 1사이의 소수의 형태로 입력할 수 있습니다.  예를 들면, <strong>0.5</strong>.',
	'SITEMAP_PRIORITY_0_EXPLAIN'		=> '검색을 위한 우선권 값을 설정 하십시오. 값은 0에서 1사이의 소수의 형태로 입력할 수 있습니다.  예를 들면, <strong>0.5</strong>.',
	'SITEMAP_PRIORITY_1_EXPLAIN'		=> '검색을 위한 우선권 값을 설정 하십시오. 값은 0에서 1사이의 소수의 형태로 입력할 수 있습니다.  예를 들면, <strong>0.5</strong>.',
	'SITEMAP_PRIORITY_2_EXPLAIN'		=> '검색을 위한 우선권 값을 설정 하십시오. 값은 0에서 1사이의 소수의 형태로 입력할 수 있습니다.  예를 들면, <strong>0.5</strong>.',
	'SITEMAP_PRIORITY_3_EXPLAIN'		=> '검색을 위한 우선권 값을 설정 하십시오. 값은 0에서 1사이의 소수의 형태로 입력할 수 있습니다.  예를 들면, <strong>0.5</strong>.',
	'SITEMAP_FREQ_0'					=> '일반 주제글의 측정빈도',
	'SITEMAP_FREQ_1'					=> '필독 주제글의 측정빈도',
	'SITEMAP_FREQ_2'					=> '공지사항의 측정빈도',
	'SITEMAP_FREQ_3'					=> '전체 공지사항의 측정빈도',
	'SITEMAP_FREQ_0_EXPLAIN'			=> '일반 주제글의 측정빈도 설정을 변경.',
	'SITEMAP_FREQ_1_EXPLAIN'			=> '필독 주제글의 측정빈도 설정을 변경.',
	'SITEMAP_FREQ_2_EXPLAIN'			=> '공지사항의 측정빈도 설정을 변경.',
	'SITEMAP_FREQ_3_EXPLAIN'			=> '전체 공지사항의 측정빈도 설정을 변경.',
	'SITEMAP_FREQ_NEVER'				=> '측정하지 않음',
	'SITEMAP_FREQ_YEARLY'				=> '매년',
	'SITEMAP_FREQ_MONTHLY'				=> '매월',
	'SITEMAP_FREQ_WEEKLY'				=> '일주',
	'SITEMAP_FREQ_DAILY'				=> '매일',
	'SITEMAP_FREQ_HOURLY'				=> '매시간',
	'SITEMAP_FREQ_ALWAYS'				=> '항상',
	'SITEMAP_CACHE_TIME'				=> '사이트맵을 캐싱하는 간격 (시간당)',
	'SITEMAP_CACHE_TIME_EXPLAIN'		=> '사이트맵은 지정된 시간에 캐쉬을 통해서 만들어 집니다. 지정된 시간의 간격 후에 사이트맵은 새롭게 만들어 집니다. 그 간격동안 파일은 캐쉬에 놓이게 됩니다. 서버의 로드를 줄이기 위해서는 더 큰 값을 주십시오.',
));

?>
