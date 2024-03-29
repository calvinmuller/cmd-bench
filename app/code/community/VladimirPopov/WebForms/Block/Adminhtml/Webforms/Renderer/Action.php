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

class VladimirPopov_WebForms_Block_Adminhtml_Webforms_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$urlModel = Mage::getModel('core/url');
		$href = $urlModel->getUrl('webforms', array('_current'=>false,'id'=>$row->getId()));
		return '<a href="'.$href.'" target="_blank">'.$this->__('Preview').'</a>';
	}
}
  
?>
