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
                        <?php echo $this->form->create('User',array('class'=>'form-horizontal','role'=>'form','data-parsley-validate',' novalidate','type'=>'file'));?>
                            <div class="form-group">
                                <label for="UserFirstName" class="col-sm-4 control-label">First Name*</label>
                                <?php
                               echo  $parentId = $this->params['pass'][0];
                                echo $this->form->hidden('parent_id',array('value'=>$parentId));?>
                                <?php echo $this->form->input('first_name',array('class'=>'form-control','label'=>false,'div'=>'col-sm-7','required'));?>
                            </div>

                            <div class="form-group">
                                <label for="UserLastName" class="col-sm-4 control-label">Last Name*</label>
                                <?php echo $this->form->input('last_name',array('type'=>'text','class'=>'form-control','label'=>false,'div'=>'col-sm-7','required'));?>
                            </div>
                            <div class="form-group">
                                <label for="UserUsername" class="col-sm-4 control-label">Contact No.*</label>
                                <?php echo $this->form->input('phone',array('type'=>'text','class'=>'form-control','label'=>false,'div'=>'col-sm-7','required'));?>
                            </div>
                            <div class="form-group">
                                <label for="UserEmail" class="col-sm-4 control-label">Email*</label>
                                <?php echo $this->form->input('email',array('type'=>'email','class'=>'form-control','label'=>false,'div'=>'col-sm-7','required'));?>
                            </div>
                            <div class="form-group">
                                <label for="UserPassword" class="col-sm-4 control-label">Password*</label>
                                <?php echo $this->form->input('password',array('type'=>'password','class'=>'form-control','label'=>false,'div'=>'col-sm-7','required'));?>
                            </div>
							
							<div class="form-group">
                                <label for="UserPassword" class="col-sm-4 control-label">Confirm Password*</label>
                                <?php echo $this->form->input('confirm_password',array('type'=>'password','class'=>'form-control','label'=>false,'div'=>'col-sm-7','required'));?>
                            </div>
					
							
							
							
                           

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        Add
                                    </button>
                                    <button type="reset" class="btn btn-default waves-effect waves-light m-l-5" onclick="cancelRedirection('users','admin_students',$parentId)">
                                        Cancel
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
