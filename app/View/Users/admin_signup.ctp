<style>
    .btn-green{background-color:#7E57C7; color:#fff;}
    .btn-green:hover{color:#fff;}
</style>
<div class="card-box">
    <div class="panel-heading"> 
        <h3 class="text-center"> Sign In to <strong class="text-custom">Jam Spot</strong> </h3>
    </div> 


    <div class="panel-body">
        <?php
        if ($this->Session->read('Message')) {
            echo $this->Session->flash('auth');
            echo $this->Session->flash();
        }

        echo $this->Form->create('User', array("class" => "form-horizontal m-t-20"));
        ?> 


        <?php echo $this->form->create('User', array('class' => 'form-horizontal', 'role' => 'form', 'data-parsley-validate', 'novalidate', 'type' => 'file')); ?>
        <div class="form-group">
            <div class="col-xs-12">
                <?php echo $this->form->hidden('role_id', array('value'=>2)); ?>
                <?php echo $this->form->input('first_name', array('class' => 'form-control', 'label' => false, 'placeholder' => 'First name')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <?php echo $this->form->input('last_name', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Last name')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <?php echo $this->form->input('email', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Email')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <?php echo $this->form->input('phone', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Contact no.')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <?php echo $this->form->input('password', array('class' => 'form-control', 'type' => 'password', 'label' => false, 'placeholder' => 'Password')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <?php echo $this->form->input('conf_password', array('class' => 'form-control', 'type' => 'password', 'label' => false, 'placeholder' => 'Confirm Password')); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="UserPassword" class="col-sm-4 control-label"></label>
            <?php echo $this->form->input('term&conditions', array('type' => 'checkbox', 'class' => '', 'label' => 'Term & Conditions', 'div' => 'col-sm-7')); ?> 
        </div>




        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <?php echo $this->Form->button('Sign up', array("class" => "btn btn-green btn-block text-uppercase waves-effect waves-light", 'type' => 'submit', 'label' => false, 'div' => false)); ?>
            </div>
        </div>

        <div class="form-group m-t-30 m-b-0">
            <div class="col-sm-12">
                <?php echo $this->Html->link('<i class="fa fa-lock m-r-5"></i> Forgot Password', '/admin/users/forgot', array('class' => 'text-dark', 'escape' => false)); ?>
            </div>
        </div>
        <div class="form-group m-t-20 m-b-0">
            <div class="col-sm-12 text-center">
                <h4><b>Sign in with</b></h4>
            </div>
        </div>
        <div class="form-group m-b-0 text-center">
            <div class="col-sm-12">
                <button type="button" class="btn btn-facebook waves-effect waves-light m-t-20">
                    <i class="fa fa-facebook m-r-5"></i> Facebook
                </button>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>   
</div> 

<div class="row">
    <div class="col-sm-12 text-center">
        <p>
            Already have account?<?php echo $this->Html->link('Sign In', '/admin/', array('class'=>'text-primary m-l-5','escape' => false)); ?>
        </p>
    </div>
</div>