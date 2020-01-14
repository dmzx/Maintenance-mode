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

class maintenance_v101 extends migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\maintenance\migrations\maintenance_install',
		];
	}

	public function update_data()
	{
		return [
			['config.add', ['maintenance_version', '1.0.1']],
		];
	}
}
