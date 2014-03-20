<?php
// This call will retrieve a single Subscriber record or multiple depending on the filter
// Filter in the example will return all Held or Unsubscribed Subscribers 
require('../exacttarget_soap_client.php');
require('../creds.php');

try	{
	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$sfp1 = new ExactTarget_SimpleFilterPart();
	$sfp1->Property = "Status";
	$sfp1->SimpleOperator = ExactTarget_SimpleOperators::equals;
	$sfp1->Value = "Unsubscribed"; 

	$sfp2 = new ExactTarget_SimpleFilterPart();
	$sfp2->Property = "Status";
	$sfp2->SimpleOperator = ExactTarget_SimpleOperators::equals;
	$sfp2->Value = "Held";

	$cfp1 = new ExactTarget_ComplexFilterPart();
	$cfp1->LeftOperand = new SoapVar($sfp1, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
	$cfp1->LogicalOperator = ExactTarget_LogicalOperators::_OR;
	$cfp1->RightOperand = new SoapVar($sfp2, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");

	$rr = new ExactTarget_RetrieveRequest();
	$rr->ObjectType = "Subscriber";
	$rr->Properties = array("ID","CreatedDate","Client.ID","EmailAddress","SubscriberKey","UnsubscribedDate","Status","EmailTypePreference");
	$rr->Filter = new SoapVar($cfp1, SOAP_ENC_OBJECT, 'ComplexFilterPart', "http://exacttarget.com/wsdl/partnerAPI");

	$request = new ExactTarget_RetrieveRequestMsg();
	$request->RetrieveRequest = $rr;
	$results = $client->Retrieve($request);

	print_r($results);

} catch (Exception  $e) {
	var_dump($e);
}
?>
?>