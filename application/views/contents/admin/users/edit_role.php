      <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Data Peran</h3>
                </div>
                <form method="POST" action="<?php echo base_url() ?>admin/usercontrol/update_role/<?php echo $data->id ?>">
                <div class="card-body">
  	              <div class="form-group">                
  	                <label>Peran</label>
  	                <input type="text" name="role" class="form-control" required value="<?php echo $data->role ?>">
  	              </div>	              
                </div>
                <div class="card-footer">
                	<div class="form-group">
                		<button type="submit" class="btn btn-primary">Submit</button>
  	                  <a href="<?php echo base_url() ?>admin/usercontrol" class="text-right btn btn-default">Kembali</a>
                	</div>
                </div>
                </form>
              </div>
          </div>
      </div>