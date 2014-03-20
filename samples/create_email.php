<?php
// This call will create an Email object which stores the content for use when sending an email
require('../exacttarget_soap_client.php');
require('../creds.php');

try	{

	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$email = new ExactTarget_Email();
	$email->Name = 'Example API Email';
	$email->Description = 'Test Email';
	$email->HTMLBody = 'Example HTML Body';
	$email->Subject = 'Example API Email';
	$email->EmailType = 'HTML';
	$email->IsPasteHTML = 'true';
	$object = new SoapVar($email, SOAP_ENC_OBJECT, 'Email', "http://exacttarget.com/wsdl/partnerAPI");

	$request = new ExactTarget_CreateRequest();
	$request->Options = NULL;
	$request->Objects = array($object);

	$results = $client->Create($request);
	print_r($results);

} catch (SoapFault $e) {
	print_r($e);
}
?>