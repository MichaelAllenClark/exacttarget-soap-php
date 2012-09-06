<?php 

define('CLASS_NS', 'ExactTarget_');

ini_set('soap.wsdl_cache_enabled', 0);
define('CLASS_REPLACE', 'class '.CLASS_NS);
define('ETXPATHNS', 'exactns');
$res_words = array('and', 'or', 'xor', 'as', 'break', 'case', 'cfunction',
			    'class', 'continue', 'declare', 'const', 'default', 'do',
			    'else', 'elseif', 'enddeclare', 'endfor', 'endforeach',
			    'endif', 'endswitch', 'endwhile', 'eval', 'extends', 'for',
			    'foreach', 'function', 'global', 'if', 'new', 'old_function',
			    'static', 'switch', 'use', 'var', 'while', 'array', 'die',
			    'echo', 'empty', 'exit', 'include', 'include_once', 'isset',
			    'list', 'print', 'require', 'require_once', 'return', 'unset',
			    '__file__', '__line__', '__function__', '__class__', 'abstract',
			    'private', 'public', 'protected', 'throw', 'try');

function splitType($input) {
	$result = '';
	
	$input = trim($input);
	if (! empty($input)) {
		$arCurrent = explode(' ', $input);
		if (count($arCurrent) > 1) {
			$result = '  public $'.$arCurrent[1].' // ';
			if (ord($arCurrent[0][0]) < 97) {
				$result .= CLASS_NS;
			}
			$result .= $arCurrent[0];
		} else {
			$result = $input;
		}
	}
	return $result;
}

function createEnum($xPath, $type) {
	$result = '';
	
	if (! empty($type)) {
		$arclass = explode(" ", $type);
		$input = trim($arclass[1]);
		$path = "//".ETXPATHNS.":simpleType[@name='".$input."']/".ETXPATHNS.":restriction/".ETXPATHNS.":enumeration";
		if ($nodeList = $xPath->query($path)) {
			$type = substr_replace ($type, CLASS_REPLACE, 0, 7);
			$result .= trim($type)." {\n";
			foreach ($nodeList AS $node) {
				$constVal = $node->getAttribute('value');
				$constKey = $constVal;
				if (in_array(strtolower($constKey), $GLOBALS['res_words'])) {
					$constKey = '_'.$constVal;
				}
				$constKey = str_replace(":","_",$constKey);
				$result .= "  const $constKey='$constVal';\n";
			}
			$result .= "}\n\n";
		}
	}
	return $result;
}

$dXPath = NULL;

if( $_SERVER['argc'] != 2 ) {
  die("usage: exact_soap_client_creator.php <path_to_wsdl>\n");
}

$wsdl = $_SERVER['argv'][1];

$soapClient = new SOAPClient($wsdl, array('trace'=>1));

$arTypes = $soapClient->__getTypes();

$outheaders = "<?php 
require('soap-wsse.php');

class ExactTargetSoapClient extends SoapClient {
	public \$username = NULL;
	public \$password = NULL;

	function __doRequest(\$request, \$location, \$saction, \$version) {
		\$doc = new DOMDocument();
		\$doc->loadXML(\$request);

		\$objWSSE = new WSSESoap(\$doc);

		\$objWSSE->addUserToken(\$this->username, \$this->password, FALSE);

		return parent::__doRequest(\$objWSSE->saveXML(), \$location, \$saction, \$version);
   }

}

";

print $outheaders;

$dupCheck = array();

foreach ($arTypes AS $type) {

	if (strncasecmp($type, 'struct ', 7) == 0) {
		$type = substr_replace ($type, CLASS_REPLACE, 0, 7);
		$arclass = explode("\n", $type);

		foreach ($arclass AS $key=>$oline) {			
			if ($key == 0 & in_array( $oline,$dupCheck))
				break;
		
			if ($key > 0) {
				$output = splitType($oline);
			} else {
				$dupCheck[] = $oline;
				$output = $oline;
			}
				print $output."\n";

		}
		print "\n";
	} elseif (strncasecmp($type, 'string ', 7) == 0) {
		if (is_null($dXPath)) {
			$domWSDL = new DOMDocument();
			$domWSDL->load($wsdl);
			$dXPath = new DOMXPath($domWSDL);
			$dXPath->registerNamespace(ETXPATHNS, 'http://www.w3.org/2001/XMLSchema');
		}
		print createEnum($dXPath, trim($type));
	}
}
print "?> \n";
?>