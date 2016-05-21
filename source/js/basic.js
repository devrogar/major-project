//js v.1 written using ajax and jquery


$("#form").keypress(function (event) {
	if(event.which == 13)
		{
			$("#proceed").click();
		}
	});
	
// Javascript to enable link to tab
var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
} 

// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
})
	
//id proceed for login button, receiving input values mode,id,pw
$("#proceed").click(function() {
		$('button').prop('disabled',true); //disabling button
		document.getElementById('proceed').innerHTML="<img src='loading.gif' height='25' width='25'>"; //inserting gif into disbled button
        console.log('validating data!');
		var action = "login";
		var id = $('#id').val();
		var pwd = $('#pwd').val();
		var mode = $('#mode').val();
		send_data = {'action':action,'id':id,'pwd':pwd,'mode':mode}; //using object format to send data using ajax////format must not be altered
		var validate = $.ajax({
			type: "POST",
			url:  "validate.php",					//calling ajax to validate.php/////validate.php will receive post values with keys id,pwd,mode
			data: send_data
		});
		validate.done(check);						//on completion of ajax request, the received response is passed onto check function.
		validate.fail(failure);
		});
		
$("#logout").click(function() {
	console.log('logging out!');
	var action = "logout";
	send_data = {'action':action};
	var logout = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	logout.done(function (response) {console.log('session destroyed!');window.open('index.php','_self');});
	logout.fail();
});

$("#inbox").click(function () {
	document.getElementById('inboxbadge').innerHTML = "";
});

//student registration flow
$("#proceedReg").click(function () {
	$('button').prop('disabled',true);
	document.getElementById('proceedReg').innerHTML="<img src='loading.gif' height='25' width='25'>";
	var action = "increment";
	send_data = {'action':action};
	var reg = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	reg.done(function (response) {location.reload();});	
});


var options = {
	beforeSubmit:  beforeSubmit,
	success: publish,
	resetForm: true
};

$('#uploadForm').submit(function() {
	$(this).ajaxSubmit(options);
	return false;
});

function beforeSubmit(){
	if($('#prereg').val()=='' || $('#tuitionfee').val()=='')
	{
		alert("Please select all required files in pdf format!");
	}
	else
	{
		var preregtype = $('#prereg')[0].files[0].type; // get file type
		var tuitionfeetype = $('#tuitionfee')[0].files[0].type; // get file type
		if(preregtype!="application/pdf" || tuitionfeetype!="application/pdf")
		{
			alert("Unsupported format for upload. Please choose pdf files.");
			return false;
		}
	}
}


function check(response) {
			console.log('response received!');
			var rec_data = JSON.parse(response); 		//response received from ajax request is in json format///parse it to make it a js object
			if(rec_data['err'])
			{
				alert(rec_data['err']);
				document.getElementById('proceed').innerHTML="Proceed";
				$('button').prop('disabled',false);
			}
			if(rec_data['key'])
			{
				var name = rec_data['name'];
				var id = rec_data['id'];
				var mode = rec_data['mode'];
				var key = rec_data['key'];
				authenticate(mode,id,name,key);
			}
}

$('#fetch_button').click(function() {
	document.getElementById('due_container').style.display="none";
	var action = "lib_due";
	var sid = $('#sid').val();
	if(sid==''){alert("Please enter a valid student id");}else{
	send_data = {'action':action,'sid':sid};
	var fetch = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	fetch.done(publish);
	fetch.fail();}
});

$('#remove_due').click(function() {
	var action = "rem_lib_due";
	var sid = $('#dsid').val();
	if(sid==''){alert("Please enter a valid student id");}else{
	send_data = {'action':action,'sid':sid};
	var rem = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	rem.done(publish);
	rem.fail();}
});

$('#add_due').click(function() {
	var action = "add_lib_due";
	var sid = $('#asid').val();
	if(sid==''){alert("Please enter a valid student id");}else{
	send_data = {'action':action,'sid':sid};
	var add = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	add.done(publish);
	add.fail();}
});

function publish(response) {
	var response = JSON.parse(response);
			if(response['err'])
			{
				alert(response['err']);
			}
			if(response['status']=="success")
			{
				alert("Due cleared");
			}
			if(response['status_add']=="success")
			{
				alert(response['status_add']);
				location.reload();
			}
			if(response['status_upload']=="success")
			{
				location.reload();
				return true;
			}
			if(response['status_rem']=="success")
			{
				alert(response['status_rem']);
				location.reload();
			}
			if(response['lib_due'])
			{
				var sid = response['sid'];
				var due = response['lib_due'];
				document.getElementById('due_container').style.display="block";
				document.getElementById('due_data').innerHTML="<tr><td>"+sid+"</td><td>"+due+"</td></tr>";
			}
}


function authenticate(mode,id,name,key) {
	send_data = {'id':id,'mode':mode,'name':name,'key':key};
	var profile = $.ajax({
		type : "POST",
		url  : "profile.php",
		data : send_data
	});
	profile.done(function (response) {console.log('session created!');window.open('index.php','_self');});
	profile.fail(failure);
}

function failure(response) {
			var rec_data = JSON.parse(response);
			alert(rec_data['err']);
			document.getElementById('proceed').innerHTML="Proceed";
			$('button').prop('disabled',false);
			//alert("failed!");
			}
			
$(document).on('click', 'button.verify', function () {
		var sid = this.id;
		document.getElementById('sdoc').innerHTML='<object type="application/pdf" data="docs/'+sid+'/prereg.pdf" width="100%" height="870px">';
		document.getElementById('approve').setAttribute("s_id",sid);
	});
			
$(document).on('click', 'button.verifyTfee', function () {
		var sid = this.id;
		document.getElementById('sdoc').innerHTML='<object type="application/pdf" data="docs/'+sid+'/tfee.pdf" width="100%" height="870px">';
		document.getElementById('sacApprove').setAttribute("s_id",sid);
	});

$('#approve').click(function (){
	var s_id = document.getElementById('approve').getAttribute('s_id');
	var action = "approve";
	send_data = {'action':action,'s_id':s_id};
	var approve = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	approve.done(function (response){location.reload();});
	approve.fail();
});

$('#sacApprove').click(function (){
	var s_id = document.getElementById('sacApprove').getAttribute('s_id');
	var action = "sacApprove";
	send_data = {'action':action,'s_id':s_id};
	var approve = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	approve.done(function (response){location.reload();});
	approve.fail();
});

$(document).on('click', 'button.register', function () {
	var s_id = this.id;
	alert(s_id);
	var action = "register";
	send_data = {'action':action,'s_id':s_id};
	var approve = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	approve.done(function (response){location.reload();});
	approve.fail();
});
			
$(document).on('click', 'a.notification', function () {
		mark_read(this.id);
	});
	
function mark_read(notifid) {
	var id = notifid.replace('notif','');
	document.getElementById("unread"+id).className = "";
	send_data = {'read':'done','notifid':id};
	var markread = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
}


//add registration from admin panel
$('#add_registration_button').click(function (){
		document.getElementById('add_registration_input').style.display = "";
		document.getElementById('no_reg_data').style.display="none";
});

//cancel creating registration from admin panel
$('#create_reg_cancel').click(function () {
	document.getElementById('add_registration_input').style.display = "none";
	document.getElementById('no_reg_data').style.display="";
});

//create registration accessed by admin panel
$('#create_reg').click(function () {
	var rid = $('#rid').val();
	var r_name = $('#r_name').val();
	var s_date = $('#s_date').val();
	var e_date = $('#e_date').val();
	var action="addRegistration";
	if(rid=='' || r_name=='' || s_date=='' || e_date==''){alert("All fields are mandatory");}else{
		send_data = {'action':action,'rid':rid,'r_name':r_name,'s_date':s_date,'e_date':e_date};
		var create = $.ajax({
			type : "POST",
			url  : "validate.php",
			data : send_data
		});
		create.done(publish);
		create.fail();
	}
	
});

//delete registration accessed by admin
$(document).on('click', 'button.deleteReg', function () {
		var rid = this.id.replace('delete_registration','');
		var action = "deleteReg";
		send_data = {'action':action,'rid':rid};
		var deleteRegistration = $.ajax({
		type : "POST",
		url  : "validate.php",
		data : send_data
	});
	deleteRegistration.done(publish);
	deleteRegistration.fail();
});

//the below function animates the data to the top of the page
$("#gotounverified").click(function() {
    $('html, body').animate({
        scrollTop: $("#unverified_data").offset().top
    }, 1000);
});

//Add unverified payment to database by hostel office management
$('#aup').click(function () {
	var sid = $('#sid').val();
	var month = $('#month').val();
	var due = $('#due').val();
	var amt_paid = $('#amnt').val();
	var mop = $('#mop').val();
	var ref_no = $('#rno').val();
	var date = $('#dop').val();
	var action="addUnverifiedPayment";
	if(sid=='' || month=='' || due=='' || amt_paid=='' || mop=='' || ref_no=='' || date==''){alert("All fields are mandatory");}else{
		send_data = {'action':action,'sid':sid,'month':month,'due':due,'amt_paid':amt_paid,'mop':mop,'ref_no':ref_no,'date':date};
		var create = $.ajax({
			type : "POST",
			url  : "validate.php",
			data : send_data
		});
		create.done(publish);
		create.fail();
	}
	
});

//Add hostel dues to database by hostel office management
$('#addDuesButton').click(function () {
	var sid = $('#id').val();
	var month = $('#mnth').val();
	var due = $('#dueAmt').val();
	var action="addDues";
	if(sid=='' || month=='' || due==''){alert("All fields are mandatory");}else{
		send_data = {'action':action,'sid':sid,'month':month,'due':due};
		var create = $.ajax({
			type : "POST",
			url  : "validate.php",
			data : send_data
		});
		create.done(publish);
		create.fail();
	}
	
});
