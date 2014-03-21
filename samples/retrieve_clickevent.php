<?php
// This call will retrieve a clicks Events which indicate a subscriber clicked a link in an email.
require('../exacttarget_soap_client.php');
require('../creds.php');

try	{
	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$rr = new ExactTarget_RetrieveRequest();
	// Uncomment the line below if using an Enterprise 1.0 or Enterprise 2.0 account and you want to retrieve from all accounts in a single request
	//$rr->QueryAllAccounts = true; 
	$rr->ObjectType = "ClickEvent";
	$rr->Properties = array("ID","ObjectID","PartnerKey","CreatedDate","ModifiedDate","Client.ID","SendID","SubscriberKey","EventDate","EventType","TriggeredSendDefinitionObjectID","BatchID","URLID","URL");
	$request = new ExactTarget_RetrieveRequestMsg();	
	
	// Uncomment the section below in order to specify a filter on date
	
	$sfp = new ExactTarget_SimpleFilterPart();
	$sfp->Property = "CreatedDate";
	$sfp->SimpleOperator = ExactTarget_SimpleOperators::greaterThan;
	$sfp->DateValue = "2012-01-01T01:00:00Z";
	$rr->Filter = new SoapVar($sfp, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
	
	
	$request->RetrieveRequest = $rr;

	$results = $client->Retrieve($request);
	print_r($results);
	
	// A single request will only contain 2500 results, if there are more then the status will indicate MoreDataAvailable
	// A follow-up request it needed in order to retrieve the next batch of objects. 
	while ($results->OverallStatus=="MoreDataAvailable") {
		$rr = new ExactTarget_RetrieveRequest();
		$rr->ContinueRequest = $results->RequestID;
		$request = new ExactTarget_RetrieveRequestMsg();
		$request->RetrieveRequest = $rr;
		$results = $client->Retrieve($request);
		print_r($results);
	}

} catch (SoapFault $e) {
	var_dump($e);
}
?>