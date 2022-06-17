<?php 
if(empty($_GET)){
	exit("Empty query");
}

	spl_autoload_register();

	use Classes\Parser;

	//Create URL and curl
	$id = $_GET['id'];
	$url = "https://db.ukc.gov.ua/mw/appeal?id=" . $id;

	$parser = new Parser($url);

	//Set authorized cookie
	$session_id = $_GET['sessionid'];

	$parser->setCookies("JSESSIONID={$session_id}");

	//Get info
	$json = $parser->getPage();
	$data = json_decode($json, 1);

	//Create empty XML
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?><root></root>";
	$xml = new SimpleXMLElement($xml);

	//Convert JSON to XML
	$xml = arrayToXml($data, $xml);

	//Render XML
	header('Content-Type: text/xml');
	echo($xml->asXML());

	function arrayToXml($array = [], SimpleXMLElement $xml)
	{
		foreach ($array as $key => $value) {
			if(is_numeric($key)){
				$key = 'key' . $key;
			}
			if(is_array($value)){
				$subnode = $xml->addChild($key);
                arrayToXml($value, $subnode);
			}else{
				$xml->addChild($key, htmlspecialchars($value));
			}
		}

		return $xml;
	}
?>