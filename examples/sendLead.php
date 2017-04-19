<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$rdStation = new \RDStation\RDStation('LEAD_EMAIL');
	$rdStation->setApiToken('RD_TOKEN');

	$rdStation->setLeadData('identifier', 'event-identifier');
	$rdStation->setLeadData('name'		, 'Fabiano Couto');
	$rdStation->setLeadData('title'	    , 'Systems Analyst');
	$rdStation->setLeadData('city'	    , 'Natal');
	$rdStation->setLeadData('state'	    , 'RN');

	$response = $rdStation->sendLead();

	var_dump($response);

} catch (Exception $e) {

	var_dump($e);
}
