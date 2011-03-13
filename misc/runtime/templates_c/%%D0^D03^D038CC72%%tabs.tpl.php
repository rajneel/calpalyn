<?php /* Smarty version 2.6.22, created on 2011-03-13 03:13:50
         compiled from layouts/tabs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'display_doctype', 'layouts/tabs.tpl', 1, false),array('function', 'display_js_links', 'layouts/tabs.tpl', 4, false),array('function', 'display_css_links', 'layouts/tabs.tpl', 5, false),array('function', 'display_alerts', 'layouts/tabs.tpl', 40, false),array('function', 'display_layout_body', 'layouts/tabs.tpl', 42, false),)), $this); ?>
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

<!--
<hr style='border:dotted 1px #FFB00D'/>  -->

    <div id="calmenu">
        <ul>
            <li><a href="#home" >Home</a></li>
            <li><a href="#admin">Admin</a></li>
        </ul>

        <div id="admin">
            This is Admin home
        </div>
        <div id="home">
            This is index home
        </div>

    </div> <!-- end of div calmenu -->
<?php echo smarty_function_display_alerts(array(), $this);?>


<?php echo smarty_function_display_layout_body(array(), $this);?>

 
   
<div id="footer">
</div>
</div> <!-- end of div container -->
</body>
</html>