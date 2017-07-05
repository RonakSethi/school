<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->                      
<div class="content-page">
	<!-- Start content -->
	<div class="content">

		<div class="wraper container">

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
				<div class="col-md-4 col-lg-3">
					<div class="profile-detail card-box">
						<div>
						<?php echo $this->Common->user_image($data['User']['image'], '', '','img-circle','Uimg'); ?>
							<hr>
							<?php 
								echo $this->Form->create('User'); 
								echo $this->Form->input('image',array('type'=>'file','class'=>'admin_image','style'=>'display:none;','label'=>false));
								echo $this->Form->end();
							?>
							
							<div class="text-left">
								<p class="text-muted font-13"><strong>Full Name :</strong> <span class="m-l-15"><?php echo $data['User']['name']; ?></span></p>


								<p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15"><?php echo $data['User']['email']; ?></span></p>


							</div>

						</div>

					</div>

				</div>


				<div class="col-lg-9 col-md-8">
					
					<div class="card-box">
					   <div class="card-box">
						<div class="row">
							<div class="col-md-8">
								<?php echo $this->element('flash_msg')?>
								<?php echo $this->Form->create('User',array('inputDefaults'=>array('div'=>false,'label'=>false))); ?>
									<div class="form-group">
										<label for="exampleInputEmail1">First name</label>
										<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Enter Full name')); ?>
									</div>
									
									<div class="form-group">
										<label for="exampleInputPassword1">Email</label>
										<?php echo $this->Form->input('email',array('class'=>'form-control','placeholder'=>'Enter Email ')); ?>
									</div>
									
									<button type="submit" class="btn btn-purple waves-effect waves-light">Submit</button>
								<?php echo $this->Form->end(); ?>
							</div>
							
						</div>
					</div>
					</div>
				</div>

			</div>



		</div> <!-- container -->
				   
	</div> <!-- content -->

</div>
