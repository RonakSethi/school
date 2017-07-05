<?php $this->Html->script('../plugins/parsleyjs/parsley.min.js', array('block' => 'scriptBottom'));?>
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
                        <?php echo $this->Form->create('EmailTemplate',array('class'=>'form-horizontal','role'=>'form','data-parsley-validate',' novalidate','id'=>'EditTemplate'));?>
                            <?php echo $this->Form->input('id');?>
<!--                            <div class="form-group">
                                <label for="UserFirstName" class="col-sm-4 control-label">Title*</label>
                                <?php // echo $this->Form->input('title',array('class'=>'form-control','label'=>false,'div'=>'col-sm-7'));?>
                            </div>-->

                            <div class="form-group">
                                <label for="UserLastName" class="col-sm-4 control-label">Email type*</label>
                                <?php echo $this->Form->input('email_type',array('class'=>'form-control','label'=>false,'div'=>'col-sm-7'));?>
                            </div>
                            <div class="form-group">
                                <label for="UserUsername" class="col-sm-4 control-label">Sender name *</label>
                                <?php echo $this->Form->input('sender_name',array('class'=>'form-control','label'=>false,'div'=>'col-sm-7'));?>
                            </div>
                            <div class="form-group">
                                <label for="UserEmail" class="col-sm-4 control-label">Sender email*</label>
                                <?php echo $this->Form->input('sender_email',array('type'=>'email','class'=>'form-control','label'=>false,'div'=>'col-sm-7'));?>
                            </div>
                            <div class="form-group">
                                <label for="UserColorCode" class="col-sm-4 control-label">Subject *</label>
                                <?php echo $this->Form->input('subject',array('class'=>'form-control','label'=>false,'div'=>'col-sm-7'));?>
                            </div>

                            <div class="form-group">
                                <label for="webSite" class="col-sm-4 control-label">Message *</label>
                                <?php echo $this->Form->input('message',array('type'=>'textarea','class'=>'form-control','label'=>false,'div'=>'col-sm-7'));?>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                                </div>
                            </div>
                        <?php echo $this->Form->end();?>
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
