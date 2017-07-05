<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php echo $this->Html->meta('icon'); ?>
    <title>Administrator - <?php echo $title_for_layout; ?></title>
	<?php echo $this->Html->css(array('../plugins/morris/morris', 'admin/bootstrap.min','select2/select2', 'admin/core', 'admin/components','admin/icons','admin/pages','admin/responsive','admin/calender','admin/jquery.timepicker','admin/custom')); ?>
    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <?php echo $this->Html->script(array('admin/modernizr.min','admin/jquery.min')); ?>
    <?php echo $this->Html->scriptStart(); ?>
    AppScript = {BASE_URL:'<?php echo $this->base; ?>',SITE_URL:'<?php echo Configure::read('Site.url'); ?>'}
    <?php echo $this->Html->scriptEnd(); ?>
	<script>
		var SITE_URL = '<?php echo Configure::read('Site.url'); ?>';
	</script>
            
	</head>
<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
		<!--header start-->
		<?php echo $this->element('admin/header'); ?>
		<!--header end-->
		<!--sidebar start-->
		<?php echo $this->element('admin/leftbar'); ?>
		<!--sidebar end-->
		<!--main content start-->
		<?php echo $this->fetch('content'); ?>
		<!--main content end-->
		<?php echo $this->element('admin/footer')?>

    </div>
    <!-- END wrapper -->
	<script> var resizefunc = [];</script>
    <!-- jQuery  -->
	<?php
	echo $this->Html->script(array('admin/bootstrap.min','admin/jquery-ui.js','admin/detect','admin/fastclick','admin/jquery.slimscroll','admin/jquery.blockUI','admin/waves','admin/wow.min','admin/jquery.nicescroll', 'admin/jquery.scrollTo.min'));

	
echo $this->Html->script(array('admin/jquery.core','admin/jquery.app.js','admin/select2.min','admin/custom','admin/jquery.timepicker.min','admin/jquery.validate.min','admin/formValidations.js','../plugins/tinymce/tinymce.min.js')); ?>

   <?php echo $this->fetch('scriptBottom');
	
	?>
</body>
</html>
