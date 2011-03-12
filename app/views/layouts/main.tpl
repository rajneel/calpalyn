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
<script>
    $(function() {
        $( "#tabs" ).tabs();
    });
</script>
</head>
<body>
<!--- THis is header -->
<div id="header" style="font-size:36px;height:50px;">
   <img src="/img/cal_logo.png" width="5%" valign='bottom' style=''><div id="header_text" style="display:inline;margin-bottom:11px;">palyn </div> 
</div>
<hr style='border:dotted 1px #FFB00D'/>
{display_alerts}

{display_layout_body}

</body>
</html>
