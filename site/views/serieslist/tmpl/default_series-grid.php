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
	@subpackage		default_series-grid.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 

	A sermon distributor that links to Dropbox. 

/----------------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;

?>
<ul id="series-sort-menu" class="uk-subnav">
	<li data-uk-sort="series"><a href=""><?php echo Text::_('COM_SERMONDISTRIBUTOR_NAME_ASC'); ?></a></li>
	<li data-uk-sort="series:desc"><a href=""><?php echo Text::_('COM_SERMONDISTRIBUTOR_NAME_DESC'); ?></a></li>
	<?php if ($this->params->get('list_series_hits')): ?>
		<li data-uk-sort="hits"><a href=""><?php echo Text::_('COM_SERMONDISTRIBUTOR_HITS_ASC'); ?></a></li>
		<li data-uk-sort="hits:desc"><a href=""><?php echo Text::_('COM_SERMONDISTRIBUTOR_HITS_DESC'); ?></a></li>
	<?php endif; ?>
	<?php if ($this->params->get('list_series_sermon_count')): ?>
		<li data-uk-sort="sermons"><a href=""><?php echo Text::_('COM_SERMONDISTRIBUTOR_SERMONS_COUNT_ASC'); ?></a></li>
		<li data-uk-sort="sermons:desc"><a href=""><?php echo Text::_('COM_SERMONDISTRIBUTOR_SERMONS_COUNT_DESC'); ?></a></li>
	<?php endif; ?>
</ul>
<div data-uk-check-display class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-grid="{controls: '#series-sort-menu',gutter: 15}">
	<?php foreach ($this->items as $item): ?>
		<div data-series="<?php echo $this->escape($item->name); ?>" data-hits="<?php echo (int) $item->hits; ?>" data-sermons="<?php echo count($item->idSeriesSermonB); ?>"><?php $item->params = $this->params; $item->desc = $this->escape($item->description, true, 65); echo LayoutHelper::render('seriespanel', $item); ?></div>
	<?php endforeach; ?>
</div>
