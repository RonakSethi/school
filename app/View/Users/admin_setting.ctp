<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title"><?php echo $title_for_layout; ?></h4>
                    <ol class="breadcrumb">
                        <li>
                            <?php echo $this->html->link('Dashboard',array('admin'=>true,'controller'=>'users','action'=>'dashboard'))?>
                        </li>
                        <li class="active"><?php echo $title_for_layout; ?></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <?php echo $this->element('flash_msg')?>
                    <div class="card-box">
                        <?php echo $this->form->create('User',array('class'=>'form-horizontal','role'=>'form','data-parsley-validate',' novalidate','type'=>'file','id'=>'updatePassword'));?>
                            <div class="form-group">
                                <label for="UserFirstName" class="col-sm-4 control-label">Password*</label>
                                <?php echo $this->form->input('password',array('class'=>'form-control','label'=>false,'div'=>'col-sm-7', 'id'=>'UserPassword'));?>
                            </div>
							
							<div class="form-group">
                                <label for="UserFirstName" class="col-sm-4 control-label">Confirm password*</label>
                                <?php echo $this->form->input('re_password',array('type'=>'password','class'=>'form-control','label'=>false,'div'=>'col-sm-7'));?>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        Update 
                                    </button>
                                   
                                </div>
                            </div>
                        <?php echo $this->form->end();?>
                    </div>
                </div>
            </div>









        </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer">
        © 2016. All rights reserved.
    </footer>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
