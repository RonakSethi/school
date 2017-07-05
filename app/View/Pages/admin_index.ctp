<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title"><?php echo $pageTitle; ?></h4>
                    <ol class="breadcrumb">
                        <li>
                            <?php echo $this->html->link('Dashboard', array('admin' => true, 'controller' => 'users', 'action' => 'dashboard')) ?>
                        </li>
                        <li class="active"><?php echo $pageTitle; ?></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                       
                        <div class="row">
                            <?php echo $this->element('flash_msg') ?>
                            <div class="col-lg-12">
                                <div class="p-20">
                                    <div class="table-responsive">
                                        <table class="table table-striped m-0" id="datatable-editable">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Created</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($staticContent)) {
                                                    $model = 'Content';
                                                    foreach ($staticContent as $val) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $val[$model]['title'] ?></td>
                                                            <td><?php echo $this->Common->checkCharLimit($val[$model]['content'],50) ?></td>
                                                            <td><?php echo $this->Common->formatDateForView($val[$model]['created']); ?></td>
                                                            <td class="hidden-phone  status-link"  data="<?php echo $val[$model]['id']; ?>" data-model="Content"><?php echo $this->Common->getActiveInactiveValueForView($val[$model]['status']); ?></td>
                                                            <td class="actions">
                                                                <?php echo $this->html->link('<i class="fa fa-pencil"></i>', array('admin' => true, 'controller' => 'pages', 'action' => 'edit', $val[$model]['id']), array('class' => 'on-default remove-row', 'escape' => false)); ?>            	                    
                                                                <?php //echo $this->html->link('<i class="fa fa-trash-o"></i>', array('admin' => true, 'controller' => 'categories', 'action' => 'delete', $val[$model]['id']), array('class' => 'on-default remove-row', 'escape' => false, 'confirm' => 'Are you sure? you want to delete this record!!')); ?>            	                    
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }else{
                                                    echo '<tr><td style="text-align:center" colspan="5">No page found</td></tr>';
                                                }
                                                
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
