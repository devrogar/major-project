<?php
	$con = mysqli_connect("localhost","root","","maindb");
	$sql = "SELECT fname,lname FROM library_staff WHERE staff_id='$id'";
	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_object($result);
	$name = $data->fname ." " .$data->lname;
?>
<div class="container" style="margin-top:70px;width:100%">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
		  <li><a data-toggle="tab" href="#manage">Manage Due</a></li>
		  <li><a data-toggle="tab" href="#view">View Dues</a></li>
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
					<div class="col-sm-4" style="background:#f2f2f2;border-radius:3px"><?php echo strtoupper($mode);?></div>
				</div>
			</div>
		  </div>
		  
		  <div id="manage" class="tab-pane fade">
			<div class="container-fluid" style="margin-top:20px">
				<div class="panel panel-success">
				  <div class="panel-heading" style="text-align:center"><h4>Remove student due here</h4></div>
				  <div class="panel-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-sm-2"></div>
							<label class="control-label col-sm-2" for="dsid">Enter student Id:</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="dsid" placeholder="Enter Roll No." name="dsid">
							</div>
							<div class="col-sm-2">
								<button type="button" id="remove_due" class="btn btn-default" style="width:200px">Remove Due</button>
							</div>
						</div>
					</form>
				  </div>
				</div>
				<div class="panel panel-danger">
				  <div class="panel-heading" style="text-align:center"><h4>Add student due here</h4></div>
				  <div class="panel-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-sm-2"></div>
							<label class="control-label col-sm-2" for="asid">Enter student Id:</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="asid" placeholder="Enter Roll No." name="asid">
							</div>
							<div class="col-sm-2">
								<button type="button" id="add_due" class="btn btn-default" style="width:200px">Add Due</button>
							</div>
						</div>
					</form>
				  </div>
				</div>
			</div>
		  </div>
		  
		  <div id="view" class="tab-pane fade">
			<div class="container-fluid" style="margin-top:20px">
			  <form class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-sm-2"></div>
					<label class="control-label col-sm-2" for="sid">Enter student Id:</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="sid" placeholder="Enter Roll No." name="sid">
					</div>
					<div class="col-sm-2">
						<button type="button" id="fetch_button" class="btn btn-default" style="width:200px">Fetch data</button>
					</div>
				</div>
			  </form>
			  
			  <div class="container-fluid" id="due_container" style="display:none;margin-top:20px">
				  <table class="table table-hover">
					<thead>
					  <tr>
						<th>Roll No.</th>
						<th>Due</th>
					  </tr>
					</thead>
					<tbody id="due_data">
					</tbody>
				  </table>
			  </div>
			</div>
		  </div>
		</div>
	</div>
	
<?php
mysqli_close($con);
?>
