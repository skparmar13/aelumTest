
<!DOCTYPE html>
<html>
<head>
<title>Test Form</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<div class="panel panel-default">
<div class="panel-heading">
<div>Time left = <span id="timer"></span></div>
</div>
<div class="panel-body">
	

<?php 
if(isset($_POST['signup'])) {

$link = mysqli_connect("localhost","root","","test");

$name = trim( $_POST['name']);
$email = trim( $_POST['email']);
$dob   = date('Y-m-d', strtotime( $_POST['dob'] ) );
$about = mysqli_real_escape_string($link,  $_POST['about'] );

$result = trim( $_POST['result']);
$actualResult = trim( $_POST['actualResult']);

$errors = array();
//validate name
if (! preg_match ("/^[a-zA-z]*$/", $name) ) { 
	$errors[] = "Only alphabets and whitespace are allowed.";
}

//validate email
if(! filter_var($email, FILTER_VALIDATE_EMAIL) ){
	$errors[] = "Please enter a valid email";
}

//validate captcha
if( $result != $actualResult ){
	$errors[] = "Invalid captcha";
}

if( empty( $errors )){	  

	mysqli_query($link,"INSERT INTO emp ( `name`, `email`, `dob`, `about`)
	VALUES ( '".$name."', '".$email."', '".$dob."', '".$about."') ");

}else{
	echo '<p class="alert alert-danger">Please fix the following errors </p>';
	echo '<ul>';
	foreach( $errors as $err ){
		echo '<li>'. $err .'</li>';
	}
	echo '</ul>';
}


if(empty( $errors)){
	echo '<p class="alert alert-success">Record inserted successfully!</p>';
}

}


?>
<form id="signupForm" method="post" class="form-horizontal" action="">
<div class="form-group">
<label class="col-sm-4 control-label" for="name">Name</label>
<div class="col-sm-5">
<input type="text" class="form-control" id="name" name="name" placeholder="Name" />
</div>
</div>

<div class="form-group">
<label class="col-sm-4 control-label" for="email">Email</label>
<div class="col-sm-5">
<input type="text" class="form-control" id="email" name="email" placeholder="Email" />
</div>
</div>

<div class="form-group">
<label class="col-sm-4 control-label" for="dob">DOB</label>
<div class="col-sm-5">
<input type="date" class="form-control" id="dob" name="dob" placeholder="DOB" max="<?php echo date("Y-m-d")?>" />
</div>
</div>

<div class="form-group">
<label class="col-sm-4 control-label" for="username">About </label>
<div class="col-sm-5">
<textarea name="about" class="form-control" rows="2"></textarea>
</div>
</div>
 
<div class="form-group">
	<label class="col-sm-4 control-label" for="Captcha">Captcha</label>
	<div class="col-sm-5">
    		<label id="queryString"></label>
    		<input name="result" type="text" value="" id="result"/>
    	</div>
    	<input type="hidden" name="actualResult" id="actualResult"/>
</div>
<div class="form-group">
<div class="col-sm-9 col-sm-offset-4">
<button type="submit" class="btn btn-primary" id="signup" name="signup" value="Sign up">Sign up</button>  
</div>
</div>
</form>
</div>
</div>
 </div>
</div>
</div>
<script type="text/javascript">
		$.validator.setDefaults( {
			submitHandler: function () {
				//alert( "submitted!" );
				$( "#signupForm" ).submit();
			}
		} );

		$( document ).ready( function () {
			$( "#signupForm" ).validate( {
				rules: {
					name: "required",  
					email: {
						required: true,
						email: true
					},
					dob: {
						required: true,
					},
					about: {
						required: true,
					},
					result: {
						required: true,
						equalTo: "#actualResult"
					},
				},
				messages: {
					name: "Please enter your name",  
					result: {
						required: "Please enter Captcha",
						equalTo: "Invalid Captcha"
					},
					email: "Please enter a valid email address", 
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
				}
			} );
 
		} );


$(document).ready(function(){
    var a = (Math.ceil(Math.random()*9))+1;
	var b = (Math.ceil(Math.random()*9))+1;
	var queryText = a+" + "+b+"=";
	document.getElementById('queryString').innerHTML=queryText;
	var result = parseInt(a)+parseInt(b);
	document.getElementById('actualResult').value=result;
});
			
  


document.getElementById('timer').innerHTML =  03 + ":" + 01;
startTimer();

function startTimer() {
  var presentTime = document.getElementById('timer').innerHTML;
  var timeArray = presentTime.split(/[:]+/);
  var m = timeArray[0];
  var s = checkSecond((timeArray[1] - 1));
  if(s==59){m=m-1}
  if(m<0){alert('Time out!'); document.getElementById("signup").disabled = true;  return; }
  
  document.getElementById('timer').innerHTML =
    m + ":" + s; 
  setTimeout(startTimer, 1000);
}

function checkSecond(sec) {
  if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
  if (sec < 0) {sec = "59"};
  return sec;
}
</script>
</body>
</html>
