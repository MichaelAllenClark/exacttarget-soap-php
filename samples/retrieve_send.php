<?php
// This call will retrieve an ExactTarget Send which is helpful for finding the current status of a send and 
// for getting aggregate tracking information for a send job. 
require('../exacttarget_soap_client.php');
require('../creds.php');

try	{
	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;
		
	$rr = new ExactTarget_RetrieveRequest();
	$rr->ObjectType = "Send";   
	$rr->Properties =  array();
	$rr->Properties[] = "ID";
	$rr->Properties[] = "SentDate";
	$rr->Properties[] = "UniqueOpens";        
	$rr->Properties[] = "NumberSent";
	$rr->Properties[] = "NumberDelivered";
	$rr->Properties[] = "HardBounces";
	$rr->Properties[] = "SoftBounces";

	$sfp= new ExactTarget_SimpleFilterPart();
	$sfp->Value =  array("10952354");
	$sfp->SimpleOperator = ExactTarget_SimpleOperators::equals;
	$sfp->Property="ID";

	$rr->Filter = new SoapVar($sfp, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI");
	$rr->Options = NULL;
	$rrm = new ExactTarget_RetrieveRequestMsg();
	$rrm->RetrieveRequest = $rr;        
	$results = $client->Retrieve($rrm);  
	var_dump($results);

	print_r('ID: '.$results->Results->ID."\n");
	print_r('Sent Date: '.$results->Results->SentDate."\n");
	print_r('NumberSent: '.$results->Results->NumberSent."\n");
	
} catch (Exception  $e) {
	var_dump($e);
}
?>