    <form class="content" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Project Name</label>
                <input type="text" id="inputName" class="form-control" name="name">
              </div>
              <div class="form-group">
                <label for="inputDescription">Project Description</label>
                <textarea id="inputDescription" class="form-control" rows="4" name="description"></textarea>
              </div>
              <div class="form-group">
                <label></label>
                <div class="col-md-12 showcase_content_area p-0">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="my_file" accept="image/*" file_extensions=".png,.jpg,.jpeg,.gif">
                    <label class="custom-file-label" for="customFile">Choose files</label>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!--project tags-->
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title" >Tags <i class="mdi mdi-tag" ></i></h3>
              <div class="card-tools" >
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-1">
              <div class="card-text" id="tag-list"></div>
              <input type="text" id="tag-list-input" name="tags" hidden required value="">
              <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#project_tags">Add Tags <i class="mdi mdi-tags" ></i></button>
            </div>
          </div>

        </div>

        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Cost</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputEstimatedBudget">Estimated budget</label>
                <input type="number" id="inputEstimatedBudget" class="form-control" name="cost">
              </div>
            </div>
            <!-- /.card-body -->
          </div>

          <div class="col-md-12 p-0">
            <div  class="row">
              <div class="col-md-12">

                <div class="card card-dark">
                  <div class="card-header">
                    <h6>
                      <small class="card-title" >Project Components</small>
                    </h6>
                  </div>
                  <div class="card-body p-0" id="added-components" style="list-style-type: none;">
                  </div>
                  <input type="text" name="components" class="form-control" id="items-values" hidden>
                  <div class="card-footer p-1">
                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#components_items" type="button">Add Components</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- /.card -->

            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-secondary">
                  <h3 class="card-title">Project dimensions</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label>Dimension :</label>
                      <input type="text" class="form-control form-control-sm" id="Dim_name" >
                    </div>
                    <div class="col-md-6 form-group">
                      <label>Value:</label>
                      <input type="text" class="form-control form-control-sm" id="Dim_value" >
                    </div>
                    <div class="col-md-12 text-right">
                      <div class="col-md-4 form-group">
                        <button class="btn btn-primary btn-xs" type="button" id="add_dimension" type="button">Append Dimension</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <textarea rows="4" cols="12" class="form-control" readonly="" name="dimensions" id="dimensions_display" placeholder='{width:"23cm",height:"23cm",raduis:"23cm"}'></textarea>
              </div>
            </div>

        </div>

        <!--Components card-->
      </div>
      <div class="row">
        <div class="col-12">
          <a href="" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-success btn-md float-right" id="create-project" type="button" name="type" value="project_add">Create new Project</button>
        </div>
      </div>
    </form>

    <div class="modal fade" id="components_items">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            Available Components
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-striped table-sm" id="components_table">
              <thead>
                <tr>
                  <td>
                    <i class="far mdi mdi-image-area" ></i>
                  </td>
                  <td>Name</td>
                  <td><i class="mdi mdi-dots-horizontal-circle-outline" ></i></td>
                </tr>
              </thead>
              <tbody>
                <?php
                  $items = $server->load_items();

                    if(isset($items)){
                      for ($i=sizeof($items)-1; $i >-1 ; $i--) { 
                        $st_trim = str_replace("{", "", $items[$i]['dimensions']);
                        $dims = explode(",",str_replace("}", "", $st_trim));
            print('<tr>
                    <td><img class="direct-chat-img" src="'.$items[$i]['images'].'" ></td>
                    <td><p><span class="badge text-md" >'.$items[$i]['name']."</span>".$items[$i]['description'].'</p></td>
                    <td><button class="btn btn-primary btn-xs" name="'.$items[$i]['CID'].'" id="add_item"><i class="mdi mdi-plus" ></i></button></td>
                  </tr>');
                      }
                    }
                ?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger btn-xs" data-dismiss="modal"> close </button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="project_tags">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            Project tags <i class="mdi mdi-tag" ></i>
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-striped table-sm" id="tags_table">
              <thead>
                <tr>
                  <td>Name</td>
                  <td><i class="mdi mdi-dots-horizontal-circle-outline" ></i></td>
                </tr>
              </thead>
              <tbody>
                <?php
                  $items = json_decode($server->get_tags(),1);

                    if(isset($items)){
                      for ($i=sizeof($items)-1; $i >-1 ; $i--) { 
            print('<tr>
                    <td><p><span class="badge text-md" >'.$items[$i]['tag']."</span>".'</p></td>
                    <td><button class="btn btn-primary btn-xs" name="'.$items[$i]['TID'].'" id="add_tag"><i class="mdi mdi-plus" ></i></button></td>
                  </tr>');
                      }
                    }
                ?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger btn-xs" data-dismiss="modal"> close </button>
          </div>
        </div>
      </div>
    </div>