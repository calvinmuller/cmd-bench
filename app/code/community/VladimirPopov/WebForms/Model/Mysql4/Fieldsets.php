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

class VladimirPopov_WebForms_Model_Mysql4_Fieldsets
	extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct(){
		$this->_init('webforms/fieldsets','id');
	}
	
	protected function _afterSave(Mage_Core_Model_Abstract $object){
		
		Mage::dispatchEvent('webforms_fieldset_save',array('fieldset'=>$object));

		return parent::_afterSave($object);
	}

	protected function _afterDelete(Mage_Core_Model_Abstract $object){
		//set fields fieldset_id to null
		$fields = Mage::getModel('webforms/fields')->getCollection()->addFilter('fieldset_id',$object->getId());
		foreach($fields as $field){
			$field->setFieldsetId(0)->save();
		}

		Mage::dispatchEvent('webforms_fieldset_delete',array('fieldset'=>$object));

		return parent::_afterDelete($object);
	}	
}  
?>
