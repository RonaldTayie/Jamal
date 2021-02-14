<?php
	$project = json_decode($server->_load_project($_SESSION['View_command']['command']),1);
?>

<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><?php echo $project[0]['name']; ?> Detail</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body">

      <div class="row">

        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">

          <div class="row">

            <div class="col-12 col-sm-4">
            </div>

            <div class="col-12 col-sm-4">
				<div class="info-box">
					<span class="info-box-icon bg-info">R <i class="lni lni-dollar"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Total Cost</span>
						<span class="info-box-number"><?php echo $project[0]['cost'] ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-4">
            </div>
          </div>

          <div class="row">

          	<div class="col-md-12">
          		<div class="card card-dark bg-dark">
          			<img src="<?php echo $project[0]['images']; ?>" class="card-img-top" >
	          		<div class="card-body">
	          			<p class="card-text" ><?php echo $project[0]['description']; ?></p>
	          		</div>
          		</div>
          	</div>

          </div>

        </div>

        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
          <h3 class="text-primary"><i class="fas mdi mdi-home-analytics"></i> <?php echo $project[0]['name']; ?></h3>
          <p class="text-muted"><?php echo $project[0]['description']; ?></p>
          <br>
          <div class="text-muted">
            <p class="text-sm">Client Company
              <b class="d-block">DEMO Inc</b>
            </p>
            <p class="text-sm">Project Leader
              <b class="d-block">The Developer</b>
            </p>
          </div>

          <h5 class="mt-5 text-muted">Project components</h5>
          <ul class="list-unstyled">
            <?php
            	//project tag list
            	$component_list = explode("/",$project[0]['components']);
            	//tags
            	//echo "<pre>";
            	$components = json_decode($server->get_components(),1);
            	//print_r($components);
            	//echo "</pre>";

            	for ($i=sizeof($component_list)-1; $i > -1 ; $i--) { 
            		
            		for ($l=0; $l < sizeof($components) ; $l++) { 
            			
            			if($component_list[$i]==$components[$l]['CID']){
      echo '<div class="direct-chat-msg left">
<!-- /.direct-chat-infos -->
<img class="direct-chat-img" src="'.$components[$l]['images'].'" alt="Component Image">
<!-- /.direct-chat-img -->
<div class="direct-chat-text">'.$components[$l]['name'].'</div>
<!-- /.direct-chat-text -->
</div>';
            			}

            		}

            	}


            ?>

          </ul>

          <h5 class="mt-5 text-muted">Project Tags</h5>
          <div class="list-unstyled">

            <?php
              $tags = $server->get_project_tags($project[0]['PID']);
              if($tags !=null){
                foreach($tags as $tag){
                  echo '<span class="badge bg-primary text-secondary m-1">
                            <i class="far mdi mdi-tag"></i>'.$tag.' 
                        </span>';
                }
              }else{
                echo '<span class="badge badge-md badge-warning" >No tags found</span>';
              }
            ?>

          </div>
          <div class="text-center mt-5 mb-3"></div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

</section>