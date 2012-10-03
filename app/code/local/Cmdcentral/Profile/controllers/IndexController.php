<?php
class Cmdcentral_Profile_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Profile"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("profile", array(
                "label" => $this->__("Profile"),
                "title" => $this->__("Profile")
		   ));

      $this->renderLayout(); 
	  
    }

    public function editAction() {

          $this->loadLayout();
          $this->getLayout()->getBlock("head")->setTitle($this->__("Profile"));
                $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
                   ));

      $breadcrumbs->addCrumb("profile", array(
                "label" => $this->__("Profile"),
                "title" => $this->__("Profile")
                   ));

      $this->renderLayout();

    }
}
