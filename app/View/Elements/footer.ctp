    
<script>
    function sendfeedbackemail() {

        //var e = $(evt);
        //console.log(e);


        var name = jQuery('#fname').val();
        var email = jQuery('#femail').val();
        var comments = jQuery('#fmessage').val();

        var error_msg = '';
        if (name == '') {
            error_msg += 'Please enter your name.' + '</br>';
        }
        if (email == '') {
            error_msg += 'Please enter Email Id.' + '</br>';
        }

        if (email != '' && !IsEmail(email)) {
            error_msg += 'Please enter valid Email Id.' + '</br>';
        }

        if (comments == '') {
            error_msg += 'Please enter feedback.' + '</br>';
        }

        if (error_msg != '') {
            jQuery('#feedbackthanks').html('');
            jQuery('#feedbackthanks').html(error_msg);
            jQuery('#feedbackthanks').show();
            return false;
        }


        /*if(name == '')
         e.preventDefault();	
         if(email == '')
         e.preventDefault();	
         if(comments == '')
         e.preventDefault();	*/


        if (name != '' && email != '' && comments != '') {

            var URL = 'sendfeedbackemail.html';
            var formData = {name: name, email: email, comments: comments};
            jQuery.post(URL,
                    formData,
                    function (data, textStatus, jqXHR)
                    {

                        jQuery('#feedbackthanks').html('Thanks for Feeback');
                        jQuery('#fname').val('');
                        jQuery('#femail').val('');
                        jQuery('#fmessage').val('');
                    }).fail(function (jqXHR, textStatus, errorThrown)
            {

            });
        }
        return false;
    }

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

</script>


<div class="certificat_section">
    <div class="container">
        <h4 class="cs_title">Our Certifications</h4>
        <div class="cs_slide">
            <div id="owl-demo" class="owl-carousel third">
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/grs.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/gubelin.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/edia/wysiwyg/new_clogo/igi.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/agl.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/gii.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/itlgj.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/cd.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/ssef.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/gia.jpg" alt="cslogo" /></div>
                </div>
                <div class="item">
                    <div class="cs_logo"><img src="img/media/wysiwyg/new_clogo/international.jpg" alt="cslogo" /></div>
                </div>            </div>
        </div>
    </div>
</div>

<footer>
    <div id="footer">
        <div class="payment">
            <div class="container">
                <div class="pay_option">
                    <ul>
                        <li>We Accept</li>
                        <li><a href="#"><img src="skin/frontend/default/lakhi/images/payment_icon.png" alt="payment"></a></li>
                    </ul>
                </div>
                <div class="delivery">
                    <p><a href="#_"><img src="img/media/wysiwyg/courier_icon.jpg" alt="courier" /></a></p>                </div>
            </div>
        </div>
        <div class="member">
            <div class="container">
                <div class="pay_option">
                    <ul>
                        <li class="space">Member :</li>
                        <li><a href="#_"><img src="img/media/wysiwyg/member_logo.jpg" alt="member" /></a></li>
                        <li><a href="#_"><img src="img/media/wysiwyg/member2_logo.jpg" alt="member" /></a></li>
                    </ul>
                </div>
                <div class="insure"><img src="skin/frontend/default/lakhi/images/insure_icon.png" alt="insure">Free insured shipping over <span>$300,</span> 30 Day Return & many more</div>
            </div>
        </div>
        <div class="container">
            <div class="foot_link">
                <h4>Information</h4>
                <ul>
                    <li><a href="about-us.html"><em class="fa fa-angle-double-right"></em>About Us</a></li>
                    <li><a href="shipping-return-policy.html"><em class="fa fa-angle-double-right"></em>Shipping &amp; Returns Policy</a></li>
                    <li><a href="privacy-policy.html"><em class="fa fa-angle-double-right"></em>Privacy Policy</a></li>
                    <li><a href="terms-conditions.html"><em class="fa fa-angle-double-right"></em>Terms &amp; Conditions</a></li>
                    <li><a href="our-certifications.html"><em class="fa fa-angle-double-right"></em>Our Certifications</a></li>
                </ul>
            </div>
            <div class="foot_link">
                <h4>Customer Service</h4>
                <ul>
                    <li><a href="contacts.html"><em class="fa fa-angle-double-right"></em>Contact Us</a></li>
                    <li><a href="contacts.html"><em class="fa fa-angle-double-right"></em>Make an Enquiry</a></li>
                    <li><a href="sitemap.html"><em class="fa fa-angle-double-right"></em>Site Map</a></li>
                </ul>
            </div>            <div class="foot_link">
                <h4>Contact Us</h4>
                <p><em class="fa fa-map-marker"></em><span>Sapphire Jewellers, Rasta Gopal ji, Johari Bazar, Jaipur-302003 ( Rajasthan ) INDIA</span></p>
                <p><em class="fa fa-envelope"></em><a href="mailto:info@sapphirejewels.in">info@sapphirejewels.in</a></p>
                <p><em class="fa fa-phone"></em>0141-4082222, 2571110</p>
                <p><em class="fa fa-fax"></em>0141-4082220, 2575848</p>            </div>
        </div>
        <div class="foot_bottom">
            <div class="container">
                <p> &copy; <?php echo date("Y") ?> www.sapphirejewels.in</p>
                <div class="foot_social">
                    <ul>
                        <li>Follow Us :-</li>
                        <li><a href="https://www.facebook.com/people/Biharilal-Holaram/100009420566492" class="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://plus.google.com/115023138570181595474/about" class="google" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" class="twittter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--*****feedback******-->
        <div id="contactFormContainer">
            <div id="contactLink"></div>
            <div id="contactForm">
                <form name="feedback_form" id="feedback_form" method="post">
                    <fieldset>
                        <p style="text-align:center;color:white;display:none;" id="feedbackthanks"> Thanks for the feedback</p>
                        <label for="fname">Name <em>*</em></label>
                        <input id="fname" type="text"  />
                        <label for="femail">Email address <em>*</em></label>
                        <input id="femail" type="email" />
                        <label for="fmessage">Your message <em>*</em></label>
                        <textarea id="fmessage" rows="3" cols="20" ></textarea>
                        <input id="sendMail" type="submit" name="submit" onclick="return sendfeedbackemail()" />
                    </fieldset>
                </form>
            </div>
        </div>
        <!--*****feedback******--> 
    </div>
</footer>

<!--*****help******-->
<div class="slide-out-div"> <a class="handle" href="#_"></a>
    <div class="callus"> <i class="fa fa-phone"></i>
        <p> call us on<span>+91 9887433358</span> 
            Timing: Mon-Sat. 11am - 8pm </p>
    </div>
    <div class="callus"> <i class="fa fa-map-marker"></i>
        <p> Sapphire Jewellers,  Rasta Gopal ji, Johari Bazar, Jaipur-302003    ( Rajasthan ) INDIA </p>
    </div>
    <div class="callus"> <i class="fa fa-envelope-o"></i>
        <p> <a href="mailto:contact@sapphirejewels.in">contact@sapphirejewels.in</a> </p>
    </div>
</div>
<!--*****help******-->                 

