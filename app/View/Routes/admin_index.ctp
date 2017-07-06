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
                    <section class="panel">
                        <header class="panel-heading">
                            <span class="title"> <?php echo $pageHeading; ?></span>
                            <div class="btn-group margin-top-7 pull-right">
                                <?php echo $this->Html->link('Add Bus Stop <i class="fa fa-plus"></i>', array('controller' => 'routes', 'action' => 'add/' . $parent_id . ''), array('escape' => false, 'class' => 'btn btn-primary', 'id' => 'editable-sample_new')); ?>                                    
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
                                    <?php echo $this->Form->create('search', array('name' => 'search', 'type' => 'get', 'class' => 'validateForm cmxform form-horizontal ', 'inputDefaults' => array('label' => false, 'div' => false))); ?> 
                                    <div class="form-group ">
                                        <div class="col-sm-12 icheck ">
                                            <div class="flat-yellow single-row">
                                                <div class="radio">
                                                    <?php echo $this->Form->select('bus_id', $catList, array('class' => ' form-control', 'label' => true, 'div' => false, 'onchange' => 'document.search.submit()', 'empty' => 'Filter By Routes')); ?>
                                                </div>

                                                <div class="radio ">

                                                    <?php echo $this->Form->text('title', array('class' => ' form-control', 'placeholder' => 'Search by Bus Stop', 'label' => false, 'div' => false)) ?>
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
                                            <th>S.no.</th>
                                            <th><?php echo $this->Paginator->sort('title', 'Bus Stop Name'); ?></th>
                                            <th><?php echo $this->Paginator->sort('Trip.title', 'Route Name'); ?></th>
                                            <th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
                                            <th><?php echo $this->Paginator->sort('created', 'created'); ?> </th>  
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($categories)) {
                                            $e = 1;
                                            foreach ($categories as $category) {
                                                ?>
                                                <tr class="gradeX">
                                                    <td><?php echo $category['Route']['oid']; ?></td>
                                                    <td><?php echo $this->Common->checkCharLimit($category['Route']['title']); ?></td>
                                                    <td><?php echo $this->Common->checkCharLimit($category['Trip']['title']); ?></td>										
                                                    <td class="hidden-phone  status-link"  data="<?php echo $category['Route']['id']; ?>" data-model="<?php echo Inflector::singularize($this->name); ?>"><?php echo $this->Common->getActiveInactiveValueForView($category['Route']['status']); ?></td>
                                                    <td><?php echo date(DEFAULT_PHP_DATE_FORMAT, strtotime($category['Route']['created'])); ?></td>

                                                    <td class="hidden-phone" align="center" >
                                                        <div class="todo-actionlist">
                                                            <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('controller' => 'routes', 'action' => 'edit', $category['Route']['id']), array('escape' => false, 'class' => 'todo-edit', 'title' => 'Edit')); ?>

                                                            <?php echo $this->Html->link('<i class="fa fa-times"></i>', array('controller' => 'routes', 'action' => 'delete', $category['Route']['id']), array('confirm' => 'Are you sure want to delete the record?', 'escape' => false, 'class' => 'todo-remove', 'title' => 'Delete')); ?>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <?php
                                                $e++;
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

                                <div>
                                    <iframe src="http://54.149.95.196/map.php?start=<?php echo $parent_id; ?>" width="100%" height="500px">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- page end-->
        </div>
    </div>
</div>