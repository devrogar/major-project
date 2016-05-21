<?php
	$con = mysqli_connect("localhost","root","","maindb");
	$sql = "SELECT * FROM students WHERE s_id='$id'";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_object($result);
	$fa_id = $data->fa_id;
	$sql2 = "SELECT f_id,fname,lname FROM faculty WHERE f_id='$fa_id'";
	$res = mysqli_query($con,$sql2);
	$fdata = mysqli_fetch_object($res);
	$facname = $fdata->fname . " " . $fdata->lname;
	$fa_id = $fdata->f_id;
	$email = $data->email;
	$phone = $data->phn;
	$sem = $data->sem;
	$prob = $data->prob;
	$chk = $data->chk;
	$docs = $data->docs;
	$fa_appr = $data->fa_appr;
	$sac_appr = $data->sac_appr;
	
	//get dues
	$hosDueR = mysqli_query($con,"SELECT * FROM hostel_dues WHERE s_id='$id'");
	$unverifiedPR = mysqli_query($con,"SELECT * FROM unverified WHERE s_id='$id'");
	$libDueR = mysqli_query($con,"SELECT * FROM library_dues WHERE s_id='$id'");
	$hosDueC = mysqli_num_rows($hosDueR);
	$unverifiedPC = mysqli_num_rows($unverifiedPR);
	$libDueC = mysqli_num_rows($libDueR);
	$hosDueD = mysqli_fetch_object($hosDueR);
	$unverifiedPD = mysqli_fetch_object($unverifiedPR);
	$libDueD = mysqli_fetch_object($libDueR);
	if($hosDueC==0)
	{
		$hosDue = 0;
	}
	else{
		$hosDue = $hosDueD->due;
	}
	if($libDueC==0)
	{
		$libDue=0;
	}
	else{
		$libDue = $libDueD->due;
	}
	if($unverifiedPC==0)
	{
		$unverifiedP = 0;
	}
	else{
		$unverifiedP = $unverifiedPD->amt_paid;
		$unverifiedPref = $unverifiedPD->ref_no;
	}
	
	//get toke no. if allotted
	$tokenIssueR = mysqli_query($con,"SELECT * FROM tokens WHERE s_id='$id'");
	$tokenIssueC = mysqli_num_rows($tokenIssueR);
	if($tokenIssueC==1)
	{
	$tokenIssueD = mysqli_fetch_object($tokenIssueR);
	$tok = $tokenIssueD->t_no;
	}
	
	?>
	<div class="container" style="margin-top:70px;width:100%">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
		  <li><a data-toggle="tab" href="#reg">Registration</a></li>
		  <li><a data-toggle="tab" href="#menu2">Extras</a></li>
		</ul>

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
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Current Semester:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo $sem;?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Faculty Advisor:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo $facname;?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Probation:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php if($prob==0)echo "NIL";else echo "Under Probation";?></div>
				</div>
			</div>
		  </div>
		  
		  <div id="reg" class="tab-pane fade">
			<div class="container-fluid" style="margin-top:20px;height:90%">
				<?php
				if($regCount==0){
					?>
					<div class="alert alert-danger">
						<strong>Alert!</strong> No active registrations found.
					</div>
					<?php
				}
				else{
					?>
					<div class="panel panel-success">
					  <div class="panel-heading" style="text-align:center"><h4>Student Registration</h4></div>
					  <div class="panel-body">
						<div id="regFlow" style="float:left;border-right:2px dashed;width:50%">
						<?php
						if($chk ==0 && $hosDue!=0 && $unverifiedP==0){
							?>
							<center><h1>Hostel Dues</h1><br></center>
							<center><h1 style="font-size:750%"><?php echo $hosDue;?></h1><br></center>
							<center><p>Contact hostel office and clear the dues</p><br><center>
							<center><button type="button" class="btn btn-success" style="width:200px" disabled>Proceed</button></center>
							<?php
						}
						if($chk==0 && $unverifiedP!=0 && $hosDue!=0){
							?>
							<center><h1>Hostel Dues</h1><br></center>
							<center><p>You have made a payment of</p><center><br>
							<center><h1 style="font-size:650%;margin-top:-15px"><?php echo $unverifiedP;?></h1><br></center>
							<center><p style="margin-top:-25px">against <?php echo $hosDue;?> hostel due.</p><center>
							<center><p style="color:red">Recorded reference no. <?php echo $unverifiedPref;?></p><br><center>
							<center><p style="margin-top:-25px"><strong>You will be allowed to proceed. But if the payment is not confirmed by the bank, <br>you will be contacted by the Dean A/R or deregistered accordingly.</strong></p><center>
							<center><button type="button" id="proceedReg" class="btn btn-success" style="width:200px">Proceed</button></center>
							<?php
						}
						if($chk == 0 && $hosDue==0){
							?>
							<center><h1>Hostel Dues</h1><br></center>
							<center><img src="green_tick.png" height="15%" width="15%"></center><br><br>
							<center><strong>You are good to go!</strong></center><br>
							<center><button type="button" id="proceedReg" class="btn btn-success" style="width:200px;margin-top:10%">Proceed</button></center>
							<?php
						}
						if($chk == 1 && $libDue!=0){
							?>
							<center><h1>Library Dues</h1><br></center>
							<center><h1 style="font-size:750%"><?php echo $libDue;?></h1><br></center>
							<center><p>Contact library and clear the dues</p><br><center>
							<center><button type="button" class="btn btn-success" style="width:200px" disabled>Proceed</button></center>
							<?php
						}
						if($chk == 1 && $libDue==0)
						{
							?>
							<center><h1>Library Dues</h1><br></center>
							<center><img src="green_tick.png" height="15%" width="15%"></center><br><br>
							<center><strong>You are good to go!</strong></center><br>
							<center><button type="button" id="proceedReg" class="btn btn-success" style="width:200px;margin-top:10%">Proceed</button></center>
							<?php
						}
						if($chk == 2 && $docs!=1)
						{
							?>
							<center><h1>Documents upload</h1><br></center>
							<form action="validate.php" id="uploadForm" method="post" enctype="multipart/form-data">
							<ul class="list-group" style="width:90%">
							<li class='list-group-item'>Pre Registration form<input type="file" name="prereg" id="prereg" style="float:right"></li>
							<li class='list-group-item'>Tution Fee print from DSS<input type="file" name="tuitionfee" id="tuitionfee" style="float:right"></li>
							</ul>
							<strong>Once uploaded, documents will be verified. You may be contacted by FA, if needed. Please mail your FA, to remind him of your upload.</strong>
							<center><button class="btn btn-success" id="upload" type="submit" value="Upload documents" name="upload" style="width:200px;margin-top:10%">Upload & request approval</button></center>
							</form>
							<?php
						}
						if($chk == 3 && $docs==1 && $fa_appr==0 && $sac_appr==0)
						{
							?>
							<center><h1>Documents upload</h1><br></center>
							<ul class="list-group" style="width:90%">
							<li class='list-group-item'>Pre Registration form<div style="float:right"><a id="preregView" style="float:left">View</a><a id="preregDel"><span class="glyphicon glyphicon-trash" style="float:right;margin-left:13px"></span></a></div></li>
							<li class='list-group-item'>Tution Fee print from DSS<div style="float:right"><a id="tfeeView" style="float:left">View</a><a id="tfeeDel"><span class="glyphicon glyphicon-trash" style="float:right;margin-left:13px"></span></a></div></li>
							</ul>
							<strong>Uploaded documents will be verified. You may be contacted by FA, if needed. Please mail your FA, to remind him of your upload.</strong>
							<center><button class="btn btn-default" style="width:200px;margin-top:10%" disabled>Awaiting FA approval</button></center>
							<?php
						}
						if($chk == 4 && $docs==1 && $fa_appr==1 && $sac_appr==0)
						{
							?>
							<center><h1>Documents upload</h1><br></center>
							<ul class="list-group" style="width:90%">
							<li class='list-group-item'>Pre Registration form<div style="float:right"><a id="preregView" style="float:left">View</a><a id="preregDel"><span class="glyphicon glyphicon-trash" style="float:right;margin-left:13px"></span></a></div></li>
							<li class='list-group-item'>Tution Fee print from DSS<div style="float:right"><a id="tfeeView" style="float:left">View</a><a id="tfeeDel"><span class="glyphicon glyphicon-trash" style="float:right;margin-left:13px"></span></a></div></li>
							</ul>
							<strong>Your pre-reg slip has been approved by your FA</strong>
							<center><button class="btn btn-default" style="width:200px;margin-top:10%" disabled>Awaiting SAC approval</button></center>
							<?php
						}
						if($chk == 5 && $docs==1 && $fa_appr==1 && $sac_appr==1)
						{
							?>
							<center><h1>Registration</h1><br></center>
							<center><strong>Your documents have been verified</strong></center><br>
							<center><p>Your token no. for registration</p></center><br>
							<center><h1 style="font-size:750%;margin-top:-20px"><?php echo $tok;?></h1></center><br>
							<center><p style="color:red">Please wait for the registration desk to finish your registration</p></center>
							<?php
						}
						if($chk == 6 && $docs==1 && $fa_appr==1 && $sac_appr==1)
						{
							?>
							<center><h1>Registration complete</h1><br></center>
							<center><strong>Your have been successfully registered.</strong></center><br>
							<?php
						}
						
						?>
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
							<ul class="list-group" style="width:90%;margin-left:15px;text-align:left">
									<li class="list-group-item list-group-item-warning"><strong><center>Check List</center></strong></li>
									<?php
										$list = array();
										$list[0] = "Hostel dues";
										$list[1] = "Library dues";
										$list[2] = "Upload documents";
										$list[3] = "FA approval";
										$list[4] = "SAC approval";
										$list[5] = "Registration complete";
										$i=$chk;
										$j=0;
										while($j<$i)
										{
											echo "<li class='list-group-item'><span class='glyphicon glyphicon-ok' style='margin-right:10px'></span>".$list[$j]."</li>";
											$j++;
										}
										while($i<6)
										{
											echo "<li class='list-group-item'><span class='glyphicon glyphicon-remove' style='margin-right:10px'></span>".$list[$i]."</li>";
											$i++;
										}
									?>
							</ul>
						</center>
						</div>
					 </div>
					</div>
					<?php
				}
				?>
			</div>
		  </div>
		  <div id="menu2" class="tab-pane fade">
			<h3>Future Work</h3>
			<p>Global Electives</p>
			<p>Mess management</p>
			<p>No dues</p>
		  </div>
		</div>
	</div>
	
<?php
mysqli_close($con);
?>