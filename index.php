<?php 

//include database connection details
include('db.php');

//redirect to real link if URL is set
if (!empty($_GET['url'])) {
	$redirect = mysql_fetch_assoc(mysql_query("SELECT url_link FROM urls WHERE url_short = '".addslashes($_GET['url'])."'"));
	$redirect = "http://".str_replace("http://","",$redirect[url_link]);
	header('HTTP/1.1 301 Moved Permanently');  
	header("Location: ".$redirect);  
}
//
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>BigFileSharing</title>
    <link rel="stylesheet" type="text/css" href="css/dropzone.css"/>
    <script type="text/javascript" src="js/dropzone.js"></script>
    
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.maximage.min.css" type="text/css" media="screen" title="CSS" charset="utf-8" />
    
    <script src="js/jquery1.11.1.js"></script>
    <script src="js/jquery.cycle.all.js" type="text/javascript"></script>
    <script src="js/jquery.maximage.min.js" type="text/javascript"></script>
	
	
</head>
<body>
<div id="wrapper">
	<div id="left">
	
	    <div id="upload">
	    <div id="logo"> <img src="images/logo.png" alt="" width="128px" height="128px"/></div>
	        <form id="myDropzoneForm" class="dropzone" enctype="multipart/form-data" >
				<div class="fallback">
					<input id="file" name="file" type="file" class="descriptif" />
				</div>        
			</form>
	        
	        <input id="validBtn" class="validBtn" type="submit" value="Envoyer" />
	        <div><input class="question" type="submit" value="?" ></div>
	    </div>
	</div>
	
	<div id="right">
	     <div id="content">
	     	<input id="url" class="textbox" type="text" value="http://www.beemoon.fr/1234567_fichier.jpg" readonly> 
	     	<label class="message">
	     		Copiez l'URL ci-dessus puis transmettez-le à vos correspondants via votre messagerie mail habituelle.
                        <p>Le document sera disponible durant 7 jours</p>
	     	</label>
	     	<input id="newFile" class="validBtn" type="submit" value="Nouveau transfert" />
	     </div>
	</div>
	 
</div>
<div id="maximage">
    <div>
        <img src="images/bg1.jpg" alt="" />
    </div>
    <img src="images/bg.jpg" alt="" />
    <img src="images/bg1.jpg" alt="" />
    <img src="images/bg2.jpg" alt="" />
    <img src="images/bg3.jpg" alt="" />
    <img src="images/bg4.jpg" alt="" />
    <img src="images/bg5.jpg" alt="" />
    
    
</div>

<script type="text/javascript" charset="utf-8">

$(function(){
    $('#maximage').maximage({
        cycleOptions: {
        	fx:'fade',
            speed: 10000,
            timeout: 800,
        },
        onFirstImageLoaded: function(){
            jQuery('#cycle-loader').hide();
            jQuery('#maximage').fadeIn('fast');
        }
    });
});

/* Conf de la zone Dropzone */
Dropzone.options.myDropzoneForm = false;
Dropzone.options.myDropzoneForm = {
	autoProcessQueue: false,
	url:"upload.php",
	uploadMultiple: false,
	parallelUploads: 100,
    maxFiles: <?php echo __maxFile__; ?>,
	maxFilesize: <?php echo __maxFileSize__; ?>,
	thumbnailWidth: 200,
	thumbnailHeight: 200,
				
	init: function() {
                var myZone = this;
                
                document.querySelector("#validBtn").addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myZone.processQueue();
                        });
                
                this.on("maxfilesexceeded", function(file){
                        alert('Vous ne pouvez pas uploader plus de 1 fichier!');
                });
                        
                this.on("success", function (file, response) {
                		document.getElementById("url").value = response;
                        $( "#content" ).fadeIn( 2000 );
						$( "#validBtn" ).fadeOut( 2000 );
                });	
                
                this.on("addedfile", function(file) {
                	var _extFile = file.name.slice((file.name.lastIndexOf(".") - 1 >>> 0) + 2).toLowerCase();

                	var video = ["avi", "mov", "mp4", "wmv","mpeg"];
                	var text = ["doc", "txt", "xls", "ppt","odt","ods"];
                	var zip = ["zip", "tar", "7z","rar","gz","bz2"];
                	var pdf = ["pdf"];
                	var apps = ["exe","msi","bat","sh"];
                	var iso = ["iso","img"];

                	var thumbIco="x";

                	if (video.indexOf(_extFile) != -1){
                		var thumbIco="video";
                	}
                	if (text.indexOf(_extFile) != -1){
                		var thumbIco="text";
                	}
                	if (zip.indexOf(_extFile) != -1){
                		var thumbIco="zip";
                	}
                	if (pdf.indexOf(_extFile) != -1){
                		var thumbIco="pdf";
                	}
                	if (apps.indexOf(_extFile) != -1){
                		var thumbIco="apps";
                	}
                	if (iso.indexOf(_extFile) != -1){
                		var thumbIco="iso";
                	}
                	this.emit("thumbnail", file, "images/" + thumbIco + ".png");
                	
                		/*
                        if (file.type.match('video.*')) {
                        this.emit("thumbnail", file, "img/video.png");
                        }
                        if (file.type.match('application/pdf')) {
                        this.emit("thumbnail", file, "img/pdf.png");
                        }
                        */
                });			
	}
    	
};

$( "#newFile" ).click(function() {
	location.assign(window.location);
});

	
</script>
</body>
</html>