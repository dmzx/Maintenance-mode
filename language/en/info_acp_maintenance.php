<?php
/**
 *
 * @package phpBB Extension - Maintenance mode
 * @copyright (c) 2019 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
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
//
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, [
	'MAINTENANCE_ENABLE'						=> 'Enable Maintenance mode',
	'MAINTENANCE_ENABLE_EXPLAIN'				=> '"Disable board" above must be set to Yes to activate Maintenance mode.',
	'MAINTENANCE_TEXT'							=> 'Maintenance text',
	'MAINTENANCE_TEXT_EXPLAIN'					=> 'If you enter text here the "Disable board text" will be overwritten.<br />HTML is allowed.',
	'MAINTENANCE_TIMER'							=> 'Enable time countdown',
	'MAINTENANCE_TIMER_EXPLAIN'					=> 'Enable time countdown to maintenance mode.',
	'MAINTENANCE_TIME'							=> 'Set countdown time',
	'MAINTENANCE_TIME_EXPLAIN'					=> 'Example:	12/31/2020 00:00:00 PM',
	'MAINTENANCE_BACKGROUND_IMAGE'				=> 'Set background image URL',
	'MAINTENANCE_BACKGROUND_IMAGE_EXPLAIN'		=> 'Leave empty for default background image.<br />Or enter URL to background image.',
]);
