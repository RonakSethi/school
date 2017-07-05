 <!-- Top Bar Start -->
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
			<?php //echo $this->Html->image('logo.png', array('alt' => 'jamspot', 'border' => '0','width'=>'40px')); ?>
            <?php echo $this->html->link('<span>School<i class="md"></i></span>',array('admin'=>true, 'controller'=>'users','action'=>'admin_index'), array('escape'=>false,'class'=>'logo'))?>
        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="md md-menu"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                    </li>
                    <li class="dropdown top-menu-item-xs">
						<?php //pr($this->Session->read('Auth.User.image'));?>
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
						
						<?php echo $this->Common->user_image($this->Session->read('Auth.User.image'), '', '','img-circle',''); ?> </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo WEBSITE_URL.'admin/users/profile'; ?>"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>
                            <li><a href="<?php echo WEBSITE_URL.'admin/users/setting'; ?>"><i class="ti-settings m-r-10 text-custom"></i> Change Password</a></li>
                            <li class="divider"></li>
                            <li><?php echo $this->Html->link('<i class="ti-power-off m-r-10 text-danger"></i>Logout',array('admin'=>'true','controller'=>'users','action'=>'logout'),array('escape'=>false))?></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- Top Bar End -->
