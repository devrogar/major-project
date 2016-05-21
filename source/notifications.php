<?php
$con = mysqli_connect("localhost","root","","maindb");
//student notifications
if($_SESSION['mode']=="student")
{
$sql1 = "SELECT * FROM student_notifications WHERE to_id='$id'";
$result = mysqli_query($con,$sql1);
$bquery = mysqli_query($con,"SELECT * FROM student_notifications WHERE to_id='$id' AND read_status=0");
$badge = mysqli_num_rows($bquery);
$notif = array();
$modal = array();
$x = 0;
while($row = mysqli_fetch_array($result))
	{
		$fid = $row['from_id'];
		$sql2 = "SELECT f_id,fname,lname FROM faculty WHERE f_id='$fid'";
		$res = mysqli_query($con,$sql2);
		$fdata = mysqli_fetch_object($res);
		$facname = $fdata->fname . " " . $fdata->lname;
		$modal[$x] = '<div id="notif'.$row['n_id'].'" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h5 class="modal-title">From: <b>'.$facname.'</b></h5></div><div class="modal-body">' . $row['msg']. '</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
		if($row['read_status']==0){
		$notif[$x] = '<li><a href="#" class="notification" data-toggle="modal" data-target="#notif'.$row['n_id'].'" id="notif'.$row['n_id'].'"><span id="unread'.$row['n_id'].'"class="glyphicon glyphicon-record" style="color:blue"></span>&nbsp;' . $row['msg']. '<br><i>From: '.$facname.'</i></a></li>';
		$x++;}else{$notif[$x] = '<li><a href="#" class="notification" data-toggle="modal" data-target="#notif'.$row['n_id'].'" id="notif'.$row['n_id'].'">' . $row['msg']. '<br><i>From: '.$facname.'</i></a></li>';$x++;}
	}
if(mysqli_num_rows($result) == 0)
{
	$modal[0] = "";
	$notif[0] = '<li><a href="#"><i>No notifications</i></a></li>';
}
}

//faculty notifications//
if($_SESSION['mode']=="faculty advisor")
{
$sql1 = "SELECT * FROM faculty_notifications WHERE to_id='$id'";
$result = mysqli_query($con,$sql1);
$bquery = mysqli_query($con,"SELECT * FROM faculty_notifications WHERE to_id='$id' AND read_status=0");
$badge = mysqli_num_rows($bquery);
$notif = array();
$modal = array();
$x = 0;
while($row = mysqli_fetch_array($result))
	{
		$fid = $row['from_id'];
		$sql2 = "SELECT s_id,fname,lname FROM students WHERE s_id='$fid'";
		$res = mysqli_query($con,$sql2);
		$fdata = mysqli_fetch_object($res);
		$facname = $fdata->fname . " " . $fdata->lname;
		$modal[$x] = '<div id="notif'.$row['n_id'].'" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h5 class="modal-title">From: <b>'.$facname.'</b></h5></div><div class="modal-body">' . $row['msg']. '</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
		if($row['read_status']==0){
		$notif[$x] = '<li><a href="#" class="notification" data-toggle="modal" data-target="#notif'.$row['n_id'].'" id="notif'.$row['n_id'].'"><span id="unread'.$row['n_id'].'"class="glyphicon glyphicon-record" style="color:blue"></span>&nbsp;' . $row['msg']. '<br><i>From: '.$facname.'</i></a></li>';
		$x++;}else{$notif[$x] = '<li><a href="#" class="notification" data-toggle="modal" data-target="#notif'.$row['n_id'].'" id="notif'.$row['n_id'].'">' . $row['msg']. '<br><i>From: '.$facname.'</i></a></li>';$x++;}
	}
if(mysqli_num_rows($result) == 0)
{
	$modal[0] = "";
	$notif[0] = '<li><a href="#"><i>No notifications</i></a></li>';
}
}


//library staff notifications//
if($mode == "library staff")
{
	$badge = 0;
	$modal[0] = "";
	$notif[0] = '<li><a href="#"><i>No notifications</i></a></li>';
}
//hostel staff notifications//
if($mode == "hostel office")
{
	$badge = 0;
	$modal[0] = "";
	$notif[0] = '<li><a href="#"><i>No notifications</i></a></li>';
}
//admin notifications//
if($mode == "admin")
{
	$badge = 0;
	$modal[0] = "";
	$notif[0] = '<li><a href="#"><i>No notifications</i></a></li>';
}
//reg desk notifications//
if($mode == "registration desk")
{
	$badge = 0;
	$modal[0] = "";
	$notif[0] = '<li><a href="#"><i>No notifications</i></a></li>';
}
//sac notifications//
if($mode == "sac")
{
	$badge = 0;
	$modal[0] = "";
	$notif[0] = '<li><a href="#"><i>No notifications</i></a></li>';
}
mysqli_close($con);
?>