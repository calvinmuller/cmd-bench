<?php
class Cmdcentral_Profile_Block_Adminhtml_Profile_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("profile_form", array("legend"=>Mage::helper("profile")->__("Item information")));

				$fieldset->addField("name", "text", array(
				"label" => Mage::helper("profile")->__("Profile Name"),
				"class" => "required-entry",
				"required" => true,
				"name" => "name",
				));




				if (Mage::getSingleton("adminhtml/session")->getProfileData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getProfileData());
					Mage::getSingleton("adminhtml/session")->setProfileData(null);
				} 
				elseif(Mage::registry("profile_data")) {
				    $form->setValues(Mage::registry("profile_data")->getData());
				}
				return parent::_prepareForm();
		}
}
