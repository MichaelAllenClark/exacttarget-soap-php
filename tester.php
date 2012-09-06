<?php
require('exacttarget_soap_client.php');
require('CreateTriggeredSend.php');

$wsdl = 'https://webservice.exacttarget.com/etframework.wsdl';

try	
{

	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = 'ccc';
	$client->password = 'ccc';

	CreateTriggeredSend($client,'TEXTEXT','ExampleEmail@bh.exacttarget.com', 'First','Last');

} catch (SoapFault $e) {
		var_dump($e);
}
?>