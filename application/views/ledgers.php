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
<?php if ( $device_id ) : ?>
<?php 
	$curl = curl_init();
	curl_setopt_array( $curl , [
		CURLOPT_URL => base_url() . "api/my_status?o4FLb6OWVq6vXgaes1zNS0NDKhQM44=C23412B9-ADC4-4438-BE3C-3D7ADCA3541D&uuid=" . $device->uuid,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	] );
	$response = curl_exec( $curl );

	curl_close( $curl );
	$status = json_decode( $response )->data;
	switch ( $status->status_class ) {
		case 'status-infected' : 
			$panel_class = 'red-thunderbird';
		break;
		case 'status-warning' : 
			$panel_class = 'yellow-lemon';
		break;
		default :
			$panel_class = 'green-jungle';
	}
	//echo $status->country;
?>
<div class="portlet box <?php echo $panel_class; ?> mt-20">
	<div class="portlet-title">
		<div class="caption">
			Device Details
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<div class="status <?php echo $status->status_class; ?>">
			<h2><?php echo $status->status_title; ?></h2>
			<p><?php echo $status->status_text; ?></p>
		</div>
		<table class="table table-bordered table-striped mt-20 red">
			<tbody>
				<tr>
					<th>Device Id</th>
					<td><?php echo $status->device_id; ?></td>
					<th>Client Id</th>
					<td><?php echo $status->client_id; ?></td>
				</tr>
				<tr>
					<th>UUID</th>
					<td><?php echo $status->uuid; ?></td>
					<th>Platform</th>
					<td><?php echo $status->platform; ?> <?php echo $status->version; ?></td>
				</tr>
				<tr>
					<th>Manufacturer</th>
					<td><?php echo $status->manufacturer; ?></td>
					<th>Country</th>
					<td><?php echo $status->country; ?></td>
				</tr>
				<tr>
					<th>Status</th>
					<td><?php echo $status->status ? '<span class="label label-sm label-success"> Enabled </span>' : '<span class="label label-sm label-danger"> Disabled </span>'; ?></td>
					<th>Warning Device Id</th>
					<td><?php echo $status->status_class == 'status-warning' ? $status->infected_device_id : 'N/A'; ?></td>
				</tr>
				<tr>
					<th>Warning Device Distance</th>
					<td><?php echo $status->status_class == 'status-warning' ? $status->infected_device_distance . 'meters' : 'N/A'; ?></td>
					<th>Warning Device Date</th>
					<td><?php echo $status->status_class == 'status-warning' && ! is_null_or_empty( $status->infected_device_date ) && $status->infected_device_date != '0000-00-00 00:00:00' ? format_date( $status->infected_device_date ) . ' ' . format_time( $status->infected_device_date ) : 'N/A'; ?></td>
				</tr>
				<tr>
					<th>Is Infected?</th>
					<td><?php echo $status->status_class == 'status-infected' ? '<span class="label label-sm label-danger"> Yes </span>' : 'N/A'; ?></td>
					<th>Infected Marked By</th>
					<td><?php echo $status->status_class == 'status-infected' ? $status->infected_marked_by : 'N/A'; ?></td>
				</tr>
				<tr>
					<th>System Infected At</th>
					<td><?php echo $status->status_class == 'status-infected' ? format_date( $status->infected_at ) . ' ' . format_time( $status->infected_at ) : 'N/A'; ?></td>
					<th>Device Infected At</th>
					<td><?php echo $status->status_class == 'status-infected' &&  $status->infected_marked_by == 'Self' ? format_date( $status->device_infected_at ) . ' ' . format_time( $status->device_infected_at ) : 'N/A'; ?></td>
				</tr>
				<tr>
					<th>Last Connection At</th>
					<td><?php echo format_date( $status->last_connection_at ) . ' ' . format_time( $status->last_connection_at ); ?></td>
					<th>Created At</th>
					<td><?php echo format_date( $status->created_at ) . ' ' . format_time( $status->created_at ); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php endif; ?>
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?php echo $page_title; ?> </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<?php $this->load->view('messages'); ?>
<select style="width:300px;margin: 10px 2px 10px 10px;" id="device_filter" name="device_filter" class="form-control pull-right" onchange="if(this.value > 0){ window.location = '<?php echo base_url(); ?>ledgers/listening/'+this.value; } else { window.location = '<?php echo base_url(); ?>ledgers'; }">
	<?php if ( $device_id == 0 ) { ?>
    <option value="0">Filter By Device</option>
    <?php } else { ?>
    <option value="0" style="color:#d9534f;font-weight:bold;">Remove Filter</option>
    <?php } ?>
	<?php
	foreach ( $devices->result() as $device ) {
	?>
		<option value="<?php echo $device->device_id; ?>" <?php if ( $device_id == $device->device_id ) { ?>selected="selected" <?php } ?>><?php echo $device->uuid; ?></option>
	<?php
	}
	?>
</select>
<table class="table table-bordered" data-toggle="table" data-url="<?php echo base_url(); ?>ledgers<?php if ( $device_id ) : ?>/listening/<?php echo $device_id; endif; ?>" data-side-pagination="server" data-pagination="true" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-export="true" data-page-list="[10, 20, 50, 100, 200, 300, 400, 500]">
	<thead>
		<tr class="th">
			<th class="<?php if ( $device_id ) : ?>hidden<?php endif; ?>" data-field="uuid" data-sortable="true">UUID</th>
			<th data-field="latitude" data-sortable="true">Latitude</th>
			<th data-field="longitude" data-sortable="true">Longitude</th>
			<th data-field="device_timezone" data-sortable="true">Device Timezone</th>
			<th data-field="device_created_at" data-sortable="true">Device Created At</th>
			<th data-field="created_at" data-sortable="true">System Created At</th>
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
<style>
.status {
  color: #fff;
  text-align: center;
}
.status h2 {
  color: #fff;
  text-align: center;
  padding-top: 5px;
  padding-bottom: 6px;
}
.status-infected {
  background-color: #e42112;
  border: 5px solid #ef473a;
}
.status-infected h2 {
  background-color: #ef473a;
}
.status-safe {
  background-color: #28a54c;
  border: 5px solid #33cd5f;
}
.status-safe h2 {
  background-color: #33cd5f;
}
.status-warning {
  background-color: #e6b500;
  border: 5px solid #ffc900;
}
.status-warning h2 {
  background-color: #ffc900;
}
.mt-20 {
  margin-top: 20px;
}
</style>