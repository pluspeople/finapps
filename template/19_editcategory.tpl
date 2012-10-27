<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{HTML_TITLE}</title>
		<meta name="Keywords" content="{META_KEYWORDS}" />
		<meta name="ROBOTS" content="NOODP" />
		<meta name="description" content="{META_DESCRIPTION}" />
		<meta name="viewport" content="width=device-width, user-scalable=no" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<link rel="stylesheet" type="text/css" href="{CSS_FILE}" media="handheld, screen" />
	</head>
	<body> 
		<!--   Produced by Dreamcakes.co.ke © 2012    -->
    <div id="headercontainer">
    	<div class="logocontainer">
        <a href="/" class="logo"></a>
      </div>
    </div>
		<div class="poweredBar">
		</div>

    <div id="maincontainer">
			<div class="contentwrapper">
			<form action="" method="post">
				<h2>Category name:</h2>
				<input type="text" name="name" value="{NAME}"/ style="width:96%;margin-bottom:5px;" /><br/>
				<h2>Description:</h2>
				<textarea name="description" style="width:96%;height:50px;">{DESCRIPTION}</textarea>

				<br/>
				<input class="button" type="submit" value="Save product" name="OK" /><br/>
				<br/>
				<input class="button" type="button" value="Back" name="cancel" onclick="document.location='16_products.php'"/><br/>
			</form>
			</div>
    </div>

    <div id="footercontainer">
    	<span class="copyright">Dreamcakes.co.ke</span>
    </div>
	</body>
</html>
