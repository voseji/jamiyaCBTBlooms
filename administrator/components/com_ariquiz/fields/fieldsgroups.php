<?php
/*
 *
 * @package		ARI Framework
 * @author		ARI Soft
 * @copyright	Copyright (c) 2011 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('_JEXEC') or die ('Restricted access');

require_once dirname(__FILE__) . '/../kernel/class.AriKernel.php';

AriKernel::import('Web.JSON.JSONHelper');

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.form');

class JFormFieldFieldsgroups extends JFormField
{
	protected $type = 'Fieldsgroups';
	
	public function getInput()
	{
		return $this->fetchElement($this->element['name'], $this->value, $this->element, $this->name);
	}
	
	public function getLabel()
	{
		return '';
	}

	protected function fetchElement($name, $value, $node, $control_name)
	{
		$selectId = str_replace(array('[', ']'), array('_', ''), $control_name);
		$this->includeAssets();

		$containerId = uniqid('groups', false);
		$document =& JFactory::getDocument();
		$document->addScriptDeclaration(
			sprintf('window.addEvent("domready", function(){ new ARIElementGroups("%s", %s); });',
				$containerId,
				AriJSONHelper::encode(array('selectId' => $selectId))));

		return sprintf('<div id="%1$s" style="float: left; width: 100%%;" class="ari-fieldsgroup"><fieldset><legend><label for="%2$s" class="ari-fieldsgroup-lbl">%3$s</label>&nbsp;&nbsp;%4$s</legend><div>%5$s</div></fieldset></div>',
			$containerId,
			$selectId,
			JText::_((string)$node['label']),
			JHTML::_(
				'select.genericlist', 
				$this->getOptionsGroup($node), 
				$control_name, 
				'class="ari-fieldsgroup-sel"', 
				'value', 
				'text', 
				$value, 
				$selectId), 
			$this->getChildsInput($node, $value, $selectId, $control_name));
	}

	protected function includeAssets()
	{
		static $loaded;
		
		if ($loaded)
			return ;

		$filePath = str_replace(DS == '\\' ? '/' : '\\', DS, realpath(dirname(__FILE__)));
		if (strlen(JPATH_ROOT) > 1)
			$filePath = str_replace(realpath(JPATH_ROOT), '', $filePath);
			
		$uri = JURI::root(true) . str_replace(DS, '/', $filePath) . '/';
			
		$document =& JFactory::getDocument();
		if (J3_0)            
    {
      JHtml::_('behavior.framework', true);
			$document->addScript($uri . 'groups_3.js');
    }
		else
			$document->addScript($uri . 'groups.js');
		$document->addStyleSheet($uri . 'groups.css', 'text/css', null, array());
			
		$loaded = true;
	}

	private function getOptionsGroup($node)
	{
		$options = array();
		foreach ($node->children() as $child) 
		{
			$tagName = $child->getName();
			if ($tagName != 'fieldsgroup' && $tagName != 'fieldset')
				continue;

			$id = (string)$child['id'];
			$label = JText::_((string)$child['label']);

			$options[] = JHTML::_(
				'select.option', 
				$id,
				$label);
		}

		return $options;
	}
	
	private function getChildsInput($node, $selectedGroup, $prefix, $name = 'params', $group = 'params')
	{
		$html = '';
		$formControl = $this->form->getFormControl();
		foreach ($node->children() as $child) 
		{
			$tagName = $child->getName();
			if ($tagName != 'fieldsgroup' && $tagName != 'fieldset')
				continue;

			$fieldsetName = $id = (string)$child['id'];
			$label = JText::_((string)$child['label']);
			$groupElId = 'group_' . $prefix . '_' . $id;
			
			$visible = ($id == $selectedGroup);
			
			
			if ($tagName == 'fieldset')
				$fieldsetName = (string)$child['name'];
			else if (isset($child['fieldset']))
				$fieldsetName = (string)$child['fieldset'];				

			$html .= sprintf('<div id="%s" class="el-group" style="display: %s;"><div class="el-group-header"><h4>%s</h4></div><div>%s</div></div>',
				$groupElId,
				$visible ? 'block' : 'none',
				$label,
				$this->getFormInput($fieldsetName));
		}

		return $html;		
	}

	private function getFormInput($fieldsetName)
	{
		$html = '';
		$hiddenFields = '';

		$fields = isset($this->form->extraParamsForm)
			? $this->form->extraParamsForm->getFieldset($fieldsetName)
			: $this->form->getFieldset($fieldsetName);

    foreach ($fields as $field)
		{
			if (!$field->hidden)
			{
				$html .= '<li>' . $field->getLabel() . ' ' . $field->getInput() . '</li>'; 
			}
			else
			{
				$hiddenFields .= $field->getInput(); 
			}
		}
		
		if ($html || $hiddenFields)
		{
			$html = '<ul>' . $html;
			if ($hiddenFields)
				$html .= '<li>' . $hiddenFields . '</li>';
				
			$html .= '</ul>';
		}

		return $html;
	}
}
?>