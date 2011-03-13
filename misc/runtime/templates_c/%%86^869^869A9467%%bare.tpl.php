<?php /* Smarty version 2.6.22, created on 2011-03-13 04:38:00
         compiled from layouts/bare.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'display_doctype', 'layouts/bare.tpl', 1, false),array('function', 'display_js_links', 'layouts/bare.tpl', 4, false),array('function', 'display_css_links', 'layouts/bare.tpl', 5, false),array('function', 'display_alerts', 'layouts/bare.tpl', 16, false),array('function', 'display_layout_body', 'layouts/bare.tpl', 18, false),)), $this); ?>
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
</head>
<body>
<!--- THis is header -->
 <div class="container">

<?php echo smarty_function_display_alerts(array(), $this);?>


<?php echo smarty_function_display_layout_body(array(), $this);?>

 
   
<div id="footer">
</div>
</div> <!-- end of div container -->
</body>
</html>