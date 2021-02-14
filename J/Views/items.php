<?php

	$items = $server->load_items();

?>
<div class="container">
	<div class="row">
		<div class="col-md-9"></div>
		<div class="col-md-3">
			<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add_item" >Add Items/Component</button>
		</div>
	</div>
	<div class="row">
		<?php
			if(isset($items)){
				for ($i=sizeof($items)-1; $i >-1 ; $i--) { 
					$st_trim = str_replace("{", "", $items[$i]['dimensions']);
					$dims = explode(",",str_replace("}", "", $st_trim));
	print('<div class="col-md-3">
			<div class="card w-18">
				<img src="'.$items[$i]['images'].'" class="card-top-img" style="height: 150px;">
				<div class="card-body p-1">
					<p>'.$items[$i]['description'].'</p>
								');
					for ($d=0; $d < sizeof($dims); $d++) { 
						echo '<span class="badge bagde-primary bg-primary ml-1">'.str_replace('"',"" , $dims[$d]).'</span>';
					}

				print('
				</div>
			</div>
		</div>');
				}
			}
		?>
	</div>
</div>

<div class="modal fade" id="add_item">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="card-title" >ADD Item/Component</h4>
			</div>

			<form class="modal-body form" action="" enctype="multipart/form-data" method="post" >
				<div class="form-group">
					<input type="text" name="name" placeholder="Component Name" required autocomplete="" class="form-control">
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Dimension :</label>
						<input type="text" class="form-control form-control-sm" id="Dim_name" >
					</div>
					<div class="col-md-6 form-group">
						<label>Value:</label>
						<input type="text" class="form-control form-control-sm" id="Dim_value" >
					</div>
					<div class="col-md-12">
						<div class="col-md-4 form-group offset-6">
							<button class="btn btn-primary btn-xs" type="button" id="add_dimension">Append Dimension</button>
						</div>
					</div>
				</div>
				<div class="form-group">
					<textarea rows="4" cols="12" class="form-control" readonly="" name="dimensions" id="dimensions_display" placeholder='{width:"23cm",height:"23cm",raduis:"23cm"}'></textarea>
				</div>


				<div class="form-group">
					<textarea class="form-control" placeholder="Component Description" name="Description"></textarea>
				</div>
				<div class="form-group">
                <label></label>
                <div class="col-md-12 showcase_content_area p-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="my_file" id="customFile" name="image" accept="image/*" file_extensions=".png,.jpg,.jpeg,.gif">
                    <label class="custom-file-label" for="customFile">Component Image</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer py-1 px-3">
              	<button class="btn btn-primary btn-sm" type="submit" role="button" name="type" value="add_item"> ADD </button>
              </div>
			</form>

		</div>
	</div>
</div>