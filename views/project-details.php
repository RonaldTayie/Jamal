
        <!--================Home Banner Area =================-->
        <section class="banner_area">
            <div class="banner_inner d-flex align-items-center">
            	<div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
				<div class="container">
					<div class="banner_content text-center">
						<h2>Project Details</h2>
						<div class="page_link">
							<a href="index">Home</a>
							<a href="projects">Projects</a>
							<a href="project-details">Project Details</a>
						</div>
					</div>
				</div>
            </div>
        </section>
        <!--================End Home Banner Area =================-->
        
        <?php
        	if(isset($_GET['project'])){
        		$project= explode("/", $_GET['project']);
	        	$project = json_decode($server->_load_project($project[1]),1)[0];
	    ?>
        <!--================Portfolio Details Area =================-->
        <section class="portfolio_details_area p_120">
        	<div class="container">
        		<div class="portfolio_details_inner">
					<div class="row">
						<div class="col-md-6">
							<div class="left_img">
								<img class="img-fluid" src="J/<?php echo $project['images']; ?>" alt="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="portfolio_right_text">
								<h4><?php echo $project['name']; ?></h4>
								<p><?php echo $project['description']; ?></p>
								<ul class="list">
									<li><span>Cost</span>: <?php echo $project['cost']; ?></li>
									<li>
										<span>Components :</span>
										<ul class="unordered-list typo-sec" >
											<?php
								            	//project tag list
								            	$component_list = explode("/",$project['components']);
								            	//tags
								            	//echo "<pre>";
								            	$components = json_decode($server->get_components(),1);
								            	//print_r($components);
								            	//echo "</pre>";
								            	for ($i=sizeof($component_list)-1; $i > -1 ; $i--) { 
								            		for ($l=0; $l < sizeof($components) ; $l++) { 
								            			if($component_list[$i]==$components[$l]['CID']){
														      echo '<li style="line-height:10px;display:flex;" class="pl-4 m-1">
														<!-- /.direct-chat-infos -->
														<img class="author_img rounded-circle" src="J/'.$components[$l]['images'].'" alt="Component Image" style="width:25px;height:25px;">
														<!-- /.direct-chat-img -->
														<div class="direct-chat-text pl-3 py-1"><h6>'.$components[$l]['name'].'</h6></div>
														<!-- /.direct-chat-text -->
														</li>';
								            			}
								            		}
								            	}
								            ?>
										</ul>
									</li>
									<li><span>Tags <i class="fa fa-tag fa-lg" ></i></span>:
										<div class="list-unstyled">
										<?php
											$tags = $server->get_project_tags($project['PID']);

											if($tags !=null){
												foreach($tags as $tag){
												echo '<span class="badge bg-primary text-secondary m-1 text-light">
															<i class="far mdi mdi-tag"></i>'.$tag.' 
														</span>';
												}
											}else{
												echo '<span class="badge badge-md badge-warning" >No tags found</span>';
											}
										?>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
       				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>
        		</div>
        	</div>
        </section>
        <!--================End Portfolio Details Area =================-->

<?php
        	}
        ?>
