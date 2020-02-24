var listName = $("#listName").text();

$(document).ready(function() {
	$.ajax({
		url:'./php/functGetList.php',
		method:'POST',
		data:{
            listName:listName
		},
		success:function(result) {
            var data = JSON.parse(result);
			var terms = data[0];
			var defs = data[1];
            var index=0;

            while (index<=terms.length-1) {
                var txt = "<div class='row' style='width:100%;' id='"+index+"'> <div class='col'><form><div class='form-group'><label for='term'>Term</label><input style='margin-bottom:1em;' type='text' class='form-control' id='"+index+"term' placeholder='Term' maxlength='6' value='"+terms[index]+"'></div></form></div><div class='col'><form><label for='def'>Definition</label><input style='margin-bottom:1em;' type='text' class='form-control' id='"+index+"def' placeholder='Definition' maxlength='60' value='"+defs[index]+"'></form></div></div>";
                $("#termList").append(txt); 
                index++;
            }
            
            $("#termCount").text(index);
		
		}
	});
});

$(document).keypress(function(event) {
    var regex = new RegExp("^[']+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    var regex = new RegExp("^['\\\"\\'\\\\\\\?\\<\\>\\!\\:\\|\\*]+$");
    if (regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

$(document).bind("cut copy paste", function(e) {
    e.preventDefault();
});

$("form").submit( function(event) {
	return false;
});

$('form').keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
       
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

$('#addTerm').on('click', function() {

	$(this).toggleClass('running');
    
    var termCount = parseInt($("#termCount").text());

    var txt = "<div class='row' style='width:100%;' id='"+termCount+"'> <div class='col'><form><div class='form-group'><label for='term'>Term</label><input style='margin-bottom:1em;' type='text' class='form-control' id='"+termCount+"term' placeholder='Term' maxlength='5'></div></form></div><div class='col'><form><label for='def'>Definition</label><input style='margin-bottom:1em;' type='text' class='form-control' id='"+termCount+"def' placeholder='Definition' maxlength='60'></form></div></div>" ;
    $("#termList").append(txt); 
    termCount += 1 ;
    
    $("#termCount").text(termCount);

    $(this).toggleClass('running');
});

$('#saveChange').on('click', function() {
    $(this).toggleClass('running');
    var terms = new Array();
    var defs = new Array();
    var termCount = parseInt($("#termCount").text());
    var index=0;

    while (index<=termCount) {
        terms.push($('#'+index+'term').val());
        defs.push($('#'+index+'def').val());
        index+=1;
    }
    
    $.ajax({
        url:'./php/functSaveList.php',
        method:'POST',
        data:{
            terms:terms,
            defs:defs,
            listName:listName
        },
        success:function(result) {
            window.location.href = 'portal.php';
        }
    });
	$(this).toggleClass('running');
});

$('#cancel').on('click', function() {
    $(this).toggleClass('running');
	window.location.href = 'portal.php';
	$(this).toggleClass('running');
});
