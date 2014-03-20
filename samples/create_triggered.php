<?php
// This call will send an email.  It requires that a TriggeredSendDefinition already exist in the account.
// The existing TriggeredSendDefinition is referenced by CustomerKey (referred to as External Key in the interface). 
// A TriggeredSendDefinition will need to be in a running state before it can be used to send emails. 
require('../exacttarget_soap_client.php');
require('../creds.php');

try	{
	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$ts = new ExactTarget_TriggeredSend();
    $tsd = new ExactTarget_TriggeredSendDefinition();
	$tsd->CustomerKey = "TEXTEXT";

	$sub = new ExactTarget_Subscriber();	
	$sub->EmailAddress = "example@bh.exacttarget.com";
	$sub->SubscriberKey = "example@bh.exacttarget.com";
		
	$ExampleAttribute1 = new ExactTarget_Attribute();
	$ExampleAttribute1->Name = "First Name";
	$ExampleAttribute1->Value = "John";
	
	$ExampleAttribute2 = new ExactTarget_Attribute();
	$ExampleAttribute2->Name = "YearOfBirth";
	$ExampleAttribute2->Value = "1989";
	
	$sub->Attributes = array($ExampleAttribute1,$ExampleAttribute2);
	
	$ts->Subscribers = array();
	$ts->Subscribers = $sub;	
    $ts->TriggeredSendDefinition = $tsd;
		
	$object = new SoapVar($ts, SOAP_ENC_OBJECT, 'TriggeredSend', "http://exacttarget.com/wsdl/partnerAPI");

	$request = new ExactTarget_CreateRequest();	
	$opts = new ExactTarget_CreateOptions();
	$request->Objects = array($object);
	$request->Options = $opts;
	$results = $client->Create($request);
	
	print_r($results);

} catch (SoapFault $e) {
	print_r($e);
}
?>