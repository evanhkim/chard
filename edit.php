<?php
require './php/db.php';
session_start();

$id = $_SESSION['id'];
$listName = $mysqli->escape_string($_GET['listName']);
$dispName = str_replace("$id"."_","",$listName);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>CHARD | Portal</title>
    <link rel="shortcut icon" type="image/x-icon" href="./img/ChardLogo.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="Evan Kim">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="./css/bootstrap/bootstrap.css">
    <script src="./js//bootstrap/bootstrap.js"></script>

    <script src="./js/jquery-3.4.1.min.js"></script>

	<link rel="stylesheet" href="./css/style.css">
</head>

<body>
<noscript>You need to enable JavaScript to run this app.</noscript>

<div class='root' style='display:block;'>
<div class='container'>
        <div class="row header">
            <div class="col">
                <span class="navbar-brand mb-0 h6"><h3>CHARD</h3></span>
            </div>
        </div>

        <div id='edit'class="row body">
            <div class="col">
                <h5> <?php echo $dispName ?></h5>
                <p id='listName' hidden><?php echo $listName ?></p>
                <div class='divide'></div>
                
                <div id="termList" class="row" style="margin-left:1em;" >
                
                </div>

                <p id='termCount' hidden>0</p>

                <div id='addTerm' class="btn btn-primary btn-block ld-ext-right">
                       Add Term
                    <div class="ld ld-ring ld-spin"></div>
                </div>
                
                <div class='divide'></div>
                    
                <div class="alert border-warning alert-warning warning alert-dismissible error-box" id='edit-error-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <div class='row' style='padding-left:15px;padding-right:15px;margin-bottom:1em;'>
                      <div class='col'>
                          <div id='saveChange' class="btn btn-primary btn-block ld-ext-right">
                            Save Changes
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                      </div>
                      <div class='col'>
                          <div id='cancel' class="btn btn-secondary btn-block ld-ext-right">
                            Cancel
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<script>
    
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
                var txt = "<div class='row' style='width:100%;' id='"+index+"'> <div class='col'><form><div class='form-group'><label for='term'>Term</label><input style='margin-bottom:1em;' type='text' class='form-control' id='"+index+"term' placeholder='Term' maxlength='1' value='"+terms[index]+"'></div></form></div><div class='col'><form><label for='def'>Definition</label><input style='margin-bottom:1em;' type='text' class='form-control' id='"+index+"def' placeholder='Definition' maxlength='60' value='"+defs[index]+"'></form></div></div>";
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

</script>
</body>
</html>