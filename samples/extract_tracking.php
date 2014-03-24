<?php
// This call will use the Extract method in order to generate a CSV file(tab-seperated also support) on the ExactTarget Enhanced FTP site for the account.
// For more details about the properties that can be specified in order to get additional data, read: https://code.exacttarget.com/content/tips-better-tracking-extracts
// While the example only requests sent data by setting the ExtractSent property to true, it is possible to pass multiple types in a single request to output multiple types of data.
require('../exacttarget_soap_client.php');
require('../creds.php');


try	{

	$client = new ExactTargetSoapClient($wsdl, array('trace'=>1));
	$client->username = $username;
	$client->password = $password;

	$er = new ExactTarget_ExtractRequest();
	$er->Options = NULL;
	$er->ID = "c7219016-a7f0-4c72-8657-1ec12c28a0db";
	$er->Parameters =  array();

	$ep1 = new ExactTarget_APIProperty();
	$ep1->Name = "StartDate";
	$ep1->Value = "8/12/2010 12:00:00 AM";
	$er->Parameters[] = $ep1;

	$ep2 = new ExactTarget_APIProperty();
	$ep2->Name = "EndDate";
	$ep2->Value = "8/14/2010 12:00:00 AM";
	$er->Parameters[] = $ep2;

	$ep3 = new ExactTarget_APIProperty();
	$ep3->Name = "ExtractSent";
	$ep3->Value = "true";
	$er->Parameters[] = $ep3;

	$ep4 = new ExactTarget_APIProperty();
	$ep4->Name = "OutputFileName";
	$ep4->Value = "PHP Sent Data.zip";
	$er->Parameters[] = $ep4;

	$ep5 = new ExactTarget_APIProperty();
	$ep5->Name = "Format";
	$ep5->Value = "csv";
	$er->Parameters[] = $ep5;

	$erm = new ExactTarget_ExtractRequestMsg();
	$erm->Requests =  array();
	$erm->Requests[] = $er;

	$results = $client->Extract($erm);  

	print_r($results);

} catch (SoapFault $e) {
	var_dump($e);
}
?>