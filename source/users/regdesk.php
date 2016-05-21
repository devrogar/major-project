<?php
	$con = mysqli_connect("localhost","root","","maindb");
	//get students issued tokens
	$sdata = mysqli_query($con,"SELECT * FROM (SELECT * FROM students) as main JOIN (SELECT * FROM tokens) as tok ON main.s_id=tok.s_id"); //getting all students issued token no's.
	//get total no. of registered students
	$rdata = mysqli_query($con,"SELECT * FROM tokens WHERE registered=1");
	$rcount = mysqli_num_rows($rdata);
	$count = mysqli_num_rows($sdata);
	if($count!=0){
	$a = array();
	$i=0;
	while($row=mysqli_fetch_array($sdata))
	{
			if($row['chk']==5 && $regCount!=0 && $row['sac_appr']==1)
			{
			$a[$i] = "<tr><td>".$row['fname']." " .$row['lname']."</td><td>".$row['s_id']."</td><td>".$row['sem']."</td><td>".$row['phn']."</td><td><button id='".$row['s_id']."' class='btn btn-default register'>Register</button></td></tr>";
			$i++;			
			}
			if($row['chk']==6 && $regCount!=0 && $row['sac_appr']==1)
			{
			$a[$i] = "<tr><td>".$row['fname']." " .$row['lname']."</td><td>".$row['s_id']."</td><td>".$row['sem']."</td><td>".$row['phn']."</td><td><button data-toggle='modal' data-target='#viewTfee' id='".$row['s_id']."' class='btn btn-success' disabled>Registered</button></td></tr>";
			$i++;			
			}
		
	}
	}
	
	?>
	<div class="container" style="margin-top:70px;width:100%">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
		  <li><a data-toggle="tab" href="#viewstudents">Students issued tokens</a></li>
		</ul>
		<div class="tab-content">
		  <div id="home" class="tab-pane fade in active">
			<div class="container-fluid" style="margin-top:20px">
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Name:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo $name;?></div>
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
						<strong>No students have been issued tokens yet!</strong>
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
									<th>Register</th>
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
								<li class="list-group-item"><h1 style="font-size:150%"><?php echo $tcount;?></h1><br></li>
								<li class="list-group-item list-group-item-warning">No. of students registered</li>
								<li class="list-group-item"><h1 style="font-size:150%"><?php echo $rcount;?></h1><br></li>
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