<?php
	$con = mysqli_connect("localhost","root","","maindb");
	$sql = "SELECT fname,lname FROM hostel_staff WHERE staff_id='$id'";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_object($result);
	$name = $data->fname ." " .$data->lname;
	$hosduedata = mysqli_query($con,"SELECT * FROM hostel_dues");
	$count = mysqli_num_rows($hosduedata);
	if($count!=0){
	$a = array();
	$i=0;
	while($row=mysqli_fetch_array($hosduedata))
	{
		$a[$i] = "<tr><td>".$row['s_id']."</td><td>".$row['month']."</td><td>".$row['due']."</td></tr>";
		$i++;
	}}
	$unverifiedSQL = "SELECT * FROM unverified";
	$uresult = mysqli_query($con,$unverifiedSQL);
	$ucount = mysqli_num_rows($uresult);
	if($ucount!=0){
	$b = array();
	$i=0;
	while($row=mysqli_fetch_array($uresult))
	{
		$b[$i] = "<tr><td>".$row['s_id']."</td><td>".$row['month']."</td><td>".$row['due']."</td><td>".$row['amt_paid']."</td><td>".$row['mode']."</td><td>".$row['ref_no']."</td><td>".$row['date']."</td></tr>";
		$i++;
	}}
?>
<div class="container" style="margin-top:70px;width:100%">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
		  <li><a data-toggle="tab" href="#upayment">Unverified payments</a></li>
		  <li><a data-toggle="tab" href="#view">View All Dues</a></li>
		  <li><a data-toggle="tab" href="#addDue">Add dues</a></li>
		</ul>

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
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo strtoupper($mode) . " MANAGEMENT";?></div>
				</div>
			</div>
		  </div>
		  
		  <div id="upayment" class="tab-pane fade">
			<div class="container-fluid" style="margin-top:20px">
				<div class="panel panel-success">
				  <div class="panel-heading" style="text-align:center"><h4>Add unverified payments here</h4></div>
				  <div class="panel-body">
				   <div class="dueform" style="float:left;border-right:2px dashed;width:50%">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-sm-1"></div>
							<label class="control-label col-sm-4" for="sid">Enter student Id:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="sid" placeholder="Enter Roll No." name="sid">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-1"></div>
							<label class="control-label col-sm-4" for="month">Due month:</label>
							<div class="col-sm-4">
								<input type="month" class="form-control" id="month" placeholder="Month paid (Nov,Dec,..)" name="month">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-1"></div>
							<label class="control-label col-sm-4" for="due">Due:</label>
							<div class="col-sm-4">
								<input type="number" class="form-control" id="due" placeholder="Due amount" name="due">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-1"></div>
							<label class="control-label col-sm-4" for="amnt">Amount paid:</label>
							<div class="col-sm-4">
								<input type="number" class="form-control" id="amnt" placeholder="Amount paid" name="amnt">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-1"></div>
							<label class="control-label col-sm-4" for="mop">Mode of payment:</label>
							<div class="col-sm-4">
								<select class="form-control" id="mop" name="mop" required>
									<option style="font-style:italic" disabled>--mode--</option>
									<option selected>SBI collect</option>
									<option>ATM</option>
									<option>Bank Challan</option>
									<option>DD</option>
									<option>Internet Banking</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-1"></div>
							<label class="control-label col-sm-4" for="rno">Reference No.:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="rno" placeholder="Reference No." name="rno">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-1"></div>
							<label class="control-label col-sm-4" for="dop">Date of payment:</label>
							<div class="col-sm-4">
								<input type="date" class="form-control" id="dop" placeholder="Reference No." name="dop">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-3"></div>
							<div class="col-sm-4">
								<button type="button" id="aup" class="btn btn-success" style="width:200px">Add to unverified payments</button>
							</div>
						</div>
					</form>
				  </div>
				  <div style="float:left;text-align:center;width:50%">
					<h1 style="color:red">Total no. of unverified<br>payments recorded</h1><br>
					<h1 style="font-size:750%"><?php echo $ucount;?></h1><br>
					<div class="form-group">
							<div class="col-sm-4"></div>
							<div class="col-sm-4">
								<a href="#unverified_data" style="width:200px" id="gotounverified">View all unverified payments</a>
							</div>
					</div>
				  </div>
				 </div>
				</div>
				
				<div class="unverified_data" id="unverified_data" style="margin-top:45px">
				<?php if($ucount!=0){ ?>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th>Student Roll. No.</th>
							<th>Month of due</th>
							<th>Due amount</th>
							<th>Amount paid</th>
							<th>Paid through</th>
							<th>Ref. No.</th>
							<th>Date</th>
						  </tr>
						</thead>
						<tbody>
							<?php
							for($i=0;$i<$ucount;$i++)
							{
								echo $b[$i];
							}
							?>
						</tbody>
					</table>
				</div>
					<?php  }else{
						
						echo "<p id='no_reg_data'>No records found.<p>";
					}
					?>	
				</div>
			</div>
		  </div>
		  
		  <div id="view" class="tab-pane fade">
			<div class="container-fluid" style="margin-top:20px">
			<?php if($count!=0){ ?>
			<div class="table-responsive" style="position:fixed;width:95%;height:90%">
				<table class="table table-hover">
					<thead>
					  <tr>
						<th>Student Roll. No.</th>
						<th>Month of due</th>
						<th>Due amount</th>
					  </tr>
					</thead>
					<tbody>
						<?php
						for($i=0;$i<$count;$i++)
						{
							echo $a[$i];
						}
						?>
					</tbody>
					<tfoot>
					  <tr>
						<th>Student Roll. No.</th>
						<th>Month of due</th>
						<th>Due amount</th>
					  </tr>
					</tfoot>
				</table>
			</div>
				<?php  }else{
					
					echo "<p id='no_data'>No records found.<p>";
				}
				?>
			</div>
		  </div>
		  
		  <div id="addDue" class="tab-pane fade">
			<div class="container-fluid" style="margin-top:20px">
			<?php
				//echo date("m"); -> current month
				if($regCount==0)
				{
				?>
					<div class="alert alert-danger">
						<strong>Alert!</strong> No active registrations found.
					</div>
				<?php
				}
				else
				{
				?>
					<div class="panel panel-default">
						<div class="panel-heading" style="height:60px"><h4 style="float:left">Add dues for registration</h4><button id="uploadXls" class="btn btn-success" style="float:right">Upload Excel Sheet</button>
						</div>
						<div class="panel-body">
						   <div class="addDuesForm" style="float:left;border-right:2px dashed;width:50%">
							<form class="form-horizontal" role="form">
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label class="control-label col-sm-4" for="id">Enter student Id:</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="id" placeholder="Enter Roll No." name="id">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label class="control-label col-sm-4" for="mnth">Due upto:</label>
									<div class="col-sm-4">
										<select class="form-control" id="mnth" name="mnth" required>
											<option style="font-style:italic" disabled>--mode--</option>
											<option selected>January</option>
											<option>February</option>
											<option>March</option>
											<option>April</option>
											<option>May</option>
											<option>June</option>
											<option>July</option>
											<option>August</option>
											<option>September</option>
											<option>October</option>
											<option>November</option>
											<option>December</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-1"></div>
									<label class="control-label col-sm-4" for="dueAmt">Due:</label>
									<div class="col-sm-4">
										<input type="number" class="form-control" id="dueAmt" placeholder="Due amount" name="dueAmt">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3"></div>
									<div class="col-sm-4">
										<button type="button" id="addDuesButton" class="btn btn-success" style="width:200px">Add</button>
									</div>
								</div>
							</form>
						  </div>
						  
						  <div style="float:left;width:50%">
						  <ul class="list-group" style="width:90%;margin-left:15px">
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
						  </div>
						</div>
					<div>
					</div>
				<?php
				}
			?>
			</div>
		  </div>
		  
		</div>
	</div>
	
<?php
mysqli_close($con);
?>
