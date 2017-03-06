<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Snap! Build Your Own Blocks</title>
		<link rel="shortcut icon" href="favicon.ico">
		<script type="text/javascript" src="morphic.js"></script>
		<script type="text/javascript" src="widgets.js"></script>
		<script type="text/javascript" src="blocks.js"></script>
		<script type="text/javascript" src="threads.js"></script>
		<script type="text/javascript" src="objects.js"></script>
		<script type="text/javascript" src="gui.js"></script>
		<script type="text/javascript" src="paint.js"></script>
		<script type="text/javascript" src="lists.js"></script>
		<script type="text/javascript" src="byob.js"></script>
		<script type="text/javascript" src="tables.js"></script>
		<script type="text/javascript" src="xml.js"></script>
		<script type="text/javascript" src="store.js"></script>
		<script type="text/javascript" src="locale.js"></script>
		<script type="text/javascript" src="cloud.js"></script>
		<script type="text/javascript" src="sha512.js"></script>
		<script type="text/javascript" src="FileSaver.min.js"></script>
		<script type="text/javascript" src="docshare.js"></script>
		<script type="text/javascript">
			var world,php_params;
			window.onload = function () {
				world = new WorldMorph(document.getElementById('world'));
				// world.isDevMode= true;
                world.worldCanvas.focus();
				new IDE_Morph().openIn(world);
				world.setDocShare(php_params);
        		loop();
			};
			function loop() {
        		requestAnimationFrame(loop);
				world.doOneCycle(); 
			}
		</script>
	</head>
	<body style="margin: 0;">
	<?php 
		function getSSLPage($url) {
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_HEADER, false);
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_SSLVERSION,3); 
    		$result = curl_exec($ch);
    		curl_close($ch);
    		return $result;
		}

        $u = isset($_GET["url"]) ? $_GET["url"] : null;
        $u = isset($_POST["url"]) ? $_POST["url"] : $u;
        $ga = isset($_GET["googleApps"]) ? $_GET["googleApps"] : null;
        $ga = isset($_POST["googleApps"]) ? $_POST["googleApps"] : $ga;
        $gid = isset($_GET["googleId"]) ? $_GET["googleId"] : null;
        $gid = isset($_POST["googleId"]) ? $_POST["googleId"] : $gid;
        $f = isset($_POST["file_content"]) ? $_POST["file_content"] : null;
        $fs = isset($_GET["fullscreen"]) ? $_GET["fullscreen"] : null;
        $fs = isset($_POST["fullscreen"]) ? $_POST["fullscreen"] : $fs;
        // Don't need to wait for page load when google url param is here :
        if (($u)&&(strpos($u, 'google.com') !== false)) {    
            	$pattern="/([-\w]{25,})/";
            	preg_match($pattern, $u, $res);
            	if ((is_array($res)) && (count($res) > 0)) {
                	$args="id=".$res[0];
                	$args=$args."&html=Snap";
                	echo "<script>location.replace('https://script.google.com/macros/s/AKfycbyEZOu-YDVlJWrrMBdDXdWzMF1HI2ONmxKTmtgYF-cFdUXyq44/exec?".$args."')</script>";
            	}
        	};
        if (($u)&&(!$f)) {
        	$f=base64_encode(file_get_contents("$u"));
        }
        echo	"<script>
        			php_params = {
        				url:\"".$u."\",
        				app:\"".$ga."\",
        				id:\"".$gid."\",
        				file:\"".$f."\",
        				fullscreen:\"".$fs."\"
        			}
        		</script>";
		?>
		<canvas id="world" tabindex="1" style="position: absolute;" />
	</body>
</html>
