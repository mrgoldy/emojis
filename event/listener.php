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
		return array('core.user_setup' => 'load_language_on_setup');
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param	\phpbb\event\data		$event		Event object
	 * @event	core.user_setup
	 * @return	void
	 * @access	public
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'mrgoldy/emojis',
			'lang_set' => 'emojis_common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}
