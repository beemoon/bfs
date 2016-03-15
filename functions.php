<?php
// On charge le fichier de conf

$confINIFile = $_SERVER['DOCUMENT_ROOT'].substr(dirname(__FILE__),strlen($_SERVER['DOCUMENT_ROOT'])) . DIRECTORY_SEPARATOR . 'config.ini';
if (is_file($confINIFile)){
	$confINI = parse_ini_file($confINIFile,true);
} else {
	$confINI = array();
	echo "no config file!";
	echo $confINIFile;
}
foreach($confINI as $key){
	foreach($key as $key2=>$val){
		define('__'.$key2.'__',$val);
	}
}


?>