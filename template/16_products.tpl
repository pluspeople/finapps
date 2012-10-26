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
		<link rel="stylesheet" type="text/css" href="/1css/my.css" media="handheld, screen" />
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
				<!-- BEGIN DYNAMIC BLOCK: Category --> 
				<br/>
				<form method="post" action="19_editcategory.php?id={CATEGORY_ID}">
					<h1>
						<span>{CATEGORY_NAME}</span>
						&nbsp; <input class="edit" type="submit" name="add" value="" style="margin:0px;" title="Edit the name and description of this category"/>
					</h1>
				</form>

				<table width="100%" cellspacing="0">
					<tr>
						<td colspan="2">{CATEGORY_DESCRIPTION}</td>
					</tr>
					<tr>
						<td colspan="2"> 
							<form method="post" action="18_editproduct.php?new={CATEGORY_ID}">
							<input type="submit" name="add" value="Add new product to {CATEGORY_NAME}" style="margin:0px;"/>
							</form>
						</td>
					</tr>
					<!-- BEGIN DYNAMIC BLOCK: Item --> 
					<tr class="{ITEM_DARK}">
						<td width="155" valign="bottom" style="padding:0px;padding-left:2px;padding-top:5px;"><strong>{ITEM_NAME}</strong></td>
						<td align="right" width="145" style="padding:0px;padding-right:2px;padding-top:5px;">
							<form method="post" action="18_editproduct.php?id={ITEM_ID}">
								{ITEM_PRICE}
							&nbsp; <input type="submit" name="edit" class="edit" value="" style="max-width:40px;margin:0px;"/>
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
				<form method="post" action="19_editcategory.php?new=true">
					<input type="submit" name="add" value="Add new category" style="margin:0px;"/>
				</form>

			</div>
    </div>

    <div id="footercontainer">
    	<span class="copyright">Dreamcakes.co.ke</span>
    </div>
	</body>
</html>
