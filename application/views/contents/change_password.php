	<div class="row">
		<div class="col-md-12">
	        <div class="card card-primary">
	            <div class="card-header">
	              <h3 class="card-title">Ganti Password</h3>
	            </div>
	            <form action="<?php echo base_url() ?>password/update/<?php echo $this->session->userdata('id') ?>" method="POST">
	            	<div class="card-body">
	            		<div class="form-group">                
		  	                <label>Password</label>
		  	                <input type="password" name="password" class="form-control" required>
		  	            </div>
	            		<div class="form-group">                
		  	                <label>Konfirmasi Password</label>
		  	                <input type="password" name="confirm" class="form-control" required>
		  	            </div>
	            	</div>

					<div class="card-footer">
	                	<div class="form-group">
	                		<button type="submit" class="btn btn-primary">Kirim</button>
	                	</div>
	                </div>
				</form>
	          </div>
	      </div>	
	</div>