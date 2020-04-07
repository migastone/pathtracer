var Login = function() {

    var handleLogin = function() {

        $('.login-form').validate({
            //errorElement: 'span', //default input error message container
            //errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                user_email: {
                    required: true,
					email: true
                },
                user_password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                user_email: {
                    required: "Email is required.",
					email: "Email is invalid."
                },
                user_password: {
                    required: "Password is required."
                }
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            showErrors: function(errorMap, errorList) {
                submitted = true;
				if (submitted) {
                    var summary = "";
                    jQuery.each(errorList, function() { if(this.message != "") { summary += this.message + '<br />' +"\n"; } });
                    var errorContainer = jQuery('.alert-danger:eq(0)');
                    errorContainer.fadeIn().html(summary);
                    submitted = false;
					(summary != "") ? jQuery('.alert-danger:eq(0)').removeClass('hidden') : $('.alert-danger:eq(0)').addClass('hidden');
                }
            },   

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Email is required.",
					email: "Email is invalid.",
                }
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            showErrors: function(errorMap, errorList) {
                submitted = true;
				if (submitted) {
                    var summary = "";
                    jQuery.each(errorList, function() { if(this.message != "") { summary += this.message + '<br />' +"\n"; } });
                    var errorContainer = jQuery('.alert-danger:eq(1)');
                    errorContainer.fadeIn().html(summary);
                    submitted = false;
					(summary != "") ? jQuery('.alert-danger:eq(1)').removeClass('hidden') : $('.alert-danger:eq(1)').addClass('hidden');
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }

    return {
        //main function to initiate the module
        init: function() {

            handleLogin();
            handleForgetPassword();

        }

    };

}();

jQuery(document).ready(function() {
    Login.init();
});