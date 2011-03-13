<?php /* Smarty version 2.6.22, created on 2011-03-13 04:37:57
         compiled from layouts/main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'display_doctype', 'layouts/main.tpl', 1, false),array('function', 'display_js_links', 'layouts/main.tpl', 4, false),array('function', 'display_css_links', 'layouts/main.tpl', 5, false),array('function', 'display_alerts', 'layouts/main.tpl', 38, false),array('function', 'display_layout_body', 'layouts/main.tpl', 40, false),)), $this); ?>
<?php echo smarty_function_display_doctype(array('type' => 'XHTML1_STRICT'), $this);?>

<html>
<head>
<?php echo smarty_function_display_js_links(array(), $this);?>

<?php echo smarty_function_display_css_links(array(), $this);?>

<title>
<?php if ($this->_tpl_vars['site_title']): ?><?php echo $this->_tpl_vars['site_title']; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['site_title'] && $this->_tpl_vars['page_title']): ?> :: <?php endif; ?>
<?php echo $this->_tpl_vars['page_title']; ?>

</title>
<?php echo '
<script type="text/javascript">
    $(function() {
        $( "#calmenu" ).tabs();
    });
</script>
'; ?>

</head>
<body>
<!--- THis is header -->
 <div class="container">
 <div id="header" style="height:65px;">
		<div id="logo" style="width:150px;font-size:36px;margin-top:25px;">
            <img src="/img/cal_logo.png" width="30%" valign='bottom' style=''><span id="header_text" style="margin-bottom:11px;">palyn </span>
        </div>
		<span id="head" style="float:right">
				Welcome, <?php if ($this->_tpl_vars['user']): ?><?php echo $this->_tpl_vars['user']; ?>
<?php else: ?>Roger<?php endif; ?> | Help | <?php if ($this->_tpl_vars['is_logged_in']): ?><a href="/login/logout">Logout</a><?php else: ?><a href="/login">Login</a><?php endif; ?>			
		</span>
		
 </div>

<div id="calmenu">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="/admin/index?nonav=1">Admin</a></li>
        </ul>

<?php echo smarty_function_display_alerts(array(), $this);?>


<?php echo smarty_function_display_layout_body(array(), $this);?>

</div> <!-- end of div calmenu -->
<div id="footer">
</div>

</div> <!-- end of div container -->
</body>
</html>