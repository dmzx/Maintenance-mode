<?php
/**
 *
 * @package phpBB Extension - Maintenance mode
 * @copyright (c) 2019 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\maintenance\event;

use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\user;
use phpbb\config\config;
use phpbb\auth\auth;
use phpbb\template\template;

class listener implements EventSubscriberInterface
{

	/** @var user */
	protected $user;

	/** @var config */
	protected $config;

	/** @var auth */
	protected $auth;

	/** @var template */
	protected $template;

	/**
	* Constructor
	*
	* @param user				$user
	* @param config				$config
	* @param auth				$auth
	* @param template			$template
	*
	*/
	public function __construct(
		user $user,
		config $config,
		auth $auth,
		template $template
	)
	{
		$this->user 				= $user;
		$this->config 				= $config;
		$this->auth 				= $auth;
		$this->template 			= $template;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.acp_board_config_edit_add' 		=> 'acp_board_config_edit_add',
			'core.user_setup_after'					=> 'user_setup_after',
		];
	}

	public function user_setup_after($event)
	{
		if ($this->config['dmzx_maintenance_enable'] && $this->config['board_disable'])
		{
			$this->user->add_lang_ext('dmzx/maintenance', 'maintenance');
			$msg_title = $this->user->lang['MAINTENANCE_INFO'];

			$msg_text = (!empty($this->config['dmzx_maintenance_text'])) ? $this->config['dmzx_maintenance_text'] : $this->config['board_disable_msg'];

			if ($this->config['board_disable'] && !defined('IN_INSTALL') && !defined('IN_LOGIN') && !defined('SKIP_CHECK_DISABLED') && !$this->auth->acl_gets('a_', 'm_') && !$this->auth->acl_getf_global('m_'))
			{
				$this->generate_page($msg_title, $msg_text);
			}
		}
	}

	public function acp_board_config_edit_add($event)
	{
		$this->inject_configs($event, [
			'mode'		=> 'settings',
			'position'	=> ['after' => 'board_disable_msg'],
			'configs'	=> [
				'dmzx_maintenance_enable' => [
					'lang' 		=> 'MAINTENANCE_ENABLE',
					'type'		=> 'radio:yes_no',
					'explain'	=> true,
				],
				'dmzx_maintenance_text' => [
					'lang' 		=> 'MAINTENANCE_TEXT',
					'type'		=> 'textarea:5:30',
					'explain'	=> true,
				],
				'dmzx_maintenance_timer' => [
					'lang' 		=> 'MAINTENANCE_TIMER',
					'type'		=> 'radio:yes_no',
					'explain'	=> true,
				],
				'dmzx_maintenance_time' => [
					'lang' 		=> 'MAINTENANCE_TIME',
					'type'		=> 'text:40:255',
					'explain'	=> true,
				],
				'dmzx_maintenance_image' => [
					'lang' 		=> 'MAINTENANCE_BACKGROUND_IMAGE',
					'type'		=> 'text:60:255',
					'explain'	=> true,
				],
			],
		]);
	}

	protected function inject_configs($event, $options)
	{
		if ($event['mode'] == $options['mode'])
		{
			$display_vars = $event['display_vars'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $options['configs'], $options['position']);
			$event['display_vars'] = ['title' => $display_vars['title'], 'vars' => $display_vars['vars']];
		}
	}

	private function generate_page($msg_title, $msg_text)
	{
		page_header($msg_title);

		$this->template->set_filenames([
			'body' => '@dmzx_maintenance\message_body.html']
		);

		$board_url = generate_board_url();

		$background_img = (!empty($this->config['dmzx_maintenance_image'])) ? $this->config['dmzx_maintenance_image'] : $board_url . '/ext/dmzx/maintenance/styles/prosilver/theme/assets/maintenance.png';

		$this->template->assign_vars([
			'MESSAGE_TITLE' 		=> $msg_title,
			'MESSAGE_TEXT' 			=> html_entity_decode($msg_text),
			'S_USER_WARNING' 		=> true,
			'S_USER_NOTICE' 		=> false,
			'S_MAINTENANCE' 		=> $this->config['dmzx_maintenance_enable'],
			'MAINTENANCE_TEXT'		=> $this->user->lang('MAINTENANCE_TEXT', $this->config['sitename']),
			'MAINTENANCE_SITENAME'	=> $this->config['sitename'],
			'S_MAINTENANCE_TIMER'	=> $this->config['dmzx_maintenance_timer'],
			'MAINTENANCE_TIME'		=> $this->config['dmzx_maintenance_time'],
			'MAINTENANCE_IMAGE'		=> $background_img,
		]);

		define('IN_CRON', true);
		page_footer();

		exit_handler();
	}
}
