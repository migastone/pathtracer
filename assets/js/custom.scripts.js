//! custom.scripts.front.js
//! version : 1.0
//! authors : Imran Rashid
//! license : CreditBlitz.ca
//! create  : 31 Dec, 2015

jQuery(document).ready(function() 
{ 
	//login validations
	if(jQuery("#btn-login").length > 0)
	{
		jQuery('#btn-login').click(function(e) {
            var strFormId	=	"frm-login";
			var strError	=	"";
            if(jQuery("#"+strFormId+" #user_email").val() == "")
            {
                strError    +=  "<li>Email cannot be empty</li>";
                jQuery("#"+strFormId+" #user_email").addClass('has-error');
            }
            else
            {
                jQuery("#"+strFormId+" #user_email").removeClass('has-error');
            }
			if(jQuery("#"+strFormId+" #user_email").val() != "" && !validateEmailAddress(jQuery("#"+strFormId+" #user_email").val()))
			{
				 strError    +=  "<li>Email is not valid</li>";
				 jQuery("#"+strFormId+" #user_email").addClass('has-error');
			}
			if(jQuery("#"+strFormId+" #user_password").val() == "")
            {
                strError    +=  "<li>Password cannot be empty</li>";
                jQuery("#"+strFormId+" #user_password").addClass('has-error');
            }
            else
            {
                jQuery("#"+strFormId+" #user_password").removeClass('has-error');
            }
			
			if(strError == "")
			{
				jQuery("#"+strFormId).removeAttr('onsubmit').submit();  	
			}
			else
			{
				messageHandler(2, '<ul>'+strError+'</ul>');
			}	
        });
	}
	
	//datepicker
	if(jQuery('.datetime-picker').length > 0)
	{
		jQuery('.datetime-picker').datepicker({ 
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			yearRange: "-100:+0"
		});
	}
	
	//profile updation
	if(jQuery("#btn-update-profile").length > 0)
	{	
		jQuery('#btn-update-profile').click(function(e) {
            var strFormId				=	"frm-profile";
			var strError				=	"";
          	
			if(jQuery("#"+strFormId+" #userName").val() == "")
            {
                strError    +=  "<li>Username cannot be empty</li>";
                jQuery("#"+strFormId+" #userName").addClass('has-error');
            }
            else
            {
                jQuery("#"+strFormId+" #userName").removeClass('has-error');
            }
			
			if(jQuery("#"+strFormId+" #userEmail").val() == "")
            {
                strError    +=  "<li>Email cannot be empty</li>";
                jQuery("#"+strFormId+" #userEmail").addClass('has-error');
            }
            else
            {
                jQuery("#"+strFormId+" #userEmail").removeClass('has-error');
            }
			if(jQuery("#"+strFormId+" #userEmail").val() != "" && !validateEmailAddress(jQuery("#"+strFormId+" #userEmail").val()))
			{
				 strError    +=  "<li>Email is not valid</li>";
				 jQuery("#"+strFormId+" #userEmail").addClass('has-error');
			}
			
			if(jQuery("#"+strFormId+" #userPass").val() != "")
			{
				if(jQuery("#"+strFormId+" #userPass").val().length < 6)
				{
					strError    +=  "<li>New password must be at least 6 characters</li>";
					jQuery("#"+strFormId+" #userPass").addClass('has-error');
				}
				else
				{
					jQuery("#"+strFormId+" #userPass").removeClass('has-error');
				}
				if(jQuery("#"+strFormId+" #user_password_retype").val() == '')
				{
					strError    +=  "<li>Retype new password cannot be empty</li>";
					jQuery("#"+strFormId+" #user_password_retype").addClass('has-error');
				}
				else
				{
					jQuery("#"+strFormId+" #user_password_retype").removeClass('has-error');
				}
				if(jQuery("#"+strFormId+" #user_password_retype").val() != '' && jQuery("#"+strFormId+" #userPass").val() != jQuery("#"+strFormId+" #user_password_retype").val())
				{
					strError    +=  "<li>Password mismatch</li>";
					jQuery("#"+strFormId+" #user_password_retype").addClass('has-error');
				}
			}

			if(strError == "")
			{
              	jQuery("#"+strFormId).submit();  	
			}
			else
			{
				messageHandler(2, '<ul>'+strError+'</ul>');
			}	
        });
	}
	
});
//check if the youtube url format is valid
function yt_url_check(strURL) 
{
    var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
    return (strURL.match(p)) ? RegExp.$1 : false;
}

//Request Payment
function RequestPayment()
{
	if(confirm('Are you sure you want to send the payment request?'))
	{
		jQuery('#sbtRequestPayment').html("Sending please wait...").attr('disabled', true);
		jQuery.ajax({  
			url   	: jQuery("#hdnBaseURL").val()+"request-payment",
			type  	: 'post',  
			data  	: jQuery('#frmRequestPayment').serialize(),
			error 	: function()
			{            
			},
			success : function(data) 
			{
				if(data=='success')
				{
					jQuery('#sbtRequestPayment').html("Payment request sent successfully please wait...");
					setTimeout(function() {
						location.reload();
					}, 2000);
				}
			}
		});
	}
}


//will show different error, success, and info messages
function messageHandlerNoAnimation(nMessageType, strMessage)
{
	if(strMessage == "" || nMessageType < 1)
	{
		jQuery("#idiv_error").addClass('hidden');
		jQuery("#idiv_info").addClass('hidden');
		jQuery("#idiv_success").addClass('hidden');
		return false;
	}		
	switch(nMessageType)
	{
		case 1:
			jQuery("#idiv_error").addClass('hidden');
			jQuery("#idiv_info").addClass('hidden');
			jQuery("#idiv_success").removeClass('hidden');
			jQuery("#idiv_success").html(strMessage);
		break;
		
		case 2:
			jQuery("#idiv_success").addClass('hidden');
			jQuery("#idiv_info").addClass('hidden');
			jQuery("#idiv_error").removeClass('hidden');
			jQuery("#idiv_error").html(strMessage);
		break;
		
		case 3:
			jQuery("#idiv_success").addClass('hidden');
			jQuery("#idiv_error").addClass('hidden');
			jQuery("#idiv_info").removeClass('hidden');
			jQuery("#idiv_info").html(strMessage);
		break;
	}	
}

// Email validation function
function validateEmailAddress(strEmailAddress)
{
	var emailPattren	=	/^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	if (emailPattren.test(strEmailAddress))
	{
		return true;
	}
	else
	{
		return false;
	}
}

//will show different error, success, and info messages
function messageHandler(nMessageType, strMessage)
{
	jQuery('html, body').animate({
			 scrollTop: 0
		 }, 200, function() {
		
		switch(nMessageType)
		{
			case 1:
				jQuery("#idiv_error").addClass('hidden');
				jQuery("#idiv_info").addClass('hidden');
				jQuery("#idiv_success").removeClass('hidden');
				jQuery("#idiv_success").html(strMessage);
			break;
			
			case 2:
				jQuery("#idiv_success").addClass('hidden');
				jQuery("#idiv_info").addClass('hidden');
				jQuery("#idiv_error").removeClass('hidden');
				jQuery("#idiv_error").html(strMessage);
			break;
			
			case 3:
				jQuery("#idiv_success").addClass('hidden');
				jQuery("#idiv_error").addClass('hidden');
				jQuery("#idiv_info").removeClass('hidden');
				jQuery("#idiv_info").html(strMessage);
			break;
		}	
	});
}