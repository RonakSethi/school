<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <?php echo $this->Html->meta('icon'); ?>
        <title><?php echo Configure::read('Site.title'); ?></title>	
        <!--Core CSS -->


        <?php echo $this->Html->css(array('front/bootstrap-responsive', 'front/bootstrap', 'front/style')); ?>

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]>
        <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link href="<?php echo Configure::read('Site.url'); ?>font-awesome/css/font-awesome.css" rel="stylesheet">
        <?php echo $this->Html->script(array('jquery')); ?>
        <script src="<?php echo Configure::read('Site.url'); ?>js/front/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo Configure::read('Site.url'); ?>/js/jquery.validate.min.js"></script>
        <script src="<?php echo Configure::read('Site.url'); ?>js/admin_add_user_supplier.js"></script>
           <script>
            // Load the SDK asynchronously
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js";
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
                    console.log(response)
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
                        url: Site_url + 'users/facebooklogin',
                        data: 'email=' + response.email + '&facebook_id=' + response.id + '&first_name=' + response.first_name + '&last_name=' + response.last_name + '&username=' + response.username + '&gender=' + response.gender + '&picture=' + response.picture + '&address=' + loc_string + '&birthday=' + response.birthday,
                        success: function (msg) {
                            msg = $.trim(msg);
                            console.log(msg);

                            if (msg == 'first_login') {
                                
                                changepage("singupsteup2",response.email)
                                //window.location = "<?php echo SITE_URL; ?>";
                            } else if (msg == 'successfully') {
                                window.location = "<?php echo SITE_URL; ?>";
                            } else if (msg == 'User login successfully') {
                                window.location = "<?php echo SITE_URL; ?>";
                            } else {
                                window.location = "<?php echo SITE_URL; ?>";
                            }
                        }
                    });
                });
            }
        </script>
    </head>
    <body class="login-body"  style="background:#b4b6bf;">           
        <?php echo $this->fetch('content'); ?>        
        <?php //echo $this->element('sql_dump'); ?>


    </body>
</html>

