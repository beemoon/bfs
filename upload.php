<?php
require_once 'functions.php';

$ds = DIRECTORY_SEPARATOR;
include('db.php');
if (!empty($_FILES)) {
	 
	$tempFile = $_FILES['file']['tmp_name'];
	$path_parts = pathinfo($_FILES['file']['name']);
	$uniqueID = time();
	
	$targetPath = dirname( __FILE__ ) . $ds. __dataStore__ . $ds;	 
	$targetFile =  $targetPath . $uniqueID . '_' . $path_parts['filename'] . '.' . $path_parts['extension'];
	
	move_uploaded_file($tempFile,$targetFile);
	chmod($targetFile, 0777);

	$url = dirname(getCurrentURL()).$ds.__dataStore__.$ds.$uniqueID . '_' . $path_parts['filename'] . '.' . $path_parts['extension'];
	
	//get random string for URL and add http:// if not already there
	while (!(isset($short)) || (mysql_num_rows(mysql_query("SELECT url_link FROM urls WHERE url_short = '".$short."'")) != 0)){
		$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
	}
	
	mysql_query("INSERT INTO urls (url_link, url_short, url_ip, url_date) VALUES
	
		(
		'".addslashes($url)."',
		'".$short."',
		'".$_SERVER['REMOTE_ADDR']."',
		'".time()."'
		)
	
	");
	
	echo dirname(getCurrentURL()).$ds.$short;

}

function getCurrentURL(){
	/* http://hayageek.com/php-get-current-url */
	$currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	$currentURL .= $_SERVER["SERVER_NAME"];

	if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
	{
		$currentURL .= ":".$_SERVER["SERVER_PORT"];
	}

	$currentURL .= $_SERVER["REQUEST_URI"];
	return $currentURL;
}

?>
