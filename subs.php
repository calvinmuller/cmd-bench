<?php

require 'app/Mage.php';

Mage::app('admin')->setUseSessionInUrl(false);

mysql_connect("sql9.cpt1.host-h.net", "rubybssuxw_1", "XZ44efK84gkl") or die(mysql_error());
mysql_select_db("rubybssuxw_db1") or die(mysql_error());

$result = mysql_query("SELECT * FROM wp_users u") or die(mysql_error());

while ($row = mysql_fetch_array($result)) {


	$query = "SELECT d.field_number, d.value FROM  wp_rg_lead_detail d, wp_rg_lead l WHERE l.id = d.lead_id AND d.form_id = 3 AND  l.created_by = ".$row['ID']. " ORDER BY d.field_number ASC LIMIT 10";
	$result2 = mysql_query($query) or die(mysql_error());

	$row2['data'] = array();
	while ($row2 = mysql_fetch_array($result2))
		$row['data'][$row2['field_number']] = $row2;

	$address = mysql_query("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'mgm_member_options' AND user_id = ".$row['ID']);
	$addrow = mysql_fetch_row($address);
	$addy = unserialize($addrow[0]);
	$row['sub'] = $addy;
	$row['address'] = $addy['custom_fields'];

	$customer = Mage::getModel("customer/customer")->setWebsiteId(1);
	$customer->loadByEmail($row['user_email']);
	if ($customer->getId()) {

	 if ($row['sub']['status'] == "Inactive" || $row['sub']['status'] == "Expired" || $row['sub']['status'] == "Cancelled")
		$status = 2;
	 elseif ($row['sub']['status'] == "Active")
		$status = 1;
	 else
		$status = 3;
	

 	 $sub = Mage::getModel("subscription/subscriptions");
	 $sub->setOrderid($row['sub']['payment_info']['subscr_id']);
	 $sub->setCustomer($customer->getId());
	 $sub->setFrequency($row['sub']['duration']);
	if ($row['sub']['custom_options']['email_of_gifted_person_if_applicable'] != "") {
	 $recip = Mage::getModel("customer/customer")->loadByEmail($row['sub']['custom_options']['email_of_gifted_person_if_applicable']);
	 $sub->setGifted($recip->getId());
	} else {
         $sub->setGifted($customer->getId());
	}
	 $sub->setTotal($row['sub']['amount']);
	 $sub->setAdded(date("Y-m-d H:i:s", $row['sub']['join_date']));
	 $sub->setStatus($status);
	 $sub->setTransactionReason($row['sub']['status_str']);
	 $sub->setPayment($row['sub']['payment_info']['module']);
	 $sub->setExpires($row['sub']['expire_date']);
	 $sub->setLastPayDate($row['sub']['last_pay_date']);
	try {
	 $sub->save();
	}
	catch (Exception $e) {
	 Mage::log($e->getMessage());
	}
	}

}


?>
