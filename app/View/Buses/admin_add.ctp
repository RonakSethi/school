<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<a href="javascript:void(0)" class="title"> <?php echo $pageHeading; ?></a>
                    </header>
                    <div class="panel-body">
                        <?php if ($this->Session->read('Message')) : ?>
                            <div class="alert <?php echo $this->Session->read('msg_type'); ?> fade in">
                                <button type="button" class="close close-sm" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>                                   
                                <?php echo $this->Session->flash(); ?>  
                            </div>   
                        <?php endif; ?>
                        <div class="form">
                            <?php echo $this->Form->create("Bus", array("action" => "add", "method" => "Post", "class" => "cmxform form-horizontal ", "id" => "addBus", 'enctype' => 'multipart/form-data')); ?>
							
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-3">School Name *</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->select('Bus.school_id', $catList, array('class' => ' form-control', 'label' => true, 'div' => false, 'empty' => 'Select School Name')) ; ?>
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-3">Bus Number *</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('Bus.bus_number', array('class' => ' form-control', 'label' => false, 'div' => false)) ?>
                                </div>
                            </div>
                            
                            
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-3">IMEI *</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('Bus.iemi', array('class' => ' form-control', 'label' => false, 'div' => false)) ?>
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-3">Driver Name *</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('Bus.driver_name', array('class' => ' form-control', 'label' => false, 'div' => false)) ?>
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-3">Mobile Number</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('Bus.mobile', array('class' => ' form-control', 'label' => false, 'div' => false)) ?>
                                </div>
                            </div>
                          <!-- <div class="form-group ">
                                <label for="username" class="control-label col-lg-3">Route Name</label>
                                <div class="col-lg-6">
                                    <?php //echo $this->Form->input('Bus.route_name', array('class' => ' form-control', 'label' => false, 'div' => false)) ?>
                                </div>
                            </div>-->
                            
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-3">Route Name *</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->select('Bus.route_name', $RouteList, array('class' => ' form-control', 'label' => true, 'div' => false, 'empty' => 'Select Route Name')) ; ?>
                                </div>
                            </div>
                                              
                            <div class="form-group ">
                                <label for="active" class="control-label col-lg-3">Active</label>
                                <div class="col-sm-9 icheck ">
                                    <div class="flat-yellow single-row">
                                        <div class="radio ">
                                            <?php
                                            $options = array(ACTIVE => 'Active', INACTIVE => 'Inactive');
                                            $attributes = array('legend' => false, 'value' => ACTIVE, 'separator' => '&nbsp;&nbsp;', 'label' => array('class' => "label_class"));
                                            echo $this->Form->radio('Bus.status', $options, $attributes);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <?php echo $this->Form->submit('Save', array('class' => ' btn btn-primary', 'label' => false, 'div' => false, 'id' => "user_submit", 'value' => "Save")); ?>
                                    <input class="btn btn-default" name="cancel" type="button" value="Cancel" onclick="cancelrediraction('buses', 'index');">
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>