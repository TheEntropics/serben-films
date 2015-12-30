<?php
    header('Content-Type: application/json');
    include_once("functions.php");
	
	$root = "";
	$link = "";
	
	$file = file_get_contents("config.json");
	$config = json_decode($file);

	if (isset($config->root)) {
		$root = $config->root;
	}
	if (isset($config->link)) {
		$link = $config->link;
	}
	
    echo getFilmsJSON($link, $root);
?>
