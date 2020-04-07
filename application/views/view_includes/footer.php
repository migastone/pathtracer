</div>
<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER --> 
<!-- #################### Work Area End #################### -->
<?php if(!$this->session->userdata('isLogin')) { ?>
<!-- BEGIN PAGE FOOTER -->
<div class="copyright"> <?php echo SITE_COPYRIGHT; ?> </div>
<!-- END PAGE FOOTER -->
<?php } else { ?>
<!-- BEGIN PAGE FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> <?php echo SITE_COPYRIGHT; ?> </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<?php } ?>
<!-- END PAGE FOOTER -->

<!--[if lt IE 9]>
<script src="<?php echo base_url();?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url();?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]--> 
<!-- BEGIN CORE PLUGINS --> 
<script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script> 
<!-- END CORE PLUGINS --> 
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/global/plugins/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/amcharts/themes/light.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS --> 
<!-- BEGIN THEME GLOBAL SCRIPTS --> 
<script src="<?php echo base_url();?>assets/global/scripts/app.min.js" type="text/javascript"></script> 
<!-- END THEME GLOBAL SCRIPTS --> 
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo base_url();?>assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script>
	jQuery(document).ready(function(e) {
		if(jQuery("#pulsate-regular").length)
		{
			jQuery("#pulsate-regular").pulsate({color:"#36c6d3"});
		}
		if(jQuery("#reload-orders").length)
		{
			jQuery("#reload-orders").click(function(e) {
				if(confirm("Are you sure you want to reload the orders?"))
				{
                	window.location = "<?php echo base_url();?>force-load-orders";
				}
			});
		}
	});
	function login_as(email, password) {
		if(email && password && confirm('You will be logged out from this account. Are you sure about this action?')) {
			email = jQuery.trim(email);
			password = jQuery.trim(password);
			jQuery("#user_email").val(email);
			jQuery("#user_password").val(password);
			jQuery("#login-form").submit();
		}
	}  
</script>
<!-- END THEME LAYOUT SCRIPTS -->
</body></html>