<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php echo $this->Html->meta('icon'); ?>
        <title>Administrator - <?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->css(array('admin/bootstrap.min', 'admin/core', 'admin/components','admin/icons','admin/pages','admin/responsive')); ?>
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <?php echo $this->Html->script(array('admin/modernizr.min')); ?>

        <?php echo $this->Html->scriptStart(); ?>
        AppScript = {BASE_URL:'<?php echo $this->base; ?>',SITE_URL:'<?php echo Configure::read('Site.url'); ?>'}
        <?php echo $this->Html->scriptEnd(); ?>
         <script src="<?php // echo Configure::read('Site.url'); ?>js/facebook-all.js"></script>
        <script src="<?php echo Configure::read('Site.url'); ?>js/platform.js" async defer></script>
         
        <script>
		var SITE_URL = '<?php echo Configure::read('Site.url'); ?>';
	
            // Load the SDK asynchronously
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://connect.facebook.net/en_US/all.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            var Site_url = "<?php echo Configure::read('Site.url'); ?>";

            //for facebook user login script
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '<?php echo FACEBOOK_APP_ID; ?>',
                    oauth: true,
                    status: true, // check login status
                    cookie: true, // enable cookies to allow the server to access the session
                    xfbml: true // parse XFBML
                });
            };
            var bool = true;

            function fb_login() {
              FB.login(function (response) {
                    if (response.authResponse) {
                        //access_token = response.authResponse.accessToken; //get access token
                        user_id = response.authResponse.userID; //get FB UID
                        FB.api('/me/permissions ', function (response) {
                            //console.log(response);

                            if (bool) {
                                //console.log(response);
                                fb_login_check(response);
                            }
                            return false;
                        });
                    } else {
                        //user hit cancel button
                        console.log('User cancelled login or did not fully authorize.');
                    }
                },
                        {
                            scope: 'public_profile,email,user_location,user_birthday,user_friends,manage_pages'
                        });
            }

            function fb_login_check(response) {
                FB.api('/me?fields=id,name,email,first_name,last_name,picture,gender', function (response) {
                    console.log(response);
                    console.log(Site_url + 'users/facebooklogin');

                    var loc_string = '';
                    $.ajax({
                        type: 'POST',
                        url: Site_url + 'admin/users/facebooklogin',
                        data: 'email=' + response.email + '&facebook_id=' + response.id + '&first_name=' + response.first_name + '&last_name=' + response.last_name + '&username=' + response.username + '&gender=' + response.gender + '&picture=' + response.picture + '&address=' + loc_string + '&birthday=' + response.birthday,
                        success: function (msg) {
                            msg = $.trim(msg);
                            console.log(msg);

                            if (msg == 'first_login') {
                                window.location = Site_url;
                               // changepage("singupsteup2",response.email)
                              
                            } else if (msg == 'successfully') {
                                window.location = Site_url;
                            } else if (msg == 'User login successfully') {
                                window.location = Site_url;
                            } else {
                                window.location = Site_url;
                            }
                        }
                    });
                });
            }
        </script>
    </head>
    <body>
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <?php echo $this->fetch('content'); ?>
        </div>
    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
		<?php echo $this->Html->script(array('admin/jquery.min','admin/jquery.validate.min','admin/formValidations','admin/bootstrap.min','admin/detect','admin/fastclick','admin/jquery.slimscroll','admin/jquery.blockUI','admin/waves','admin/wow.min','admin/jquery.nicescroll','admin/jquery.scrollTo.min','admin/jquery.core','admin/jquery.app')); ?>
	</body>
</html>
