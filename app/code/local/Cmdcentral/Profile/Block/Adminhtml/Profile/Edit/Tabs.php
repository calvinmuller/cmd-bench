<?php
class Cmdcentral_Profile_Block_Adminhtml_Profile_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("profile_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("profile")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("profile")->__("Item Information"),
				"title" => Mage::helper("profile")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("profile/adminhtml_profile_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
