<?php $this->load->view('view_includes/header'); ?>
<!-- #################### Work Area Start #################### -->
<?php $this->load->view('view_includes/sidebar'); ?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-circle"></i> </li>
    <li> <a href="<?php echo base_url();?>users">Users</a> <i class="fa fa-circle"></i> </li>
    <li> <span><?php echo $strPageTitle; ?></span> </li>
  </ul>
</div>
<!-- END PAGE BAR --> 
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?php echo $strPageTitle; ?> </h3>
<!-- END PAGE TITLE--> 
<!-- END PAGE HEADER-->

<?php $this->load->view('messages'); ?>
<select style="width:300px;margin: 10px 2px 10px 10px;" id="listFilterTalent" name="listFilterTalent" class="form-control pull-right" onchange="if(this.value > 0){ window.location = '<?php echo base_url();?>users/'+this.value; } else { window.location = '<?php echo base_url();?>users'; }">
	<?php if($nGroupId == $objGroup->pk_group_id){ ?>
    <option value="0">Filter By Group</option>
    <?php } else { ?>
    <option value="0" style="color:#d9534f;font-weight:bold;">Remove Filter</option>
    <?php } ?>
    <?php
        foreach($arrGroups['results'] as $objGroup)
        {
    ?>	
            <option value="<?php echo $objGroup->pk_group_id; ?>" <?php if($nGroupId == $objGroup->pk_group_id){?>selected="selected"<?php } ?>><?php echo $objGroup->group_name; ?></option>
    <?php
        }
    ?>
</select>
<table class="table table-bordered" data-toggle="table" data-url="<?php echo base_url();?>users<?php if($nGroupId > 0){?>/<?php echo $nGroupId; }?>" data-side-pagination="server" data-pagination="true" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-export="true" data-page-list="[10, 20, 50, 100, 200, 300, 400, 500]">
    <thead>
        <tr class="th">
            <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents" data-align="center"></th>
			<th data-field="user_first_name" data-sortable="true">First Name</th>
            <th data-field="user_last_name" data-sortable="true">Last Name</th>
            <th data-field="user_email" data-sortable="true">Email</th>
            <th data-field="group_name" data-sortable="true">Group</th>
            <th data-field="creation_date" data-sortable="true">Date</th>
            <th data-field="user_status" data-sortable="true">Status</th>
        </tr>
    </thead>
</table>

</div>
<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER --> 
<!-- #################### Work Area End #################### -->
<?php $this->load->view('view_includes/footer'); ?>
<link rel='stylesheet' id='bootstrap-table.css'  href='<?php echo base_url();?>assets/js/bootstrap_table/bootstrap-table.css' type='text/css' media='all' />
<script src="<?php echo base_url();?>assets/js/bootstrap_table/bootstrap-table.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_table/extensions/filter/bootstrap-table-filter.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_table/extensions/export/tableExport.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_table/extensions/export/jquery.base64.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap_table/extensions/export/bootstrap-table-export.js"></script>
<script>
	function operateFormatter(value, row, index) 
	{
        if(row.pk_user_id != parseInt(jQuery('#hdnUserId').val()))
		{
			if(row.user_c_status < 1)
			{
				return [
				'<a class="edit ml10" href="javascript:void(0)" title="Edit">',
					'<span class="glyphicon glyphicon-edit" style="color:black;"></span>',
				'</a>',
				'&nbsp;&nbsp;&nbsp;<a class="remove ml10" href="javascript:void(0)" title="Remove">',
					'<span class="glyphicon glyphicon-trash" style="color:black;"></span>',
				'</a>',
				'&nbsp;&nbsp;&nbsp;<a class="status ml10" href="javascript:void(0)" title="Enable?">',
					'<span class="glyphicon glyphicon-eye-close" style="color:black;"></span>',
				'</a>',
				].join('');	
				
			}
			else
			{
				return [
				'<a class="edit ml10" href="javascript:void(0)" title="Edit">',
					'<span class="glyphicon glyphicon-edit" style="color:black;"></span>',
				'</a>',
				'&nbsp;&nbsp;&nbsp;<a class="remove ml10" href="javascript:void(0)" title="Remove">',
					'<span class="glyphicon glyphicon-trash" style="color:black;"></span>',
				'</a>',
				'&nbsp;&nbsp;&nbsp;<a class="status ml10" href="javascript:void(0)" title="Disable?">',
					'<span class="glyphicon glyphicon-eye-open" style="color:black;"></span>',
				'</a>',
				].join('');	
			}
		}
		else
		{
			return [
                '<span class="glyphicon glyphicon-edit" style="color:grey;"></span>',
				'&nbsp;&nbsp;&nbsp<span class="glyphicon glyphicon-trash" style="color:grey;"></span>',
				'&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" style="color:grey;"></span>',
        	].join('');
		}
    }
	window.operateEvents = {
        'click .edit': function (e, value, row, index) {
            window.location = '<?php echo base_url();?>edit-user/'+row.pk_user_id+'/'+row.fk_group_id;
        },
		'click .remove': function (e, value, row, index) {
            if(confirm('Are you sure you want to delete that user?'))
			{
				window.location = '<?php echo base_url();?>delete-user/'+row.pk_user_id+'/'+row.fk_group_id;
			}
        },
		'click .status': function (e, value, row, index) {
            var strStatus	=	(row.user_c_status > 0) ? 'disable' : 'enable';
			var nStatus		=	(row.user_c_status > 0) ? 0 : 1;
			if(confirm('Are you sure you want to '+strStatus+' that user?'))
			{
				window.location = '<?php echo base_url();?>update-user-status/'+row.pk_user_id+'/'+nStatus;
			}
        }
    };
</script>
