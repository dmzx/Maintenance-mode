<?php
/**
 *
 * @package phpBB Extension - Maintenance mode
 * @copyright (c) 2019 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\maintenance\migrations;

use phpbb\db\migration\migration;

class maintenance_install extends migration
{
	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	public function update_data()
	{
		return [
			['config.add', ['dmzx_maintenance_text', 'We’ll be back soon.']],
			['config.add', ['dmzx_maintenance_enable', 0]],
			['config.add', ['dmzx_maintenance_timer', 0]],
			['config.add', ['dmzx_maintenance_time', '']],
			['config.add', ['dmzx_maintenance_image', '']],
		];
	}
}
