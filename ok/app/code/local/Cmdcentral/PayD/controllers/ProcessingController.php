<?php
/* ----- Copyright (c) CMDcentral 2012 ----- */

class Cmdcentral_PayD_ProcessingController extends Mage_Core_Controller_Front_Action {

//  Define Variables
protected $_order = NULL;
protected $_paymentInst = NULL;

//  Action to be performed when the User Places an Order
public function redirectingAction() {
//  Get PayDo Functions, the Current Order and Order Placed Email Status
    $module = Mage::getModel('payd/functions');
    $order = $module->getOrder();
    if ($module->getOrderPlacedEmail()) {$email = true;} else {$email = false;}
//  Set the Order Status and Comment
    $order->addStatusToHistory($module->getOrderStatus(),'The User was Redirected to PayD for Payment',$email);
//  Notify User of Order via Email
    if ($email) {$order->sendNewOrderEmail();}
//  Save the Order
    $order->save();
//  Load Layout and add Processing Block for User Redirection
    $this->loadLayout();
//    $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
    $this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('payd/processing'));
    $this->renderLayout();
}

//  Action to be performed when the Order is Successfully Paid

public function successfulAction() {
// Adding some security
    $post = $this->getRequest()->getParams();

//  Get payd Functions, the Current Order and Order Successful Email Status
    $module = Mage::getModel('payd/functions');
    $order = $module->getOrder();
    if ($module->getOrderSuccessfulEmail()) {$email = true;} else {$email = false;}
    $order->addStatusToHistory($module->getOrderStatus(),$post['MSISDN']." processed payment with CODE: ".$post['AUTH_CODE']. " STATUS: " .$post['MESSAGE']. " for amount: " .$post['AMOUNT'],$email);
//  Create the Invoice and Capture Payment
    $invoice = $order->prepareInvoice();
    $invoice->register()->capture();
    $order->addRelatedObject($invoice);
//  Set the Order Status and Comment
//  Notify User of Invoice via Email
    if ($email) { $invoice->sendEmail(true);}
//  Save the Order
    $order->save();
//  Load Layout and add Successful Block

    $this->_redirect('checkout/onepage/success');
    return $this;

//    $this->loadLayout();
//    $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
//    $this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('payd/successful'));
//    $this->renderLayout();
}

//  Action to be performed when the Order is Cancelled or Fails
public function failedAction() {

//  get post details from MyGate

//  Get payd Functions, the Current Order and Order Failed Email Status
    $module = Mage::getModel('payd/functions');

// commenting starting here

    $order = $module->getOrder();
    if ($module->getOrderFailedEmail()) {$email = true;} else {$email = false;}
//  Set the Order Status and Comment
    $order->addStatusToHistory(Mage_Sales_Model_Order::STATE_CANCELED,'The User Cancelled Payment or Failed to make a Successful Payment with MyGate',$email);
//  Notify User of Order via Email
    if ($email) {$order->sendNewOrderEmail();}
//  Save the Order
    $order->save();
//  Load Layout and add Successful Block
// END HERE CMDcentral

    $this->loadLayout();
    $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
    $this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('payd/failed'));
    $this->renderLayout();
}

}
