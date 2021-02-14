<div class="container" ><div class="jumbotron"><h4>Dashboard</h4></div></div>
<div class="container">
<div class="row">
<?php
	$proj = json_decode($server->_load_project('all'),1);
    $d = json_decode($server->get_tags(),1);
    $items = $server->load_items();

    $cost = null;
    
    if($proj!=null){
        foreach($proj as $p){
            $cost = $cost + floatval($p['cost']);
        }
    }else{
        $cost = 0;
    }

?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                <?php echo $proj!=null?sizeof($proj):0; ?>
                </h3>

                <p>Projects</p>
              </div>
              <div class="icon">
              <i class="fa fa-project-diagram fa-24px"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $d!=null?sizeof($d):0; ?></h3>

                <p>Tags</p>
              </div>
              <div class="icon">
                <i class="fa fa-tag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $items!=null?sizeof($items):0; ?></h3>

                <p>Components</p>
              </div>
              <div class="icon">
              <i class="lni lni-ruler-pencil"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $cost; ?></h3>

                <p>Total Cost<b>( ZAR )</b></p>
              </div>
              <div class="icon">
              <i class="lni lni-coin"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div></div>