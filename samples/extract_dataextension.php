<?php
// This call will use the Extract method in order to generate a CSV file(tab-seperated also supported) on the ExactTarget Enhanced FTP site for the account for a specific data extension.
require('../exacttarget_soap_client.php');
require('../creds.php');


try	{

	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$er = new ExactTarget_ExtractRequest();
	$er->Options = NULL;
	$er->ID = "bb94a04d-9632-4623-be47-daabc3f588a6";
	$er->Parameters =  array();

	// Always set an StartDate to the value specified
	$ep1 = new ExactTarget_APIProperty();
	$ep1->Name = "StartDate";
	$ep1->Value = "1/1/1900 1:00:00 AM";
	$er->Parameters[] = $ep1;
	
	// Always set an EndDate to the value specified
	$ep2 = new ExactTarget_APIProperty();
	$ep2->Name = "EndDate";
	$ep2->Value = "1/1/1900 1:00:00 AM";
	$er->Parameters[] = $ep2;

	// Always set _AsyncID to 0
	$ep3 = new ExactTarget_APIProperty();
	$ep3->Name = "_AsyncID";
	$ep3->Value = "0";
	$er->Parameters[] = $ep3;

	$ep4 = new ExactTarget_APIProperty();
	$ep4->Name = "OutputFileName";
	$ep4->Value = "PHPExtractDE.csv";
	$er->Parameters[] = $ep4;

	$ep5 = new ExactTarget_APIProperty();
	$ep5->Name = "DECustomerKey";
	$ep5->Value = "Bademails";
	$er->Parameters[] = $ep5;
	
	$ep6 = new ExactTarget_APIProperty();
	$ep6->Name = "HasColumnHeaders";
	$ep6->Value = "true";
	$er->Parameters[] = $ep6;

	$erm = new ExactTarget_ExtractRequestMsg();
	$erm->Requests =  array();
	$erm->Requests[] = $er;

	$results = $client->Extract($erm);  

	print_r($results);

} catch (SoapFault $e) {
	var_dump($e);
}
?>