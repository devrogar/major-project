<?php
	$con = mysqli_connect("localhost","root","","maindb");
	$sql = "SELECT * FROM faculty WHERE f_id='$id'";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_object($result);
	$email = $data->email;
	$phone = $data->phn;
	$did = $data->d_id;
	$dept_data = mysqli_fetch_object(mysqli_query($con,"SELECT dname FROM department WHERE d_id='$did'"));
	$dept = $dept_data->dname;
	$sdata = mysqli_query($con,"SELECT * FROM students WHERE fa_id='$id'"); //getting all students registered under current logged in fa using id.
	$count = mysqli_num_rows($sdata);
	if($count!=0){
	$a = array();
	$i=0;
	while($row=mysqli_fetch_array($sdata))
	{
		if($row['chk']<3 && $regCount!=0){
		$a[$i] = "<tr><td>".$row['fname']." " .$row['lname']."</td><td>".$row['s_id']."</td><td>".$row['sem']."</td><td>".$row['email']."</td><td><button  type='button' id='msg_student".$row['s_id']."' class='btn btn-default'>Message  <span class='glyphicon glyphicon-pencil'></span></button><button  type='button' id='email_student".$row['s_id']."' class='btn btn-primary emailStudent' style='margin-left:5px'>Email  <span class='glyphicon glyphicon-envelope'></span></button></td><td><button id='verify".$row['s_id']."' class='btn btn-default' data-toggle='tooltip' title='Student has not uploaded the documents' disabled>Verify</button></td></tr>";
		$i++;}
		else{
			if($regCount!=0 && $row['fa_appr']==1)
			{
			$a[$i] = "<tr><td>".$row['fname']." " .$row['lname']."</td><td>".$row['s_id']."</td><td>".$row['sem']."</td><td>".$row['email']."</td><td><button  type='button' id='msg_student".$row['s_id']."' class='btn btn-default'>Message  <span class='glyphicon glyphicon-pencil'></span></button><button  type='button' id='email_student".$row['s_id']."' class='btn btn-primary emailStudent' style='margin-left:5px'>Email  <span class='glyphicon glyphicon-envelope'></span></button></td><td><button data-toggle='modal' data-target='#viewPrereg' id='".$row['s_id']."' class='btn btn-success verify' disabled>Verified</button></td></tr>";
			$i++;
			}
			if($row['chk']==3 && $regCount!=0 && $row['fa_appr']==0){
			$a[$i] = "<tr><td>".$row['fname']." " .$row['lname']."</td><td>".$row['s_id']."</td><td>".$row['sem']."</td><td>".$row['email']."</td><td><button  type='button' id='msg_student".$row['s_id']."' class='btn btn-default'>Message  <span class='glyphicon glyphicon-pencil'></span></button><button  type='button' id='email_student".$row['s_id']."' class='btn btn-primary emailStudent' style='margin-left:5px'>Email  <span class='glyphicon glyphicon-envelope'></span></button></td><td><button data-toggle='modal' data-target='#viewPrereg' id='".$row['s_id']."' class='btn btn-default verify'>Verify</button></td></tr>";
			$i++;			
			}
		}
		if($regCount==0){
		$a[$i] = "<tr><td>".$row['fname']." " .$row['lname']."</td><td>".$row['s_id']."</td><td>".$row['sem']."</td><td>".$row['email']."</td><td><button  type='button' id='msg_student".$row['s_id']."' class='btn btn-default'>Message  <span class='glyphicon glyphicon-pencil'></span></button><button  type='button' id='email_student".$row['s_id']."' class='btn btn-primary emailStudent' style='margin-left:5px'>Email  <span class='glyphicon glyphicon-envelope'></span></button></td></tr>";
		$i++;	
		}
	}}
	?>
	<div class="container" style="margin-top:70px;width:100%">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
		  <li><a data-toggle="tab" href="#students">Students</a></li>
		</ul>
			<div id="viewPrereg" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h5 class="modal-title"><b>Pre-reg slip</b></h5>
						</div>
						<div class="modal-body" id="sdoc"></div>
						<div class="modal-footer"><button type="button" class="btn btn-primary" id="message" data-dismiss="modal">Message</button><button type="button" class="btn btn-success" id="approve" s_id="" data-dismiss="modal">Approve</button></div>
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
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Login Id:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo strtoupper($id);?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Department:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo strtoupper($dept);?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>e-mail:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo $email;?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Phone:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo $phone;?></div>
				</div>
			</div>
		  </div>
		  <div id="students" class="tab-pane fade">
			<div class="container-fluid" style="height:90%">
				<table class="table table-hover">
					<thead>
					  <tr>
						<th>Student</th>
						<th>Roll No.</th>
						<th>Semester</th>
						<th>Email</th>
						<th>Contact</th>
						<?php
							if($regCount!=0)
							{
							?>
								<th>Verify</th>
							<?php
							}
							?>
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
		  </div>
		</div>
	</div>
	<?php
mysqli_close($con);
?>