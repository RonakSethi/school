<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Select product</h4>
			</div>
			<div class="modal-body">
			  
			  
			  <div class="row m-t-10 m-b-10">
					<div class="col-sm-6 col-lg-5">
						<?php echo $this->Form->create('Product'); ?>		                                    
							<div class="form-group contact-search m-b-30">
								<input id="searchProductList" class="form-control" placeholder="Search..." name="keywords" type="text">
								<input type="hidden" id="role_type" value="<?php echo !empty($role_type) ? $role_type : 2 ;   ?>">
								<input type="hidden" id="distributer_id" value="">
								<button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
							</div> <!-- form-group -->
						<?php echo $this->Form->end(); ?>		                        	
					</div>
			</div>
			  <?php echo $this->Form->create('ProductInformation'); ?>
			  
			  <div class="table-responsive productContains" style="overflow-y:auto;max-height:300px;">
			  
				<table class="table table-actions-bar">
					<thead>
						<tr>
							<th><div class="checkbox checkbox-primary ">
									<input id="checkbox" type="checkbox" class="checkProduct">
	                                 <label for="checkbox"></label>
								</div></th>
							<th>Product image</th>
							<th>Name</th>
							<th>Price</th>
							<th>created</th>
							<th style="min-width: 40px;">Update price</th>
						</tr>
					</thead>

					<tbody>
						<tr>
						<?php
							$check_select_product = 0;
							$product_count = 1;
							if(isset($product) && !empty($product)){
								foreach($product as $product_rec){
						?>
							<td>
								<div class="checkbox checkbox-primary">
									<?php
										$checked = '';
										if(!empty($selectedProduct)){
											if(array_key_exists($product_rec['Product']['id'],$selectedProduct)){
												$check_select_product = 1;
												$checked = 'checked';
											}
										}
									?>
									<input id="checkbox<?php echo $product_rec['Product']['id']; ?>" type="checkbox" name="data[ProductInformation][product_id][]" value="<?php echo $product_rec['Product']['id']; ?>" class="select_check" <?php echo $checked ?> >
	                                 <label for="checkbox<?php echo $product_rec['Product']['id']; ?>"></label>
								</div>
							</td>
							<td><img src="<?php echo WEBSITE_URL.'uploads/products/'.$product_rec['Product']['picture']; ?>" style="height:50px; width:50px;"></td>
							<td><?php echo $product_rec['Product']['name']; ?></td>
							<td><?php echo $product_rec['Product']['cost']; ?></td>
							<td><?php echo $this->Common->date_formate($product_rec['Product']['created']); ?></td>				
							<td>
								<div class="input-group m-t-10 col-sm-4 col-lg-8">
									<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
									<?php
										$price = $product_rec['Product']['cost'];
										if(!empty($selectedProduct)){
											if(array_key_exists($product_rec['Product']['id'],$selectedProduct)){
												$price = $selectedProduct[$product_rec['Product']['id']];
											}
										}
									?>
									<input id="input<?php echo $product_rec['Product']['id']; ?>" name="data[ProductInformation][price][]" class="form-control update_cost" placeholder=".." type="text" value="<?php echo $price; ?>" <?php echo !empty($checked)? '' : 'disabled'; ?> rel="<?php echo $product_rec['Product']['id']; ?>">
								</div>
															
							</td>
						</tr>

						<?php
						$product_count++;
							}
						}
						?>				                                                

					</tbody>
				</table>
				
			</div>
			<?php
					if($product_count > 1){
				?>
				<div class="pull-right" style="margin-right:44px;">
					<button type="submit" class="btn btn-primary waves-effect waves-light btn-submit" <?php (($check_select_product)? '' : 'disabled'); ?>>
                                        Add
                                    </button>
				</div>
				<?php } ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->