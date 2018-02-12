<?php
/**
*
* Emoji extension for the phpBB Forum Software package.
*
* @copyright (c) 2018 Mr. Goldy
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace mrgoldy\emojis\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Emojis Event listener.
 */
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.posting_modify_template_vars' => 'posting_page_template_vars',
			'core.ucp_profile_modify_signature'	=> 'signature_page_template_vars',
			'core.acp_board_config_edit_add'	=> 'emojis_settings',
		);
	}

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\extension\manager */
	protected $ext_manager;

	/** @var \phpbb\language\language */
	protected $lang;

	/** @var \phpbb\template\template */
	protected $template;

	/**
	 * Constructor
	 *
	 * @param  \phpbb\config\config			$config			Configuration object
	 * @param  \phpbb\extension\manager		$ext_manager	Extension Manager object
	 * @param  \phpbb\language\language		$lang			Language object
	 * @param  \phpbb\template\template		$template		Template object
	 * @access public
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\extension\manager $ext_manager, \phpbb\language\language $lang, \phpbb\template\template $template)
	{
		$this->config		= $config;
		$this->ext_manager	= $ext_manager;
		$this->lang			= $lang;
		$this->template		= $template;
	}

	/**
	 * Add emojis theme and path to the posting template variables
	 *
	 * @param	\phpbb\event\data		$event		Event object
	 * @event	core.posting_modify_template_vars
	 * @return	void
	 * @access	public
	 */
	public function posting_page_template_vars($event)
	{
		$page_data = $event['page_data'];
		$mode = $event['mode'];

		/* We only have to add the data, when in one of the following modes: */
		if (in_array($mode, array('post', 'reply', 'quote', 'edit')))
		{
			$page_data['EMOJIS_PATH'] = $this->ext_manager->get_extension_path('mrgoldy/emojis') . 'emojis/';
			$page_data['EMOJIS_THEME'] = $this->config['emojis_theme'];

			/* Merge the event data back in */
			$event['page_data'] = $page_data;

			/* Add the language variable */
			$this->lang->add_lang('emojis_common', 'mrgoldy/emojis');
		}
	}

	/**
	 * Add emojis theme and path to the signature template variables
	 *
	 * @event	core.ucp_profile_modify_signature
	 * @return	void
	 * @access	public
	 */
	public function signature_page_template_vars()
	{
		$this->template->assign_vars(array(
			'EMOJIS_PATH'				=> $this->ext_manager->get_extension_path('mrgoldy/emojis') . 'emojis/',
			'EMOJIS_THEME'				=> $this->config['emojis_theme'],
		));

		/* Add the language variable */
		$this->lang->add_lang('emojis_common', 'mrgoldy/emojis');
	}

	/**
	 * Add emojis settings to the ACP
	 *
	 * @param	\phpbb\event\data		$event		Event object
	 * @event	core.acp_board_config_edit_add
	 * @return	void
	 * @access	public
	 */
	public function emojis_settings($event)
	{
		if ($event['mode'] === 'post' && isset($event['display_vars']['vars']['allow_smilies']))
		{
			/* The Emoji theme options */
			$emoji_theme_array = array(
				'blue'		=> 'ACP_EMOJIS_BLUE',
				'red'		=> 'ACP_EMOJIS_RED',
				'green'		=> 'ACP_EMOJIS_GREEN',
				'black'		=> 'ACP_EMOJIS_BLACK',
			);

			/* Load language file */
			$this->lang->add_lang('emojis_acp', 'mrgoldy/emojis');

			/* Store display_vars event data in a local variable */
			$display_vars = $event['display_vars'];

			/**
			 * Define the new config variables
			 *
			 * @example function build_select($option_ary, $option_default = false)
			 * @see /includes/functions_acp.php
			 */
			$emoji_config = array(
				/* Emoji theme */
				'emojis_theme'		=> array(
					'lang'		=> 'ACP_EMOJIS_THEME',
					'validate'	=> 'string',
					'type'		=> 'select',
					'function'	=> 'build_select',
					'params'	=> array($emoji_theme_array, '{CONFIG_VALUE}'),
					'explain'	=> false
				),
			);

			/* Add the new config variable after the allow_smilies in the display_vars config array */
			$insert_after = array('after' => 'allow_smilies');
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $emoji_config, $insert_after);

			/* Merge the event data back in */
			$event['display_vars'] = $display_vars;
		}
	}
}
