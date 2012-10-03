<?php
class Mage_Customer_Model_Api extends Mage_Api_Model_Resource_Abstract
{
   
    public function create($customerData)
    {
	Mage::log($customerData);
    }
 
    public function info($customerId)
    {
    }
 
    public function items($filters)
    {
    }
 
    public function update($customerId, $customerData)
    {
    }
 
    public function delete($customerId)
    {
    }
}
