<?php
require_once 'functions.php';

if ($_SERVER['HTTP_HOST'] == ""){

	$dir = opendir(__dataStore__) or die("Could not open directory");
	chdir($dir);
	$old = mktime(0,0,0,date("n"),date("j")-$retentionDay,date("Y"));
	echo "Working in <tt>".__dataStore__."</tt><br>";
	echo "Deleting files created before <tt>".date("F d Y", $old)."</tt><br><br>";
	
	/*
	if ($handle = $dir) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				echo "$entry<br>\n";
					$cur = filemtime(__dataStore__."/".$entry);
					if($cur < $old) {
						if(unlink(__dataStore__."/".$entry))
							echo "<del><b><tt>$entry</tt></b></del> modified <b><tt>".date("F d Y H:i:s",$cur)."</tt></b><br>";
						else
							echo "Error deleting file <tt><b>$entry</b></tt><br>";
					}
					else
					echo "<b><tt>$entry</tt></b> modified <b><tt>".date("F d Y H:i:s",$cur)."</tt></b><br>";
				}
				
			
			}
			closedir($handle);
	}
	*/
	
	if ($handle = $dir) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != ".." && $entry !="index.html" && $entry !="index.php") {
				
				$cur = filemtime(__dataStore__."/".$entry);
				if($cur < $old) {
					if(unlink(__dataStore__."/".$entry)) {
						echo "Error deleting file <tt><b>$entry</b></tt><br>";
					}
				}
				
			}
				
	
		}
		closedir($handle);
	}


} else {
	echo "Forbidden!";
}
?>