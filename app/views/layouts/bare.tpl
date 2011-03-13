{display_doctype type='XHTML1_STRICT'}
<html>
<head>
{display_js_links}
{display_css_links}
<title>
{if $site_title}{$site_title}{/if}
{if $site_title and $page_title} :: {/if}
{$page_title}
</title>
</head>
<body>
<!--- THis is header -->
 <div class="container">

{display_alerts}

{display_layout_body}
 
   
<div id="footer">
</div>
</div> <!-- end of div container -->
</body>
</html>
