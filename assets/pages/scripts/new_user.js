var NewUserValidation = function () {

    // basic validation
    var handleNewUser = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_new_user');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    user_first_name: {
                        required: true,
                        //lettersonly: true
                    },
					user_last_name: {
                        required: true,
                        //lettersonly: true
                    },
					/*user_company: {
                        required: true,
                    },*/
                    user_email: {
                        required: true,
                        email: true
                    },
					user_password: {
						required: true,
                        minlength: 6,
                    },
					user_password_retype: {
						required: true,
					}
                },
				messages: {
					user_first_name: {
						required: "First name is required.",
						//lettersonly: "First name must be a string."
					},
					user_last_name: {
						required: "Last name is required.",
						//lettersonly: "Last name must be a string."
					},
					/*user_company: {
						required: "Company is required.",
						lettersonly: "Last name must be a string."
					},*/
					user_email: {
						required: "Email is required.",
						email: "Email is invalid."
					},
					user_password: {
						required: "Password is required.",
						minlength: "Password must be at least 6 characters."
					},
					user_password_retype: {
						required: "Re-Type password is required."
					}
				},

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    form.submit();
                }
            });


    }

    return {
        //main function to initiate the module
        init: function () {
            handleNewUser();
        }

    };

}();

jQuery(document).ready(function() {
    NewUserValidation.init();
});