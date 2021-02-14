<?php
	$d = json_decode($server->get_tags(),1);
?>
<div class="content">
	<div class="row">
		
		<div class="col-md-4">
			
			<div class="card card-success">
				<div class="card-header">
					<h3 class="card-title" >
						tags
					</h3>
					<div class="card-tools"></div>
				</div>
				<div class="card-body p-1">
					<?php
						if(isset($d) & $d !== null){
							if(sizeof($d)>0){
								for ($i=sizeof($d)-1; $i > -1 ; $i--) { 
									echo '<span class="badge badge-primary m-1" >'.$d[$i]['tag'].'<i class="mdi mdi-tag mx-1" ></i></span>';
								}
							}
						}
					?>
				</div>
				<dv class="card-footer">
					<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#tags-add" >Add tag <i class="mdi mdi-tag" ></i></button>
				</dv>
			</div>
		</div>
	</div>
</div>

<!--Tag addition modal-->
<div class="modal fade" id="tags-add">
	<div class="modal-dialog modal-sm">
		<form class="modal-content" method="post">
			<div class="modal-header">
				<h3 class="card-title" >Tag Addition</h3>
			</div>
			<div class="modal-body">
				<div class="form">
					<div class="form-group">
						<input type="text" name="name" id="tag-name" placeholder="Tag name" class="form-control border border-primary" required>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default btn-xs border border-primary text-primary float-left"  id="add-tag" name="type" value="add-tag"> Add Tag <i class="mdi mdi-tag" ></i> </button>
				<button class="btn btn-default btn-xs border border-danger text-danger"  data-dismiss="modal" type="button">Close <i class="mdi mdi-close" ></i> </button>
			</div>
		</form>
	</div>
</div>