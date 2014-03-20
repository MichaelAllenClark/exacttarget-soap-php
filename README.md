# ExactTarget SOAP Starter Project for PHP

This starter project contains some a working project showing how to access [ExactTarget][0]'s SOAP API using PHP. 

## Prerequisites

### Required PHP Extensions
- SOAP
- mcrypt
- openssl

### Required PHP Version
5.2.3 or greater

## Getting Started ##

- Copy the creds.php.template file to creds.php
- Open cred.php and input the appropriate values for username/password and WSDL
 - Requires an ExactTarget user with 'API User' and 'Grant the user access to the web services' permissions
- Navigate to samples directory
- Run the getsystemstatus.php script
- Successful response will include StatusCode of OK:

Example:

    object(stdClass)#3 (4) {
      ["Results"]=>
      object(stdClass)#9 (1) {
        ["Result"]=>
        object(stdClass)#5 (3) {
          ["StatusCode"]=>
          string(2) "OK"
          ["StatusMessage"]=>
          string(23) "System Status Retrieved"
          ["SystemStatus"]=>
          string(2) "OK"
        }
      }
      ["OverallStatus"]=>
      string(2) "OK"
      ["OverallStatusMessage"]=>
      string(0) ""
      ["RequestID"]=>
      string(36) "5acea13a-d685-473e-a02d-c9960b47864e"
    }

## Refreshing the ExactTarget Client ##

The exact\_soap\_client.php file contains the definitions for all of the SOAP objects that are available.  If new objects are added then it may be necessary to refresh this file to bring in new objects or properties.  The following command will generate a new client file:

    php exact_soap_client_creator.php https://webservice.exacttarget.com/etframework.wsdl > exacttarget_soap_client.php

### Questions about ExactTarget's SOAP API? ###

Check out: [https://salesforce.stackexchange.com/questions/tagged/exacttarget](https://salesforce.stackexchange.com/questions/tagged/exacttarget) 



[0]: http://www.exacttarget.com
