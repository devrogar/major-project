<?php
	$con = mysqli_connect("localhost","root","","maindb");
	$sql = "SELECT fname,lname FROM registration_staff WHERE staff_id='$id'";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_object($result);
	$name = $data->fname ." " .$data->lname;
	$regdata = mysqli_query($con,"SELECT * FROM registration");
	$count = mysqli_num_rows($regdata);
	if($count!=0){
	$a = array();
	$i=0;
	while($row=mysqli_fetch_array($regdata))
	{
		$a[$i] = "<tr><td>".$row['rid']."</td><td>".$row['r_name']."</td><td>".$row['s_date']."</td><td>".$row['e_date']."</td><td><button  type='button' id='edit_registration".$row['rid']."' class='btn btn-success'>Edit  <span class='glyphicon glyphicon-pencil'></span></button><button  type='button' id='delete_registration".$row['rid']."' class='btn btn-danger deleteReg' style='margin-left:5px'>Delete  <span class='glyphicon glyphicon-trash'></span></button></td></tr>";
		$i++;
	}}
	?>
	<div class="container" style="margin-top:70px;width:100%" onload="">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
		  <li><a data-toggle="tab" href="#manage">Manage registrations</a></li>
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
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Login Id:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo strtoupper($id);?></div>
				</div>
				<div class="row" style="padding:2px 0 2px 0">
					<div class="col-sm-2" style="background:#bfbfbf;border-radius:3px"><b>Department:</b></div>
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo strtoupper($mode) . " (Registration Management)";?></div>
				</div>

			</div>
		  </div>
		  
		  <div id="manage" class="tab-pane fade">
			<div class="container-fluid" style="margin-top:20px">
				<pre><h4 style="float:left">Admin Panel</h4><button  type='button' id='add_registration_button' class='btn btn-primary' style="float:right">Add Registration</button></pre>
			<?php if($count!=0){ ?>
				<table class="table table-hover">
					<thead>
					  <tr>
						<th>Reg Id</th>
						<th>Registration Name</th>
						<th>Start date</th>
						<th>End date</th>
						<th>Registration management</th>
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
				<?php  }else{
					
					echo "<p id='no_reg_data'>No active registrations found. Create one using Add registration.<p>";
				}


				?>
				<table class="table table-hover"  id="add_registration_input" style="display:none">
					<thead>
					  <tr>
						<th>Reg Id</th>
						<th>Registration Name</th>
						<th>Start date</th>
						<th>End date</th>
						<th>Create/Cancel</th>
					  </tr>
					</thead>
					<tbody>
						<tr>
							<td><input type='number' class='form-control' id='rid' placeholder='Id' name='rid'></td>
							<td><input type='text' class='form-control' id='r_name' placeholder='Registration name' name='r_name'></td>
							<td><input type='date' class='form-control' id='s_date' placeholder='Start date' name='s_date'></td>
							<td><input type='date' class='form-control' id='e_date' placeholder='End date' name='e_date'></td>
							<td><button type='button' class='btn btn-success' id='create_reg'>Create</button><button type='button' class='btn btn-danger' id='create_reg_cancel' style='margin-left:5px'>Cancel</button></td>
						</tr>
					</tbody>
				</table>
			</div>
		  </div>
		  
		  <div id="menu2" class="tab-pane fade">
			<h3>Menu 2</h3>
			<p>Some content in menu 2.</p>
		  </div>
		</div>
	</div>
<?php
mysqli_close($con);
?>