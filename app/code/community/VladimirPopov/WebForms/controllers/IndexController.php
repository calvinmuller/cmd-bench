<?php
/**
 * Feel free to contact me via Facebook
 * http://www.facebook.com/rebimol
 *
 *
 * @author 		Vladimir Popov
 * @copyright  	Copyright (c) 2011 Vladimir Popov
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class VladimirPopov_WebForms_IndexController extends Mage_Core_Controller_Front_Action{
	
	public function indexAction()
	{
		Mage::register('show_form_name',true);
		$this->loadLayout();
		if(Mage::getStoreConfig('webforms/contacts/enable') && $this->getFullActionName() == 'contacts_index_index'){
			$this->getLayout()->getBlock('contactForm')->setTemplate(false);
			$block = $this->getLayout()->createBlock('webforms/webforms','webforms',array(
				'template' => 'webforms/default.phtml',
				'webform_id' => Mage::getStoreConfig('webforms/contacts/webform')
			));
			$this->getLayout()->getBlock('content')->append($block);
		}
		$this->_initLayoutMessages('customer/session');
		$this->_initLayoutMessages('catalog/session');
		$this->renderLayout();
	}	
}  
?>