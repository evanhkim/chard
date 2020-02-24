$('#newListName').keypress(function(event) {
    var regex = new RegExp("^[']+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    var regex = new RegExp("^['\\\"\\'\\\\\\\?\\<\\>\\!\\:\\|\\*]+$");
    if (regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

$('#newListName').bind("cut copy paste", function(e) {
    e.preventDefault();
});

$("form").submit( function(event) {
	return false;
});
$('form').keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
        $('#createList').click();
   	}
});

$('.alert .close').on('click', function(e) {
    $(this).parent().fadeOut('fast');
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

$('#cancel').on('click', function() {
	$(this).toggleClass('running');
	window.location.href = 'portal.php';
	$(this).toggleClass('running');
});

$('#createList').on('click', function() {
    var listName = $('#newListName').val(); 
    $(this).toggleClass('running');
	
    if (listName) {
        $.ajax({
			url:'./php/functCreateList.php',
			method:'POST',
			data:{
                listName:listName
            },
            success:function(result) {
                if (result == "repeat") {
                    error("create",'List with same name already exists');
	                $(this).toggleClass('running');
                }
                else if (result == 'no') {
                    error("create",'List could not be created');
	                $(this).toggleClass('running');
                }
                else if (result == 'yes') {
                    window.location.href = 'portal.php';
                    $(this).toggleClass('running');
                }
            }
        });
    }
    else {
        error('create','Type in a list name');
    }
});