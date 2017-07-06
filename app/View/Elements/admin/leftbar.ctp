<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>
                <li class="text-muted menu-title">Navigation</li>
               

                <!-- Only for super admin type users -->
                <?php if ($this->Session->read('Auth.User.role_id') == 1) { ?>

                 <!-- li class="">
                    <?php
                   // $activeClass = ( isset($leftnav) && $leftnav == 'dashboard') ? 'subdrop' : '';
                    //echo $this->html->link('<i class="ti-home"></i> <span> Dashboard </span>', array('admin' => true, 'controller' => 'users', 'action' => 'dashboard'), array('escape' => false, 'class' => 'waves-effect' . $activeClass))
                    ?>
                </li -->
                    <!--USER MANAGER-->

                    <li class="has_sub">
                        <?php
                        $activeClass = ( isset($leftnav) && $leftnav == 'schools') ? 'subdrop' : '';
                        echo $this->html->link('<i class="md md-directions-car"></i> <span> Schools </span><span class="menu-arrow"></span>', 'javascript:void(0);', array('escape' => false, 'class' => 'waves-effect ' . $activeClass))
                        ?>
                        <ul class="list-unstyled">
                            <?php $activeSubClass = ( isset($subleftnav) && $subleftnav == 'schoolList') ? 'active' : ''; ?>
                            <li class="<?php echo $activeSubClass; ?>">
                                <?php echo $this->html->link('Listings', array('admin' => true, 'controller' => 'users', 'action' => 'admin_schools'), array('class' => $activeSubClass)) ?>
                            </li>
                        </ul>
                    </li>
                   
                    <!--Enquiry MANAGER-->

                  

                   
                    
                    <!--EMAIL TEMPLATES-->
                    <li class="has_sub">
                        <?php
                        $activeClass = ( isset($leftnav) && $leftnav == 'email_templates') ? 'subdrop' : '';
                        echo $this->html->link('<i class="md md-email"></i> <span> Email Templates </span><span class="menu-arrow"></span>', '' . WEBSITE_URL . 'admin/email_templates', array('escape' => false, 'class' => 'waves-effect ' . $activeClass))
                        ?>
                    </li>

                <?php } 
                //for Schools
                if($this->Session->read('Auth.User.role_id') == 2) { ?>
                     <li class="has_sub">
                        <?php
                        $activeClass = ( isset($leftnav) && $leftnav == 'parents') ? 'subdrop' : '';
                        echo $this->html->link('<i class="md md-directions-car"></i> <span> Parents </span><span class="menu-arrow"></span>', 'javascript:void(0);', array('escape' => false, 'class' => 'waves-effect ' . $activeClass))
                        ?>
                        <ul class="list-unstyled">
                            <?php $activeSubClass = ( isset($subleftnav) && $subleftnav == 'parentsList') ? 'active' : ''; ?>
                            <li class="<?php echo $activeSubClass; ?>">
                                <?php echo $this->html->link('Listings', array('admin' => true, 'controller' => 'users', 'action' => 'admin_parents'), array('class' => $activeSubClass)) ?>
                            </li>
                            <li class="<?php echo $activeSubClass; ?>">
                                <?php echo $this->html->link('Add Parent', array('admin' => true, 'controller' => 'users', 'action' => 'admin_add_parent'), array('class' => $activeSubClass)) ?>
                            </li>
                        </ul>
                    </li>
                     <li class="has_sub">
                        <?php
                        $activeClass = ( isset($leftnav) && $leftnav == 'buses') ? 'subdrop' : '';
                        echo $this->html->link('<i class="md md-directions-car"></i> <span> Buses </span><span class="menu-arrow"></span>', 'javascript:void(0);', array('escape' => false, 'class' => 'waves-effect ' . $activeClass))
                        ?>
                        <ul class="list-unstyled">
                            <?php $activeSubClass = ( isset($subleftnav) && $subleftnav == 'view_bus') ? 'active' : ''; ?>
                            <li class="<?php echo $activeSubClass; ?>">
                                <?php echo $this->html->link('Listings', array('admin' => true, 'controller' => 'buses', 'action' => 'admin_index'), array('class' => $activeSubClass)) ?>
                            </li>
                           
                        </ul>
                    </li>
                     <li class="has_sub">
                        <?php
                        $activeClass = ( isset($leftnav) && $leftnav == 'trips') ? 'subdrop' : '';
                        echo $this->html->link('<i class="md md-directions-car"></i> <span> Bus Routes </span><span class="menu-arrow"></span>', 'javascript:void(0);', array('escape' => false, 'class' => 'waves-effect ' . $activeClass))
                        ?>
                        <ul class="list-unstyled">
                            <?php $activeSubClass = ( isset($subleftnav) && $subleftnav == 'view_route') ? 'active' : ''; ?>
                            <li class="<?php echo $activeSubClass; ?>">
                                <?php echo $this->html->link('Listings', array('admin' => true, 'controller' => 'trips', 'action' => 'admin_index'), array('class' => $activeSubClass)) ?>
                            </li>
                            
                        </ul>
                    </li>
                
               <?php }
                ?>

                <!--  ADMIN   -->
               
                
                <!--STATIC PAGES  MANAGER-->

                    <li class="has_sub">
                        <?php
                        $activeClass = ( isset($leftnav) && $leftnav == 'static') ? 'subdrop' : '';
                        echo $this->html->link('<i class="fa fa-user"></i> <span> Static Pages </span><span class="menu-arrow"></span>', array('admin' => true, 'controller' => 'pages', 'action' => 'index'), array('escape' => false, 'class' => 'waves-effect ' . $activeClass))
                        ?>
                    </li>
                  <!--LOGOUT-->
                    <li>
                        <?php echo $this->html->link('<i class="ti-power-off m-r-10 text-danger"></i> <span> Logout </span>', '' . WEBSITE_URL . 'admin/users/logout', array('escape' => false, 'class' => 'waves-effect')) ?>
                    </li>

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->
