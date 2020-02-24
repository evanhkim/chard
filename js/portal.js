var email; 
var listNames;
var id;

$(document).ready(function() {
	$.ajax({
		url:'./php/functCheckLog.php',
		method:'POST',
		data:{
		},
		success:function(result) {
			if(result == 'yes') {
				admin();
			}
			else {
				$('#index').fadeIn(10);
				var chrome   = navigator.userAgent.indexOf('Chrome') > -1;
				if (!chrome) {
					var message = 'CHARD officially supports Google Chrome. Use of other browsers may lead to bugs or data loss.';
					error('google',message);
				}
				$('#index').fadeIn(10);
			}
		}
	});
});

$("form").submit( function(event) {
	return false;
});
$('form').keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
       		if ($('#index').is(":visible")) {
       			$('#login').click();
       		}
       		else if ($('#reset').is(":visible")) {
       			$('#resetPwd').click();
       		}
   	}
});

$('.alert .close').on('click', function(e) {
    $(this).parent().fadeOut('fast');
});

$('#login').on('click', function() {
	$(this).toggleClass('running');
	var email = $('#email').val();
	var pwd = $('#password').val();
	var e_val = isValidEmailAddress(email);
	if (e_val && pwd) {
		$.ajax({
			url:'./php/functLogin.php'	              		,
			method:'POST',
			data:{
			email: email,
			pwd: pwd
			},
		        success:function(result) {
		        	if (result == 'profile') {
		        		$('#index').fadeOut(10);
		        		admin();
		        	}
		        	else {
		        		error('index',result);
		        	}
		        	$('#login').toggleClass('running');
			}
		});
	}
	else {
		$('#login').toggleClass('running');
		error('index','Username/Email and/or Password is incorrectly formatted.');
	}
});

$('#create').on('click', function() {
	$(this).toggleClass('running');
	var email = $('#email').val();
	var pwd = $('#password').val();
	var e_val = isValidEmailAddress(email);
	if (e_val && pwd) {
		$.ajax({
			url:'./php/functReg.php',
			method:'POST',
			data:{
			email: email,
			pwd: pwd
			},
		        success:function(result) {
		        	if (result == 'profile') {
		        		$('#index').fadeOut(10);
		        		var message = 'Registration Successful';
		        		success('admin',message);

					$.ajax({
						url:'./php/functLogin.php'	              		,
						method:'POST',
						data:{
						email: email,
						pwd: pwd
						},
					        success:function(result) {
					        	if (result == 'profile') {
					        		$('#index').fadeOut(10);
					        		admin();
					        	}
						}
					});
		        	}
		        	else {
		        		error('index',result);
		        	}
		        	$('#create').toggleClass('running');
			}
		});
	}
	else {
		error('index','Username/Email and/or Password is incorrectly formatted.');
		$('#create').toggleClass('running');
	}
});
$('#logOut').on('click', function() {
	$(this).toggleClass('running');
	$.ajax({
		url:'./php/functLogOut.php',
		method:'POST',
		data:{
		},
		success:function(result) {
			$('#admin').fadeOut(10);
			$("#listNames option").each(function() {
				$(this).remove();
			});
		    $('#index').fadeIn(10);
		   	$('#logOut').toggleClass('running');
		}
	});
});

$('#forgot').on('click', function() {
	$('#index').fadeOut(10);
	$('#reset').fadeIn(10);
});
$('#cancel').on('click', function() {
	$(this).toggleClass('running');
	$('#reset').fadeOut(10);
	$('#index').fadeIn(10);
	$(this).toggleClass('running');
});
$('#resetPwd').on('click', function() {
	$(this).toggleClass('running');
	var email = $('#emailReset').val();
	var e_val = isValidEmailAddress(email);
	if (e_val) {
		$.ajax({
			url:'./php/functResetPwd.php',
			method:'POST',
			data:{
			email: email
			},
			success:function(result) {
				if ($.trim(result) == 'success') {
					var message = 'Reset Link sent to ' + email;
					success('index',message);
					$('#reset').fadeOut(10);
					$('#index').fadeIn(10);
				}
				else {
					var message = email + "is not registered in RunMUN database.";
					error('reset',message);
				}
				$('#resetPwd').toggleClass('running');
			}
		});
	}
	else {
		var message = 'Email is incorrectly formatted or missing.';
		error('reset',message);
		$('#resetPwd').toggleClass('running');
	}
});

$('#createList').on('click', function() {
	$(this).toggleClass('running');
	window.location.href = 'create.php';
	$(this).toggleClass('running');
});

$('#editList').on('click', function() {
	$(this).toggleClass('running');
	if ($("#listNames option:selected").val() == null) {
		error('admin', "select a list to edit");
	}
	else {
		window.location.href = './edit.php?listName='+$("#listNames option:selected").val();
	}
	$(this).toggleClass('running');
});

$('#remList').on('click', function() {
	$(this).toggleClass('running');
	var result = confirm("Want to delete?");
	if (result) {
		$.ajax({
			url:'./php/functRemList.php',
			method:'POST',
			data:{
			listName: $("#listNames option:selected").val()
			},
				success:function(result) {
					$("#listNames option:selected").remove();
				}
			});
		}

	$(this).toggleClass('running');
});

$('#practiceList').on('click', function() {
	$(this).toggleClass('running');
	if ($("#listNames option:selected").val() == null) {
		error('admin', "select a list to practice");
	}
	else {
		window.location.href = './practice.php?listName='+$("#listNames option:selected").val();
	}
	$(this).toggleClass('running');
});


function error(page,message) {
	$('#'+page+'-error-box strong').text('Error');
	$('#'+page+'-error-box h6').text(message);
	$('#'+page+'-error-box').fadeIn('fast');
}
function success(page,message) {
	$('#'+page+'-success-box strong').text('Success');
	$('#'+page+'-success-box h6').text(message);
	$('#'+page+'-success-box').fadeIn('fast');
}

function admin() {
	$.ajax({
		url:'./php/functGetUser.php',
		method:'POST',
		data:{
		},
		success:function(result) {
			var data = JSON.parse(result);
			var admin = data[0];
			email = admin[0];
			id = admin[1];
			listNames = data[1];

			$('#user').text(email);

			for (let name of listNames) {

				nameText = name.replace(id+"_", "");

				$('#listNames').append($("<option></option>")
						        	.attr({
    									"value": name,
     								}).text(nameText));
			}
			$('#admin').fadeIn(10);
		}
	});
}
function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}