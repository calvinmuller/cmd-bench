<?php


class Cmdcentral_Profile_Block_Adminhtml_Profile extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_profile";
	$this->_blockGroup = "profile";
	$this->_headerText = Mage::helper("profile")->__("Profile Manager");
	$this->_addButtonLabel = Mage::helper("profile")->__("Add New Item");
	parent::__construct();

	}

}