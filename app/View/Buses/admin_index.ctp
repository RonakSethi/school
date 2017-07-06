<?php
//For Ajax paginations
$this->Js->JqueryEngine->jQueryObject = 'jQuery';
$this->Paginator->options(array('update' => '#contentResult','evalScripts' => true,));
?>
<div class="content-page">
    <div class="content">
        <div class="container">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                         <span class="title"> <?php echo $pageHeading; ?></span>
                        <div class="btn-group margin-top-7 pull-right">
							<?php echo $this->Html->link('Add New <i class="fa fa-plus"></i>', array('controller' => 'buses', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-primary', 'id' => 'editable-sample_new')); ?>                                    
						</div>
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
                        <div class="clearfix">
                            
                        </div><div class="space15"></div>
                      
                        
                        <div class="search_div-table pull-right">
                            <div class="form-group ">
                           <?php echo $this->Form->create('search', array('name' => 'search', 'type' => 'get', 'class' => 'validateForm cmxform form-horizontal ', 'inputDefaults' => array('label' => false, 'div' => false) ));?> 
                            <div class="form-group ">
                                <div class="col-sm-12 icheck ">
                                    <div class="flat-yellow single-row">
                                        <?php if($this->Session->read('Auth.User.role_id')==1){ ?>
                                        <div class="radio">
										<?php echo $this->Form->select('school_id', $catList, array('class' => ' form-control', 'label' => true, 'div' => false,'onchange'=>'document.search.submit()', 'empty' => 'Filter By School')) ; ?>
										</div>
                                        <?php }?>
                                        <div class="radio ">
											<?php echo $this->Form->text('bus', array('class' => ' form-control','placeholder'=>'Search by bus', 'label' => false, 'div' => false)) ?>
                                         </div>
                                        <div class="radio ">
											<?php echo $this->Form->submit('Go', array('class' => ' btn btn-primary', 'label' => false, 'div' => false, 'id' => "user_submit", 'value' => "Go")); ?>
                                         </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="adv-table">
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr>
                                        
										<th><?php echo $this->Paginator->sort('bus_number','Bus Details');?></th>
                                        <th><?php echo $this->Paginator->sort('driver_name ','Drive Details');?></th>
                                        <th><?php echo $this->Paginator->sort('status','Status');?></th>
										<th><?php echo $this->Paginator->sort('created','Created');?> </th>  
										<th>Actions</th>
									</tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($buses)) {
                                        foreach ($buses as $bus) {
                                            ?>
                                            <tr class="gradeX">
                                                
												<td><strong>Bus Number : </strong><?php echo $this->Common->checkCharLimit($bus['Bus']['bus_number']);?>
                                                <br /><strong>School Name :</strong> <?php echo $this->Common->getSchoolName($bus['Bus']['school_id']);?><br /><?php echo $this->Html->link('<i class="fa fa-tasks">&nbsp;&nbsp;View Live map</i>', array('controller' => 'buses', 'action' => 'busmap', $bus['Bus']['id']), array('escape' => false, 'class' => 'todo-edit','title'=>'View Live map')); ?>
<br /><?php //echo $this->Html->link('<i class="fa fa-tasks">&nbsp;&nbsp;View trip report</i>', array('controller' => 'buses', 'action' => 'busmapreport', $bus['Bus']['id']), array('escape' => false, 'class' => 'todo-edit','title'=>'View trip report')); ?>
                                                </td>
                                               	<td><strong>Driver Name : </strong><?php echo $this->Common->checkCharLimit($bus['Bus']['driver_name']);?>
                                                <br /><strong>Mobile :</strong> <?php echo $bus['Bus']['mobile'];?><br /><strong>Route Name :</strong> <?php echo $this->Common->getTripName($bus['Bus']['route_name']);?><?php //echo $bus['Bus']['route_name'];?>
                                                </td>											
												<td class="hidden-phone  status-link"  data="<?php echo $bus['Bus']['id']; ?>" data-model="<?php echo Inflector::singularize($this->name); ?>"><?php echo $this->Common->getActiveInactiveValueForView($bus['Bus']['status']); ?></td>
												 <td><?php echo date(DEFAULT_PHP_DATE_FORMAT, strtotime($bus['Bus']['created'])); ?></td>
												
												<td class="hidden-phone" align="center" >
                                                    <div class="todo-actionlist">
													  <?php echo $this->Html->link('<i class="fa fa-tasks"></i>', array('controller' => 'routes', 'action' => 'index', $bus['Bus']['route_name']), array('escape' => false, 'class' => 'todo-edit','title'=>'View trips')); ?>
													  
                                                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('controller' => 'buses', 'action' => 'edit', $bus['Bus']['id']), array('escape' => false, 'class' => 'todo-edit','title'=>'Edit')); ?>
                                                        
														<?php echo $this->Html->link('<i class="fa fa-times"></i>', array('controller' => 'buses', 'action' => 'delete', $bus['Bus']['id']), array('confirm' => 'Are you sure want to delete the record?', 'escape' => false, 'class' => 'todo-remove','title'=>'Delete')); ?>
                                                    </div>
                                                </td>
												
                                            </tr>
                                            <?php
                                        }
                                    }else{
									?>
									<tr><td colspan="4" align="center">Record Not Found</td></tr>
									<?php 
									}
                                    ?>    
                                </tbody>
                            </table>
                            <div class="pull-right"><?php echo $this->element('paginate');?></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
        </div>
    </div>
</div>
