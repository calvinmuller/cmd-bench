<?php
    class Cmdcentral_Profile_Model_Mysql4_Profile_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
    {

		public function _construct(){
			$this->_init("profile/profile");
		}
    }
	 