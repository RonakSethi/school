<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    
                    <header class="panel-heading">
                        <a href="javascript:void(0)" class="title"> <?php echo $pageHeading; ?></a>
                    </header>
                    <div class="panel-body">
                        <?php
                        if ($this->Session->read('Message')) {
                            ?>
                            <div class="alert <?php echo $this->Session->read('msg_type'); ?> fade in">
                                <button type="button" class="close close-sm" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>                                   
                                <?php echo $this->Session->flash(); ?>  
                            </div>            
                            <?php
                        }
                       
                        ?>
                        <div class="form">
                            <?php echo $this->Form->create("Message", array("action" => "add", "method" => "Post", "class" => "cmxform form-horizontal ","id" => "addUser",  'enctype' => 'multipart/form-data')); ?>
                           
							<div class="form-group ">
                                <label for="parent" class="control-label col-lg-3">Title *</label>
                                <div class="col-lg-6">
                                     <?php echo $this->Form->text('title', array('class'=>'form-control','label'=>false, 'div'=>false)) ?>  
                                </div>
                            </div> 
							
							<div class="form-group ">
                                <label for="parent" class="control-label col-lg-3">Message Description</label>
                                <div class="col-lg-6"> 
                                     <?php echo $this->Form->input('message_body', array('id'=>'tinyMcContent','class' => ' form-control', 'label' => false, 'div' => false)) ?>  
									
                                </div>
                            </div> 
							<div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <?php echo $this->Form->submit('Save', array('class' => ' btn btn-primary', 'label' => false, 'div' => false, 'id' => "user_submit", 'value' => "Save")); ?>
                                    <input class="btn btn-default" name="cancel" type="button" value="Cancel" onclick="cancelrediraction('items', 'index');">
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
<?php $this->Html->script(array('ckeditor/ckeditor.js','ckfinder/ckfinder.js','editor.js'), array('block' => 'scriptBottom'));?>