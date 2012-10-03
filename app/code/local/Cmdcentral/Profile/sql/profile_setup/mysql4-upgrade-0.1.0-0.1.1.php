<?php
$installer = $this;
$installer->startSetup();
$installer->run("create table profiles(id int not null auto_increment, question varchar(255), options longtext, primary key(id));");
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 