<div class="alert alert-info <?php if(!$this->session->flashdata('information')) { ?>hidden<?php } ?>" id="idiv_info">
  <button class="close" data-close="alert"></button>
  <?php echo $this->session->flashdata('information'); ?>
</div>
<div class="alert alert-success <?php if(!$this->session->flashdata('success')) { ?>hidden<?php } ?>" id="idiv_success">
  <button class="close" data-close="alert"></button>
  <?php echo $this->session->flashdata('success'); ?>
</div>
<div class="alert alert-danger <?php if(!$this->session->flashdata('error')) { ?>hidden<?php } ?>" id="idiv_error">
  <button class="close" data-close="alert"></button>
  <?php echo $this->session->flashdata('error'); ?>
</div>

