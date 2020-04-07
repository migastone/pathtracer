<?php $this->load->view('view_includes/header'); ?>
<!-- #################### Work Area Start #################### -->
<?php $this->load->view('view_includes/sidebar'); ?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-circle"></i> </li>
    <li> <a href="<?php echo base_url();?>clients">Clients</a> <i class="fa fa-circle"></i> </li>
    <li> <span><?php echo $page_title; ?></span> </li>
  </ul>
</div>
<!-- END PAGE BAR --> 
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?php echo $page_title; ?> </h3>
<!-- END PAGE TITLE--> 
<!-- END PAGE HEADER-->

<?php $this->load->view('messages'); ?>
<table class="table table-bordered" data-toggle="table" data-url="<?php echo base_url();?>clients" data-side-pagination="server" data-pagination="true" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-export="true" data-page-list="[10, 20, 50, 100, 200, 300, 400, 500]">
    <thead>
        <tr class="th">
            <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents" data-align="center"></th>
			<th data-field="title" data-sortable="true">Title</th>
            <th data-field="description" data-sortable="true">Description</th>
            <th data-field="token" data-sortable="true">Token</th>
            <th data-field="created_at" data-sortable="true">Created At</th>
            <th data-field="updated_at" data-sortable="true">Updated At</th>
        </tr>
    </thead>
</table>
<!-- #################### Work Area End #################### -->
<?php $this->load->view('view_includes/footer'); ?>
<link rel='stylesheet' id='bootstrap-table.css'  href='<?php echo base_url();?>assets/js/bootstrap_table/bootstrap-table.css' type='text/css' media='all' />
<script src="<?php echo base_url();?>assets/js/bootstrap_table/bootstrap-table.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_table/extensions/filter/bootstrap-table-filter.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_table/extensions/export/tableExport.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_table/extensions/export/jquery.base64.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_table/extensions/export/bootstrap-table-export.js"></script>
<script>
	function operateFormatter(value, row, index) {
		var status = row.status == '1' ? 'open' : 'close';
		var status_title = row.status == '1' ? 'Disable?' : 'Enable?';
		return [
			'<a class="edit ml10" href="javascript:void(0)" title="Edit">',
				'<span class="glyphicon glyphicon-edit" style="color:black;"></span>',
			'</a>',
			'&nbsp;&nbsp;&nbsp;<a class="remove ml10" href="javascript:void(0)" title="Remove">',
				'<span class="glyphicon glyphicon-trash" style="color:black;"></span>',
			'</a>',
			'&nbsp;&nbsp;&nbsp;<a class="status ml10" href="javascript:void(0)" title="'+status_title+'">',
				'<span class="glyphicon glyphicon-eye-'+status+'" style="color:black;"></span>',
			'</a>',
		].join('');	
    }
	window.operateEvents = {
        'click .edit': function (e, value, row, index) {
            window.location = '<?php echo base_url();?>edit-client/' + row.client_id;
        },
		'click .remove': function (e, value, row, index) {
            if(confirm('All the client-related data will be lost. Are you sure you want to delete that client?')) {
				window.location = '<?php echo base_url();?>delete-client/' + row.client_id;
			}
        },
		'click .status': function (e, value, row, index) {
			if(confirm('Are you sure you want to ' + (row.status == '1' ? 'disable' : 'enable') + ' that client?')) {
				window.location = '<?php echo base_url();?>update-client-status/' + row.client_id + '/' + (row.status == '1' ? 0 : 1);
			}
        }
    };
</script>
