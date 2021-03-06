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
{literal}
<script type="text/javascript">
    $(function() {
        $( "#calmenu" ).tabs();
    });
</script>
<style>
    body { font-family: Gill Sans,Arial,sans-serif;}
</style>
{/literal}
</head>
<body>
<!--- THis is header -->
 <div class="container">
 <div id="header" style="height:65px;">
		<div id="logo" style="width:150px;font-size:36px;margin-top:15px;">
            <img src="/img/cal_logo.png" width="30%" valign='bottom' style=''><span id="header_text" style="margin-bottom:21px;">palyn </span>
        </div>
		<span id="head" style="float:right">
				Welcome, {if $logged_in_user->id}{$logged_in_user->first_name|capitalize}{else}Visitor{/if} | Help | {if $is_logged_in}<a href="/user/logout">Logout</a>{else}<a href="/login">Login</a>{/if}
		</span>
		
 </div>

<div id="calmenu">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="/admin/index?nonav=1">Admin</a></li>
        </ul>

{display_alerts}

{display_layout_body}
</div> <!-- end of div calmenu -->
<div id="footer">
</div>

</div> <!-- end of div container -->
</body>
</html>
