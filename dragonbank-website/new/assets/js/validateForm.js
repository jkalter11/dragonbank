$ = jQuery.noConflict();

$(document).ready(function() {

	$("#new-entity").validate({
		rules: {
			'codelistname': {
				required: true,
				remote: "../ajax/ajax_check_entity"
			}
		},
		messages:{
			'codelistname': {remote: "Entity name already in use."}
		}
	});
	
	$('#user-edit').validate({
		rules: {
			'user_info[user_email]': {email: true},
			'user_info[password]': {minlength: 6},
			'user_info[check-password]': {equalTo: '#password' },
			'user_info[dev_email]': {email: true},
			'user_info[pro_email]': {email: true}
		},
		messages: {
			'user_info[password]': {minlength: "Password must be at least {0} characters long"},
			'user_info[check-password]': {equalTo: "Passwords do not match"}
		}
	});
	
	$('#settings-edit').validate({
		rules: {
			'user_info[dev_email]': {email: true},
			'user_info[pro_email]': {email: true}
		}
	});

    $("#contact-form").validate({
       rules: {
           name: {required: true},
           email: {email: true, required: true},
           message: {required: true},
           captcha: {required: true}
       }
    });
	
	$("#order-form").validate({
		rules: {
            'lname': {required: true},
            'fname': {required: true},
			'email': {email: true, required: true},
			'message': {required: true},
			'check-email': {equalTo: '#email'},
			'captcha': {required: true}
		}
	});
	
	$('#signup-edit').validate({
		rules: {
			'code': {
				required: true,
				remote: 'ajax/ajax_checkcode'
			},
		},
		messages: {
			'code': "Please Enter a Valid Access Code.",
		}
	});
	
	$('#signup2-edit').validate({
		rules: {
			'user_info[user_email]': {
				email: true, 
				required: true,
				remote:	{
					url: 'ajax/ajax_checkemail',
					type: "GET",
					data:{
						email: function() {
							return $("#email").val();
						}
					}
				}
			},
			'user_info[user_password]': {minlength: 6, required: true},
			'check_parent_password': {equalTo: '#password' },
			'user_info[check_email]': {equalTo: '#email'},
			'user_info[user_full_name]': {required: true},
			'user_info[user_phone]': {required: true},
			'user_info[kids]': {required: true},
			'child_info[user_full_name]': {required: true},
			'child_info[birthday]': {required: true},
			'child_info[gender]': {required: true},
			'child_info[user_name]': {
				required: true,
				minlength: 4,
				remote: {
					url: 'ajax/ajax_checkusername',
					type: "GET",
					data:{
						username: function() {
							return $( "#username" ).val();
						}
					}
				}
			},
			'child_info[user_password]': {minlength: 6, required: true},
			'check_child_password': {equalTo: '#child-password' },
		},
		messages: {
			'user_info[password]': {minlength: "Password must be at least {0} characters long"},
			'user_info[user_email]': {remote: "Email taken"},
			'child_info[user_name]': {minlength: "user name must be at least {0} characters long", remote: "Please select a different username"},
			'check_parent_password': {equalTo: "Passwords do not match"},
			'child_info[password]': {minlength: "Password must be at least {0} characters long"},
			'check_child_password': {equalTo: "Passwords do not match"},
		}
	});
	
	$('#signup2-edit-loggedin').validate({
		rules: {
			'user_info[user_email]': {
				email: true,
				required: true,
				remote:	{
					url: 'ajax/ajax_checkemail',
					type: "GET",
					data:{
						email: function() {
							return $("#email").val();
						}
					}
				}
			},
			'user_info[user_password]': {minlength: 6},
			'check_parent_password': {equalTo: '#password' },
			'user_info[check_email]': {equalTo: '#email'},
			'user_info[user_full_name]': {required: true},
			'user_info[user_phone]': {required: true},
			'user_info[kids]': {required: true},
			'child_info[user_full_name]': {required: true},
			'child_info[birthday]': {required: true},
			'child_info[gender]': {required: true},
			'child_info[user_name]': {
				required: true,
				minlength: 4,
				remote: {
					url: 'ajax/ajax_checkusername',
					type: "GET",
					data:{
						username: function() {
							return $( "#username" ).val();
						}
					}
				}
			},
			'child_info[user_password]': {minlength: 6, required: true},
			'check_child_password': {equalTo: '#child-password' },
		},
		messages: {
			'user_info[password]': {minlength: "Password must be at least {0} characters long"},
			'child_info[user_name]': {minlength: "user name must be at least {0} characters long", remote: "Please select a different username"},
			'user_info[user_email]': {remote: "Email taken"},
			'user_info[check-password]': {equalTo: "Passwords do not match"},
			'child_info[password]': {minlength: "Password must be at least {0} characters long"},
			'check_child_password': {equalTo: "Passwords do not match"},
		}
	});
	
	$('#parent-edit').validate({
		rules: {
			'user_info[user_email]': {
				email: true,
				required: true,
				remote:	{
					url: '../ajax/ajax_checkemail',
					type: "GET",
					data:{
						email: function() {
							return $("#email").val();
						}
					}
				}
			},
			'user_info[user_password]': {minlength: 6},
			'check_parent_password': {equalTo: '#password' },
			'user_info[check_email]': {equalTo: '#email'},
			'user_info[user_full_name]': {required: true},
			'user_info[user_phone]': {required: true},
			'user_info[kids]': {required: true},
		},
		messages: {
			'user_info[password]': {minlength: "Password must be at least {0} characters long"},
			'user_info[user_email]': {remote: "Email taken"},
			'user_info[check-password]': {equalTo: "Passwords do not match"},
		}
	});
	
	$('#child-edit').validate({
		rules: {
			'child_info[user_full_name]': {required: true},
			'child_info[birthday]': {required: true},
			'child_info[gender]': {required: true},
			'child_info[user_name]': {
				required: true,
				minlength: 4,
				remote: {
					url: '../ajax/ajax_checkusername',
					type: "GET",
					data:{
						username: function() {
							return $( "#username" ).val();
						},
						child_user_id: function() {
							return $("#child_user_id").val();
						}
					}
				}
			},
			'child_info[user_password]': {minlength: 6},
			'check_child_password': {equalTo: '#child-password' },
		},
		messages: {
			'child_info[user_name]': {minlength: "user name must be at least {0} characters long", remote: "Please select a different username"},
			'child_info[password]': {minlength: "Password must be at least {0} characters long"},
			'check_child_password': {equalTo: "Passwords do not match"},
		}
	});

	$('#refresh-captcha').button({
		text: false,
		icons: {
			primary: 'ui-icon-refresh'
		}
	}).click(function(event){
			event.preventDefault();
			$(this).prev().attr('src', 'order/new_captcha');
		});
});