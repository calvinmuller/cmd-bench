<?php

class Cmdcentral_PayD_Model_Functions extends Mage_Payment_Model_Method_Abstract {

//  Define Code Variable
protected $_code = 'payd_functions';
protected $_canCapture = true;

//  Get MyGatePM Post Url
public function getPostUrl() {
    return $this->getConfigData('post_url');
}

//  Get MyGatePM Mode
public function getMode() {
    return $this->getConfigData('mode');
}

public function getKey() {
    return $this->getConfigData('key');
}

//  Get MyGatePM Merchant ID
public function getMerchantID() {
    return $this->getConfigData('merchant_id');
}

//  Get MyGatePM Application ID
public function getApplicationID() {
    return $this->getConfigData('application_id');
}

//  Get MyGatePM Order Status
public function getOrderStatus() {
    return $this->getConfigData('order_status');
}

//  Get MyGatePM Order Placed Email Status
public function getOrderPlacedEmail() {
    return $this->getConfigData('order_placed_email');
}

//  Get MyGatePM Order Successful Email Status
public function getOrderSuccessfulEmail() {
    return $this->getConfigData('order_successful_email');
}

//  Get MyGatePM Order Failed Email Status
public function getOrderFailedEmail() {
    return $this->getConfigData('order_failed_email');
}

//  Get MyGatePM Currency Code
public function getCurrencyCode() {
    return $this->getConfigData('currency_code');
}

//  Get MyGatePM Shipping Code
public function getShippingCode() {
    return $this->getConfigData('shipping_code');
}

//  Get the Current Order
public function getOrder() {
    $order = Mage::getModel('sales/order');
    $session = Mage::getSingleton('checkout/session');
    $order->loadByIncrementId($session->getLastRealOrderId());
    return $order;
}

public function getCustomer() {
	$customer = Mage::getSingleton('customer/session')->getCustomer();
	return $customer;
}

//  Set Redirecting Url
public function getOrderPlaceRedirectUrl() {
    return Mage::getUrl('payd/processing/redirecting');
}

//  Set Successful Url
public function getSuccessfulUrl() {
    return Mage::getUrl('payd/processing/successful');
}

//  Set Failed Url
public function getFailedUrl() {
    return Mage::getUrl('payd/processing/failed');
}

}
