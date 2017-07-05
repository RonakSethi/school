<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php echo $this->Html->meta('icon'); ?>
        <title>Administrator - <?php echo Configure::read('Site.title'); ?></title>

		 <?php echo $this->Html->css(array('admin/morris', 'admin/bootstrap.min', 'admin/core', 'components','icons','pages','responsive')); ?>
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

       <?php echo $this->Html->script(array('modernizr.min')); ?>


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
           <?php echo $this->element('admin/rightbar'); ?>
        </div>
        <!-- END wrapper -->

        <script>
            var resizefunc = [];
        </script>

		 <!-- jQuery  -->
		<?php echo $this->Html->script(array('jquery.min','bootstrap.min','detect','fastclick','jquery.slimscroll','jquery.blockUI','waves','wow.min','jquery.nicescroll','jquery.scrollTo.min','jquery.core','jquery.app','plugins/peity/jquery.peity.min', 'plugins/waypoints/lib/jquery.waypoints','plugins/counterup/jquery.counterup.min','plugins/morris/morris.min','raphael-min','jquery.knob','jquery.dashboard', 'jquery.core', 'jquery.app')); ?>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });

                $(".knob").knob();

            });
        </script>
    </body>
</html>
