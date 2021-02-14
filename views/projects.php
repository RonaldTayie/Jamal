
        <!--================Home Banner Area =================-->
        <section class="banner_area">
            <div class="banner_inner d-flex align-items-center">
            	<div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
				<div class="container">
					<div class="banner_content text-center">
						<h2>Projects</h2>
						<div class="page_link">
							<a href="index">Home</a>
							<a href="projects">Projects</a>
						</div>
					</div>
				</div>
            </div>
        </section>
        <!--================End Home Banner Area =================-->
        
        <!--================Furniture Area =================-->
        <section class="furniture_area p_120">
            <div class="container">
                <div class="main_title">
                    <h2>Projects</h2>
                </div>
                <div class="furniture_inner row">
                    <?php
                        if(json_decode($server->_load_project('all'),1)){
                            $proj = json_decode($server->_load_project('all'),1);
                            if(sizeof($proj)>0){
                                for ($i=sizeof($proj)-1; $i > -1 ; $i--) { 
                                    echo ' <div class="col-md-4 col-sm-6 col-6">
                <div class="furniture_item">
                    <img class="img-fluid" src="J/'.$proj[$i]['images'].'" alt="">
                    <h4>'.$proj[$i]['name'].'</h4>
                    <p>'.$proj[$i]['description'].'</p>
                    <a href="project-details?project='.$proj[$i]['name'].'/'.$proj[$i]['PID'].'" class="genric-btn info-border circle arrow small text-md">Details<span class="lnr lnr-eye"></span></a>
                </div>
            </div>';
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
        <!--================End Furniture Area =================-->
