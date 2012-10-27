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
				<center>
					<img src="/1image/chart3.png" width="300" height="120"/><br/>
					<br/>

					<table>
						<tr>
							<td width="200"><strong>Month</strong></td>
							<td width="100" align="right"><strong>Revenue</strong></td>
						</tr>
						<!-- BEGIN DYNAMIC BLOCK: Month -->
						<tr>
							<td>{MONTH_NAME}</td>
							<td align="right">{MONTH_SALE} EURO</td>
						</tr>
						<!-- END DYNAMIC BLOCK: Month -->

					</table>
				</center>


				<br/>
				<input class="button" type="button" value="Back" name="cancel" onclick="document.location='11_dashboard.php'"/><br/>

			</div>
    </div>

    <div id="footercontainer">
    	<span class="copyright">Dreamcakes.co.ke</span>
    </div>
	</body>
</html>
