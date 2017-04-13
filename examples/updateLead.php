<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$rdStation = new \RDStation\RDStation('LEAD_EMAIL');
	$rdStation->setApiPrivateToken('RD_PRIVATE_TOKEN');

	$rdStation->setLeadData('nome'		   , 'Fabiano Couto');
	$rdStation->setLeadData('cargo'		   , 'Webdeveloper');
	$rdStation->setLeadData('cidade'	   , 'Rio de Janeiro');
	$rdStation->setLeadData('estado'	   , 'RJ');

	$response = $rdStation->updateLead();

	var_dump($response);

} catch (Exception $e) {

	var_dump($e);
}