  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <?php if ($this->session->userdata('role') == 3) : ?>
        <li class="nav-item">
          <?php $emp = $this->db->select('e.name, e.id')
            ->from('employees as e')
            ->join('employee_pt as ep', 'ep.employee_id = e.id')
            ->where(array('ep.status !=' => 2))->get() ?>
          <select onchange="getDataEmployee(this.value)" class="form-control phonebook">
            <option value=""></option>
            <?php foreach ($emp->result() as $emp) : ?>
              <option value="<?= $emp->id ?>"><?= $emp->name ?></option>
            <?php endforeach ?>
          </select>
        </li>
      <?php endif ?>

      <li class="nav-item top-menu">
        <div class="nav-link" id="watch"></div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <?php if ($this->session->userdata('role') == MY_Controller::HRD) : ?>
            <span class="badge badge-danger navbar-badge"><?= count($notif) + count($promotion) ?></span>
          <?php elseif ($this->session->userdata('role') == 3) : ?>
            <span class="badge badge-danger navbar-badge"><?= count($promotion) ?></span>
          <?php endif ?>
        </a>
        <div class="dropdown-menu">
          <?php if ($this->session->userdata('role') == MY_Controller::HRD) : ?>
            <span class="dropdown-header">Ada <?= count($notif) + count($promotion) ?> Pemberitahuan Baru</span>
          <?php elseif ($this->session->userdata('role') == MY_Controller::EMPLOYEE) : ?>
            <span class="dropdown-header">Ada <?= count($promotion) ?> Pemberitahuan Baru</span>
          <?php endif ?>
          <div class="dropdown-divider"></div>

          <?php if ($this->session->userdata('role') == MY_Controller::HRD) : ?>
            <?php $i = 0;
            foreach ($notif as $not) : $i++ ?>
              <?php if ($i <= 3) : ?>
                <a href="#" class="dropdown-item text-wrap">
                  <!-- <i class="fas fa-user mr-2"></i>  -->
                  <?= $not['name'] . ' tidak hadir selama ' . $not['day'] . ' hari'; ?>
                  <!-- <span class="float-right text-muted text-sm"></span> -->
                </a>
                <div class="dropdown-divider"></div>
              <?php else : break ?>
              <?php endif ?>
            <?php endforeach ?>

          <?php endif ?>

          <?php if ($this->session->userdata('role') == MY_Controller::HRD or $this->session->userdata('role') == MY_Controller::EMPLOYEE) : ?>

            <?php for ($i = 0; $i < count($promotion); $i++) : ?>
              <?php if ($i > 3) break ?>
              <a href="#" class="dropdown-item text-wrap">
                
                <?= $promotion[$i]->notification ?>
              </a>
              <div class="dropdown-divider"></div>
            <?php endfor ?>

          <?php endif ?>

          <a href="<?= base_url('notification/'); ?>" class="dropdown-item dropdown-footer">Lihat Semua Pemberitahuan &nbsp;<i class="fa fa-arrow-right"></i></a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link logout-confirmation" href="<?= base_url() ?>/auth/logout">
          <i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;<span class="top-menu">Logout</span>
        </a>
      </li>
    </ul>
  </nav>