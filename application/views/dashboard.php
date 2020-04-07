<?php $this->load->view('view_includes/header'); ?>
<?php $this->load->view('view_includes/sidebar'); ?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li> <a href="<?php echo base_url();?>dashboard">Home</a> <i class="fa fa-circle"></i> </li>
    <li> <span><?php echo $page_title; ?></span> </li>
  </ul>
</div>
<!-- END PAGE BAR --> 
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?php echo $page_title; ?> <small>dashboard &amp; statistics</small></h3>
<!-- END PAGE TITLE--> 
<!-- END PAGE HEADER-->
<?php $this->load->view('messages');?>

<?php $this->load->view('view_includes/footer'); ?>