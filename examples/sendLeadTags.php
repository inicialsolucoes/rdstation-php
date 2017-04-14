<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$rdStation = new \RDStation\RDStation('LEAD_EMAIL');
	$rdStation->setApiPrivateToken('RD_PRIVATE_TOKEN');

	$rdStation->setLeadData('tags', 'add, lead, tag');

	$response = $rdStation->sendLeadTags();

	var_dump($response);

} catch (Exception $e) {

	var_dump($e);
}
