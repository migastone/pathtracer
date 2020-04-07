<?php $this->load->view('view_includes/header'); ?>
<!-- #################### Work Area Start #################### -->
<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo"> <a href="<?php echo base_url();?>"> <img src="<?php echo base_url();?>assets/img/logo_small.png" alt="<?php echo SITE_TITLE; ?>" /> </a> </div>
<!-- END LOGO --> 
<!-- BEGIN LOGIN -->
<div class="content"> 
  <!-- BEGIN LOGIN FORM -->
  <form class="login-form" action="<?php echo base_url();?>authenticate" method="post">
    <h3 class="form-title font-green">Sign In</h3>
    <?php $this->load->view('messages'); ?>
    <div class="form-group"> 
      <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
      <label class="control-label visible-ie8 visible-ie9">Email</label>
      <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="user_email" value="<?php echo $_COOKIE['pc_user_email'];?>" />
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Password</label>
      <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="user_password" value="<?php echo $_COOKIE['pc_user_password'];?>" />
    </div>
    <div class="form-actions">
      <button type="submit" class="btn green uppercase">Login</button>
      <label class="rememberme check">
        <input type="checkbox" name="remember" value="1" />
        Remember </label>
      <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> </div>
  </form>
  <!-- END LOGIN FORM --> 
  <!-- BEGIN FORGOT PASSWORD FORM -->
  <form class="forget-form" action="<?php echo base_url();?>forget-password" method="post">
    <h3 class="font-green">Forget Password ?</h3>
    <?php $this->load->view('messages'); ?>
    <p> Enter your e-mail address below to reset your password. </p>
    <div class="form-group">
      <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" />
    </div>
    <div class="form-actions">
      <button type="button" id="back-btn" class="btn btn-default">Back</button>
      <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
  </form>
  <!-- END FORGOT PASSWORD FORM --> 
</div>
<!-- #################### Work Area End #################### -->
<?php $this->load->view('view_includes/footer'); ?>
<!-- BEGIN PAGE LEVEL SCRIPTS --> 
<script src="<?php echo base_url();?>assets/pages/scripts/login.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS --> 
