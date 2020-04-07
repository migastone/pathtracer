<?php $this->load->view('view_includes/header'); ?>
<!-- #################### Work Area Start #################### -->
<?php $this->load->view('view_includes/sidebar'); ?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-circle"></i> </li>
		<li> <a href="<?php echo base_url(); ?>clients">Clients</a> <i class="fa fa-circle"></i> </li>
		<li> <span><?php echo $page_title; ?></span> </li>
	</ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?php echo $page_title; ?> </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<?php $this->load->view('messages'); ?>
<select style="width:300px;margin: 10px 2px 10px 10px;" id="client_filter" name="client_filter" class="form-control pull-right" onchange="if(this.value > 0){ window.location = '<?php echo base_url(); ?>devices/listening/'+this.value; } else { window.location = '<?php echo base_url(); ?>devices'; }">
	<?php if ( $client_id == 0 ) { ?>
    <option value="0">Filter By Client</option>
    <?php } else { ?>
    <option value="0" style="color:#d9534f;font-weight:bold;">Remove Filter</option>
    <?php } ?>
	<?php
	foreach ( $clients->result() as $client ) {
	?>
		<option value="<?php echo $client->client_id; ?>" <?php if ( $client_id == $client->client_id ) { ?>selected="selected" <?php } ?>><?php echo $client->title; ?></option>
	<?php
	}
	?>
</select>
<table class="table table-bordered" data-toggle="table" data-url="<?php echo base_url(); ?>devices<?php if ( $client_id ) : ?>/listening/<?php echo $client_id; endif; ?>" data-side-pagination="server" data-pagination="true" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-export="true" data-page-list="[10, 20, 50, 100, 200, 300, 400, 500]">
	<thead>
		<tr class="th">
			<th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents" data-align="center"></th>
			<th data-field="is_infected">Is Infected?</th>
			<th data-field="uuid" data-sortable="true">UUID</th>
			<th data-field="platform" data-sortable="true">Platform</th>
			<th data-field="version" data-sortable="true">Version</th>
			<th data-field="manufacturer" data-sortable="true">Manufacturer</th>
			<th data-field="created_at" data-sortable="true">Join Date</th>
			<th data-field="last_connection_at" data-sortable="true">Last Connection</th>
			<th data-field="status_badge">Status</th>
		</tr>
	</thead>
</table>
<!-- #################### Work Area End #################### -->
<?php $this->load->view('view_includes/footer'); ?>
<link rel='stylesheet' id='bootstrap-table.css' href='<?php echo base_url(); ?>assets/js/bootstrap_table/bootstrap-table.css' type='text/css' media='all' />
<script src="<?php echo base_url(); ?>assets/js/bootstrap_table/bootstrap-table.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap_table/extensions/filter/bootstrap-table-filter.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap_table/extensions/export/tableExport.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap_table/extensions/export/jquery.base64.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap_table/extensions/export/bootstrap-table-export.js"></script>
<script>
	function operateFormatter(value, row, index) {
		return [
			'<a class="details ml10" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" title="Device Details">',
			'<span class="icon-drawer" style="color:black;"></span>',
			'</a>'
			//'<a class="edit ml10" href="javascript:void(0)" title="Edit">',
			//'<span class="glyphicon glyphicon-edit" style="color:black;"></span>',
			//'</a>',
			//'&nbsp;&nbsp;&nbsp;<a class="remove ml10" href="javascript:void(0)" title="Remove">',
			//'<span class="glyphicon glyphicon-trash" style="color:black;"></span>',
			//'</a>',
			//'<a class="status ml10" href="javascript:void(0)" title="' + status_title + '">',
			//'<span class="glyphicon glyphicon-eye-' + status + '" style="color:black;"></span>',
			//'</a>',
		].join('');
	}
	window.operateEvents = {
		'click .details': function(e, value, row, index) {
			window.location = '<?php echo base_url(); ?>ledgers/listening/' + row.device_id;
		}
	};
	$(document).ajaxComplete(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>