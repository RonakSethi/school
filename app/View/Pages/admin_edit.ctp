<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <!-- Page-Title -->
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
                <div class="col-lg-12">
                    <?php echo $this->element('flash_msg')?>
                    <div class="card-box">
                       <?php  echo $this->Form->create('Content',array('class'=>'form-horizontal','role'=>'form','data-parsley-validate',' novalidate'));?>
                            
                   
                            <div class="form-group">
                                <label for="UserEmail" class="col-sm-4 control-label">Title*</label>
                                <?php echo $this->form->hidden('id',array('name'=>"data[Content][id]",'value'=>$this->request->data['Content']['id']));?>
                                <?php echo $this->form->input('title',array('type'=>'text','name'=>"data[Content][title]",'value'=>$this->request->data['Content']['title'],'class'=>'form-control','label'=>false,'div'=>'col-sm-7','required'));?>
                            </div>
                            <div class="form-group">
                                <label for="UserEmail" class="col-sm-4 control-label">Content*</label>
                                <?php echo $this->form->input('content',array('id'=>'elm1','name'=>"data[Content][content]",'value'=>$this->request->data['Content']['content'],'type'=>'textarea','class'=>'form-control','label'=>false,'div'=>'col-sm-7','required'));?>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-default waves-effect waves-light m-l-5" onclick="cancelRedirection('pages','index')">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        <?php echo $this->form->end();?>
                    </div>
                </div>
            </div>









        </div> <!-- container -->

    </div> <!-- content -->

  <script type="text/javascript">
        	$(document).ready(function () {
			    if($("#elm1").length > 0){
			        tinymce.init({
			            selector: "textarea#elm1",
			            theme: "modern",
			            height:300,
			            plugins: [
			                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			                "save table contextmenu directionality emoticons template paste textcolor"
			            ],
			            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
			            style_formats: [
			                {title: 'Bold text', inline: 'b'},
			                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			                {title: 'Example 1', inline: 'span', classes: 'example1'},
			                {title: 'Example 2', inline: 'span', classes: 'example2'},
			                {title: 'Table styles'},
			                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			            ]
			        });    
			    }  
			});
        </script>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
