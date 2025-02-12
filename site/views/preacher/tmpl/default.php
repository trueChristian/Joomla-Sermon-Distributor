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
	@subpackage		default.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 

	A sermon distributor that links to Dropbox. 

/----------------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper as Html;
?>
<form action="<?php echo Route::_('index.php?option=com_sermondistributor'); ?>" method="post" name="adminForm" id="adminForm">
<?php if ($this->preacher): ?>
	<?php if ($this->params->get('preacher_display') == 1) : ?>
		<div class="uk-grid" data-uk-grid-match="{target:'.uk-panel'}"><?php echo $this->loadTemplate('preacherpanel'); ?></div>
	<?php elseif ($this->params->get('preacher_display') == 2) : ?>
		<?php echo $this->loadTemplate('preacherbox'); ?>
	<?php else: ?>
		<?php echo $this->loadTemplate('preachersmall'); ?>
	<?php endif; ?>
<?php else: ?>
	<div class="uk-alert uk-alert-warning" data-uk-alert>
		<a href="" class="uk-alert-close uk-close"></a>
		<p><?php echo Text::_('COM_SERMONDISTRIBUTOR_NO_PREACHER_WAS_FOUND'); ?></p>
	</div>
<?php endif; ?>
<?php if ($this->items): ?>
	<?php if ($this->params->get('preacher_sermons_display') == 1) : ?>
		<?php echo $this->loadTemplate('sermons-table'); ?>
	<?php elseif ($this->params->get('preacher_sermons_display') == 2) : ?>
		<?php echo $this->loadTemplate('sermons-grid'); ?>
	<?php else: ?>
		<?php echo $this->loadTemplate('sermons-list'); ?>
	<?php endif; ?>
	<script>

	function sermonCounter(key, filename) {
		const getUrl = "index.php?option=com_sermondistributor&task=ajax.countDownload&format=json&raw=true";
		let requestUrl = '';

		if (key.length > 0 && filename.length > 0) {
			request = getUrl + '&<?php echo \JSession::getFormToken(); ?>=1&key=' + encodeURIComponent(key) + '&filename=' + encodeURIComponent(filename);
		} else {
			return;
		}

		// Using Fetch API for the AJAX call
		return fetch(requestUrl, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			}
		})
		.then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.json();
		})
		.catch(error => console.error('There was a problem with your fetch operation:', error));
	}
	</script>
<?php else: ?>
	<div class="uk-alert uk-alert-warning" data-uk-alert>
		<a href="" class="uk-alert-close uk-close"></a>
		<p><?php echo Text::_('COM_SERMONDISTRIBUTOR_NO_SERMONS_WERE_FOUND'); ?></p>
	</div>
<?php endif; ?>


<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>
	<div class="pagination">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
<?php endif; ?><?php echo $this->toolbar->render(); ?>
<input type="hidden" name="task" value="" />
<?php echo Html::_('form.token'); ?>
</form>
