<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$rdStation = new \RDStation\RDStation('LEAD_EMAIL');
	$rdStation->setApiPrivateToken('RD_PRIVATE_TOKEN');

	$rdStation->setLeadData('status', 'won');
	$rdStation->setLeadData('value' , 100.00);

	//$rdStation->setLeadData('status'	   , 'lost');
	//$rdStation->setLeadData('lost_reason', 'Reason of the lost');

	$response = $rdStation->updateLeadStatus();

	var_dump($response);

} catch (Exception $e) {

	var_dump($e);
}