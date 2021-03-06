<?php
/**
 *
 * @package phpBB Extension - Maintenance mode
 * @copyright (c) 2020 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\maintenance\acp;

class maintenance_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $user;

		// Add the ACP lang file
		$user->add_lang_ext('dmzx/maintenance', 'acp_maintenance');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('dmzx.maintenance.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		switch ($mode)
		{
			case 'config':
				// Load a template from adm/style for our ACP page
				$this->tpl_name = 'acp_maintenance';
				// Set the page title for our ACP page
				$this->page_title = $user->lang['ACP_MAINTENANCE_SETTINGS'];
				// Load the display options handle in the admin controller
				$admin_controller->display_options();
			break;
		}
	}
}
