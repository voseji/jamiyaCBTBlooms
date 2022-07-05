<?php
/*
 *
 * @package		ARI Quiz
 * @author		ARI Soft
 * @copyright	Copyright (c) 2011 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

(defined('_JEXEC') && defined('ARI_FRAMEWORK_LOADED')) or die;

AriKernel::import('Joomla.Controllers.Controller');
AriKernel::import('Web.Controls.Data.MultiPageDataTable');
AriKernel::import('Data.DataFilter');

class AriQuizControllerMailtemplates extends AriController 
{
	var $_templateStateKey = 'com_ariquiz.dtMailTemplates';
	
	function quizzes() 
	{
		$this->redirect('index.php?option=com_ariquiz&view=quizzes');
	}

	function add()
	{
		if (!AriQuizHelper::isAuthorise('mailtemplate.create'))
		{
			JError::raiseWarning(500, JText::_('JLIB_APPLICATION_ERROR_CREATE_RECORD_NOT_PERMITTED'));
			$this->redirect('index.php?option=com_ariquiz&view=mailtemplates');
		}
		
		$this->redirect('index.php?option=com_ariquiz&view=mailtemplate&task=add');
	}
	
	function edit()
	{
		if (!AriQuizHelper::isAuthorise('mailtemplate.edit'))
		{
			JError::raiseWarning(500, JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->redirect('index.php?option=com_ariquiz&view=mailtemplates');
		}
		
		$templateId = JRequest::getVar('MailTemplateId');
		if (is_array($templateId) && count($templateId) > 0)
			$templateId = $templateId[0];
			
		$templateId = intval($templateId, 10);
		
		$this->redirect('index.php?option=com_ariquiz&view=mailtemplate&task=edit&templateId=' . $templateId);
	}

	function ajaxGetTemplateList()
	{
		$model =& $this->getModel();

		$filter = new AriDataFilter(
			array(
				'startOffset' => 0, 
				'limit' => ARIQUIZ_GRID_PAGESIZE, 
				'sortField' => 'TemplateName', 
				'dir' => 'asc'
			), 
			true,
			$this->_templateStateKey);

		$totalCnt = $model->getTemplateCount($filter);
		$filter->fixFilter($totalCnt);

		$templates = $this->_extendTemplateList(
			$model->getTemplateList($filter)
		);
		$data = AriMultiPageDataTableControl::createDataInfo($templates, $filter, $totalCnt); 

		return $data;
	}
	
	function _extendTemplateList($data)
	{
		if (!is_array($data))
			return $data;

		$allowEdit = AriQuizHelper::isAuthorise('mailtemplate.edit');
		for ($i = 0; $i < count($data); $i++)
		{
			$data[$i]->AllowEdit = $allowEdit;
		}

		return $data;
	}
	
	function ajaxDelete()
	{
		if (!AriQuizHelper::isAuthorise('mailtemplate.delete'))
		{
			return false;
		}
		
		$model =& $this->getModel();
		
		return $model->deleteTemplate(JRequest::getVar('MailTemplateId'));
	}
}