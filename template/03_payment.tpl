<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{HTML_TITLE}</title>
		<meta name="Keywords" content="{META_KEYWORDS}" />
		<meta name="ROBOTS" content="NOODP" />
		<meta name="description" content="{META_DESCRIPTION}" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<link rel="stylesheet" type="text/css" href="{CSS_FILE}" media="handheld, screen" />
	</head>
	<body bgcolor="#FFFFFF">
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
				<!-- BEGIN DYNAMIC BLOCK: Payment_complete --> 
				<h2>Payment complete</h2>
				The payment for this order have already been received - thank you.<br/><br/>
				<!-- END DYNAMIC BLOCK: Payment_complete --> 

				<!-- END DYNAMIC BLOCK: Mpesa --> 

				<!-- BEGIN DYNAMIC BLOCK: Visa --> 
				<!-- BEGIN DYNAMIC BLOCK: Visa_error --> 
				<h1>{ARTICLE0_HEADLINE}</h1>
				<span style="color:red">{ARTICLE0_BODYTEXT}</span><br/>
				<!-- END DYNAMIC BLOCK: Visa_error --> 
				Please enter the VISA card information below<br/>
				For security we do not store any credit card information.<br/>
				<br/>
				<form method="post" action="">
					<h2>Card number:</h2>
					<input type="text" name="card" style="width:297px;margin-bottom:5px;"/><br/>
					<h2>Expiration month - year</h2>
					<select name="month" style="width:100px;margin-right:7px;margin-bottom:5px;">
						<option>01</option>
						<option>02</option>
						<option>03</option>
						<option>04</option>
						<option>05</option>
						<option>06</option>
						<option>07</option>
						<option>08</option>
						<option>09</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
					</select>
					<select name="year" style="width:190px;margin-bottom:5px;">
						<option>2012</option>
						<option>2013</option>
						<option>2014</option>
						<option>2015</option>
						<option>2016</option>
						<option>2017</option>
						<option>2018</option>
						<option>2019</option>
						<option>2020</option>
						<option>2021</option>
						<option>2022</option>
						<option>2023</option>
						<option>2024</option>
						<option>2025</option>
						<option>2026</option>
					</select><br/>
					<h2>Card Verification Number (on the back-side)</h2>
					<input type="text" name="cvv2" value="" style="width:297px;margin-bottom:5px;"/><br/>
					<br/>
					<input class="button" type="submit" value="Confirm &gt;" name="confirm" /><br/>
					<br/>
				</form>
				<!-- END DYNAMIC BLOCK: Visa --> 
			</div>
    </div>

    <div id="footercontainer">
    	<span class="copyright">Dreamcakes.co.ke</span>
    </div>
	</body>
</html>
