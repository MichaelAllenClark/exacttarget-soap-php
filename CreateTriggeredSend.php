<?php

function CreateTriggeredSend($client, 
	$iTriggeredSendCustomerKey, 
	$iEmailAddress, 
	$iFirstName, 
	$iLastName)
{
    $ts = new ExactTarget_TriggeredSend();
	
    $tsd = new ExactTarget_TriggeredSendDefinition();
    $tsd->CustomerKey = $iTriggeredSendCustomerKey;
    $ts->TriggeredSendDefinition = new SoapVar($tsd, SOAP_ENC_OBJECT, 'TriggeredSendDefinition', "http://exacttarget.com/wsdl/partnerAPI");

    $ts->Subscribers = array();

    $subscriber = new ExactTarget_Subscriber();
    $subscriber->EmailAddress = $iEmailAddress;
    $subscriber->SubscriberKey = $iEmailAddress;

    $firstName = new ExactTarget_Attribute();
    $firstName->Name = "First Name";
    $firstName->Value = $iFirstName;

    $lastName = new ExactTarget_Attribute();
    $lastName->Name = "Last Name";
    $lastName->Value = $iLastName;

    $sub->Attributes = array($firstName,$lastName);

    $ts->Subscribers[] = $subscriber;

    $object = new SoapVar($ts, SOAP_ENC_OBJECT, 'TriggeredSend', "http://exacttarget.com/wsdl/partnerAPI");
    $request = new ExactTarget_CreateRequest();
    $request->Options = NULL;
    $request->Objects = array($object);
    $results = $client->Create($request);

    echo 'Status: '.$results->OverallStatus.'<br />';
    echo 'Request ID: '.$results->RequestID.'<br />';

    if (isset($results->Results->SubscriberFailures))
	{
		if (is_array($results->Results->SubscriberFailures))
			{
				foreach ($results->Results->SubscriberFailures as $SubFailure)
				{
					echo 'ErrorCode: '.$SubFailure->ErrorCode.'<br>';
					echo 'ErrorDescription: '.$SubFailure->ErrorDescription.'<br>';
				}
			} else {
				echo 'ErrorCode: '.$results->Results->SubscriberFailures->ErrorCode.'<br>';
				echo 'ErrorDescription: '.$results->Results->SubscriberFailures->ErrorDescription.'<br>';
			}
		}
	}

?>