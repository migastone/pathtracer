<?php $this->load->view('view_includes/header'); ?>
<!-- #################### Work Area Start #################### -->
<?php $this->load->view('view_includes/sidebar'); ?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-circle"></i> </li>
    <li> <a href="<?php echo base_url();?>clients">Clients</a> <i class="fa fa-circle"></i> </li>
    <li> <span> <?php echo $page_title; ?> </span> </li>
  </ul>
</div>
<!-- END PAGE BAR --> 
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?php echo $page_title; ?> </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->

<!-- BEGIN FORM-->
<form action="<?php echo base_url();?>update-client" id="form_new_client" class="form-horizontal" method="post">
    <input type="hidden" name="client_id" value="<?php echo $client->client_id; ?>" />
    <div class="form-body">
    	<?php $this->load->view('messages'); ?>
        <div class="form-group">
            <label class="control-label col-md-3">Title <span class="required">*</span></label>
            <div class="col-md-4">
                <input type="text" id="title" name="title" required class="form-control" placeholder="Title *" value="<?php echo $client->title; ?>" /> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Description</label>
            <div class="col-md-4">
                <textarea rows="5" class="form-control" id="description" name="description" placeholder="Description"><?php echo $client->description; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Status</label>
            <div class="col-md-2">
                <select id="status" name="status" class="form-control">
                    <option value="1">Enabled</option>
                    <option <?php echo !$client->status ? 'selected' : ''; ?> value="0">Disabled</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">Save Client</button>
                <button type="reset" class="btn grey-salsa btn-outline">Cancel</button>
            </div>
        </div>
    </div>
</form>
<!-- #################### Work Area End #################### -->
<?php $this->load->view('view_includes/footer'); ?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/pages/scripts/new_client.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS --> 