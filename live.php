<?php

require 'app/Mage.php';

Mage::app('admin')->setUseSessionInUrl(false);

mysql_connect("sql9.cpt1.host-h.net", "rubybssuxw_1", "XZ44efK84gkl") or die(mysql_error());
mysql_select_db("rubybssuxw_db1") or die(mysql_error());

$result = mysql_query("SELECT * FROM wp_users u") or die(mysql_error());

while ($row = mysql_fetch_array($result)) {


	$query = "SELECT d.field_number, d.value FROM  wp_rg_lead_detail d, wp_rg_lead l WHERE l.id = d.lead_id AND d.form_id = 3 AND  l.created_by = ".$row['ID']. " ORDER BY d.field_number ASC";
	$result2 = mysql_query($query) or die(mysql_error());

	$row2['data'] = array();
	while ($row2 = mysql_fetch_array($result2))
		$row['data'][$row2['field_number']] = $row2;

	$address = mysql_query("SELECT meta_value FROM wp_usermeta WHERE meta_key = 'mgm_member_options' AND user_id = ".$row['ID']);
	$addrow = mysql_fetch_row($address);
	$addy = unserialize($addrow[0]);
	$row['address'] = $addy['custom_fields'];

try {
	$customerData = array('email' => $row['user_email'], 'firstname' => $row['address']['first_name'], 'lastname' => $row['address']['last_name'], 'dob' => $row['data'][4]['value'],
				'created_at' => $row['user_registered'],
				'gender' => "Female", 
				'website_id' => 1,
				'group_id' => 1
				);

	if ($row['address']['password'] != "")
		$customerData['password_hash'] = md5($row['address']['password']);
	else
		$customerData['password_hash'] = $row['user_pass'];

        $customer = Mage::getModel('customer/customer');
        $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
        $customer->loadByEmail($row['user_email']);
	$customer->setData($customerData);
	try { 
	$customer->save();
	} catch (Exception $e) {
		Mage::log("ERROR: ".$e->getMessage() . " ".$customer->getEmail(). "\n");
	}

	if ($row['address']) {
		$_custom_address = array (
		    'firstname' => $row['address']['first_name'],
		    'lastname' => $row['address']['last_name'],
		    'street' => array (
		        '0' => $row['address']['building_company']." ".$row['address']['address'],
		        '1' => $row['address']['parcel_area'],
		    ),
 
		    'city' => $row['address']['city'],
		    'company' => $row['address']['company_business'],
		    'region_id' => '',
		    'region' => '',
		    'postcode' => $row['address']['postal_code'],
		    'country_id' => $row['address']['country'],
		    'telephone' => $row['address']['phone'],
		    'fax'	=> $row['address']['landline']
		);
         
		$customAddress = Mage::getModel('customer/address');
		$customAddress->setData($_custom_address)
		            ->setCustomerId($customer->getId())
		            ->setIsDefaultBilling('1')
		            ->setIsDefaultShipping('1')
		            ->setSaveInAddressBook('1');
		try {
		    $customAddress->save();
		    echo $customer->getEmail() . " has an address added\n";
		}
		catch (Exception $ex) {
			Mage::log("ERROR: ".$ex->getMessage(). " " . $customer->getEmail(). "\n");
		}
	}


	echo "Successfully added ".$row['user_email']. "\n";
} catch (Exception $e) {
	Mage::log("ERROR: " . $e->getMessage()." " . $customer->getEmail(). "\n");
}
}


?>
