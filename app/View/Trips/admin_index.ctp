<?php
//For Ajax paginations
$this->Js->JqueryEngine->jQueryObject = 'jQuery';
$this->Paginator->options(array('update' => '#contentResult', 'evalScripts' => true,));
?>
<div class="content-page">
    <div class="content">
        <div class="container">
        <!-- page start-->
         <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title"><?php echo $pageHeading; ?></h4>
                    <ol class="breadcrumb">
                        <li>
                            <?php echo $this->html->link('Dashboard', array('admin' => true, 'controller' => 'users', 'action' => 'dashboard')) ?>
                        </li>
                        <li class="active"><?php echo $pageHeading; ?></li>
                    </ol>
                </div>
            </div>
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                  
                    <div class="panel-body">
                        <?php echo $this->Html->link('Add Routes <i class="fa fa-plus"></i>', array('controller' => 'trips', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-primary', 'id' => 'editable-sample_new')); ?>
                        <div class="clearfix"></div>
                        <div class="space15">  </div>


                        <div class="search_div-table pull-right">
                            
                            <div class="form-group ">
                                <?php echo $this->Form->create('search', array('name' => 'search', 'type' => 'get', 'class' => 'validateForm cmxform form-horizontal ', 'inputDefaults' => array('label' => false, 'div' => false))); ?> 
                                <div class="form-group ">
                                    <div class="col-sm-12 icheck ">
                                        <div class="flat-yellow single-row">


                                            <div class="radio ">

                                                <?php echo $this->Form->text('title', array('class' => ' form-control', 'placeholder' => 'Search by route name', 'label' => false, 'div' => false)) ?>
                                                
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

                                        <th><?php echo $this->Paginator->sort('title', 'Route Name'); ?></th>
                                        <th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
                                        <th><?php echo $this->Paginator->sort('created', 'created'); ?> </th>  
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($categories)) {
                                        foreach ($categories as $category) {
                                            ?>
                                            <tr class="gradeX">

                                                <td><?php echo $this->Common->checkCharLimit($category['Trip']['title']); ?></td>
                                                <td class="hidden-phone  status-link"  data="<?php echo $category['Trip']['id']; ?>" data-model="<?php echo Inflector::singularize($this->name); ?>"><?php echo $this->Common->getActiveInactiveValueForView($category['Trip']['status']); ?></td>
                                                <td><?php echo date(DEFAULT_PHP_DATE_FORMAT, strtotime($category['Trip']['created'])); ?></td>

                                                <td class="hidden-phone" align="center" >
                                                    <div class="todo-actionlist">
                                                        <?php echo $this->Html->link('<i class="fa fa-tasks"></i>', array('controller' => 'routes', 'action' => 'index', $category['Trip']['id']), array('escape' => false, 'class' => 'todo-edit', 'title' => 'View trips')); ?>
                                                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('controller' => 'trips', 'action' => 'edit', $category['Trip']['id']), array('escape' => false, 'class' => 'todo-edit', 'title' => 'Edit')); ?>

                                                        <?php echo $this->Html->link('<i class="fa fa-times"></i>', array('controller' => 'trips', 'action' => 'delete', $category['Trip']['id']), array('confirm' => 'Are you sure want to delete the record?', 'escape' => false, 'class' => 'todo-remove', 'title' => 'Delete')); ?>
                                                    </div>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr><td colspan="5" align="center">Record Not Found</td></tr>
                                        <?php
                                    }
                                    ?>    
                                </tbody>
                            </table>
                            <div class="pull-right"><?php echo $this->element('paginate'); ?></div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
        </div>
    </div>
</div>