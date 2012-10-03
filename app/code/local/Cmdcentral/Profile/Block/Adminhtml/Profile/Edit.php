<?php
	
class Cmdcentral_Profile_Block_Adminhtml_Profile_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "profile";
				$this->_controller = "adminhtml_profile";
				$this->_updateButton("save", "label", Mage::helper("profile")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("profile")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("profile")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("profile_data") && Mage::registry("profile_data")->getId() ){

				    return Mage::helper("profile")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("profile_data")->getName()));

				} 
				else{

				     return Mage::helper("profile")->__("Add Item");

				}
		}
}