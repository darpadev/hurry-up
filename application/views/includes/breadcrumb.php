    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              <?php 
                if ($sub_title == '') {
                  echo $title;
                } else {
                  echo $sub_title;
                }
              ?>  
              </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href=""><?php echo $title ?></a></li>
              <li class="breadcrumb-item active"><?php echo $sub_title ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fas fa-check"></i><font style="text-align: justify; margin-right: 3%"><?php echo $this->session->flashdata('success') ?></font>
      </div>
      <?php elseif ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fas fa-ban"></i><font style="text-align: justify; margin-right: 3%"><?php echo $this->session->flashdata('error') ?></font>
      </div>
      <?php endif; ?>
      </div><!-- /.container-fluid -->
    </div>