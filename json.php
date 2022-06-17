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
	$data = json_decode($parser->getPage(), 1);

	//Echo JSON
	header('Content-Type: application/json');
	exit(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
?>