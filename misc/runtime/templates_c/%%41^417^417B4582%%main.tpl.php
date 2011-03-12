<?php /* Smarty version 2.6.22, created on 2011-03-12 15:48:15
         compiled from layouts/main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'display_doctype', 'layouts/main.tpl', 1, false),array('function', 'display_js_links', 'layouts/main.tpl', 4, false),array('function', 'display_css_links', 'layouts/main.tpl', 5, false),array('function', 'display_alerts', 'layouts/main.tpl', 18, false),array('function', 'display_layout_body', 'layouts/main.tpl', 20, false),)), $this); ?>
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
<div id="header" style="font-size:36px;height:50px;">
   <img src="/img/cal_logo.png" width="5%" valign='bottom' style=''><div id="header_text" style="display:inline;margin-bottom:11px;">palyn </div> 
</div>
<hr style='border:dotted 1px #FFB00D'/>
<?php echo smarty_function_display_alerts(array(), $this);?>


<?php echo smarty_function_display_layout_body(array(), $this);?>


</body>
</html>