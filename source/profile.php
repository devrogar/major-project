<?php
session_start();
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest")
{
//setting important values here
}
//initial profile values//
if(/*check certain parameters*/)
{
$name = /*get name*/;
$id = /*get id*/;
$mode = /*get mode*/;
$title = $name . " | Profile";
$con = mysqli_connect("localhost","root","","maindb");
$currentDate = date("Y-m-d");
$checkRegSql = "SELECT r_name,s_date,e_date FROM registration WHERE '$currentDate' < e_date";
$checkQuery = mysqli_query($con,$checkRegSql);
$regCount = mysqli_num_rows($checkQuery);
//get total tokens
$tokens = mysqli_query($con,"SELECT * FROM tokens");
$tcount = mysqli_num_rows($tokens);
mysqli_close($con);
//get notifications
include 'notifications.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title;?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" href="favicon.ico">
	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/jquery.form.js"></script>
	<script src="js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$.getScript('js/basic.js');
		});
	</script>
</head>
<body>
	<?php
		foreach(@$modal as $key => $value)
			{
				echo $value;
			}
	?>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid center" style="width:100%">
			<div class="navbar-header">
			  <a class="navbar-brand" href="profile.php"><?php echo $name;?></a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#account-settings">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			</div>
			<div class="collapse navbar-collapse" id="account-settings" style="float:right">
				<div class="dropdown center" style="padding-right:10px"><span id="inboxbadge" class="badge badge-pos"><?php if($badge!=0){echo $badge;}else{}?></span><button type="button" title="Notifications" id="inbox" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="glyphicon glyphicon-inbox"></span></button>
						<ul class="dropdown-menu">
							<?php
								foreach(@$notif as $key => $value)
									{
									  echo $value;
									}
							?>
						</ul>
				</div>
				<div class="center" style="padding-right:10px"><button type="button" title="Settings" id="settings" class="btn btn-default"><span class="glyphicon glyphicon-cog"></span></button></div>
				<div class="center"><button  type="button" id="logout" class="btn btn-default">Logout  <span class="glyphicon glyphicon-log-out"></span></button></div>
			</div>
		</div>
	</nav>
<?php
//individual profile pages for different users//
if($mode == "student")
{
include 'users/student.php';
}
//
if($mode == "faculty advisor")
{
include 'users/fa.php';
}
//
if($mode == "library staff")
{
	include 'users/library.php';
}
//
if($mode == "hostel office")
{
	include 'users/hostel.php';
}
//
if($mode == "admin")
{
	include 'users/admin.php';
}
//
if($mode == "sac")
{
	include 'users/sac.php';
}
//
if($mode == "registration desk")
{
	include 'users/regdesk.php';
}
?>
</body>
</html>
<?php
}
else
{
	header('Location: http://localhost/cs4089/');
}
?>