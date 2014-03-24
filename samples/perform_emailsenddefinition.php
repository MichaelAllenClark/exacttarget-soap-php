<?php
// This call will use the Perform method in order to start an EmailSendDefinition (aka User-Initiated Send). 
// An EmailSendDefinition will need to be created in the account prior to making this request. 
require('../exacttarget_soap_client.php');
require('../creds.php');

try	{

	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;
		
	$pr = new ExactTarget_PerformRequestMsg();
	$pr->Options = NULL;
	$pr->Action = "start";   
	$pr->Definitions =  array();

	$def = new ExactTarget_EmailSendDefinition();
	$def->CustomerKey = "ExampleExternalKey";

	$pr->Definitions[] = new SoapVar($def, SOAP_ENC_OBJECT, 'EmailSendDefinition', "http://exacttarget.com/wsdl/partnerAPI");

	$results = $client->Perform($pr);  
	
	print_r($results);

} catch (SoapFault $e) {
	var_dump($e);
}
?>