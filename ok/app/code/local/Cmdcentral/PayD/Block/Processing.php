<?php
/* ----- Copyright (c) Cmdcentral 2012 ----- */

class Cmdcentral_PayD_Block_Processing extends Mage_Core_Block_Abstract {

//  Create PayD Post Form HTML
 protected function _toHtml() {
    $session = Mage::getSingleton('core/session');
 //  Get PayD Functions
    $module = Mage::getModel('payd/functions');
 //  Set the Current Order and Billing Address
    $order = $module->getOrder();
    $customer = $module->getCustomer();
    $description = "Purchase from ".Mage::app()->getStore()->getFrontendName();
    $billingaddress = $order->getBillingAddress();
    $hashText = "cardPayment".$module->getMerchantID().$module->getKey().$order->getRealOrderId().number_format($order->getGrandTotal()*1, 2, ".","").$description.$module->getSuccessfulUrl().$module->getFailedUrl().$module->getApplicationID();
 //  Display Redirecting Message
    $html = '<div class="grid"><div class="grid_12"><h2>Please Wait ...</h2><p>Please wait while you are directed to PaymentGate.</p></div></div>';
    $html.= '<form id="Checkout" method="post" action="'.$module->getPostUrl().'">';
    $html.= '<input type="hidden" name="method" value="cardPayment">';
    $html.= '<input type="hidden" name="merchant_id" value="'.$module->getMerchantID().'">';
    $html.= '<input type="hidden" name="ref" value="'.$order->getRealOrderId().'">';
    $html.= '<input type="hidden" name="amount" value="'.number_format($order->getGrandTotal()*1, 2, ".","").'">';
    $html.= '<input type="hidden" name="return_url" value="'.$module->getSuccessfulUrl().'">';
    $html.= '<input type="hidden" name="cancel_url" value="'.$module->getFailedUrl().'">';
    $html.= '<input type="hidden" name="key" value="'.$module->getKey().'">';
    $html.= '<input type="hidden" name="hash" value="'.hash('md5', $hashText).'">';
    $html.= '<input type="hidden" name="description" value="'.$description.'">';
    $html.= '</form>';
 //  Redirect the User to PayD
    $html.= '<script type="text/javascript">setTimeout("document.getElementById(\"Checkout\").submit();",1000);</script>';
 //  Return the Post Form HTML
    return $html;
 }

}
