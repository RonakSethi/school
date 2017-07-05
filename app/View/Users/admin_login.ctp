<style>
    .btn-green{background-color:#7E57C7; color:#fff;}
    .btn-green:hover{color:#fff;}
</style>
<div class="card-box">
    <div class="panel-heading"> 
        <h3 class="text-center"> Sign In to <strong class="text-custom">School</strong> </h3>
    </div> 


    <div class="panel-body">
        <?php
        if ($this->Session->read('Message')) {
            ?>
            <!--strong>Error!</strong-->
            <?php echo $this->Session->flash('auth'); 
            echo $this->Session->flash();
        }
        echo $this->Form->create('User',  array('class' => 'form-horizontal m-t-20', 'role' => 'form', 'data-parsley-validate', 'novalidate', 'type' => 'file')); ?>   
        <div class="form-group ">
            <div class="col-xs-12">
                <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Email', 'autofocus')); ?>     
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <?php echo $this->Form->input('password', array('class' => 'form-control', 'label' => false, 'div' => false, 'placeholder' => 'Password', 'autofocus')); ?>  
            </div>
        </div>

        <div class="form-group ">
            <div class="col-xs-12">
                <div class="checkbox checkbox-primary">
                    <?php echo $this->Form->input('remmber_me', array('type' => 'checkbox', 'id' => 'checkbox-signup', 'label' => 'Remember me', 'div' => false)); ?>
                </div>

            </div>
        </div>

        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <?php echo $this->Form->button('Log In', array("class" => "btn btn-green btn-block text-uppercase waves-effect waves-light", 'type' => 'submit', 'label' => false, 'div' => false)); ?>
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
<!--        <div class="form-group m-b-0 text-center">
            <div class="col-sm-12">
                <button onclick="fb_login();" type="button" class="btn btn-facebook waves-effect waves-light m-t-20">
                    <i class="fa fa-facebook m-r-5"></i> Facebook
                </button>


            </div>
        </div>-->
        <?php echo $this->Form->end(); ?>
    </div>   
</div> 


<div class="row">
    <div class="col-sm-12 text-center">
        <p>
            Don't have an account? <?php echo $this->Html->link('Sign Up', '/admin/users/signup', array('class' => 'text-primary m-l-5', 'escape' => false)); ?>
        </p>
    </div>
</div>

