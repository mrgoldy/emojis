<?php
/**
*
* Google Analytics extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace mrgoldy\emojis\migrations;

/**
* Migration stage 1: Initial data changes to the database
*/
class m1_initial_data extends \phpbb\db\migration\container_aware_migration
{
	/**
	* Assign migration file dependencies for this migration
	*
	* @return array Array of migration files
	* @static
	* @access public
	*/
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v32x\v321');
	}

	/**
	* Add Emoji data to the database.
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		return array(
			array('config.add', array('emojis_theme', 'blue')),
		);
	}
}
