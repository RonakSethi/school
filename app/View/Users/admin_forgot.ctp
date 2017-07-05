<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> Reset Password </h3>
				</div>

				<div class="panel-body">
				   <?php
                if ($this->Session->read('Message')) {
                   ?>

                <div class="alert alert-block alert-danger fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <strong>Error!</strong>
                    <?php echo $this->Session->flash('auth'); ?>                                     
                    <?php echo $this->Session->flash(); ?>  
                </div>            

            <?php
           }
           ?>
				    <?php echo $this->Form->create('User', array("class" => "text-center")); ?>
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								×
							</button>
							Enter your <b>Email</b> and instructions will be sent to you!
						</div>
						<div class="form-group m-b-0">
							<div class="input-group">
								<?php echo $this->Form->input('email', array('class'=>'form-control','label' => false, 'div' => false,'placeholder'=>'Enter Email','autofocus')); ?>  
								<span class="input-group-btn">
									  <?php echo $this->Form->button('Reset Password', array("class" => "btn btn-pink w-sm waves-effect waves-light",'type'=>'submit', 'label' => false, 'div' => false)); ?>
								</span>
							</div>
						</div>

					<?php echo $this->Form->end(); ?>
				</div>
			</div>
