var RegistrationSettingsValidation = function () {

    // basic validation
    var handleRegistrationSettings = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_registration_settings');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
              errorElement: "span", //default input error message container
              errorClass: "help-block help-block-error", // default input error message class
              focusInvalid: false, // do not focus the last invalid input
              ignore: "", // validate all fields including form hidden input
              rules: {
                registration_disabled_reason: {
                  required: function() {
                    return $("#registration_is_feature_enabled")
                      .children("option:selected")
                      .val() != "1"
                      ? true
                      : false;
                  }
                },
                registration_terms_and_conditions: {
                  required: true
                },
                registration_countries: {
                  required: true
                },
                registration_distance_warning: {
                  required: true,
                  number: true
				},
				registration_distance_warning_minutes: {
                  required: true,
                  number: true
                },
                registration_status_warning_title: {
                  required: true
                },
                registration_status_warning_text: {
                  required: true
                },
                registration_status_infected_title: {
                  required: true
                },
                registration_status_infected_text: {
                  required: true
                },
                registration_status_safe_title: {
                  required: true
                },
                registration_status_safe_text: {
                  required: true
                },
                registration_welcome_push_title: {
                  required: function() {
                    return $("#registration_is_welcome_push_enabled")
                      .children("option:selected")
                      .val() == "1"
                      ? true
                      : false;
                  }
                },
                registration_welcome_push_text: {
                  required: function() {
                    return $("#registration_is_welcome_push_enabled")
                      .children("option:selected")
                      .val() == "1"
                      ? true
                      : false;
                  }
                },
                registration_youtube_url: {
                  required: function() {
                    return $("#registration_is_video_enabled")
                      .children("option:selected")
                      .val() == "1"
                      ? true
                      : false;
                  },
                  url: function() {
                    return $("#registration_is_video_enabled")
                      .children("option:selected")
                      .val() == "1"
                      ? true
                      : false;
                  }
                }
              },
              messages: {},

              invalidHandler: function(event, validator) {
                //display error alert on form submit
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
              },

              highlight: function(element) {
                // hightlight error inputs
                $(element)
                  .closest(".form-group")
                  .addClass("has-error"); // set error class to the control group
              },

              unhighlight: function(element) {
                // revert the change done by hightlight
                $(element)
                  .closest(".form-group")
                  .removeClass("has-error"); // set error class to the control group
              },

              success: function(label) {
                label.closest(".form-group").removeClass("has-error"); // set success class to the control group
              },

              submitHandler: function(form) {
                form.submit();
              }
            });


    }

    return {
        //main function to initiate the module
        init: function () {
            handleRegistrationSettings();
        }

    };

}();

jQuery(document).ready(function() {
    RegistrationSettingsValidation.init();
});