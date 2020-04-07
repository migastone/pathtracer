<?php $this->load->view('view_includes/header'); ?>
<!-- #################### Work Area Start #################### -->
<?php $this->load->view('view_includes/sidebar'); ?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-circle"></i> </li>
    <li> <a href="<?php echo base_url();?>smtp-settings">Settings</a> <i class="fa fa-circle"></i> </li>
    <li> <span> <?php echo $page_title; ?> </span> </li>
  </ul>
</div>
<!-- END PAGE BAR --> 
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?php echo $page_title; ?> </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN FORM-->
<?php if($settings->num_rows()) : ?>
<form action="<?php echo base_url();?>save-smtp-settings" id="form_smtp_settings" class="form-horizontal" method="post">
    <div class="form-body">
        <?php $this->load->view('messages'); ?>
    <?php foreach($settings->result() as $setting) : ?>    
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo str_replace('Bcc', 'BCC', ucwords(str_replace('_', ' ', str_replace('smtp_', 'SMTP ', $setting->setting_slug)))); ?>
                <span class="required"> * </span>
            </label>
            <div class="col-md-4">
                <input type="text" name="<?php echo $setting->setting_slug; ?>" required class="form-control" value="<?php echo $setting->setting_data; ?>" /> 
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">Save SMTP Settings</button>
                <button type="reset" class="btn grey-salsa btn-outline">Cancel</button>
            </div>
        </div>
    </div>
</form>
<?php endif; ?>
<!-- END FORM-->
</div>
<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER --> 
<!-- #################### Work Area End #################### -->
<?php $this->load->view('view_includes/footer'); ?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/pages/scripts/smtp.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS --> 