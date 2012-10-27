<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{HTML_TITLE}</title>
		<meta name="Keywords" content="{META_KEYWORDS}" />
		<meta name="ROBOTS" content="NOODP" />
		<meta name="description" content="{META_DESCRIPTION}" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, user-scalable=no" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<link rel="stylesheet" type="text/css" href="{CSS_FILE}" media="handheld, screen" />
    <script type="text/javascript" src="/jquery-1.6.4.min.js"></script>
		<script type="text/javascript">
			var grandTotal = {GRAND_TOTAL};
			function uptotal(context, price) {
			  $(context).parent().next().next().text(Math.abs(context.value) * price);
			  $(".grandTotal").text(grandTotal);
			}

			function dec(input, price) {
			  if (input.value > 0) {
			    input.value--;
			    grandTotal -= price; // not done
        }
			  uptotal(input, price);
			}

			function inc(input, price) {
			  input.value++;
			  grandTotal += price; // not done
			  uptotal(input, price);
			}

		</script>
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
				<h1>{ARTICLE0_HEADLINE}</h1>
				{ARTICLE0_BODYTEXT}

				<!-- BEGIN DYNAMIC BLOCK: Error --> 
				<div style="color:#f00;">
				<h1>{ARTICLE1_HEADLINE}</h1>
				{ARTICLE1_BODYTEXT}
				</div>
				<!-- END DYNAMIC BLOCK: Error --> 

				<form method="post" action="" name="OF">
					<h2>Full Name:</h2>
					<input type="text" name="name" value="{NAME_VALUE}"/ style="width:96%;margin-bottom:5px;"/><br/>
					<h2>Phone:</h2>
					<input type="text" name="phone" value="{PHONE_VALUE}" style="width:96%;margin-bottom:5px;"/><br/>
					<h2>Email:</h2>
					<input type="text" name="email" value="{EMAIL_VALUE}" style="width:96%;margin-bottom:5px;"/><br/>
					<h2>Address:</h2>
					<textarea name="address" style="width:96%;height:50px;">{ADDRESS_VALUE}</textarea>
					<br/>
					<br/>
					<br/>
					<h1>Review your order:</h1>
					<table width="96%">
						<tr>
							<th width="9%">Qty</th>
							<th width="67%" align="left">Food</th>
							<th width="24%" align="right">Total</th>
						</tr>
						
						<!-- BEGIN DYNAMIC BLOCK: Item --> 
						<tr>
							<td align="center">{ITEM_AMOUNT}</td>
							<td>{ITEM_NAME}</td>
							<td align="right">{ITEM_TOTAL}</td>
						</tr>
						<!-- END DYNAMIC BLOCK: Item --> 
						
						<tr>
							<td>&nbsp;</td>
							<td><strong>Total</strong></td>
							<td align="right"><strong class="grandTotal">{GRAND_TOTAL}</strong></td>
						</tr>
					</table>
					<br/>
					<input class="button" type="submit" value="Continue &gt;" name="continue" /><br/>
					<br/>
					<input class="button" type="submit" value="&lt; Go back" name="back" style="background-color:#CCC;"/>
				</form>
			</div>
    </div>

    <div id="footercontainer">
    	<span class="copyright">Dreamcakes.co.ke</span>
    </div>
	</body>
</html>
