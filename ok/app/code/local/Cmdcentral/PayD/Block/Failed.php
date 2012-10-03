<?php
/* ----- Copyright (c) Cmdcentral 2010 ----- */

class Cmdcentral_PayD_Block_Failed extends Mage_Core_Block_Template {

//  Create PayD Post Form HTML
protected function _toHtml() {
//  Display Redirecting Message
    $post = $this->getRequest()->getParams();

    $html = '<div class="grid"><div class="grid_12">';
    $html .= '<h1>Oh dear, something went wrong</h1>';
    $html .= $this->__('There was an error processing your request, we received the following response.');
    $html .= "<br/><br/>";
    $html .= $this->__('<b>Error Code: </b>'.$post['AUTH_CODE']);
    $html .= "<br/><br/>";
    $html .= $this->__('<b>Error: </b>'.$post['MESSAGE']);
    $html .= "<br/><br/>";
    $html .= $this->__('<b>Time: </b>'.$post['TIME']);
    $html .= "<br/><br/>";
    $html .= $this->__('If the problem persists please contact your bank.');
    $html .= "<br/><br/>";
    $html .= $this->__('<center><a class="button" href="/">Continue Shopping</a></center>');
    $html .= "</div></div>";

    return $html;
}

}
