<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$rdStation = new \RDStation\RDStation('LEAD_EMAIL');
	$rdStation->setApiPrivateToken('RD_PRIVATE_TOKEN');

	$rdStation->setLeadData('name' , 'Fabiano Couto');
	$rdStation->setLeadData('title', 'Webdeveloper');
	$rdStation->setLeadData('city' , 'Rio de Janeiro');
	$rdStation->setLeadData('state', 'RJ');

	$response = $rdStation->updateLead();

	var_dump($response);

} catch (Exception $e) {

	var_dump($e);
}
