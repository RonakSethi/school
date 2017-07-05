<div class="content-page">
    <div class="content">
        <div class="container">
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
                    <div class="card-box">
                        <div style="width: 23%" class="search_div-table pull-right">
                            <div class="form-group ">
                                <?php echo $this->Form->create("User", array("action" => "admin_parents", "type" => "POST", "class" => "validateForm cmxform form-horizontal ", "id" => "searchUsers", 'enctype' => 'multipart/form-data')); ?>                      
                                <div class="form-group ">
                                    <div class="col-sm-12 icheck ">
                                        <div class="flat-yellow single-row">
                                            <div class="pull-left radio ">
                                                <?php echo $this->Form->text('User.keyword', array('class' => ' form-control', 'placeholder' => 'Search by name or email', 'label' => false, 'div' => false)) ?>
                                            </div>
                                            <div class="pull-left radio ">
                                                <?php echo $this->Form->submit('Go', array('class' => ' btn btn-primary', 'label' => false, 'div' => false, 'id' => "user_submit", 'value' => "Go")); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>         
                            </div>
                        </div>

                        <div class="row">
                            <?php echo $this->element('flash_msg') ?>
                            <div class="col-lg-12">
                                <div class="p-20">
                                    <div class="table-responsive">
                                        <table class="table table-striped m-0" id="datatable-editable">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->Paginator->sort('first_name', 'Full Name'); ?></th>
                                                    <th><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
                                                    <th><?php echo $this->Paginator->sort('phone', 'Phone'); ?></th>

                                                    <th><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
                                                    <th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($users)) {
                                                    foreach ($users as $u) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $u['User']['first_name'] . ' ' . $u['User']['last_name'] ?></td>

                                                            <td><?php echo $u['User']['email'] ?></td>
                                                            <!--td>
                                                            <?php if (isset($u['User']['image']) && !empty($u['User']['image'])) { ?>
                                                                                                                                                                            <img src="<?php echo Configure::read('Site.uploads') . 'users/' . $u['User']['image'] ?>" height="50" width="50"/>
                                                                <?php
                                                            } else {
                                                                echo 'No Image';
                                                            }
                                                            ?>
                                                                                                                        </td-->
                                                            <td><?php echo $u['User']['phone'] ?></td>

                                                            <td><?php echo $this->Common->formatDateForView($u['User']['created']) ?></td>
                                                            <td class="hidden-phone  status-link"  data="<?php echo $u['User']['id']; ?>" data-model="<?php echo Inflector::singularize($this->name); ?>"><?php echo $this->Common->getActiveInactiveValueForView($u['User']['status']); ?></td>
                                                            <td class="actions">
                                                                <?php echo $this->html->link('<i class="fa fa-list"></i>', array('admin' => true, 'controller' => 'users', 'action' => 'admin_students', $u['User']['id']), array('class' => 'on-default edit-row', 'alt'=>'students','escape' => false)); 
                                                                
                                                                echo $this->html->link('<i class="fa fa-pencil"></i>', array('admin' => true, 'controller' => 'users', 'action' => 'edit', $u['User']['id']), array('class' => 'on-default edit-row', 'escape' => false)); 
                                                                
                                                                echo $this->html->link('<i class="fa fa-trash-o"></i>', array('admin' => true, 'controller' => 'users', 'action' => 'delete', $u['User']['id']), array('class' => 'on-default remove-row', 'escape' => false, 'confirm' => 'Are you sure? you want to delete this record!!')); ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo '<tr><td style="text-align:center" colspan="7">No User Found</td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class=" pull-right p-20" id="datatable_paginate">
                                    <?php echo $this->element('paginate') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
