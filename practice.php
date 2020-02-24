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
	
<style>

.box{
    background:black;
    touch-action:none;
    margin-right:10px;
    margin-bottom:10px;
    float:left;
}
</style>
</head>

<body onload="init()">
<noscript>You need to enable JavaScript to run this app.</noscript>

<div class='update text-center container-fluid'>
	<img src="./img/loader.svg" width='50px' height='50px' style='position:absolute;top:calc(50%);'></img>
</div>

<div class='root' style='display:block;'>
<div class='container'>
    
        <div class="row header">
            
            <div class="col">
                
                <span class="navbar-brand mb-0 h6"><h3>CHARD</h3></span>
            </div>
        </div>

        <div id='practice'class="row body">

        <div class="" style="width:100%;">
                <h4> <?php echo $dispName ?></h4>
                <div class='divide'></div>
                <p id='listName' hidden><?php echo $listName ?></p>
                
                
                <div class='row' style='padding-left:15px;padding-right:15px;margin-bottom:1em;'>
                    
                    <div class='col' style='max-width:25%;'>
                        <h6>Definition: </h6>
                        <p id='def'></p>
                        <p id='term' hidden></p>
                    </div>    
                    
                    <div class='' style="width:75%;">
                        <h6>Write the character(s)</h6>
                            <div id="sketchpadapp" style="float:left; z-index:100;">
                            <canvas id="sketchpad1" class="box" height="95px" width="95px"></canvas>
                        </div>    
                    </div>
                </div>

                <div class='divide'></div>

                <div class='row' style='padding-left:15px;padding-right:15px;margin-bottom:1em;'>
                      <div class='col'>
                          <div id='erase' class="btn btn-outline-danger btn-block ld-ext-right" onclick="clearCanvas(canvas,ctx);">
                            Erase
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                      </div>
                      <div class='col'>
                          <div id='submit' class="btn btn-outline-primary btn-block ld-ext-right">
                            Submit
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                      </div>
                </div>
                  
                
                <div class='divide'></div>

                <div class="alert border-warning alert-warning warning alert-dismissible error-box" id='practice-error-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <div class="alert border-success alert-success success alert-dismissible error-box"
                     id='practice-success-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <div class="alert border-warning alert-warning warning alert-dismissible error-box" id='practice-danger-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>

                <div id='stop' class="btn btn-secondary btn-block ld-ext-right">
                    Stop
                    <div class="ld ld-ring ld-spin"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    


var listName = $("#listName").text();

var terms;
var defs;
var quizIndex = 0;

$(document).ready(function() {
	$.ajax({
		url:'./php/functGetList.php',
		method:'POST',
		data:{
            listName:listName
		},
		success:function(result) {
            var data = JSON.parse(result);
			terms = data[0];
            defs = data[1];
            
            $("#def").text(defs[quizIndex]);
            $("#def").val(defs[quizIndex]);
            $("#term").text(terms[quizIndex]);
            $("#term").val(terms[quizIndex]);
            
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
function wrong(page,message) {
	$('#'+page+'-danger-box strong').text('Incorrect');
	$('#'+page+'-danger-box h6').text(message);
	$('#'+page+'-danger-box').fadeIn('fast');
}
function success(page,message) {
	$('#'+page+'-success-box strong').text('Success');
	$('#'+page+'-success-box h6').text(message);
	$('#'+page+'-success-box').fadeIn('fast');
}

$('#stop').on('click', function() {
    $(this).toggleClass('running');
	window.location.href = 'portal.php';
	$(this).toggleClass('running');
});

$('#erase').on('click', function() {
    $(this).toggleClass('running');
	clearArea();
	$(this).toggleClass('running');
});

function clearArea() {
    clearCanvas(canvas1,ctx);
};

$('#submit').on('click', function() {
    
    $(this).toggleClass('running');
    $('.update').fadeIn(1);
    var context = canvas1.getContext("2d");
    data = context.getImageData(0, 0, 96, 96);

    var compositeOperation = context.globalCompositeOperation;

		//set to draw behind current content
		context.globalCompositeOperation = "destination-over";

        //set background color
        var backgroundColor = canvas1.getAttribute("data-color");
		context.fillStyle = backgroundColor;

		//draw background / rect on entire canvas
        context.fillRect(0,0,96,96);

    var imageData = canvas1.toDataURL("image/png");
    
    $.ajax({
        url:'./php/functSubmitHanzi.php',
        method:'POST',
        data:{
            imageData:imageData
        },
        success:function(result) {
            res = JSON.parse(result);
            
            if (res == $("#term").val()) {
                success('practice','Correct! '+terms[quizIndex]+' means '+defs[quizIndex]);
            }
            else {
                wrong('practice','Wrong! '+terms[quizIndex]+' means '+defs[quizIndex] +", " + res +" is incorrect!");
            }
            //reset page
            $(this).toggleClass('running');
            
            if (quizIndex == terms.length-1) {
                quizIndex=0;
            }
            else {
                quizIndex += 1;
            }
            $("#def").text(defs[quizIndex]);
            $("#def").val(defs[quizIndex]);
            $("#term").text(terms[quizIndex]);
            $("#term").val(terms[quizIndex]);
            
	        $('.update').fadeOut(1);
            $('#erase').click();
        }
    });
    

});

    // Variables for referencing the canvas and 2dcanvas context
    var canvas,ctx;

    // Variables to keep track of the mouse position and left-button status 
    var mouseX,mouseY,mouseDown=0;

    // Variables to keep track of the touch position
    var touchX,touchY;

    // Keep track of the old/last position when drawing a line
    // We set it to -1 at the start to indicate that we don't have a good value for it yet
    var lastX,lastY=-1;

    // Draws a line between the specified position on the supplied canvas name
    // Parameters are: A canvas context, the x position, the y position, the size of the dot
    function drawLine(ctx,x,y,size) {

        // If lastX is not set, set lastX and lastY to the current position 
        if (lastX==-1) {
            lastX=x;
	    lastY=y;
        }

        // Let's use black by setting RGB values to 0, and 255 alpha (completely opaque)
        r=200; g=200; b=200; a=255;

        // Select a fill style
        ctx.strokeStyle = "rgba("+r+","+g+","+b+","+(a/255)+")";

        // Set the line "cap" style to round, so lines at different angles can join into each other
        ctx.lineCap = "round";
        //ctx.lineJoin = "round";


        // Draw a filled line
        ctx.beginPath();

	// First, move to the old (previous) position
	ctx.moveTo(lastX,lastY);

	// Now draw a line to the current touch/pointer position
	ctx.lineTo(x,y);

        // Set the line thickness and draw the line
        ctx.lineWidth = size;
        ctx.stroke();

        ctx.closePath();

	// Update the last position to reference the current position
	lastX=x;
	lastY=y;
    } 

    // Clear the canvas context using the canvas width and height
    function clearCanvas(canvas,ctx) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // Keep track of the mouse button being pressed and draw a dot at current location
    function sketchpad_mouseDown() {
        mouseDown=1;
        drawLine(ctx,mouseX,mouseY,5);
    }

    // Keep track of the mouse button being released
    function sketchpad_mouseUp() {
        mouseDown=0;

        // Reset lastX and lastY to -1 to indicate that they are now invalid, since we have lifted the "pen"
        lastX=-1;
        lastY=-1;
    }

    // Keep track of the mouse position and draw a dot if mouse button is currently pressed
    function sketchpad_mouseMove(e) { 
        // Update the mouse co-ordinates when moved
        getMousePos(e);

        // Draw a dot if the mouse button is currently being pressed
        if (mouseDown==1) {
            drawLine(ctx,mouseX,mouseY,5);
        }
    }

    // Get the current mouse position relative to the top-left of the canvas
    function getMousePos(e) {
        if (!e)
            var e = event;

        if (e.offsetX) {
            mouseX = e.offsetX;
            mouseY = e.offsetY;
        }
        else if (e.layerX) {
            mouseX = e.layerX;
            mouseY = e.layerY;
        }
     }

    // Draw something when a touch start is detected
    function sketchpad_touchStart() {
        // Update the touch co-ordinates
        getTouchPos();

        drawLine(ctx,touchX,touchY,5);

        // Prevents an additional mousedown event being triggered
        event.preventDefault();
    }

    function sketchpad_touchEnd() {
        // Reset lastX and lastY to -1 to indicate that they are now invalid, since we have lifted the "pen"
        lastX=-1;
        lastY=-1;
    }

    // Draw something and prevent the default scrolling when touch movement is detected
    function sketchpad_touchMove(e) { 
        // Update the touch co-ordinates
        getTouchPos(e);

        // During a touchmove event, unlike a mousemove event, we don't need to check if the touch is engaged, since there will always be contact with the screen by definition.
        drawLine(ctx,touchX,touchY,5); 

        // Prevent a scrolling action as a result of this touchmove triggering.
        event.preventDefault();
    }

    // Get the touch position relative to the top-left of the canvas
    // When we get the raw values of pageX and pageY below, they take into account the scrolling on the page
    // but not the position relative to our target div. We'll adjust them using "target.offsetLeft" and
    // "target.offsetTop" to get the correct values in relation to the top left of the canvas.
    function getTouchPos(e) {
        if (!e)
            var e = event;

        if(e.touches) {
            if (e.touches.length == 1) { // Only deal with one finger
                var touch = e.touches[0]; // Get the information for finger #1
                touchX=touch.pageX-touch.target.offsetLeft;
                touchY=touch.pageY-touch.target.offsetTop;
            }
        }
    }


    // Set-up the canvas and add our event handlers after the page has loaded
    function init() {
        // Get the specific canvas element from the HTML document
        canvas1 = document.getElementById('sketchpad1');

        // If the browser supports the canvas tag, get the 2d drawing context for this canvas
        if (canvas1.getContext)
            ctx = canvas1.getContext('2d');

        // Check that we have a valid context to draw on/with before adding event handlers
        if (ctx) {
            // React to mouse events on the canvas, and mouseup on the entire document
            canvas1.addEventListener('mousedown', sketchpad_mouseDown, false);
            canvas1.addEventListener('mousemove', sketchpad_mouseMove, false);
            window.addEventListener('mouseup', sketchpad_mouseUp, false);

            // React to touch events on the canvas
            canvas1.addEventListener('touchstart', sketchpad_touchStart, false);
            canvas1.addEventListener('touchend', sketchpad_touchEnd, false);
            canvas1.addEventListener('touchmove', sketchpad_touchMove, false);
        }
    }
    
</script>
</body>
</html>