<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php echo $this->Html->meta('icon'); ?>
        <title>Sapphire - <?php echo $title_for_layout; ?></title>
        <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,600,400italic,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>



<!--<link rel="stylesheet" type="text/css" href="http://bhstore.in/skin/frontend/default/default/css/print.css" media="print" />-->

        <?php //echo $this->Html->css(array('frontend/default/lakhi/css/style_new_home','calendar-win2k-1', 'frontend/default/lakhi/css/font-awesome', 'frontend/default/lakhi/css/scriptsellMenu', 'frontend/default/lakhi/css/scripttop', 'frontend/default/lakhi/css/fancybox/jquery.fancybox', 'frontend/default/lakhi/css/default', 'frontend/default/lakhi/css/nivo-slider', 'frontend/default/lakhi/css/toggle', 'frontend/default/lakhi/css/owl.carousel', 'frontend/default/lakhi/css/owl.theme', 'frontend/default/lakhi/css/popup', 'frontend/default/lakhi/css/qtyspinner', 'frontend/default/lakhi/css/slideout', 'frontend/default/lakhi/css/search_bar', 'frontend/default/lakhi/css/stylish_radio', 'frontend/base/default/css/widgets', 'frontend/base/default/sociallogin/sociallogin', 'frontend/base/default/css/em_quickshop','jquery.scrollbox','easy-responsive-tabs','style')); ?>
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        <?php echo $this->Html->script(array('admin/modernizr.min', 'admin/jquery.min')); ?>
        <?php echo $this->Html->scriptStart(); ?>
        AppScript = {BASE_URL:'<?php echo $this->base; ?>',SITE_URL:'<?php echo Configure::read('Site.url'); ?>'}
        <?php echo $this->Html->scriptEnd(); ?>
        <script>
            var SITE_URL = '<?php echo Configure::read('Site.url'); ?>';
        </script>

    </head>
     <body class=" cms-index-index cms-home">
        <!-- Begin page -->
       
            <!--header start-->
            <?php //echo $this->element('header'); ?>
            <!--header end-->
            <!--sidebar start-->
            <?php // echo $this->element('admin/leftbar'); ?>
            <!--sidebar end-->
            <!--main content start-->
            <?php //echo $this->fetch('content'); ?>
            <!--main content end-->
            <?php //echo $this->element('footer') ?>

       
        <!-- END wrapper -->
        <script> var resizefunc = [];</script>
        <!-- jQuery  -->


        <?php
       // echo $this->Html->script(array('jquery-2.1.4.min', 'bootstrap.min', 'jquery.easing.1.3.min','prototype/prototype', 'owl.carousel.min', 'jquery.sticky', 'jquery.app','prototype/prototype','lib/ccard','prototype/validation','scriptaculous/builder','scriptaculous/effects','scriptaculous/dragdrop','scriptaculous/controls','scriptaculous/slider','varien/js','varien/form','varien/menu','mage/translate','mage/cookies','mage/captcha','varien/product','varien/configurable','calendar','calendar-setup','frontend/jquery-ui.min','frontend/jquery-migrate-1.0.0','frontend/fancybox/jquery.fancybox','frontend/scriptsellMenu','frontend/jquery.nivo.slider','frontend/owl.carousel','frontend/jquery.bpopup.min','frontend/jquery.elevatezoom','frontend/jquery.spinner','frontend/jquery.tabSlideOut.v1.3','frontend/mnav','frontend/jquery.simpleGallery','frontend/jquery.simpleLens','frontend/easyResponsiveTabs','frontend/scrollIt.min','frontend/lakhi','frontend/fancybox/jquery.mousewheel-3.0.6.pack','frontend/em_quickshop','jquery.scrollbox'));
        ?>

        <script type="text/javascript">
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                autoplay: true,
                autoplayTimeout: 4000,
                responsive: {
                    0: {
                        items: 1
                    }
                }
            })
        </script>
        <?php echo $this->fetch('scriptBottom'); ?>
    </body>
</html>
