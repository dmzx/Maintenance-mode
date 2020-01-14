<?php
/**
 *
 * @package phpBB Extension - Maintenance mode
 * @copyright (c) 2020 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\maintenance\migrations;

use phpbb\db\migration\migration;

class maintenance_v102 extends migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\maintenance\migrations\maintenance_v101',
		];
	}

	public function update_data()
	{
		return [
			['config.update', ['maintenance_version', '1.0.2']],
			['config.add', ['dmzx_maintenance_enable_social', 0]],
			['config.add', ['dmzx_maintenance_enable_facebook', 0]],
			['config.add', ['dmzx_maintenance_facebook_url', '']],
			['config.add', ['dmzx_maintenance_enable_twitter', 0]],
			['config.add', ['dmzx_maintenance_twitter_url', '']],
			['config.add', ['dmzx_maintenance_enable_rss', 0]],
			['config.add', ['dmzx_maintenance_rss_url', '']],
			['config.add', ['dmzx_maintenance_enable_youtube', 0]],
			['config.add', ['dmzx_maintenance_youtube_url', '']],
			['config.add', ['dmzx_maintenance_enable_linkedin', 0]],
			['config.add', ['dmzx_maintenance_linkedin_url', '']],
			['config.add', ['dmzx_maintenance_enable_github', 0]],
			['config.add', ['dmzx_maintenance_github_url', '']],
			['config.add', ['dmzx_maintenance_enable_email', 0]],
			['config.add', ['dmzx_maintenance_email', '']],

			// ACP module
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MAINTENANCE'
			]],
			['module.add', [
				'acp', 'ACP_MAINTENANCE',
				[
					'module_basename'	=> '\dmzx\maintenance\acp\maintenance_module',
					'modes' => ['config'],
				],
			]],
		];
	}
}
