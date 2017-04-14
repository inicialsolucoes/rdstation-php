<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$rdStation = new \RDStation\RDStation('LEAD_EMAIL');
	$rdStation->setApiToken('RD_TOKEN');

	$rdStation->setLeadData('identificador', 'event-identifier');
	$rdStation->setLeadData('nome'		   , 'Fabiano Couto');
	$rdStation->setLeadData('cargo'		   , 'Webdeveloper');
	$rdStation->setLeadData('cidade'	   , 'Rio de Janeiro');
	$rdStation->setLeadData('estado'	   , 'RJ');

	$response = $rdStation->sendLead();

	var_dump($response);

} catch (Exception $e) {

	var_dump($e);
}
