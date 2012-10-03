<?php   
class Cmdcentral_Profile_Block_Index extends Mage_Core_Block_Template{   


    public function getCustomer()
    {
        return Mage::getSingleton('customer/session')->getCustomer();
    }


}
