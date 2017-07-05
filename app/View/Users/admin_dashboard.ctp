<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <!-- Page-Title -->
            <!--div class="row">
                <div class="col-sm-12">
                    <div class="btn-group pull-right m-t-15">
                        <button type="button" class="btn btn-default dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                        <ul class="dropdown-menu drop-menu-right" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>

                    <h4 class="page-title">Dashboard 4</h4>
                    <p class="text-muted page-title-alt">Welcome to Ubold admin panel !</p>
                </div>
            </div-->

            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="card-box widget-box-1 bg-white">
                        <i class="fa fa-info-circle text-muted pull-right inform" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="total no of studio owners  at jamspot"></i>
                        <h4 class="text-dark">Studio Owners</h4>
                        <h2 class="text-primary text-center"><span data-plugin="counterup"><?php echo $totalStudiosOwner;?></span></h2>
                       
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="card-box widget-box-1 bg-white">
                        <i class="fa fa-info-circle text-muted pull-right inform" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="total no of customers at jamspot"></i>
                        <h4 class="text-dark">Customers</h4>
                        <h2 class="text-pink text-center"><span data-plugin="counterup"><?php echo $totalCustomer;?></span></h2>
                        
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="card-box widget-box-1 bg-white">
                        <i class="fa fa-info-circle text-muted pull-right inform" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="total no of studios at jamspot"></i>
                        <h4 class="text-dark">Studios</h4>
                        <h2 class="text-success text-center"><span data-plugin="counterup"><?php echo $totalStudios;?></span></h2>
                        
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="card-box widget-box-1 bg-white">
                        <i class="fa fa-info-circle text-muted pull-right inform" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="total no of bookings at jamspot"></i>
                        <h4 class="text-dark">Bookings</h4>
                        <h2 class="text-warning text-center"><span data-plugin="counterup"><?php echo $DeclineRequests;?></span></h2>
                       
                    </div>
                </div>

            </div>

            <!-- BAR Chart -->
<!--            <div class="row">
                <div class="col-lg-6">
                    <div class="portlet">
                       
                        <div class="portlet-heading">
                            <h3 class="portlet-title text-dark"> Total Revenue </h3>
                            <div class="portlet-widgets">
                                <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                <span class="divider"></span>
                                <a data-toggle="collapse" data-parent="#accordion1" href="#bg-default1"><i class="ion-minus-round"></i></a>
                                <span class="divider"></span>
                                <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="bg-default1" class="panel-collapse collapse in">
                            <div class="portlet-body">
                                <div class="text-center">
                                    <ul class="list-inline chart-detail-list">
                                        <li>
                                            <h5><i class="fa fa-circle m-r-5" style="color: #3ac9d6;"></i>Series A</h5>
                                        </li>
                                        <li>
                                            <h5><i class="fa fa-circle m-r-5" style="color: #f9c851;"></i>Series B</h5>
                                        </li>
                                        <li>
                                            <h5><i class="fa fa-circle m-r-5" style="color: #ebeff2;"></i>Series C</h5>
                                        </li>
                                    </ul>
                                </div>
                                <div id="morris-bar-example" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="col-lg-6">
                    <div class="portlet">
                      
                        <div class="portlet-heading">
                            <h3 class="portlet-title text-dark"> Sales Analytics </h3>
                            <div class="portlet-widgets">
                                <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                <span class="divider"></span>
                                <a data-toggle="collapse" data-parent="#accordion1" href="#bg-default"><i class="ion-minus-round"></i></a>
                                <span class="divider"></span>
                                <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="bg-default" class="panel-collapse collapse in">
                            <div class="portlet-body">
                                <div class="text-center">
                                    <ul class="list-inline chart-detail-list">
                                        <li>
                                            <h5><i class="fa fa-circle m-r-5" style="color: #4793f5;"></i>Mobiles</h5>
                                        </li>
                                        <li>
                                            <h5><i class="fa fa-circle m-r-5" style="color: #ff3f4e;"></i>Tablets</h5>
                                        </li>
                                        <li>
                                            <h5><i class="fa fa-circle m-r-5" style="color: #bbbbbb;"></i>Desktops</h5>
                                        </li>
                                    </ul>
                                </div>
                                <div id="morris-area-example" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                  
                </div>
               
            </div>-->
        </div> <!-- container -->

    </div> <!-- content -->

    
</div>
