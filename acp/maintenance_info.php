<?php
/**
 *
 * @package phpBB Extension - Maintenance mode
 * @copyright (c) 2020 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\maintenance\acp;

class maintenance_info
{
	function module()
	{
		return [
			'filename'	=> '\dmzx\maintenance\acp\maintenance_module',
			'title'		=> 'ACP_MAINTENANCE',
			'modes'		=> [
			'config'	=> [
				'title' => 'ACP_MAINTENANCE_SETTINGS',
				'auth' => 'ext_dmzx/maintenance && acl_a_board',
				'cat' => ['ACP_MAINTENANCE']],
			],
		];
	}
}
