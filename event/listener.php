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

	/** @var string */
	protected $phpbb_admin_path;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	* Constructor
	*
	* @param user				$user
	* @param config				$config
	* @param auth				$auth
	* @param template			$template
	* @param string			 $adm_relative_pat
	* @param string				$root_path
	* @param string				$php_ext
	*
	*/
	public function __construct(
		user $user,
		config $config,
		auth $auth,
		template $template,
		$adm_relative_path,
		$root_path,
		$php_ext
	)
	{
		$this->user 				= $user;
		$this->config 				= $config;
		$this->auth 				= $auth;
		$this->template 			= $template;
		$this->adm_relative_path 	= $adm_relative_path;
		$this->phpbb_admin_path 	= $root_path . $adm_relative_path;
		$this->root_path 			= $root_path;
		$this->php_ext 				= $php_ext;
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
					'type'		=> 'custom',
					'function'	=> array($this, 'dmzx_maintenance_enable'),
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

		if ($this->config['dmzx_maintenance_enable'])
		{
			$this->user->add_lang_ext('dmzx/maintenance', 'maintenance_social');

			$this->template->assign_vars([
				'S_MAINTENANCE_SOCIAL' 				=> $this->config['dmzx_maintenance_enable_social'],
				'S_MAINTENANCE_SOCIAL_FACEBOOK' 	=> $this->config['dmzx_maintenance_enable_facebook'],
				'MAINTENANCE_FACEBOOK_URL' 			=> $this->config['dmzx_maintenance_facebook_url'],
				'S_MAINTENANCE_SOCIAL_TWITTER' 		=> $this->config['dmzx_maintenance_enable_twitter'],
				'MAINTENANCE_TWITTER_URL' 			=> $this->config['dmzx_maintenance_twitter_url'],
				'S_MAINTENANCE_SOCIAL_RSS' 			=> $this->config['dmzx_maintenance_enable_rss'],
				'MAINTENANCE_RSS_URL' 				=> $this->config['dmzx_maintenance_rss_url'],
				'S_MAINTENANCE_SOCIAL_YOUTUBE' 		=> $this->config['dmzx_maintenance_enable_youtube'],
				'MAINTENANCE_YOUTUBE_URL' 			=> $this->config['dmzx_maintenance_youtube_url'],
				'S_MAINTENANCE_SOCIAL_LINKEDIN' 	=> $this->config['dmzx_maintenance_enable_linkedin'],
				'MAINTENANCE_LINKEDIN_URL' 			=> $this->config['dmzx_maintenance_linkedin_url'],
				'S_MAINTENANCE_SOCIAL_GITHUB' 		=> $this->config['dmzx_maintenance_enable_github'],
				'MAINTENANCE_GITHUB_URL' 			=> $this->config['dmzx_maintenance_github_url'],
				'S_MAINTENANCE_SOCIAL_EMAIL' 		=> $this->config['dmzx_maintenance_enable_email'],
				'MAINTENANCE_EMAIL' 				=> $this->config['dmzx_maintenance_email'],
			]);
		}

		define('IN_CRON', true);
		page_footer();

		exit_handler();
	}

	function dmzx_maintenance_enable($value, $key)
	{
		$go_settings = append_sid($this->phpbb_admin_path . 'index.' . $this->php_ext, 'i=-dmzx-maintenance-acp-maintenance_module&amp;mode=config', true);

		$radio_ary = array(1 => 'YES', 0 => 'NO');
		return h_radio('config[dmzx_maintenance_enable]', $radio_ary, $value) . '<a href="' . $go_settings . '" >'. $this->user->lang('ACP_MAINTENANCE_SETTINGS') . '</a>';
	}
}
