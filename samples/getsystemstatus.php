<?php
// This is a simple call that can be used for testing network connectivity and user permissions 
require('../exacttarget_soap_client.php');
require('../creds.php');

try	{
	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$results = $client->GetSystemStatus(null);

	var_dump($results);

} catch (SoapFault $e) {
	var_dump($e);
}
?>