<?php
/* ----- Copyright (c) Cmdcentral 2010 ----- */

class Cmdcentral_PayD_Block_Successful extends Mage_Core_Block_Template {

//  Create PayD Post Form HTML
protected function _toHtml() {
//  Display Redirecting Message
    $html = '<h2>Your Order has been Successful</h2><p>You will be redirected shortly ...</p>';
//  Redirect the User to the Store's Web Url
    $html.= '<script type="text/javascript">setTimeout("window.setLocation(\"'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'\");",3000);</script>';
//  Return the Post Form HTML
    return $html;
}

}
