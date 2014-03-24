<?php
// This call will create a Subscriber record if one does not exist.
// If a record already exists with that key value (Email Address by default or Subscriber Key if enabled) then it will update. 
require('../exacttarget_soap_client.php');
require('../creds.php');

try	{

	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$subscriber = new ExactTarget_Subscriber();
	$subscriber->EmailAddress = "example@bh.exacttarget.com";
	$subscriber->SubscriberKey = "example@bh.exacttarget.com";

	$FirstNameAttribute = new ExactTarget_Attribute();
	$FirstNameAttribute->Name = "First Name";
	$FirstNameAttribute->Value = "John";

	$LastNameAttribute = new ExactTarget_Attribute();
	$LastNameAttribute->Name = "Last Name";
	$LastNameAttribute->Value = "Smith";

	$subscriber->Attributes=array($FirstNameAttribute,$LastNameAttribute);

	$subscriber->Lists = array();
	$list = new ExactTarget_SubscriberList();
	$list->ID = "1938565";
	$subscriber->Lists[] = $list;

	$so = new ExactTarget_SaveOption();
	$so->PropertyName = "*";
	$so->SaveAction = ExactTarget_SaveAction::UpdateAdd;
	$soe = new SoapVar($so, SOAP_ENC_OBJECT, 'SaveOption', "http://exacttarget.com/wsdl/partnerAPI");
	$opts = new ExactTarget_UpdateOptions();
	$opts->SaveOptions = array($soe);

	$object = new SoapVar($subscriber, SOAP_ENC_OBJECT, 'Subscriber', "http://exacttarget.com/wsdl/partnerAPI");

	$request = new ExactTarget_CreateRequest();
	$request->Options = $opts;
	$request->Objects = array($object);
	$results = $client->Create($request);

	print_r($results);

} catch (SoapFault $e) {
	var_dump($e);
}
?>