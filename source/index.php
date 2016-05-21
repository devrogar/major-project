<?php
session_start();
if(!isset($_SESSION['name']) && !isset($_SESSION['mode']) && !isset($_SESSION['id']))
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>NIT Calicut | Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" href="favicon.ico">
	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$.getScript('js/basic.js');
		});
	</script>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Institute Central | Login</a>
			</div>
		</div>
	</nav>
	<div class="container" style="text-align:center">
		<img src="nitc-logo.png" height="10%" width="10%">
		<div class="row" style="margin-top:3%">
			<div class="col-sm-4"></div>
				<div class="col-sm-4"><pre style="border-radius:5px 5px 0 0">Login</pre></div>
				<div class="col-sm-4"></div>
		</div>
			<form class="form-horizontal" role="form" id="form">
				<div class="form-group">
					<div class="col-sm-2"></div>
					<label class="control-label col-sm-2" for="mode">Mode:</label>
					<div class="col-sm-4">
						<select class="form-control" id="mode" name="mode" required>
							<option style="font-style:italic" disabled>--mode--</option>
							<option>Admin</option>
							<option>Faculty Advisor</option>
							<option selected>Student</option>
							<option>Hostel Office</option>
							<option>Library Staff</option>
							<option>SAC</option>
							<option>Registration Desk</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2"></div>
					<label class="control-label col-sm-2" for="id">Id:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="id" placeholder="Enter Id" name="id">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2"></div>
					<label class="control-label col-sm-2" for="pwd">Password:</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						<button type="button" id="proceed" class="btn btn-default" style="width:200px">Proceed</button>
					</div>
				</div>
			</form>
			<div class="form-group">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						<a href="" style="width:200px" id="forgot">Forgot password?</a>
					</div>
			</div>
		</div>
</body>
</html>
<?php
}
else
{
	header('Location: http://localhost/cs4089/profile.php');
}
?>