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
        $u=$_GET["url"];
        if (!$u) $u=$_POST["url"];
        $ga=$_GET["googleApps"];
        if (!$ga) $ga=$_POST["googleApps"];
        $gid=$_GET["googleId"];
        if (!$gid) $gid=$_POST["googleId"];
        $f=$_POST["file_content"];
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
        if (($u)&&(!$f)) $f=base64_encode(file_get_contents("$u"));
        echo	"<script>
        			php_params = {
        				url:\"".$u."\",
        				app:\"".$ga."\",
        				id:\"".$gid."\",
        				file:\"".$f."\"
        			}
        		</script>";
		?>
		<canvas id="world" tabindex="1" style="position: absolute;" />
	</body>
</html>
