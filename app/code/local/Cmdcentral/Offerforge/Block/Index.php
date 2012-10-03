<?php   
class Cmdcentral_Offerforge_Block_Index extends Mage_Core_Block_Template{   

 var $_order;
 var $_total;
 var $_campaign;
 var $_status;

 function __construct() {
        $id = Mage::getSingleton('checkout/session')->getLastOrderId();
        $this->_order = Mage::getModel("sales/order")->load($id);
	$this->_total = number_format($this->_order->getGrandTotal(), 2, ".", "");
	$this->_campaign = Mage::getStoreConfig('settings_offerforge/general/campaign');
	switch ($this->_order->getStatus()) {
		case "pending":
		case "canceled":
			$status = 1;
		break;
		case "complete":
		case "processing":
			$status = 3;
		break;
	}
	$this->_status = $status;
        return $this->_order;
 }

 function generateString() {
	$content = "";
	if ($this->orderHasSubscriptionOnly()) {
                $content = $this->getSubscriptionPixel();
	} elseif ($this->orderHasSubscriptionandProducts()) {
		$content = $this->getSalePixel();
		$content.= $this->getSubscriptionPixel();
	} else
		$content = $this->getSalePixel();
	return $content;
 }

 function getSalePixel() {
	return '
		<script src="https://za.offerforge.com/i_sale_third/'.$this->_campaign.'/'.$this->_total.'/'.$this->_campaign.'_'.$this->_order->getIncrementId().'/'.$this->getProductString().'&sale_status='.$this->_status.'"></script>
		<noscript><IMG SRC="https://za.offerforge.com/i_track_sale/'.$this->_campaign.'/'.$this->_total.'/'.$this->_campaign.'_'.$this->_order->getIncrementId().'/'.$this->getProductString().'&sale_status='.$this->_status.'"></noscript>
	';
 }

 function getSubscriptionPixel() {
	return '
		<img src="http://za.offerforge.com/track_lead/'.$this->_campaign.'/'.$this->_order->getIncrementId().'&'.$this->getProductString().'">
	';
 }

 protected function orderHasSubscriptionOnly() {
        $sub = 0;
        $item_count = 0;
        $order = $this->_order;                        
        $items = $order->getItemsCollection();
        foreach ($items as $item) {
  	        $_p = $item->getProductId();
                $product = Mage::getModel("catalog/product")->load($_p);
                if ($product->getResource()->getAttribute('subscription_product')) {
                 if ($product->getAttributeText('subscription_product') == 'Yes') {
                        $sub++;
                 }                                                                              
                 else
                        $item_count++;
                }
                else
                        $item_count++;
        }
        if ($sub > 0 && $item_count == 0)
                return true;
        return false;
 }

 protected function orderHasSubscriptionandProducts() {
  
        $sub = 0;
        $item_count = 0;
   
	$order = $this->_order;
        
        $items = $order->getItemsCollection();
        foreach ($items as $item) {
                $_p = $item->getProductId();
                $product = Mage::getModel("catalog/product")->load($_p);
		if ($product->getResource()->getAttribute('subscription_product')) {
		 if ($product->getAttributeText('subscription_product') == 'Yes') {
                        $sub++;
		 }
		 else
			$item_count++;
                }
         	else
                    	$item_count++;
        }
        if ($sub > 0 && $item_count > 0)
                return true;
        return false;
 }

 protected function getProductString() {
        $order = $this->_order;
	$products = "";
        $items = $order->getItemsCollection();
        foreach ($items as $item) {
	 $products.= $this->slugify($item->getName())."&";
	}
	return urlencode(rtrim($products, "&"));
 }

 static public function slugify($text)
 { 
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
  // trim
  $text = trim($text, '-');
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // lowercase
  $text = strtolower($text);
   // remove unwanted characters
   $text = preg_replace('~[^-\w]+~', '', $text);
  if (empty($text))
  {
    return 'n-a';
  }
  return $text;
 }
}
