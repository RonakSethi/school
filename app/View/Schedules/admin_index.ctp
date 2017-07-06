<?php
//For Ajax paginations
$this->Js->JqueryEngine->jQueryObject = 'jQuery';
$this->Paginator->options(array('update' => '#contentResult','evalScripts' => true,));
?>
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
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
                        <div class="clearfix"></div>
                        	<?php echo $this->Form->create("Schedules", array("action"=>"index","type" => "POST", "class" => "form-horizontal", "id"=>"schedules", 'enctype'=>'multipart/form-data')); ?>
                         
                        <div class="clearboth"></div>
						
                        <div class="adv-table">
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr></tr>
								 </thead>
                                <tbody class="sche">
                                        <td>
											    <?php echo $this->Form->input('monday', array('type'=>'checkbox','value'=>'monday','checked'=>false,'label'=>'Monday','hiddenField'=>false,'class' => 'form-control checkbox1','div'=>false)); ?>
												<hr/>
												<?php echo $this->Form->input('tuesday', array('type'=>'checkbox','value'=>'tuesday','checked'=>false,'label'=>'Tuesday','hiddenField'=>false,'class' => 'form-control checkbox1','div'=>false)); ?>
												<hr/>
												<?php echo $this->Form->input('wednesday', array('type'=>'checkbox','value'=>'wednesday','checked'=>false,'label'=>'Wednesday','hiddenField'=>false,'class' => 'form-control checkbox1','div'=>false)); ?>
												<hr/>
												<?php echo $this->Form->input('thrusday', array('type'=>'checkbox','value'=>'thrusday','checked'=>false,'label'=>'Thrusday','hiddenField'=>false,'class' => 'form-control checkbox1','div'=>false)); ?>
												<hr/>
												<?php echo $this->Form->input('friday', array('type'=>'checkbox','value'=>'friday','checked'=>false,'label'=>'Friday','hiddenField'=>false,'class' => 'form-control checkbox1','div'=>false)); ?>
												<hr/>
									
												
												<?php echo $this->Form->input('saturday', array('type'=>'checkbox','value'=>'saturday','checked'=>false,'label'=>'Saturday','hiddenField'=>false,'class' => 'form-control checkbox1','div'=>false)); ?>
												<hr/>
												<?php echo $this->Form->input('sunday', array('type'=>'checkbox','value'=>'sunday','checked'=>false,'label'=>'Sunday','hiddenField'=>false,'class' => 'form-control checkbox1','div'=>false)); ?>
												<hr/>
												<p style="text-align:center"><?php echo "OR"; ?></p>
												<hr/>
												<?php echo $this->Form->input('everyday', array('type'=>'checkbox','value'=>'everyday','checked'=>false,'label'=>'Everyday','hiddenField'=>false,'class' => 'form-control checkbox1','div'=>false)); ?>
												<hr/>
												
												<?php echo $this->Form->submit('Save', array('class' => 'btn btn-primary', 'id' => 'sechedule','label' => false, 'div' => false,)); ?> 
											</td>
								</tbody>
                            </table>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
