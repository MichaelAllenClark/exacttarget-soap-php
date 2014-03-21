<?php
// DataExtensionObject represents a single row of data in a data extension.
// For this example, the data extension has a name of Bademails and 2 fields called: Email and Reason.  
require('../exacttarget_soap_client.php');
require('../creds.php');

try {
	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$rr = new ExactTarget_RetrieveRequest();
	$rr->Options = new ExactTarget_RetrieveOptions();
	$rr->Filter = NULL;

	// BADEMAILS referenced below is the Name of the Data Extension
	$rr->ObjectType = "DataExtensionObject[BADEMAILS]";
	// The properties specified below are the fields from the Data Extension
	$rr->Properties = array("EMAIL", "Reason");
	
	$sfp = new ExactTarget_SimpleFilterPart();
	$sfp->Property = "EMAIL";
	$sfp->SimpleOperator = ExactTarget_SimpleOperators::equals;
	$sfp->Value = "MyBadEmail1000@bh.exacttarget.com";
	$rr->Filter = new SoapVar($sfp, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
	
	$rrm = new ExactTarget_RetrieveRequestMsg();
	$rrm->RetrieveRequest = $rr;
	$results = $client->Retrieve($rrm);
	print_r($results);

} catch (SoapFault $e) {
  var_dump($e);
}
?>
