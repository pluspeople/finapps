<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{HTML_TITLE}</title>
		<meta name="Keywords" content="{META_KEYWORDS}" />
		<meta name="ROBOTS" content="NOODP" />
		<meta name="description" content="{META_DESCRIPTION}" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" type="text/css" href="/1css/public-default.css" media="screen" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<link rel="stylesheet" type="text/css" href="{CSS_FILE}" media="handheld, screen" />
    <script type="text/javascript" src="/jquery-1.6.4.min.js"></script>
		<script type="text/javascript">
			$().ready(function() {
			  $(".category").each(function (index) {
          if ($(this).next().find(':hidden[name|="categoryOpen"]').val() != '1') {
			      $(this).toggleClass("plus").next().hide();
          }
			  });

			  $(".category").click(function() {
					$(this).toggleClass("plus").next().toggle();
				});

			  if (!{OPEN_BASKET}) {
  			  $('#basketcontent').hide();
        }
			});
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
		
		<!-- BEGIN DYNAMIC BLOCK: Basket_wrap --> 
		<div style="background-color:#DDD;">
			<div class="basket" style="margin:0px auto;width:300px;color:#000;background-color:#DDD;font-size:14px;padding:10px;">
				<center>
					<strong>Order: {ITEMS_AMOUNT} items {ITEMS_TOTAL} EURO</strong> <input type="button" name="basket" value="Review order" onclick="$('#basketcontent').slideToggle();"/>
				</center>
			</div>

			<div class="basket" id="basketcontent" style="display:block;margin:0px auto;width:300px;color:#000;background-color:#DDD;padding:10px;">
				<table width="100%" cellspacing="0">
					<tr>
						<td colspan="4"><h2>Items to be ordered</h2></td>
					</tr>
					<!-- BEGIN DYNAMIC BLOCK: Basket_item_wrap --> 
					<!-- BEGIN DYNAMIC BLOCK: Basket_item --> 
					<tr class="{ITEM_DARK}" style="padding-top:5px;">
						<td width="15">{ITEM_AMOUNT}x</td>
						<td width="185"><strong>{ITEM_NAME}</strong></td>
						<td width="60" align="right">{ITEM_PRICE}</td>
						<td width="40" align="right">
							<form method="post" action="{ACTION}">
								<input type="hidden" name="delId" value="{ITEM_ID}"/>
								<input type="submit" name="delete" value="Del"/>
							</form>
						</td>
					</tr>
					<!-- END DYNAMIC BLOCK: Basket_item --> 
					<!-- END DYNAMIC BLOCK: Basket_item_wrap --> 
					<tr class="{TOTAL_DARK}">
						<td>&nbsp;</td>
						<td width="200"><strong>Total</strong></td>
						<td align="right"><strong>{ITEMS_TOTAL}</strong></td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<br/>
				<form method="post" action="{ACTION}">
					<center>
						<input class="button" type="submit" value="Place Order" name="order"/>
					</center>
				</form>
			</div>
		</div>
		<!-- END DYNAMIC BLOCK: Basket_wrap --> 
    <div id="maincontainer">
			<div class="contentwrapper">
				<br/>
				<!-- BEGIN DYNAMIC BLOCK: Category --> 
				<br/>
				<h2 class="category">{CATEGORY_NAME}</h2>
				<table width="100%" cellspacing="0">
					<tr>
						<td colspan="2">{CATEGORY_DESCRIPTION}</td>
					</tr>
					<!-- BEGIN DYNAMIC BLOCK: Item --> 
					<tr class="{ITEM_DARK}">
						<td width="155" valign="bottom" style="padding:0px;padding-left:2px;padding-top:5px;"><strong>{ITEM_NAME}</strong></td>
						<td align="right" width="145" style="padding:0px;padding-right:2px;padding-top:5px;">
							<form method="post" action="{ACTION}">
								<input type="hidden" name="categoryOpen" value="{CATEGORY_OPEN}"/>
								{ITEM_PRICE}
							<input type="hidden" name="buyId" value="{ITEM_ID}"/>
							<input type="submit" name="buy" value="buy" style="max-width:40px;margin:0px;"/>
							</form>
							</td>
					</tr>
					<!-- BEGIN DYNAMIC BLOCK: Item_description -->
					<tr class="{ITEM_DARK}" style="padding:0px;">
						<td colspan="2" style="padding:0px;padding-left:2px;">{ITEM_DESCRIPTION}</td>
					</tr>
					<!-- END DYNAMIC BLOCK: Item_description -->
					<!-- END DYNAMIC BLOCK: Item --> 
					
				</table>
				<br/>
				<!-- END DYNAMIC BLOCK: Category --> 
			</div>
    </div>

    <div id="footercontainer">
    	<span class="copyright">Dreamcakes.co.ke</span>
    </div>
		{GOOGLE_ADWORD}
	</body>
</html>
