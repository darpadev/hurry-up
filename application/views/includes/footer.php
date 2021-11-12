  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y') ?> <a href="https://universitaspertamina.ac.id" target="_blank" rel="noopener noreferrer"><?php echo $this->db->select('name')->from('company')->get()->row()->name; ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 2.0.0
    </div>
  </footer>