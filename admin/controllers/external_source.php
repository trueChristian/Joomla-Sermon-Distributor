<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.0.x
	@build			3rd March, 2018
	@created		22nd October, 2015
	@package		Sermon Distributor
	@subpackage		external_source.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	A sermon distributor that links to Dropbox. 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * External_source Controller
 */
class SermondistributorControllerExternal_source extends JControllerForm
{
	/**
	 * Current or most recently performed task.
	 *
	 * @var    string
	 * @since  12.2
	 * @note   Replaces _task.
	 */
	protected $task;

	public function __construct($config = array())
	{
		$this->view_list = 'External_sources'; // safeguard for setting the return view listing to the main view.
		parent::__construct($config);
	}

	public function clearLocalListing() 
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// get the data
		$originalData = $this->input->post->get('jform', array(), 'array');
		if (isset($originalData['id']) && $originalData['id'] > 0)
		{			
			// get the needed
			$app   	= JFactory::getApplication();
			$lang  	= JFactory::getLanguage();
			$model 	= $this->getModel();
			$user 	= JFactory::getUser();
			$context = "$this->option.edit.$this->context";
			if (!$user->authorise('external_source.clear_local_listing', 'com_sermondistributor'))
			{
				// force production is not permitted
				$app->enqueueMessage(JText::_('COM_SERMONDISTRIBUTOR_YOU_DO_NOT_HAVE_PERMISSION_TO_CLEAR_LOCAL_LISTING'), 'error');
				// Save the data in the session.
				$app->setUserState($context . '.data', $originalData);
				// Redirect back to the edit screen.
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend($originalData['id'], 'id'), false
					)
				);
				return false;
			}
			// clear the listing
			$cleared = $model->clearLocalListing($originalData['id']);
			if (!$cleared)
			{
				// force production is not permitted
				$app->enqueueMessage(JText::_('COM_SERMONDISTRIBUTOR_LOCAL_LISTING_WAS_NOT_CLEARED'), 'error');
				// Save the data in the session.
				$app->setUserState($context . '.data', $originalData);
				// Redirect back to the edit screen.
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend($originalData['id'], 'id'), false
					)
				);
				return false;
			}
			// force production is not permitted
			$app->enqueueMessage(JText::_('COM_SERMONDISTRIBUTOR_LOCAL_LISTING_WAS_CLEARED_SUCCESSFULLY'), 'success');
			// Save the data in the session.
			$app->setUserState($context . '.data', $originalData);
			// Redirect back to the edit screen.
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($originalData['id'], 'id'), false
				)
			);
			return true;
		}
		$this->setError(JText::_('COM_SERMONDISTRIBUTOR_CLEARING_LOCAL_LISTING_CAN_NOT_BE_DONE'));
		$this->setMessage($this->getError(), 'error');
		// Redirect back to the list screen.
		$this->setRedirect(
			JRoute::_(
				'index.php?option=' . $this->option . '&view=' . $this->view_list
				. $this->getRedirectToListAppend(), false
			)
		);
		return false;
	}

	public function resetUpdateStatus() 
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// get the data
		$originalData = $this->input->post->get('jform', array(), 'array');
		if (isset($originalData['id']) && $originalData['id'] > 0)
		{			
			// get the needed
			$app   	= JFactory::getApplication();
			$lang  	= JFactory::getLanguage();
			$model 	= $this->getModel();
			$user 	= JFactory::getUser();
			$context = "$this->option.edit.$this->context";
			if (!$user->authorise('external_source.reset_update_status', 'com_sermondistributor'))
			{
				// force production is not permitted
				$app->enqueueMessage(JText::_('COM_SERMONDISTRIBUTOR_YOU_DO_NOT_HAVE_PERMISSION_TO_RESET_UPDATE_STATUS'), 'error');
				// Save the data in the session.
				$app->setUserState($context . '.data', $originalData);
				// Redirect back to the edit screen.
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend($originalData['id'], 'id'), false
					)
				);
				return false;
			}
			// reset update status
			$reset = $model->resetUpdateStatus($originalData['id']);
			if (isset($reset['error']))
			{
				// reset update status did not happen
				$app->enqueueMessage($reset['error'], 'error');
				// Save the data in the session.
				$app->setUserState($context . '.data', $originalData);
				// Redirect back to the edit screen.
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend($originalData['id'], 'id'), false
					)
				);
				return false;
			}
			// reset update status success
			$app->enqueueMessage(JText::_('COM_SERMONDISTRIBUTOR_RESETTING_THE_UPDATE_STATUS_WAS_SUCCESSFUL'), 'success');
			// Save the data in the session.
			$app->setUserState($context . '.data', $originalData);
			// Redirect back to the edit screen.
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($originalData['id'], 'id'), false
				)
			);
			return true;
		}
		$this->setError(JText::_('COM_SERMONDISTRIBUTOR_RESET_UPDATE_STATUS_CAN_NOT_BE_DONE'));
		$this->setMessage($this->getError(), 'error');
		// Redirect back to the list screen.
		$this->setRedirect(
			JRoute::_(
				'index.php?option=' . $this->option . '&view=' . $this->view_list
				. $this->getRedirectToListAppend(), false
			)
		);
		return false;
	}

        /**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		// Access check.
		$access = JFactory::getUser()->authorise('external_source.access', 'com_sermondistributor');
		if (!$access)
		{
			return false;
		}
		// In the absense of better information, revert to the component permissions.
		return JFactory::getUser()->authorise('external_source.create', $this->option);
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// get user object.
		$user		= JFactory::getUser();
		// get record id.
		$recordId	= (int) isset($data[$key]) ? $data[$key] : 0;


		// Access check.
		$access = ($user->authorise('external_source.access', 'com_sermondistributor.external_source.' . (int) $recordId) &&  $user->authorise('external_source.access', 'com_sermondistributor'));
		if (!$access)
		{
			return false;
		}

		if ($recordId)
		{
			// The record has been set. Check the record permissions.
			$permission = $user->authorise('external_source.edit', 'com_sermondistributor.external_source.' . (int) $recordId);
			if (!$permission)
			{
				if ($user->authorise('external_source.edit.own', 'com_sermondistributor.external_source.' . $recordId))
				{
					// Now test the owner is the user.
					$ownerId = (int) isset($data['created_by']) ? $data['created_by'] : 0;
					if (empty($ownerId))
					{
						// Need to do a lookup from the model.
						$record = $this->getModel()->getItem($recordId);

						if (empty($record))
						{
							return false;
						}
						$ownerId = $record->created_by;
					}

					// If the owner matches 'me' then allow.
					if ($ownerId == $user->id)
					{
						if ($user->authorise('external_source.edit.own', 'com_sermondistributor'))
						{
							return true;
						}
					}
				}
				return false;
			}
		}
		// Since there is no permission, revert to the component permissions.
		return $user->authorise('external_source.edit', $this->option);
	}

	/**
	 * Gets the URL arguments to append to an item redirect.
	 *
	 * @param   integer  $recordId  The primary key id for the item.
	 * @param   string   $urlVar    The name of the URL variable for the id.
	 *
	 * @return  string  The arguments to append to the redirect URL.
	 *
	 * @since   12.2
	 */
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$tmpl   = $this->input->get('tmpl');
		$layout = $this->input->get('layout', 'edit', 'string');

		$ref 	= $this->input->get('ref', 0, 'string');
		$refid 	= $this->input->get('refid', 0, 'int');

		// Setup redirect info.

		$append = '';

		if ($refid)
                {
			$append .= '&ref='.(string)$ref.'&refid='.(int)$refid;
		}
		elseif ($ref)
		{
			$append .= '&ref='.(string)$ref;
		}

		if ($tmpl)
		{
			$append .= '&tmpl=' . $tmpl;
		}

		if ($layout)
		{
			$append .= '&layout=' . $layout;
		}

		if ($recordId)
		{
			$append .= '&' . $urlVar . '=' . $recordId;
		}

		return $append;
	}

	/**
	 * Method to run batch operations.
	 *
	 * @param   object  $model  The model.
	 *
	 * @return  boolean   True if successful, false otherwise and internal error is set.
	 *
	 * @since   2.5
	 */
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel('External_source', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_sermondistributor&view=external_sources' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}

	/**
	 * Method to cancel an edit.
	 *
	 * @param   string  $key  The name of the primary key of the URL variable.
	 *
	 * @return  boolean  True if access level checks pass, false otherwise.
	 *
	 * @since   12.2
	 */
	public function cancel($key = null)
	{
		// get the referal details
		$this->ref 		= $this->input->get('ref', 0, 'word');
		$this->refid 	= $this->input->get('refid', 0, 'int');

		$cancel = parent::cancel($key);

		if ($cancel)
		{
			if ($this->refid)
			{
				$redirect = '&view='.(string)$this->ref.'&layout=edit&id='.(int)$this->refid;

				// Redirect to the item screen.
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . $redirect, false
					)
				);
			}
			elseif ($this->ref)
			{
				$redirect = '&view='.(string)$this->ref;

				// Redirect to the list screen.
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . $redirect, false
					)
				);
			}
		}
		else
		{
			// Redirect to the items screen.
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list, false
				)
			);
		}
		return $cancel;
	}

	/**
	 * Method to save a record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @since   12.2
	 */
	public function save($key = null, $urlVar = null)
	{
		// get the referal details
		$this->ref 		= $this->input->get('ref', 0, 'word');
		$this->refid 	= $this->input->get('refid', 0, 'int');

		if ($this->ref || $this->refid)
		{
			// to make sure the item is checkedin on redirect
			$this->task = 'save';
		}

		$saved = parent::save($key, $urlVar);

		if ($this->refid && $saved)
		{
			$redirect = '&view='.(string)$this->ref.'&layout=edit&id='.(int)$this->refid;

			// Redirect to the item screen.
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . $redirect, false
				)
			);
		}
		elseif ($this->ref && $saved)
		{
			$redirect = '&view='.(string)$this->ref;

			// Redirect to the list screen.
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . $redirect, false
				)
			);
		}
		return $saved;
	}

	/**
	 * Function that allows child controller access to model data
	 * after the data has been saved.
	 *
	 * @param   JModel  &$model     The data model object.
	 * @param   array   $validData  The validated data.
	 *
	 * @return  void
	 *
	 * @since   11.1
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		return;
	}

}