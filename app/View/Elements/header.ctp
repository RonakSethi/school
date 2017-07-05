<div id="eEmail" style="display:none">
    <div id="emodal">
        <div class="etopp">
            <h4>EMAIL FOR PRICE</h4>
            <div class="eclose-icon"><a href="javascript:void(0)" onClick="return closeEmailPopup()" class=""><img src="skin/frontend/default/lakhi/images/cross_icon.png"></a></div>
        </div>
        <div class="ebottom">
            <form name="emailforpriceform" id="emailforpriceform" method="post">
                <div class="erightt">
                    <span style="color:#002FA7;display: none;clear:both" id="thanks">Your request has been submitted.</span>
                    <h5 id="skudisplay">SKU Code: </h5>
                    <input name="fname" id="efname" type="text" class="efive-input" placeholder="First Name*" >
                    <input name="lname" id="elname" type="text" class="esix-input" placeholder="Last Name*" >
                    <input name="email" id="eemail" type="text" class="eseven-input" placeholder="Email*" >
                    <input name="country" id="ecountry" type="text" class="efive-input" placeholder="Country*" >
                    <input name="city" id="ecity" type="text" class="esix-input" placeholder="City*" >
                    <input name="phone" id="ephone" type="text" class="eseven-input" placeholder="Phone Number*" >
                    <textarea name="query" id="comments" cols="" rows="" class="eeight-input" placeholder="Massage*"></textarea>
                    <input name="epname" id="epname" type="hidden" class="ap_textfield" value="">
                    <input name="esku" id="esku" type="hidden" class="ap_textfield"  value="">
                    <div class="ermad">          
                        <input name="submit" type="button" class="enine-input" value="Submit" onclick="sendProductemail();">
                        <input name="back" type="button" class="enine-input" onClick="return closeEmailPopup()" value="Back">
                    </div>
                </div>
            </form>
            <div class="eleftt">
                <div class="eaddrs">
                    <p><span>Address :</span> <br> 
                        75, Gopal Ji ka Rasta, Johari Bazar,<br> 
                        Jaipur, Rajasthan - India 302003
                    </p>
                    <i class="fa fa-map-marker"></i>
                </div>
                <div class="eaddrs">
                    <p><span>Direct Numbers :</span><br> 
                        +91 7023333719 (Vaibhav Lakhi)<br>
                        +91 9887433358 (Vishnu Bundela)
                    </p>
                    <i class="fa fa-tablet"></i>
                </div>
                <div class="eaddrs">
                    <p><span>Telephone :</span> +91-141-4082222  
                    </p>
                    <i class="fa fa-phone"></i>
                </div>
                <div class="eaddrs">
                    <p><span>Ext. :</span> 11 , 16(Monday to Saturday 11am-8pm IST)
                    </p>
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="eaddrs">
                    <p><span>Email :</span> sales@bhstore.in
                    </p>
                    <i class="fa fa-envelope"></i>
                </div>
            </div>
        </div>

    </div>
</div>



<div id="eAskQuestion" style="display:none">
    <div id="emodal">
        <div class="etopp">
            <h4>ASK YOUR QUESTION</h4>
            <div class="eclose-icon"><a href="javascript:void(0)" onClick="return closeAskPopup()" class=""><img src="skin/frontend/default/lakhi/images/cross_icon.png"></a></div>
        </div>
        <div class="ebottom">
            <form name="emailforpriceform" id="aemailforpriceform" method="post">
                <div class="erightt">
                    <span style="color:#e74847;display: none;clear:both" id="athanks">Your request has been submitted.</span>
                    <h5 id="askudisplay">SKU Code: </h5>
                    <input name="fname" id="aefname" type="text" class="efive-input" placeholder="First Name*" >
                    <input name="lname" id="aelname" type="text" class="esix-input" placeholder="Last Name*" >
                    <input name="email" id="aeemail" type="text" class="eseven-input" placeholder="Email*" >
                    <input name="country" id="aecountry" type="text" class="efive-input" placeholder="Country*" >
                    <input name="city" id="aecity" type="text" class="esix-input" placeholder="City*" >
                    <input name="phone" id="aephone" type="text" class="eseven-input" placeholder="Phone Number*" >
                    <textarea name="query" id="acomments" cols="" rows="" class="eeight-input" placeholder="Massage*"></textarea>
                    <input name="epname" id="aepname" type="hidden" class="ap_textfield" value="">
                    <input name="esku" id="aesku" type="hidden" class="ap_textfield"  value="">
                    <div class="ermad">          
                        <input name="submit" type="button" class="enine-input" value="Submit" onclick="sendAskemail();">
                        <input name="back" type="button" class="enine-input" onClick="return closeAskPopup()" value="Back">
                    </div>
                </div>
            </form>
            <div class="eleftt">
                <div class="eaddrs">
                    <p><span>Address :</span> <br> 
                        75, Gopal Ji ka Rasta, Johari Bazar,<br> 
                        Jaipur, Rajasthan - India 302003
                    </p>
                    <i class="fa fa-map-marker"></i>
                </div>
                <div class="eaddrs">
                    <p><span>Direct Numbers :</span><br> 
                        +91 7023333719 (Vaibhav Lakhi)<br>
                        +91 9887433358 (Vishnu Bundela)
                    </p>
                    <i class="fa fa-tablet"></i>
                </div>
                <div class="eaddrs">
                    <p><span>Telephone :</span> +91-141-4082222  
                    </p>
                    <i class="fa fa-phone"></i>
                </div>
                <div class="eaddrs">
                    <p><span>Ext. :</span> 11 , 16(Monday to Saturday 11am-8pm IST)
                    </p>
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="eaddrs">
                    <p><span>Email :</span> sales@bhstore.in
                    </p>
                    <i class="fa fa-envelope"></i>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- banner -->
<script>jQuery(function () {
        jQuery.scrollIt();
    });</script>
<script>
    jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() >= 1) {
            jQuery('#header').addClass('fixed-header');
        }
        else {
            jQuery('#header').removeClass('fixed-header');
        }
    });
</script>
<!--=======login=========-->
<div id="button_to_pop_up" style="display:none">
    <div id="modal">
        <div class="close-icon"><a href="#" onClick="return closePop()" class=""><img src="skin/frontend/default/lakhi/images/cross.png"></a></div>
        <div class="loginpopup">
            <h4>User Login</h4>
            <div class="loginpopup_form">
                <form action="http://bhstore.in/index.php/customer/account/loginPost/" method="post" id="login-form">
                    <input name="form_key" type="hidden" value="NDb76WyA3tYeOr7B" />
                    <input name="login[username]" id="email" type="text" class="loginpopup_field" required="required" placeholder="Email Address">
                    <input name="login[password]" id="pass" type="password" class="loginpopup_field" required="required" placeholder="Password">
                    <a href="#" class="loginpopup_forgot">Forget Password</a>
                    <input name="send" id="send2" type="submit" class="loginpopup_form_button" value="login">
                </form>
            </div>
            <div class="social_share">
                <h5>Login With?</h5>
                <ul style="margin-top:30px;">
                    <li><a href="#"><img src="skin/frontend/default/lakhi/images/login_with_facebook.png" alt="facebook"></a></li>
                    <li><a href="#"><img src="skin/frontend/default/lakhi/images/login_with_twitter.png" alt="twiiter"></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--=======Registration Start=========-->
<div id="registration_popup" style="display:none">
    <div id="modal">
        <div class="close-icon"><a href="#" onClick="return closePopRefistration()" class=""><img src="skin/frontend/default/lakhi/images/cross.png"></a></div>
        <div class="loginpopup">
            <h4>Registration</h4>
            <div class="loginpopup_form">
                <form action="http://bhstore.in/index.php/customer/account/createpost/" method="post" id="form-validate">
                    <input type="hidden" name="success_url" value="" />
                    <input type="hidden" name="error_url" value="" />
                    <input name="form_key" type="hidden" value="NDb76WyA3tYeOr7B" />

                    <input name="firstname" id="firstname" type="text" class="loginpopup_field" required="required" placeholder="First Name">
                    <input name="lastname" id="email" type="text" class="loginpopup_field" required="required" placeholder="Last Name">
                    <input name="email" id="email_address" type="text" class="loginpopup_field" required="required" placeholder="Email Address">
                    <input name="password" id="password" type="password" class="loginpopup_field" required="required" placeholder="Password">
                    <input name="confirmation" id="confirmation" type="password" class="loginpopup_field" required="required" placeholder="Confirm Password">
                    <input name="send" id="send2" type="submit" class="loginpopup_form_button" value="Submit">
                </form>
                <script type="text/javascript">
                    //<![CDATA[
                    var dataForm = new VarienForm('login-validate', true);
                    //]]>
                </script>
            </div>
        </div>
    </div>
</div>
<!--=======Registration End=========-->

<header>
    <div id="header" class=""> 
        <!-- top bar -->
        <div class="head_top">
            <div class="container"> 
                <!-- top link -->
                <div class="top_link pull-left">
                    <ul>
                        <li><a href="http://bhstore.in/">Home</a></li>
                        <li><a href="http://bhstore.in/about-us">About</a></li>
                        <li><a href="http://bhstore.in/faq">Faq's</a></li>
                    </ul>
                </div>
                <div class="top_link">
                    <ul>
                        <li><a href="http://sapphirejewels.in/customer/account/login/">MYSJ LOGIN</a></li>
                        <li class="register-main"><a href="http://sapphirejewels.in/customer/account/create/">Registration</a></li>

<!-- <li><a href="http://bhstore.in/checkout/cart/">VIEW CART (0) <i class="fa fa-shopping-cart"></i>

</a></li>-->
                        <li class="currency_li">        Currency        <select name="currency" title="Select Your Currency" onchange="setLocation(this.value)">
                                <option value="http://bhstore.in/directory/currency/switch/currency/AUD/uenc/aHR0cDovL2Joc3RvcmUuaW4v/">
                                    AUD            </option>
                                <option value="http://bhstore.in/directory/currency/switch/currency/BND/uenc/aHR0cDovL2Joc3RvcmUuaW4v/">
                                    BND            </option>
                                <option value="http://bhstore.in/directory/currency/switch/currency/EUR/uenc/aHR0cDovL2Joc3RvcmUuaW4v/">
                                    EUR            </option>
                                <option value="http://bhstore.in/directory/currency/switch/currency/HKD/uenc/aHR0cDovL2Joc3RvcmUuaW4v/">
                                    HKD            </option>
                                <option value="http://bhstore.in/directory/currency/switch/currency/INR/uenc/aHR0cDovL2Joc3RvcmUuaW4v/" selected="selected">
                                    INR            </option>
                                <option value="http://bhstore.in/directory/currency/switch/currency/NZD/uenc/aHR0cDovL2Joc3RvcmUuaW4v/">
                                    NZD            </option>
                                <option value="http://bhstore.in/directory/currency/switch/currency/USD/uenc/aHR0cDovL2Joc3RvcmUuaW4v/">
                                    USD            </option>
                            </select>
                        </li>
                        <li>
                            <!--<form id="search_mini_form" action="http://bhstore.in/catalogsearch/result/" method="get">
<div class="form-search">
    <label for="search">Search:</label>
    <input id="search" type="text" name="q" value="" class="input-text" maxlength="128" />
    <button type="submit" title="Search" class="button"><span><span>Search</span></span></button>
    <div id="search_autocomplete" class="search-autocomplete"></div>
    <script type="text/javascript">
    //<![CDATA[
        var searchForm = new Varien.searchForm('search_mini_form', 'search', 'Search entire store here...');
        searchForm.initAutocomplete('http://bhstore.in/catalogsearch/ajax/suggest/', 'search_autocomplete');
    //]]>
    </script>
</div>
</form>-->

                            <form id="demo-2" action="http://bhstore.in/catalogsearch/result/" method="get">

                                <input placeholder="Search" id="search" name="q" value="" class="input-text" maxlength="128" type="search">
                                <button style="display:none" type="submit" title="Search" class="button"><span><span>Search</span></span></button>
                                <script type="text/javascript">
                                    //&lt;![CDATA[
                                    var searchForm = new Varien.searchForm('demo-2', 'search', 'Search');
                                    //searchForm.initAutocomplete('http://bhstore.in/catalogsearch/ajax/suggest/', 'search_autocomplete');
                                    //]]&gt;
                                </script>
                            </form>
                            <!--<form id="demo-2">
                                <input type="search" placeholder="Search">
                            </form>-->
                        </li>
                    </ul>
                </div>
                <!-- top link --> 
            </div>
        </div>
        <!-- top bar --> 

        <!-- head mid -->
        <div class="container">
            <div class="head_mid"> 
                <a href="http://sapphirejewels.in/" class="logo">
                    <img src="http://sapphirejewels.in/img/logo.png" alt="http://sapphirejewels.in/"></a> 

                <div class="cart-new">
                    <img src="http://bhstore.in/skin/frontend/default/lakhi/images/cart-new.png"> <a href="#_">0 item(s) - $0.00</a> </div>
                <img src="http://bhstore.in/skin/frontend/default/lakhi/images/head_tag.png" alt="tag" class="tag">
            </div>
        </div>
        <!-- head mid --> 

        <!-- navigation -->
        <div id="nav_bar">
            <div class="container">
                <nav>
                    <div class="navigaton">
                        <div class="menu-toggle-button inactive-devices light-brown" style="min-height: 37px; line-height: 37px;"><span>?</span></div><ul class="nav1 nav light-brown" style="min-height: 37px;">
                            <li class="submenu"><span class="hover" style="height: 38px; bottom: 0px; display: none;"></span><a href="#_" style="line-height: 37px;">Gemstones <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdownmenu" style="min-width: 250px; display: none;">
                                    <li class="submenu"><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/ruby.html" style="line-height: 37px;">Ruby ( Manik )</a>
                                        <ul class="dropdownmenu" style="min-width: 250px; display: none;">
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/ruby/burma-ruby.html" style="line-height: 37px;">Burma Ruby</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/ruby/mozambique-ruby.html" style="line-height: 37px;">Mozambique Ruby</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/ruby/madagascar.html" style="line-height: 37px;">Madagascar Ruby</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/ruby/tajikistan.html" style="line-height: 37px;">Tajikistan Ruby</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/ruby/thailand-ruby.html" style="line-height: 37px;">Thailand Ruby</a></li>
                                        </ul>
                                        <i class="arrow" style="top: 17px;"></i></li>
                                    <li class="submenu"><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/sapphire.html" style="line-height: 37px;">Sapphire</a>
                                        <ul class="dropdownmenu" style="min-width: 250px; display: none;">
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/sapphire/blue-sapphire.html" style="line-height: 37px;">Blue Sapphire (Neelam)</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/sapphire/yellow-sapphire.html" style="line-height: 37px;">Yellow Sapphire (Pukhraj)</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/sapphire/orange-sapphire.html" style="line-height: 37px;">Orange Sapphire</a></li>
                                        </ul>
                                        <i class="arrow" style="top: 17px;"></i></li>
                                    <li class="submenu"><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/emerald.html" style="line-height: 37px;">Emerald ( Panna )</a>
                                        <ul class="dropdownmenu" style="min-width: 250px; display: none;">
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/emerald/emerald.html" style="line-height: 37px;">Zambia Emerald</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/emerald/colombian.html" style="line-height: 37px;">Colombian Emerald</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/emerald/brazil.html" style="line-height: 37px;">Brazil Emerald</a></li>
                                        </ul>
                                        <i class="arrow" style="top: 17px;"></i></li>
                                    <li class="submenu"><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/pearl.html" style="line-height: 37px;">Pearl ( Moti )</a>
                                        <ul class="dropdownmenu" style="min-width: 250px; display: none;">
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/pearl/basra-pearl.html" style="line-height: 37px;">Basra Pearl</a></li>
                                        </ul>
                                        <i class="arrow" style="top: 17px;"></i></li>
                                    <li class="submenu"><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/hessonite-gomed.html" style="line-height: 37px;">Hessonite (Gomed)</a>
                                        <ul class="dropdownmenu" style="min-width: 250px; display: none;">
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/hessonite-gomed/sri-lanka.html" style="line-height: 37px;">Sri Lanka Hessonite (Gomed)</a></li>
                                        </ul>
                                        <i class="arrow" style="top: 17px;"></i></li>
                                    <li class="submenu"><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/coral-moonga.html" style="line-height: 37px;">Coral (Moonga)</a>
                                        <ul class="dropdownmenu" style="min-width: 250px; display: none;">
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/coral-moonga/red-coral.html" style="line-height: 37px;">Red Coral</a></li>
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/coral-moonga/white-coral.html" style="line-height: 37px;">White Coral</a></li>
                                        </ul>
                                        <i class="arrow" style="top: 17px;"></i></li>
                                    <li class="submenu"><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/cat-s-eye-lehsunia.html" style="line-height: 37px;">Cats Eye ( Lehsunia )</a>
                                        <ul class="dropdownmenu" style="min-width: 250px; display: none;">
                                            <li><span class="hover" style="height: 0px; bottom: 0px;"></span><a href="http://bhstore.in/cat-s-eye-lehsunia/cat-s-eye-lehsunia.html" style="line-height: 37px;">Cats Eye ( Lehsunia )</a></li>
                                        </ul>
                                        <i class="arrow" style="top: 17px;"></i></li>
                                </ul>
                                <i class="arrow" style="top: 17px;"></i></li>
                            <li><span class="hover" style="height: 37px; bottom: 0px; display: none; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;"></span><a href="#" style="line-height: 37px;">Jewelry</a></li>
                            <li><span class="hover" style="height: 174px; bottom: 0px;"></span><a href="http://bhstore.in/our-certifications" style="line-height: 37px;">Our Certifications</a></li>
                            <li><span class="hover" style="height: 164px; bottom: 0px;"></span><a href="http://bhstore.in/astrological-use" style="line-height: 37px;">Astrological Use</a></li>
                            <li><span class="hover" style="height: 71px; bottom: 0px;"></span><a href="http://bhstore.in/blog" style="line-height: 37px;">Blog</a></li>
                            <li><span class="hover" style="height: 76px; bottom: 0px;"></span><a href="#" class="foc" style="line-height: 37px;">Deals</a></li>
                            <li><span class="hover" style="height: 119px; bottom: 0px;"></span><a href="http://bhstore.in/contacts" style="line-height: 37px;">Contact Us</a></li>

                        </ul>
                    </div>
                </nav>
                <div class="advance-search"><a href="#_">Advance Search</a></div>
            </div>
        </div>
        <!-- navigation --> 
    </div>
</header>
