<?php
	$proj = json_decode($server->_load_project('all'),1);
?>
<div class="container-fluid">
	<div class="btn-group py-2">
		<a href="project-add" class="btn btn-default border border-primary" > Add Project <i class="mdi mdi-plus" ></i></a>
	</div>
</div>

<div class="container-fluid">
	<div class="container-fluid">

		<div class="row">
			<?php
				if($proj!==null){
					
					if(sizeof($proj)>0){

						for ($i=sizeof($proj)-1; $i > -1 ; $i--) { 
	print('<div class="col-md-4">
				<div class="card w-18">
					<img src="'.$proj[$i]['images'].'" class="card-top-img" height="250px">
					<div class="card-body p-1">
						<p class="card-text" >'.$proj[$i]['description'].'</p>
					</div>
					
					<div class="card-footer">
						<a href="project-details_'.$proj[$i]['PID'].'" class="btn btn-default btn-xs border border-primary" > View Project</a>
					</div>
					
				</div>
			</div>');
						}

					}

				}
			?>
		</div>

	</div>
</div>

<!--modals-->

<!--tags modal-->
<div class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content modal-sm">
			<div class="modal-header">
				
			</div>
			<div class="modal-body">
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="project_add">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<div class="modal-header">
				<h3 class="card-title" >Add Project</h3>
			</div>

			<form method="post" enctype="multipart/form-data" class="modal-body pb-0">

				<div class="form-group">
					<input type="text" name="name" placeholder="Project Name :" class="form-control">
				</div>
				<div class="form-group">
					<textarea class="form-control" rows="3" cols="12" placeholder="Description"></textarea>
				</div>
				<div class="form-group">
					<input type="text" name="cost" placeholder="000.00" class="form-control">
				</div>

				<div class="form-group">
					<div class="col-md-12 showcase_content_area p-0">
						<input type="text" name="type" value="profile_img_change" hidden>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="customFile" name="my_file" accept="image/*" file_extensions=".png,.jpg,.jpeg,.gif">
							<label class="custom-file-label" for="customFile">Choose files</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					
				</div>

				<div class="form-group">
					<button class="btn btn-primary btn-sm" >Add project <i class="mdi mdi-wrench" ></i></button>
				</div>

			</form>

		</div>
	</div>
</div>
