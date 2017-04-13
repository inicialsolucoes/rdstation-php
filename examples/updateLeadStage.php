<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$rdStation = new \RDStation\RDStation('LEAD_EMAIL');
	$rdStation->setApiPrivateToken('RD_PRIVATE_TOKEN');

	$rdStation->setLeadData('lifecycle_stage', 1);
	$rdStation->setLeadData('opportunity'	 , true);

	$response = $rdStation->updateLeadStage();

	var_dump($response);

} catch (Exception $e) {

	var_dump($e);
}