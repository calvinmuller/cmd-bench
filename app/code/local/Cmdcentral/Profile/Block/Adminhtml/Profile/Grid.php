<?php

class Cmdcentral_Profile_Block_Adminhtml_Profile_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("profileGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("profile/profile")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("profile")->__("ID"),
				"align" =>"right",
				"width" => "50px",
				"index" => "id",
				));
				$this->addColumn("name", array(
				"header" => Mage::helper("profile")->__("Profile Name"),
				"align" =>"left",
				"index" => "name",
				));


				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}

}