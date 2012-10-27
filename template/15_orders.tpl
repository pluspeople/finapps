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
				<table>
					<tr>
						<td colspan="3">
							<h2>Awaiting your feedback:</h2>
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td>Order</td>
						<td>Action</td>
					</tr>

					<!-- BEGIN DYNAMIC BLOCK: Order -->
					<tr class="{DARK}">
						<td valign="top">
							{ORDER_NAME}<br/>
							{ORDER_PHONE}<br/>
							{ORDER_EMAIL}<br/>
							{ORDER_ADDRESS}<br/>
						</td>
						<td valign="top">
							<!-- BEGIN DYNAMIC BLOCK: Line -->
							{LINE_AMOUNT}x {LINE_NAME}<br/>
							<!-- END DYNAMIC BLOCK: Line -->
						</td>
						<td valign="top">
							<form action="" method="post">
								<input type="hidden" name="orderId" value="{ORDER_ID}"/>
								<input type="submit" value="Accept" name="accept" /><br/>
								<input type="submit" value="Decline" name="refuse" /><br/>
							</form>
						</td>
					</tr>
					<!-- END DYNAMIC BLOCK: Order -->
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
