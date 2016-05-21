<?php
	$con = mysqli_connect("localhost","root","","maindb");
	$sql = "SELECT * FROM students WHERE s_id='$id'";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_object($result);
	$email = $data->email;
	$phone = $data->phn;

	//get students approved
	$sdata = mysqli_query($con,"SELECT * FROM students WHERE fa_appr=1 AND docs=1"); //getting all students approved by FAs.
	$count = mysqli_num_rows($sdata);
	if($count!=0){
	$a = array();
	$i=0;
	while($row=mysqli_fetch_array($sdata))
	{
			if($row['chk']==4 && $regCount!=0 && $row['sac_appr']==0)
			{
			$a[$i] = "<tr><td>".$row['fname']." " .$row['lname']."</td><td>".$row['s_id']."</td><td>".$row['sem']."</td><td>".$row['phn']."</td><td><button data-toggle='modal' data-target='#viewTfee' id='".$row['s_id']."' class='btn btn-default verifyTfee'>Verify</button></td></tr>";
			$i++;			
			}
			if($regCount!=0 && $row['sac_appr']==1)
			{
			$a[$i] = "<tr><td>".$row['fname']." " .$row['lname']."</td><td>".$row['s_id']."</td><td>".$row['sem']."</td><td>".$row['phn']."</td><td><button data-toggle='modal' data-target='#viewTfee' id='".$row['s_id']."' class='btn btn-success' disabled>Verified</button></td></tr>";
			$i++;			
			}
		
	}
	}
	
	?>
	<div class="container" style="margin-top:70px;width:100%">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
		  <li><a data-toggle="tab" href="#viewstudents">Students approved by FA</a></li>
		</ul>
			<div id="viewTfee" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h5 class="modal-title"><b>Tuition Fee from DSS</b></h5>
						</div>
						<div class="modal-body" id="sdoc"></div>
						<div class="modal-footer"><button type="button" class="btn btn-primary" id="message" data-dismiss="modal">Message</button><button type="button" class="btn btn-success" id="sacApprove" s_id="" data-dismiss="modal">Approve</button></div>
					</div>
				</div>
			</div>
		<div class="tab-content">
		  <div id="home" class="tab-pane fade in active">
			<div class="container-fluid" style="margin-top:20px">
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Name:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo $name;?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Academic Roll No:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo strtoupper($id);?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>e-mail:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo $email;?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Phone:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo $phone;?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Logged in as:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo strtoupper($mode) . " Member";?></div>
				</div>
			</div>
		  </div>
		  
		  <div id="viewstudents" class="tab-pane fade">
			<div class="container-fluid" style="margin-top:20px;height:90%">
				<?php
				if($regCount==0){
					?>
					<div class="alert alert-danger">
						<strong>Alert!</strong> No active registrations found.
					</div>
					<?php
				}else{
				if($count==0)
				{
					?>
					<div class="alert alert-danger">
						<strong>No students have been approved yet!</strong>
					</div>
					<?php
				}
				else{
					?>
					<div class="panel panel-success">
					  <div class="panel-heading" style="text-align:center"><h4>Student Registration</h4></div>
					  <div class="panel-body">
						<div style="float:left;border-right:2px dashed;width:50%">
							<table class="table table-hover">
								<thead>
								  <tr>
									<th>Student</th>
									<th>Roll No.</th>
									<th>Semester</th>
									<th>Contact</th>
									<th>Verify</th>
								  </tr>
								</thead>
								<tbody>
									<?php
									for($i=0;$i<$count;$i++)
									{
										echo $a[$i]."<br>";
									}
									?>
								</tbody>
							</table>
						</div>
						<!--right div starts here-->
						<div style="float:left;text-align:center;width:50%">
						<center>
							<ul class="list-group" style="width:90%">
								<?php
									while($row = mysqli_fetch_array($checkQuery))
									{
										$sdate = date_create($row["s_date"]);
										$edate = date_create($row["e_date"]);
										$diff1 = date_diff(date_create($currentDate),$sdate);
										$diff2 = date_diff(date_create($currentDate),$edate);
										if($diff1->format("%R")=="-" && $diff2->format("%R")=="+"){//checking if current date is between sdate and edate
										echo "<li class='list-group-item'>".$row["r_name"]." registration is currenly active.</li>";
										}
										if($diff1->format("%a")=="0"){
										echo "<li class='list-group-item'>".$row["r_name"]." registration has just begun.</li>";
										}
										if($diff1->format("%R")=="+" && $diff1->format("%a")!="0"){
										echo "<li class='list-group-item'>".$row["r_name"]." registration will start in ".$diff1->format("%a days").".</li>";
										}
									}
								?>
							</ul>
							<ul class="list-group" style="width:90%">
								<li class="list-group-item list-group-item-warning">Tokens issued</li>
								<li class="list-group-item"><h1 style="font-size:750%"><?php echo $tcount;?></h1><br></li>
							</ul>
						</center>
						</div>
					 </div>
					</div>
					<?php
				}
				}
				?>
			</div>
		  </div>
		</div>
	</div>
	
<?php
mysqli_close($con);
?>