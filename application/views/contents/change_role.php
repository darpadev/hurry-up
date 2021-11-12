	<div class="row">
		<div class="col-md-12">
	        <div class="card card-primary">
	            <div class="card-header">
	              <h3 class="card-title">Ganti Peran</h3>
	            </div>
	            <form action="<?php echo base_url() ?>role/select" method="POST">
	            	<div class="card-body">
	            		<div class="form-group">
	            			<label>Ganti Peran</label>	            			
							<select class="form-control" name="role" required>			
								<?php 
								$roles = $this->db->select('r.*')
								->from('roles as r')
								->join('login as l', 'l.role_id = r.id')
								->where('l.user_id', $this->session->userdata('employee'))
								->get();

								foreach ($roles->result() as $row) { ?>
						            <option <?= ($this->session->userdata('role') == $row->id) ? "selected" : ''; ?> value="<?php echo $row->id;?>"><?php echo $row->role;?></option>
						        <?php } ?>
							</select>
	            		</div>
	            	</div>

					<div class="card-footer">
	                	<div class="form-group">
	                		<button type="submit" class="btn btn-primary">Kirim</button>
	  	                  <a href="<?php echo base_url() ?>" class="text-right btn btn-default">Kembali</a>
	                	</div>
	                </div>
				</form>
	          </div>
	      </div>	
	</div>