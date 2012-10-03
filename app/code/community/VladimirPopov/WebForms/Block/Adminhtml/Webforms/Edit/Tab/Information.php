<?php
/**
 * Feel free to contact me via Facebook
 * http://www.facebook.com/rebimol
 *
 *
 * @author 		Vladimir Popov
 * @copyright  	Copyright (c) 2011 Vladimir Popov
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class VladimirPopov_WebForms_Block_Adminhtml_Webforms_Edit_Tab_Information
	extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareLayout(){
		
		parent::_prepareLayout();
	}	
	
	protected function _prepareForm()
	{
		$model = Mage::getModel('webforms/webforms');
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('webforms_form',array(
			'legend' => Mage::helper('webforms')->__('Form Information')
		));
		
		$fieldset->addField('name','text',array(
			'label' => Mage::helper('webforms')->__('Name'),
			'class' => 'required-entry',
			'required' => true,
			'name' => 'name'
		));
		
		$fieldset->addField('code','text',array(
			'label' => Mage::helper('webforms')->__('Code'),
			'name' => 'code',
			'note' => Mage::helper('webforms')->__('Code is used to help identify this web-form in scripts'),
		));
		
		$editor_type = 'textarea';
		$style= '';
		$config = '';
		if((float)substr(Mage::getVersion(),0,3) > 1.3 && substr(Mage::getVersion(),0,5)!= '1.4.0'){
			
			$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
				array('tab_id' => $this->getTabId())
			);

			$wysiwygConfig["files_browser_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index');
			$wysiwygConfig["directives_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
			$wysiwygConfig["directives_url_quoted"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');

			$wysiwygConfig["add_widgets"] = false;
			$wysiwygConfig["add_variables"] = false;
			$wysiwygConfig["widget_plugin_src"] = false;
			$plugins = $wysiwygConfig->setData("plugins",array());
			
			$editor_type='editor';
			$style = 'height:20em; width:50em;';
			$config = $wysiwygConfig;
			$renderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element');
		}
		
		$descField = $fieldset->addField('description',$editor_type,array(
			'label' => Mage::helper('webforms')->__('Description'),
			'required' => false,
			'name' => 'description',
			'style' => $style,
			'note' => Mage::helper('webforms')->__('This text will appear under the form name'),
			'wysiwyg' => true,
			'config' => $config,
		));
		
		$succField = $fieldset->addField('success_text',$editor_type,array(
			'label' => Mage::helper('webforms')->__('Success text'),
			'required' => false,
			'name' => 'success_text',
			'style' => $style,
			'note' => Mage::helper('webforms')->__('This text will be displayed after the form completion'),
			'wysiwyg' => true,
			'config' => $config,
		));
		if(isset($renderer)){
			$descField->setRenderer($renderer);
			$succField->setRenderer($renderer);
		}
		
		$fieldset->addField('is_active', 'select', array(
			'label'     => Mage::helper('webforms')->__('Status'),
			'title'     => Mage::helper('webforms')->__('Status'),
			'name'      => 'is_active',
			'required'  => true,
			'options'   => $model->getAvailableStatuses(),
		));
		
		Mage::dispatchEvent('webforms_adminhtml_webforms_edit_tab_information_prepare_form', array('form' => $form, 'fieldset' => $fieldset));

		if (!$model->getId()) {
			$model->setData('is_active', '0');
		}
		
		if(Mage::getSingleton('adminhtml/session')->getWebFormsData())
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getWebFormsData());
			Mage::getSingleton('adminhtml/session')->setWebFormsData(null);
		} elseif(Mage::registry('webforms_data')){
			$form->setValues(Mage::registry('webforms_data')->getData());
		}
		return parent::_prepareForm();
	}
}  
?>
