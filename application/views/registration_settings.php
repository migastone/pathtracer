<?php $this->load->view('view_includes/header'); ?>
<!-- #################### Work Area Start #################### -->
<?php $this->load->view('view_includes/sidebar'); ?>
<?php
//echo '<pre>';
//print_r($settings);
?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-circle"></i> </li>
		<li> <a href="<?php echo base_url(); ?>smtp-settings">Settings</a> <i class="fa fa-circle"></i> </li>
		<li> <span> <?php echo $page_title; ?> </span> </li>
	</ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> <?php echo $page_title; ?> </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN FORM-->
<form action="<?php echo base_url(); ?>save-registration-settings" id="form_registration_settings" class="form-horizontal" method="post">
	<div class="form-body">
		<?php $this->load->view('messages'); ?>
		<div class="form-group">
			<label class="control-label col-md-3">Feature Status</label>
			<div class="col-md-2">
				<select id="<?php echo $settings[0]->setting_slug; ?>" name="<?php echo $settings[0]->setting_slug; ?>" class="form-control" onchange="if($(this).val() != '1') { $('#div_registration_disabled_reasons').removeClass('hidden'); } else { $('#div_registration_disabled_reasons').addClass('hidden'); }">
					<option value="1">Enabled</option>
					<option <?php echo $settings[0]->setting_data != 1 ? 'selected' : ''; ?> value="0">Disabled</option>
				</select>
			</div>
		</div>
		<div class="form-group <?php echo $settings[0]->setting_data ? 'hidden' : ''; ?>" id="div_registration_disabled_reasons">
			<label class="control-label col-md-3">Disabled Reason <span class="required">*</span></label>
			<div class="col-md-6">
				<textarea rows="5" class="form-control" id="<?php echo $settings[6]->setting_slug; ?>" name="<?php echo $settings[6]->setting_slug; ?>" placeholder="Disabled Reason"><?php echo $settings[6]->setting_data; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Enable "I'm Infected"?</label>
			<div class="col-md-2">
				<select id="<?php echo $settings[1]->setting_slug; ?>" name="<?php echo $settings[1]->setting_slug; ?>" class="form-control">
					<option value="1">Enabled</option>
					<option <?php echo $settings[1]->setting_data != 1 ? 'selected' : ''; ?> value="0">Disabled</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Terms and Conditions <span class="required">*</span></label>
			<div class="col-md-6">
				<textarea rows="15" class="form-control" id="<?php echo $settings[2]->setting_slug; ?>" name="<?php echo $settings[2]->setting_slug; ?>" placeholder="Terms and Conditions"><?php echo str_replace("<br />", "", $settings[2]->setting_data); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Countries (separated by comma) <span class="required">*</span></label>
			<div class="col-md-6">
				<textarea rows="5" class="form-control" id="<?php echo $settings[3]->setting_slug; ?>" name="<?php echo $settings[3]->setting_slug; ?>" placeholder="Countries (separated by comma)"><?php echo $settings[3]->setting_data; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Distance Warning in Meters<span class="required">*</span></label>
			<div class="col-md-1">
				<input value="<?php echo $settings[10]->setting_data; ?>" type="text" name="<?php echo $settings[10]->setting_slug; ?>" id="<?php echo $settings[10]->setting_slug; ?>" class="form-control" placeholder="Distance Warning Three" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Distance Warning Minutes<span class="required">*</span></label>
			<div class="col-md-1">
				<input value="<?php echo $settings[19]->setting_data; ?>" type="text" name="<?php echo $settings[19]->setting_slug; ?>" id="<?php echo $settings[19]->setting_slug; ?>" class="form-control" placeholder="Distance Warning Minutes" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Closed to Infected Person Status Title <span class="required">*</span></label>
			<div class="col-md-6">
				<input value="<?php echo $settings[17]->setting_data; ?>" type="text" name="<?php echo $settings[17]->setting_slug; ?>" id="<?php echo $settings[17]->setting_slug; ?>" class="form-control" placeholder="Closed to Infected Person Status Title" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Closed to Infected Person Status Text <span class="required">*</span></label>
			<div class="col-md-6">
				<textarea rows="5" class="form-control" id="<?php echo $settings[18]->setting_slug; ?>" name="<?php echo $settings[18]->setting_slug; ?>" placeholder="Closed to Infected Person Status Text"><?php echo $settings[18]->setting_data; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">You are Infected Status Title <span class="required">*</span></label>
			<div class="col-md-6">
				<input value="<?php echo $settings[15]->setting_data; ?>" type="text" name="<?php echo $settings[15]->setting_slug; ?>" id="<?php echo $settings[15]->setting_slug; ?>" class="form-control" placeholder="You are Infected Status Title" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">You are Infected Status Text <span class="required">*</span></label>
			<div class="col-md-6">
				<textarea rows="5" class="form-control" id="<?php echo $settings[16]->setting_slug; ?>" name="<?php echo $settings[16]->setting_slug; ?>" placeholder="You are Infected Status Text"><?php echo $settings[16]->setting_data; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">You are Safe Status Title <span class="required">*</span></label>
			<div class="col-md-6">
				<input value="<?php echo $settings[13]->setting_data; ?>" type="text" name="<?php echo $settings[13]->setting_slug; ?>" id="<?php echo $settings[13]->setting_slug; ?>" class="form-control" placeholder="You are Safe Status Title" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">You are Safe Status Text <span class="required">*</span></label>
			<div class="col-md-6">
				<textarea rows="5" class="form-control" id="<?php echo $settings[14]->setting_slug; ?>" name="<?php echo $settings[14]->setting_slug; ?>" placeholder="You are Safe Status Text"><?php echo $settings[14]->setting_data; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Welcome Push</label>
			<div class="col-md-2">
				<select id="<?php echo $settings[7]->setting_slug; ?>" name="<?php echo $settings[7]->setting_slug; ?>" class="form-control" onchange="if($(this).val() == '1') { $('.div_registration_welcome_push').removeClass('hidden'); } else { $('.div_registration_welcome_push').addClass('hidden'); }">
					<option value="1">Enabled</option>
					<option <?php echo $settings[7]->setting_data != 1 ? 'selected' : ''; ?> value="0">Disabled</option>
				</select>
			</div>
		</div>
		<div class="div_registration_welcome_push form-group <?php echo !$settings[7]->setting_data ? 'hidden' : ''; ?>">
			<label class="control-label col-md-3">Push Title <span class="required">*</span></label>
			<div class="col-md-6">
				<input value="<?php echo $settings[8]->setting_data; ?>" type="text" name="<?php echo $settings[8]->setting_slug; ?>" id="<?php echo $settings[8]->setting_slug; ?>" class="form-control" placeholder="Push Title" />
			</div>
		</div>
		<div class="div_registration_welcome_push form-group <?php echo !$settings[7]->setting_data ? 'hidden' : ''; ?>">
			<label class="control-label col-md-3">Push Text <span class="required">*</span></label>
			<div class="col-md-6">
				<textarea rows="5" class="form-control" id="<?php echo $settings[9]->setting_slug; ?>" name="<?php echo $settings[9]->setting_slug; ?>" placeholder="Push Text"><?php echo $settings[9]->setting_data; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Video Tutorial</label>
			<div class="col-md-2">
				<select id="<?php echo $settings[5]->setting_slug; ?>" name="<?php echo $settings[5]->setting_slug; ?>" class="form-control" onchange="if($(this).val() == '1') { $('#div_video_url, #div_video').removeClass('hidden'); } else { $('#div_video_url, #div_video').addClass('hidden'); }">
					<option value="0">Disabled</option>
					<option <?php echo $settings[5]->setting_data ? 'selected' : ''; ?> value="1">Enabled</option>
				</select>
			</div>
		</div>
		<div class="form-group <?php echo !$settings[5]->setting_data ? 'hidden' : ''; ?>" id="div_video_url">
			<label class="control-label col-md-3">Youtube URL <span class="required">*</span></label>
			<div class="col-md-6">
				<input value="<?php echo $settings[4]->setting_data; ?>" type="text" name="<?php echo $settings[4]->setting_slug; ?>" id="<?php echo $settings[4]->setting_slug; ?>" class="form-control" placeholder="Youtube URL" />
			</div>
		</div>
		<div class="form-group <?php echo !$settings[5]->setting_data ? 'hidden' : ''; ?>" id="div_video">
			<label class="control-label col-md-3"></label>
			<div class="col-md-6">
				<?php if ($settings[4]->setting_data && $settings[5]->setting_data) : ?>
					<div class="video_wrapper">
						<iframe width="100%" height="480" src="<?php echo get_youtube_rmbed_url($settings[4]->setting_data); ?>" frameborder="0" allowfullscreen></iframe>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green">Save Registration Settings</button>
				<button type="reset" class="btn grey-salsa btn-outline">Cancel</button>
			</div>
		</div>
	</div>
</form>
<!-- END FORM-->
</div>
<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- #################### Work Area End #################### -->
<?php $this->load->view('view_includes/footer'); ?>
<style type="text/css" media="screen">
	.video_wrapper {
		position: relative;
		padding-bottom: 56.25%;
		/* 16:9 */
		padding-top: 25px;
		height: 0;
	}

	.video_wrapper iframe {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}
</style>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/pages/scripts/registration_settings.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->