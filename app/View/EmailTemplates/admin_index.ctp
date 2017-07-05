<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title"><?php echo $title_for_layout; ?></h4>
                    <ol class="breadcrumb">
                        <li>
                            <?php echo $this->html->link('Dashboard',array('admin'=>true,'controller'=>'users','action'=>'dashboard'))?>
                        </li>
                        <li class="active"><?php echo $title_for_layout; ?></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="row">
                            <?php echo $this->element('flash_msg')?>
                            <div class="col-lg-12">
                                <div class="p-20">
                                    <div class="table-responsive">
                                        <table class="table table-striped m-0" id="datatable-editable">
                                            <thead>
                                                <tr>
<!--                                                    <th>Title</th>-->
                                                    <th>Email type</th>
                                                    <th>Subject</th>
                                                    <th>Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(!empty($templates)){
                                                    foreach($templates as $rec){
                                                        ?>
                                                        <tr>
                                                            <!--<td><?php // echo $rec['EmailTemplate']['title']?></td>-->
                                                            <td><?php echo $rec['EmailTemplate']['email_type']?></td>
                                                            <td><?php echo $rec['EmailTemplate']['subject']?></td>
                                                            <td><?php echo date(DEFAULT_PHP_DATE_FORMAT,strtotime($rec['EmailTemplate']['created'])); ?></td>
															
                                                            <td class="actions">

                                                                <?php echo $this->html->link('<i class="fa fa-pencil"></i>',array('admin'=>true,'controller'=>'email_templates','action'=>'edit_templates',$rec['EmailTemplate']['id']),array('class'=>'on-default edit-row','escape'=>false)); ?>

            	                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
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
                                    <?php echo $this->element('paginate')?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
