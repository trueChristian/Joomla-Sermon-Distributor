<?php
/*-------------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
 ____                                                  ____                 __               __               __
/\  _`\                                               /\  _`\   __         /\ \__         __/\ \             /\ \__
\ \,\L\_\     __   _ __    ___ ___     ___     ___    \ \ \/\ \/\_\    ____\ \ ,_\  _ __ /\_\ \ \____  __  __\ \ ,_\   ___   _ __
 \/_\__ \   /'__`\/\`'__\/' __` __`\  / __`\ /' _ `\   \ \ \ \ \/\ \  /',__\\ \ \/ /\`'__\/\ \ \ '__`\/\ \/\ \\ \ \/  / __`\/\`'__\
   /\ \L\ \/\  __/\ \ \/ /\ \/\ \/\ \/\ \L\ \/\ \/\ \   \ \ \_\ \ \ \/\__, `\\ \ \_\ \ \/ \ \ \ \ \L\ \ \ \_\ \\ \ \_/\ \L\ \ \ \/
   \ `\____\ \____\\ \_\ \ \_\ \_\ \_\ \____/\ \_\ \_\   \ \____/\ \_\/\____/ \ \__\\ \_\  \ \_\ \_,__/\ \____/ \ \__\ \____/\ \_\
    \/_____/\/____/ \/_/  \/_/\/_/\/_/\/___/  \/_/\/_/    \/___/  \/_/\/___/   \/__/ \/_/   \/_/\/___/  \/___/   \/__/\/___/  \/_/

/------------------------------------------------------------------------------------------------------------------------------------/

	@version		3.0.x
	@created		22nd October, 2015
	@package		Sermon Distributor
	@subpackage		adminviewfolderlist.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 

	A sermon distributor that links to Dropbox. 

/----------------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use VDM\Joomla\Utilities\StringHelper;

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Adminviewfolderlist Form Field class for the Sermondistributor component
 */
class JFormFieldAdminviewfolderlist extends JFormFieldList
{
	/**
	 * The adminviewfolderlist field type.
	 *
	 * @var        string
	 */
	public $type = 'adminviewfolderlist';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return    array    An array of Html options.
	 */
	protected function getOptions()
	{
		// get custom folder files
		$localfolders = [];
		$localfolders[] = JPATH_ADMINISTRATOR . '/components/com_sermondistributor/views';
		$localfolders[] = JPATH_ADMINISTRATOR . '/components/com_sermondistributor/src/View';
		// set the default
		$options = [];
		// now check if there are files in the folder
		foreach ($localfolders as $localfolder)
		{
			if (is_dir($localfolder) && $folders = \Joomla\Filesystem\Folder::folders($localfolder))
			{
				if ($this->multiple === false)
				{
					$options[] = Html::_('select.option', '', Text::_('COM_SERMONDISTRIBUTOR_SELECT_AN_ADMIN_VIEW'));
				}
				foreach ($folders as $folder)
				{
					$options[] = Html::_('select.option', $folder, StringHelper::safe($folder, 'W'));
				}
			}
		}
		return $options;
	}
}
