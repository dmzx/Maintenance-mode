<?php
/**
 *
 * @package phpBB Extension - Maintenance mode
 * @copyright (c) 2020 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\maintenance\controller;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\log\log_interface;
use phpbb\user;
use phpbb\request\request_interface;

class admin_controller
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/** @var user */
	protected $user;

	/** @var request_interface */
	protected $request;

	/** @var string */
	protected $phpbb_admin_path;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $u_action;

	/**
	* Constructor
	*
	* @param config					$config
	* @param template				$template
	* @param log_interface			$log
	* @param user					$user
	* @param request_interface		$request
	* @param string			 	$adm_relative_pat
	* @param string					$root_path
	* @param string					$php_ext
	*/
	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		user $user,
		request_interface $request,
		$adm_relative_path,
		$root_path,
		$php_ext
	)
	{
		$this->config 				= $config;
		$this->template 			= $template;
		$this->log 					= $log;
		$this->user 				= $user;
		$this->request 				= $request;
		$this->phpbb_admin_path 	= $root_path . $adm_relative_path;
		$this->root_path 			= $root_path;
		$this->php_ext 				= $php_ext;
	}

	public function display_options()
	{
		add_form_key('acp_maintenance');

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('acp_maintenance'))
			{
				trigger_error($this->user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_MAINTENANCE_SAVED');

			trigger_error($this->user->lang['MAINTENANCE_SAVED'] . adm_back_link($this->u_action));
		}

		$url_board_settings = append_sid($this->phpbb_admin_path . 'index.' . $this->php_ext, 'i=acp_board&amp;mode=settings');
		$board_settings = $this->user->lang('MAINTENANCE_SETTINGS_EXPLAIN', '<a href="' . $url_board_settings . '">', '</a>');

		$this->template->assign_vars([
			'S_MAINTENANCE' 				=> $this->config['dmzx_maintenance_enable'],
			'MAINTENANCE_SETTINGS_EXPLAIN'	=> $board_settings,
			'MAINTENANCE_VERSION'			=> $this->config['maintenance_version'],
			'MAINTENANCE_TEXT'				=> $this->config['dmzx_maintenance_text'],
			'MAINTENANCE_TIMER'				=> $this->config['dmzx_maintenance_timer'],
			'MAINTENANCE_TIME'				=> $this->config['dmzx_maintenance_time'],
			'MAINTENANCE_BACKGROUND_IMAGE'	=> $this->config['dmzx_maintenance_image'],
			'MAINTENANCE_SOCIAL' 			=> $this->config['dmzx_maintenance_enable_social'],
			'MAINTENANCE_SOCIAL_FACEBOOK' 	=> $this->config['dmzx_maintenance_enable_facebook'],
			'MAINTENANCE_FACEBOOK_URL' 		=> $this->config['dmzx_maintenance_facebook_url'],
			'MAINTENANCE_SOCIAL_TWITTER' 	=> $this->config['dmzx_maintenance_enable_twitter'],
			'MAINTENANCE_TWITTER_URL' 		=> $this->config['dmzx_maintenance_twitter_url'],
			'MAINTENANCE_SOCIAL_RSS' 		=> $this->config['dmzx_maintenance_enable_rss'],
			'MAINTENANCE_RSS_URL' 			=> $this->config['dmzx_maintenance_rss_url'],
			'MAINTENANCE_SOCIAL_YOUTUBE' 	=> $this->config['dmzx_maintenance_enable_youtube'],
			'MAINTENANCE_YOUTUBE_URL' 		=> $this->config['dmzx_maintenance_youtube_url'],
			'MAINTENANCE_SOCIAL_LINKEDIN' 	=> $this->config['dmzx_maintenance_enable_linkedin'],
			'MAINTENANCE_LINKEDIN_URL' 		=> $this->config['dmzx_maintenance_linkedin_url'],
			'MAINTENANCE_SOCIAL_GITHUB' 	=> $this->config['dmzx_maintenance_enable_github'],
			'MAINTENANCE_GITHUB_URL' 		=> $this->config['dmzx_maintenance_github_url'],
			'MAINTENANCE_SOCIAL_EMAIL' 		=> $this->config['dmzx_maintenance_enable_email'],
			'MAINTENANCE_EMAIL' 			=> $this->config['dmzx_maintenance_email'],
			'U_ACTION'						=> $this->u_action,
		]);
	}

	protected function set_options()
	{
		$this->config->set('dmzx_maintenance_text', $this->request->variable('dmzx_maintenance_text', '', true));
		$this->config->set('dmzx_maintenance_timer', $this->request->variable('dmzx_maintenance_timer', 0));
		$this->config->set('dmzx_maintenance_time', $this->request->variable('dmzx_maintenance_time', '', true));
		$this->config->set('dmzx_maintenance_image', $this->request->variable('dmzx_maintenance_image', '', true));
		$this->config->set('dmzx_maintenance_enable_social', $this->request->variable('dmzx_maintenance_enable_social', 0));
		$this->config->set('dmzx_maintenance_enable_facebook', $this->request->variable('dmzx_maintenance_enable_facebook', 0));
		$this->config->set('dmzx_maintenance_facebook_url', $this->request->variable('dmzx_maintenance_facebook_url', '', true));
		$this->config->set('dmzx_maintenance_enable_twitter', $this->request->variable('dmzx_maintenance_enable_twitter', 0));
		$this->config->set('dmzx_maintenance_twitter_url', $this->request->variable('dmzx_maintenance_twitter_url', '', true));
		$this->config->set('dmzx_maintenance_enable_rss', $this->request->variable('dmzx_maintenance_enable_rss', 0));
		$this->config->set('dmzx_maintenance_rss_url', $this->request->variable('dmzx_maintenance_rss_url', '', true));
		$this->config->set('dmzx_maintenance_enable_youtube', $this->request->variable('dmzx_maintenance_enable_youtube', 0));
		$this->config->set('dmzx_maintenance_youtube_url', $this->request->variable('dmzx_maintenance_youtube_url', '', true));
		$this->config->set('dmzx_maintenance_enable_linkedin', $this->request->variable('dmzx_maintenance_enable_linkedin', 0));
		$this->config->set('dmzx_maintenance_linkedin_url', $this->request->variable('dmzx_maintenance_linkedin_url', '', true));
		$this->config->set('dmzx_maintenance_enable_github', $this->request->variable('dmzx_maintenance_enable_github', 0));
		$this->config->set('dmzx_maintenance_github_url', $this->request->variable('dmzx_maintenance_github_url', '', true));
		$this->config->set('dmzx_maintenance_enable_email', $this->request->variable('dmzx_maintenance_enable_email', 0));
		$this->config->set('dmzx_maintenance_email', $this->request->variable('dmzx_maintenance_email', '', true));
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
