<?php

class Cmdcentral_Profile_Adminhtml_ProfileController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("profile/profile")->_addBreadcrumb(Mage::helper("adminhtml")->__("Profile  Manager"),Mage::helper("adminhtml")->__("Profile Manager"));
				return $this;
		}
		public function indexAction() 
		{
				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{
				$brandsId = $this->getRequest()->getParam("id");
				$brandsModel = Mage::getModel("profile/profile")->load($brandsId);
				if ($brandsModel->getId() || $brandsId == 0) {
					Mage::register("profile_data", $brandsModel);
					$this->loadLayout();
					$this->_setActiveMenu("profile/profile");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Profile Manager"), Mage::helper("adminhtml")->__("Profile Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Profile Description"), Mage::helper("adminhtml")->__("Profile Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("profile/adminhtml_profile_edit"))->_addLeft($this->getLayout()->createBlock("profile/adminhtml_profile_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("profile")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("profile/profile")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("profile_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("profile/profile");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Profile Manager"), Mage::helper("adminhtml")->__("Profile Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Profile Description"), Mage::helper("adminhtml")->__("Profile Description"));


		$this->_addContent($this->getLayout()->createBlock("profile/adminhtml_profile_edit"))->_addLeft($this->getLayout()->createBlock("profile/adminhtml_profile_edit_tabs"));

		$this->renderLayout();

		       // $this->_forward("edit");
		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						$brandsModel = Mage::getModel("profile/profile")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Profile was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setProfileData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $brandsModel->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setProfileData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$brandsModel = Mage::getModel("profile/profile");
						$brandsModel->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}
}
