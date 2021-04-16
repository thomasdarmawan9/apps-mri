<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
	/*margin-left: 2px;*/
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>

<div class="card">
	<div class="card-header">
		<h3 class="card-title">Add Signup</h3>
	</div>
	<div class="card-body">
		<a class="btn btn-dark" id="add_signup"><i class="fa fa-user-plus"></i>&nbsp; Add Data</a>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead>
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Program</th>
						<th style="vertical-align: middle">Participant</th>
						<!-- <th style="vertical-align: middle">Age</th> -->
						<!-- <th style="vertical-align: middle">Gender</th> -->
						<th style="vertical-align: middle">Phone</th>
						<th style="vertical-align: middle">Email</th>
						<th style="vertical-align: middle">Paid</th>
						<th style="vertical-align: middle">Paid Date</th>
						<th style="vertical-align: middle">Payment</th>
						<th style="vertical-align: middle">Type</th>
						<th style="vertical-align: middle">Sales</th>
						<th style="vertical-align: middle">Status</th>
						<th style="vertical-align: middle">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					foreach($waiting as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td>".$row['event_name']."</td>";
						echo "<td>".ucwords($row['participant_name'])."</td>";
						// echo "<td class='text-center'>".$row['age']."</td>";
						// if($row['gender'] == "L"){
						// 	echo "<td><label class='badge orange'>Male</label></td>";
						// }else{
						// 	echo "<td><label class='badge pink lighten-2'>Female</label></td>";
						// }
						echo "<td>".$row['phone']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td>".number_format($row['paid_value'])."</td>";
						echo "<td>".$row['paid_date']."</td>";
						
						if(!empty($row['transfer_atas_nama'])){
							echo "<td>".$row['payment_type']."<br><label class='badge badge-primary'>".$row['transfer_atas_nama']."</label></td>";
						}else{
							echo "<td>".$row['payment_type']."</td>";
						}

						if($row['closing_type'] == "Lunas"){
							echo "<td><label class='badge badge-success'>".ucfirst($row['closing_type'])."</label></td>";
						}else{
							echo "<td><label class='badge badge-light'>".ucfirst($row['closing_type'])."</label></td>";
						}

						echo "<td><label class='badge badge-info'>".ucfirst($row['username'])."</label></td>";
						
						if($row['is_approved'] == 1){
							echo "<td><label class='badge badge-success'>Approved</label></td>";
						}else if($row['is_rejected'] == 1){
							echo "<td><label class='badge badge-danger'>Rejected</label></td>";
						}else{
							echo "<td><label class='badge badge-light'>Waiting</label></td>";
						}
				
						echo "<td><a onclick='hapus(".$row['transaction_id'].")' class='btn btn-danger' title='Hapus data?'><i class='fa fa-trash'></i></a></td>";
						echo "</tr>";

					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_add_signup" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">ADD SIGNUP</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-inline">
					<div class="form-group row w-100">
						<label class="col-sm-4">Phone Number</label>
						<div class="col-sm-6">
							<input type="text" id="search_phone" class="form-control w-100 numeric" placeholder="Masukkan kontak peserta">
						</div>
						<div class="col-sm-2">
							<button type="button" onclick="search_phone()" class="btn btn-dark"><i class="fa fa-search"></i>&nbsp; Search</button>
						</div>
					</div>
				</div>
				<div class="form-group row w-100 pt-1">
					<label class="col-sm-4"></label>
					<div class="col-sm-6">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="no_phone">
							<label class="custom-control-label" for="no_phone">No Phone Number</label>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_participant" data-backdrop="static" data-keyboard="false" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?= base_url('user/signup/submit_form_participant')?>" method="post" id="form_participant" style="padding-left:15px;padding-right: 15px;">
				<div class="modal-header" style="background-color:#17a2b8;color:#fff">
					<h4 class="modal-title" id="header_participant">FORM DATA | NEW</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="card">
						<input type="hidden" name="participant_id" id="participant_id" value="">
						<input type="hidden" name="affiliate_id" id="affiliate_id" value="">
						<div class="card-body">
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Program Name</label>
								<div class="col-sm-8">
									<select class="form-control" name="event_name" id="event_name" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($event as $row){
											echo "<option value='".$row['id']."' data-kids='".$row['is_program_kids']."'>".$row['name']."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Signup Method</label>
								<div class="col-sm-8">
									<select class="form-control" name="signup_type" id="signup_type" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_signup_type as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row" id="show_task">
								<label class="col-form-label col-sm-4">Session</label>
								<div class="col-sm-8">
									<select class="form-control" name="id_task" id="id_task">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_task as $row){
											echo "<option value='".$row['id']."'>".date('d-M-Y', strtotime($row['date'])).' | '.$row['event'].' | '.$row['location']."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4"></label>
								<div class="col-sm-4">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="is_reattendance" name="is_reattendance">
										<label class="custom-control-label" for="is_reattendance">Re-Attendance</label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="is_no_commision" name="is_no_commision">
										<label class="custom-control-label" for="is_no_commision">No Commision</label>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Closing Type</label>
								<div class="col-sm-8">
									<select class="form-control" name="closing_type" id="closing_type" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_closing_type as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Payment Type</label>
								<div class="col-sm-8">
									<select class="form-control" name="payment_type" id="payment_type" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_payment_type as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row" id="atas_nama_div">
								<label class="col-form-label col-sm-4">Atas Nama</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="atas_nama" id="atas_nama" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Amount Paid</label>
								<div class="col-sm-8">
									<input name="paid_value" id="paid_value" class="form-control numeric" required="" type="text" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Paid Date</label>
								<div class="col-sm-8">
									<input name="paid_date" id="paid_date" class="form-control datepicker" required="" type="text" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Sales</label>
								<div class="col-sm-8">
									<select class="form-control" name="id_user_closing" id="id_user_closing" required="">
										<option value="">- Choose a Warrior -</option>
										<?php 
										foreach($list_warrior as $row){
											echo "<option value='".$row['id']."'>".ucfirst($row['username'])."</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="card text-white elegant-color" style="border-radius: 0px;">
							<div class="card-body text-right text-white py-2">
								<span>Sales Commision : <b>Rp <span id="commision_label">0</span></b></span>
								<input type="hidden" name="event_commision" id="event_commision">
							</div>
						</div>
					</div>
					<div class="card mt-3">
						<div class="card-body">
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Name</label>
								<div class="col-sm-8">
									<input name="participant_name" id="participant_name" class="form-control" required="" type="text" placeholder="" autocomplete="off">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Birthdate</label>
								<div class="col-sm-8">
									<input name="birthdate" id="birthdate" class="form-control" type="text" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Gender</label>
								<div class="col-sm-8">
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input" type="radio" name="gender" id="inlineRadio1" value="L" required="">
										<label class="custom-control-label" for="inlineRadio1">Male</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input" type="radio" name="gender" id="inlineRadio2" value="P" required="">
										<label class="custom-control-label" for="inlineRadio2">Female</label>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Phone</label>
								<div class="col-sm-8">
									<input name="phone" id="phone" class="form-control numeric" type="text" placeholder="" autocomplete="off" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Email</label>
								<div class="col-sm-8">
									<input name="email" id="email" class="form-control" type="email" placeholder="" autocomplete="off">
								</div>
							</div>

							<div id="show_kids">
								<div class="form-group row">
									<label class="col-form-label col-sm-4">Address</label>
									<div class="col-sm-8">
										<input name="address" id="address" class="form-control" type="text" placeholder="" autocomplete="off">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-sm-4">School</label>
									<div class="col-sm-8">
										<input name="school" id="school" class="form-control" type="text" placeholder="" autocomplete="off">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-sm-4"></label>
									<div class="col-sm-8">
										<div class="custom-control custom-checkbox custom-control-inline">
											<input class="custom-control-input" type="checkbox" id="is_vegetarian" name="is_vegetarian" value="1">
											<label class="custom-control-label" for="is_vegetarian">Vegetarian</label>
										</div>
										<div class="custom-control custom-checkbox custom-control-inline">
											<input class="custom-control-input" type="checkbox" id="is_allergy" name="is_allergy" value="1">
											<label class="custom-control-label" for="is_allergy">Alergi</label>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<h5 class="text-center w-100">Dad's Data</h5>
										</div>
										<div class="form-group row">
											<label class="col-form-label col-sm-4">Phone</label>
											<div class="col-sm-8">
												<input name="dad_phone" id="dad_phone" class="form-control numeric" type="text" placeholder="" autocomplete="off">
												<input name="dad_id" id="dad_id" class="dad" type="hidden">
											</div>
										</div>
										<div class="form-group row dad">
											<label class="col-form-label col-sm-4">Name</label>
											<div class="col-sm-8">
												<input name="dad_name" id="dad_name" class="form-control" type="text" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group row dad">
											<label class="col-form-label col-sm-4">Email</label>
											<div class="col-sm-8">
												<input name="dad_email" id="dad_email" class="form-control" type="email" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group row dad">
											<label class="col-form-label col-sm-4">Job</label>
											<div class="col-sm-8">
												<input name="dad_job" id="dad_job" class="form-control" type="text" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="col-12 text-right px-0">
											<label class="blockquote-footer badge-light px-3" id="dad_message"></label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<h5 class="text-center w-100">Mom's Data</h5>
										</div>
										<div class="form-group row border-left-div">
											<label class="col-form-label col-sm-4">Phone</label>
											<div class="col-sm-8">
												<input name="mom_phone" id="mom_phone" class="form-control numeric" type="text" placeholder="" autocomplete="off">
												<input name="mom_id" id="mom_id" type="hidden">
											</div>
										</div>
										<div class="form-group row border-left-div mom">
											<label class="col-form-label col-sm-4">Name</label>
											<div class="col-sm-8">
												<input name="mom_name" id="mom_name" class="form-control" type="text" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group row border-left-div mom">
											<label class="col-form-label col-sm-4">Email</label>
											<div class="col-sm-8">
												<input name="mom_email" id="mom_email" class="form-control" type="email" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group row border-left-div mom">
											<label class="col-form-label col-sm-4">Job</label>
											<div class="col-sm-8">
												<input name="mom_job" id="mom_job" class="form-control" type="text" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="col-12 text-right px-0">
											<label class="blockquote-footer badge-light px-3" id="mom_message"></label>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Source</label>
								<div class="col-sm-8">
									<select class="form-control" name="source" id="source" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_source as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row" id="referral_div">
								<label class="col-form-label col-sm-4">Referral Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="referral" id="referral" placeholder="" autocomplete="off">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Notes</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="remark" id="remark" placeholder="" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="submit_new">Submit</button>
					<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
				</div>
			</form>				
		</div>

	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_student" data-backdrop="static" data-keyboard="false" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?= base_url('user/signup/submit_form_student')?>" method="post" id="form_student" style="padding-left:15px;padding-right: 15px;">
				<div class="modal-header" style="background-color:#ec407a ;color:#fff">
					<h4 class="modal-title" id="header_std">FORM DATA | NEW STUDENT</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="card">
						<input type="hidden" name="participant_id_std" id="participant_id_std" value="">
						<input type="hidden" name="affiliate_id_std" id="affiliate_id_std" value="">
						<div class="card-body">
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Program Name</label>
								<div class="col-sm-8">
									<select class="form-control" name="std_event_name" id="std_event_name" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($event as $row){
											echo "<option value='".$row['id']."' data-kids='".$row['is_program_kids']."'>".$row['name']."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Signup Method</label>
								<div class="col-sm-8">
									<select class="form-control" name="std_signup_type" id="std_signup_type" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_signup_type as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row" id="std_show_task">
								<label class="col-form-label col-sm-4">Session</label>
								<div class="col-sm-8">
									<select class="form-control" name="std_id_task" id="std_id_task">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_task as $row){
											echo "<option value='".$row['id']."'>".date('d-M-Y', strtotime($row['date'])).' | '.$row['event'].' | '.$row['location']."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4"></label>
								<div class="col-sm-4">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="std_is_upgrade" name="std_is_upgrade">
										<label class="custom-control-label" for="std_is_upgrade">Upgrade Program</label>
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="std_is_no_commision" name="std_is_no_commision">
										<label class="custom-control-label" for="std_is_no_commision">No Commision</label>
									</div>
								</div>

							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Closing Type</label>
								<div class="col-sm-8">
									<select class="form-control" name="std_closing_type" id="std_closing_type" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_closing_class as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row modul">
								<label class="col-form-label col-sm-4">Total Modul</label>
								<div class="col-sm-8">
									<input name="modul_class" id="modul_class" class="form-control numeric" type="number" min="1" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row full_program">
								<label class="col-form-label col-sm-4">Start Date</label>
								<div class="col-sm-8">
									<input name="full_program_startdate" id="full_program_startdate" class="form-control datepicker2" type="text" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Payment Type</label>
								<div class="col-sm-8">
									<select class="form-control" name="std_payment_type" id="std_payment_type" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_payment_type as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row" id="std_atas_nama_div">
								<label class="col-form-label col-sm-4">Atas Nama</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="std_atas_nama" id="std_atas_nama" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Amount Paid</label>
								<div class="col-sm-8">
									<input name="std_paid_value" id="std_paid_value" class="form-control numeric" required="" type="text" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Paid Date</label>
								<div class="col-sm-8">
									<input name="std_paid_date" id="std_paid_date" class="form-control datepicker" required="" type="text" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Sales</label>
								<div class="col-sm-8">
									<select class="form-control" name="std_id_user_closing" id="std_id_user_closing" required="">
										<option value="">- Choose a Warrior -</option>
										<?php 
										foreach($list_warrior as $row){
											echo "<option value='".$row['id']."'>".ucfirst($row['username'])."</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="card text-white elegant-color" style="border-radius: 0px;">
							<div class="card-body text-right text-white py-2">
								<span>Sales Commision : <b>Rp <span id="std_commision_label">0</span></b></span>
								<input type="hidden" name="std_event_commision" id="std_event_commision">
							</div>
						</div>
					</div>
					<div class="card mt-3">
						<div class="card-body">
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Name</label>
								<div class="col-sm-8">
									<input name="std_participant_name" id="std_participant_name" class="form-control" required="" type="text" placeholder="" autocomplete="off">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Birthdate</label>
								<div class="col-sm-8">
									<input name="std_birthdate" id="std_birthdate" class="form-control" type="text" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Gender</label>
								<div class="col-sm-8">
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input" type="radio" name="std_gender" id="inlineRadio3" value="L" required="">
										<label class="custom-control-label" for="inlineRadio3">Male</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input" type="radio" name="std_gender" id="inlineRadio4" value="P" required="">
										<label class="custom-control-label" for="inlineRadio4">Female</label>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Phone</label>
								<div class="col-sm-8">
									<input name="std_phone" id="std_phone" class="form-control numeric" type="text" placeholder="" autocomplete="off" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Email</label>
								<div class="col-sm-8">
									<input name="std_email" id="std_email" class="form-control" type="email" placeholder="" autocomplete="off">
								</div>
							</div>

							<div id="std_show_kids">
								<div class="form-group row">
									<label class="col-form-label col-sm-4">Address</label>
									<div class="col-sm-8">
										<input name="std_address" id="std_address" class="form-control" type="text" placeholder="" autocomplete="off">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-sm-4">School</label>
									<div class="col-sm-8">
										<input name="std_school" id="std_school" class="form-control" type="text" placeholder="" autocomplete="off">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-sm-4"></label>
									<div class="col-sm-8">
										<div class="custom-control custom-checkbox custom-control-inline">
											<input class="custom-control-input" type="checkbox" id="std_is_vegetarian" name="std_is_vegetarian" value="1">
											<label class="custom-control-label" for="std_is_vegetarian">Vegetarian</label>
										</div>
										<div class="custom-control custom-checkbox custom-control-inline">
											<input class="custom-control-input" type="checkbox" id="std_is_allergy" name="std_is_allergy" value="1">
											<label class="custom-control-label" for="std_is_allergy">Alergi</label>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<h5 class="text-center w-100">Dad's Data</h5>
										</div>
										<div class="form-group row">
											<label class="col-form-label col-sm-4">Phone</label>
											<div class="col-sm-8">
												<input name="std_dad_phone" id="std_dad_phone" class="form-control numeric" type="text" placeholder="" autocomplete="off">
												<input name="std_dad_id" id="std_dad_id" class="dad" type="hidden">
											</div>
										</div>
										<div class="form-group row dad">
											<label class="col-form-label col-sm-4">Name</label>
											<div class="col-sm-8">
												<input name="std_dad_name" id="std_dad_name" class="form-control" type="text" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group row dad">
											<label class="col-form-label col-sm-4">Email</label>
											<div class="col-sm-8">
												<input name="std_dad_email" id="std_dad_email" class="form-control" type="email" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group row dad">
											<label class="col-form-label col-sm-4">Job</label>
											<div class="col-sm-8">
												<input name="std_dad_job" id="std_dad_job" class="form-control" type="text" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="col-12 text-right px-0">
											<label class="blockquote-footer badge-light px-3" id="std_dad_message"></label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<h5 class="text-center w-100">Mom's Data</h5>
										</div>
										<div class="form-group row border-left-div">
											<label class="col-form-label col-sm-4">Phone</label>
											<div class="col-sm-8">
												<input name="std_mom_phone" id="std_mom_phone" class="form-control numeric" type="text" placeholder="" autocomplete="off">
												<input name="std_mom_id" id="std_mom_id" type="hidden">
											</div>
										</div>
										<div class="form-group row border-left-div mom">
											<label class="col-form-label col-sm-4">Name</label>
											<div class="col-sm-8">
												<input name="std_mom_name" id="std_mom_name" class="form-control" type="text" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group row border-left-div mom">
											<label class="col-form-label col-sm-4">Email</label>
											<div class="col-sm-8">
												<input name="std_mom_email" id="std_mom_email" class="form-control" type="email" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group row border-left-div mom">
											<label class="col-form-label col-sm-4">Job</label>
											<div class="col-sm-8">
												<input name="std_mom_job" id="std_mom_job" class="form-control" type="text" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="col-12 text-right px-0">
											<label class="blockquote-footer badge-light px-3" id="std_mom_message"></label>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Source</label>
								<div class="col-sm-8">
									<select class="form-control" name="std_source" id="std_source" required="">
										<option value="">- Choose an option -</option>
										<?php 
										foreach($list_source as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row" id="std_referral_div">
								<label class="col-form-label col-sm-4">Referral Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="std_referral" id="std_referral" placeholder="" autocomplete="off">
								</div>
							</div> 
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Notes</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="std_remark" id="std_remark" placeholder="" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="std_submit_new">Submit</button>
					<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
				</div>
			</form>				
		</div>

	</div>
</div>


<script type="text/javascript" src="<?= base_url();?>inc/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>inc/md5.min.js"></script>

<script>
	$(document).ready(function(){
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});

		$('[data-toggle="tooltip"]').tooltip(); 
		$('#table1').DataTable({
			'scrollX':true,
			'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		$("#birthdate, #std_birthdate").datepicker({
			dateFormat : 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: '1930:'+new Date().getFullYear()
		});

		$(".datepicker").datepicker({
			dateFormat : 'yy-mm-dd',
			maxDate : 0,
		});

		$(".datepicker2").datepicker({
			dateFormat : 'yy-mm-dd',
		});
		$('.mom, .dad').hide();
		show_kids();
		show_task();
		show_referral();
		show_kids_std();
		show_task_std();
		show_referral_std();
		std_closing_type();
		std_payment_type();
		payment_type();
	});

	function reload_page(){
		window.location.reload();
	}

	function hapus(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Hapus data transaksi, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('user/signup/delete')?>",
						type: "POST",
						dataType: "json",
						data:{'id': id},
						success:function(result){					
							reload_page();
						}, error: function(e){
							console.log(e);
						}
					})
				}
			});
		}
	}

	$('.numeric').keyup(function(e){
		if (/\D/g.test(this.value)){
			this.value = this.value.replace(/\D/g, '');
		}
	});
	
	$('#add_signup').click(function(){
		// $("#form_participant").trigger('reset');
		$('#search_phone').val('');
		$('#modal_add_signup').modal('show');
	});

	$('#new').click(function(){
		$("#form_participant").trigger('reset');
		$('#modal_participant').modal('show');
		show_kids();
		show_task();
	});


	$('#event_name').change(function(){
		show_kids();
	});

	$('#signup_type').change(function(){
		show_task();
	});

	$('#std_event_name').change(function(){
		show_kids_std();
	});

	$('#std_signup_type').change(function(){
		show_task_std();
	});

	$('#search_phone').keypress(function (e) {
		if (e.which == 13) {
			search_phone();
		}
	});

	$('#dad_phone').on('change',function(){
		is_dad_phone_exist();
	});

	$('#mom_phone').on('change',function(){
		is_mom_phone_exist();
	});

	$('#std_dad_phone').on('change',function(){
		std_is_dad_phone_exist();
	});

	$('#std_mom_phone').on('change',function(){
		std_is_mom_phone_exist();
	});

	$('#std_closing_type').on('change', function(){
		std_closing_type();
	});

	$('#source').on('change', function(){
		show_referral();
	});

	$('#std_source').on('change', function(){
		show_referral_std();
	});

	$('#signup_type, #is_reattendance, #event_name, #closing_type, #is_no_commision').change(function(){
		check_commision();
	});

	$('#std_signup_type, #std_event_name, #std_closing_type, #std_is_no_commision').change(function(){
		std_check_commision();
	});

	$('#payment_type').on('change', function(){
		payment_type();
	});

	$('#std_payment_type').on('change', function(){
		std_payment_type();
	});

	function check_commision(){
		var event 			= $('#event_name').val();
		var signup_method 	= $('#signup_type').val();
		var closing_type 	= $('#closing_type').val();
		var reattendance 	= false;
		var no_commision 	= false;
		// var id_participant 	= $('#participant_id').val();
		if ($('#is_reattendance').is(":checked")){
			reattendance = true;
		}
		if ($('#is_no_commision').is(":checked")){
			no_commision = true;
		}

		if(reattendance == false && signup_method != '' && signup_method != 'Others' && event != '' && closing_type != '' && no_commision == false){
			$.ajax({
				url: "<?= base_url('user/signup/json_get_data_event')?>",
				type: "POST",
				dataType: "json",
				data:{'event': event},
				success:function(result){
					var commision = 0;
					if(closing_type == 'Lunas'){
						commision = result.lunas;
					}else if(closing_type = 'DP'){
						commision = result.dp;
					}
					$('#event_commision').val(commision);
					$('#commision_label').empty().html(Number(commision).toLocaleString());
				}, error: function(e){
					console.log(e);
				}
			});
		}else{
			$('#event_commision').val('');
			$('#commision_label').empty().html(0);
		}

	}

	function std_check_commision(){
		var event 			= $('#std_event_name').val();
		var signup_method 	= $('#std_signup_type').val();
		var closing_type 	= $('#std_closing_type').val();
		var no_commision 	= false;
		// var id_participant 	= $('#participant_id_std').val();
		if ($('#std_is_no_commision').is(":checked")){
			no_commision = true;
		}

		if(signup_method != '' && signup_method != 'Others' && event != '' && closing_type != '' && no_commision == false){
			$.ajax({
				url: "<?= base_url('user/signup/json_get_data_event')?>",
				type: "POST",
				dataType: "json",
				data:{'event': event},
				success:function(result){
					var commision = 0;
					if(closing_type == 'Full Program'){
						commision = result.lunas;
					}else if(closing_type = 'Modul'){
						commision = result.dp;
					}
					$('#std_event_commision').val(commision);
					$('#std_commision_label').empty().html(Number(commision).toLocaleString());
				}, error: function(e){
					console.log(e);
				}
			});
		}else{
			$('#std_event_commision').val('');
			$('#std_commision_label').empty().html(0);
		}

	}

	function show_kids(){
		var kids = $('#event_name').find(':selected').data('kids');
		if(kids == 1){
			$('#show_kids').show('slide',{direction:'up'},500);
		}else{
			$('#show_kids').hide('slide',{direction:'up'},500);
		}
	}

	function show_task(){
		var task = $('#signup_type').val();
		if(task == 'SP'){
			$('#show_task').show('slide',{direction:'up'},500);
		}else{
			$('#show_task').hide('slide',{direction:'up'},500);
		}
	}

	function show_referral(){
		var source = $('#source').val();
		if(source == 'Referral'){
			$('#referral_div').slideDown(500);
		}else{
			$('#referral_div').hide('slide',{direction:'up'},500);
		}
	}

	function show_referral_std(){
		var source = $('#std_source').val();
		if(source == 'Referral'){
			$('#std_referral_div').slideDown(500);
		}else{
			$('#std_referral_div').hide('slide',{direction:'up'},500);
		}
	}

	function show_kids_std(){
		var kids = $('#std_event_name').find(':selected').data('kids');
		if(kids == 1){
			$('#std_show_kids').show('slide',{direction:'up'},500);
		}else{
			$('#std_show_kids').hide('slide',{direction:'up'},500);
		}
	}

	function show_task_std(){
		var task = $('#std_signup_type').val();
		if(task == 'SP'){
			$('#std_show_task').show('slide',{direction:'up'},500);
		}else{
			$('#std_show_task').hide('slide',{direction:'up'},500);
		}
	}

	function std_closing_type(){
		var closing_type = $('#std_closing_type').val();
		if(closing_type == 'Full Program'){
			$('.full_program').show(500);
			$('.modul').hide(500);
		}else if(closing_type == 'Modul'){
			$('.modul').show(500);
			$('.full_program').hide(500);
		}else{
			$('.modul, .full_program').hide(500);
		}
	}

	function payment_type(){
		var payment_type = $('#payment_type').val();
		if(payment_type == 'Transfer'){
			$('#atas_nama_div').show(500);
		}else{
			$('#atas_nama_div').hide(500);
		}
	}

	function std_payment_type(){
		var payment_type = $('#std_payment_type').val();
		if(payment_type == 'Transfer'){
			$('#std_atas_nama_div').show(500);
		}else{
			$('#std_atas_nama_div').hide(500);
		}
	}

	function is_dad_phone_exist(){
		var phone = $('#dad_phone').val();
		if(phone != ''){
			$.ajax({
				url: "<?= base_url('user/signup/json_phone_exist')?>",
				type: "POST",
				dataType: "json",
				data:{'phone': phone},
				success:function(result){
					if(!result){
						$('#dad_message').empty().removeClass().addClass('blockquote-footer badge-info px-3').html('New Data').show('slide',{direction:'up'},500);
						$('.dad :input').val('').prop('readonly', false);
					}else{
						$('#dad_name').val(result.participant_name).prop('readonly', true);
						$('#dad_id').val(result.participant_id);
						$('#dad_job').val(result.job).prop('readonly', true);
						$('#dad_email').val(result.email).prop('readonly', true);
						$('#dad_message').empty().removeClass().addClass('blockquote-footer badge-success px-3').html('Found').show('slide',{direction:'up'},500);
					}
					$('.dad').show(500);
				}, error: function(e){
					console.log(e);
				}
			});
		}else{
			$('.dad').hide();
			$('.dad :input').val('').prop('readonly', false);
			$('#dad_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
		}
	}

	function is_mom_phone_exist(){
		var phone = $('#mom_phone').val();
		if(phone != ''){
			$.ajax({
				url: "<?= base_url('user/signup/json_phone_exist')?>",
				type: "POST",
				dataType: "json",
				data:{'phone': phone},
				success:function(result){
					if(!result){
						$('#mom_message').empty().removeClass().addClass('blockquote-footer badge-info px-3').html('New Data').show('slide',{direction:'up'},500);
						$('.mom :input').val('').prop('readonly', false);
					}else{
						$('#mom_name').val(result.participant_name).prop('readonly', true);
						$('#mom_id').val(result.participant_id);
						$('#mom_job').val(result.job).prop('readonly', true);
						$('#mom_email').val(result.email).prop('readonly', true);
						$('#mom_message').empty().removeClass().addClass('blockquote-footer badge-success px-3').html('Found').show('slide',{direction:'up'},500);
					}
					$('.mom').show(500);
				}, error: function(e){
					console.log(e);
				}
			});
		}else{
			$('.mom').hide();
			$('.mom :input').val('').prop('readonly', false);
			$('#mom_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
		}
	}

	function std_is_dad_phone_exist(){
		var phone = $('#std_dad_phone').val();
		if(phone != ''){
			$.ajax({
				url: "<?= base_url('user/signup/json_phone_exist')?>",
				type: "POST",
				dataType: "json",
				data:{'phone': phone},
				success:function(result){
					if(!result){
						$('#std_dad_message').empty().removeClass().addClass('blockquote-footer badge-info px-3').html('New Data').show('slide',{direction:'up'},500);
						$('.dad :input').val('').prop('readonly', false);
					}else{
						$('#std_dad_name').val(result.participant_name).prop('readonly', true);
						$('#std_dad_id').val(result.participant_id);
						$('#std_dad_job').val(result.job).prop('readonly', true);
						$('#std_dad_email').val(result.email).prop('readonly', true);
						$('#std_dad_message').empty().removeClass().addClass('blockquote-footer badge-success px-3').html('Found').show('slide',{direction:'up'},500);
					}
					$('.dad').show(500);
				}, error: function(e){
					console.log(e);
				}
			});
		}else{
			$('.dad').hide();
			$('.dad :input').val('').prop('readonly', false);
			$('#std_dad_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
		}
	}

	function std_is_mom_phone_exist(){
		var phone = $('#std_mom_phone').val();
		if(phone != ''){
			$.ajax({
				url: "<?= base_url('user/signup/json_phone_exist')?>",
				type: "POST",
				dataType: "json",
				data:{'phone': phone},
				success:function(result){
					if(!result){
						$('#std_mom_message').empty().removeClass().addClass('blockquote-footer badge-info px-3').html('New Data').show('slide',{direction:'up'},500);
						$('.mom :input').val('').prop('readonly', false);
					}else{
						$('#std_mom_name').val(result.participant_name).prop('readonly', true);
						$('#std_mom_id').val(result.participant_id);
						$('#std_mom_job').val(result.job).prop('readonly', true);
						$('#std_mom_email').val(result.email).prop('readonly', true);
						$('#std_mom_message').empty().removeClass().addClass('blockquote-footer badge-success px-3').html('Found').show('slide',{direction:'up'},500);
					}
					$('.mom').show(500);
				}, error: function(e){
					console.log(e);
				}
			});
		}else{
			$('.mom').hide();
			$('.mom :input').val('').prop('readonly', false);
			$('#std_mom_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
		}
	}

	function validateEmail($email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test( $email );
	}	

	function add_data_referral(id){
		$.ajax({
			url: "https://merryriana.com/reseller/request/get_affiliate_detail",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				console.log(result);
				$.ajax({
					url: "<?= base_url('user/signup/json_email_exist')?>",
					type: "POST",
					dataType: "json",
					data:{'email': result.email},
					success:function(exist){
						if(!exist){
							$('#modal_referral').modal('hide');
							$('#id_affiliate').val(result.id);
							$('#ref_event_name').val(result.event).change();
							$('#ref_participant_name').val(result.nama);
							$('#ref_email').val(result.email);
							$('#ref_phone').val(result.hp);
							$('#ref_username').val(result.referral);
							$('#modal_data_referral').modal('show');
						}else{
							$.ajax({
								url: "https://merryriana.com/reseller/request/set_affiliate_is_cancel",
								type: "POST",
								dataType: "json",
								data:{'id': result.id},
							});
							$('#modal_referral').modal('hide');
							swal("Referral ditolak", "Peserta sebelumnya sudah mengikuti salah satu program Merry Riana.", "error");							
						}
					}
				})
			}, error: function(e){
				console.log(e);
			}
		})
	}

	function search_phone(){
		var phone = $('#search_phone').val();
		var student = "<?= $this->session->userdata('student_privilege')?>";
		if(phone != ''){
			$.ajax({
				url: "<?= base_url('user/signup/search_data_by_phone')?>",
				type: "POST",
				dataType: "json",
				data:{'phone': phone},
				success:function(result){
					if(result.type == 'new'){
						if(student == 1){
							// Form New Data | MRLC
							$("#form_student").trigger('reset');
							$('#std_event_name').val('').change();
							$('#modal_student').modal('show');
							$('#participant_id_std, #affiliate_id_std, #mom_id, #dad_id, #std_birthdate, #std_email, #std_dad_phone, #std_mom_phone, #std_referral').val('').prop('readonly', false);
							$('#std_phone').val(phone);
							$('[name=std_gender]').attr('checked', false).prop('readonly', 'false');
							$('#header_std').empty().html('FORM NEW | STUDENT');
							show_kids_std();
						}else{
							// Form New Data | MREvent, MRLA
							$("#form_participant").trigger('reset');
							$('#event_name').val('').change();
							$('#modal_participant').modal('show');
							$('#participant_id, #affiliate_id, #mom_id, #dad_id, #birthdate, #email, #dad_phone, #mom_phone, #referral').val('').prop('readonly', false);
							$('#phone').val(phone);
							$('[name=gender]').attr('checked', false).prop('readonly', 'false');
							$('#header_participant').empty().html('FORM NEW | PARTICIPANT');
							show_kids();
						}
					}else if(result.type == 'reseller'){
						if(student == 1){
							// Form Reseller Data | MRLC
							$("#form_student").trigger('reset');
							$('#std_event_name option').filter(function(){
								return $(this).text().toLowerCase() == result.data.event.toLowerCase();
							}).attr('selected', true);
							$('#std_affiliate_id').val(result.data.id);
							$('#std_phone').val(result.data.hp);
							$('#std_email').val(result.data.email);
							$('#std_participant_name').val(result.data.nama);
							$('#std_source').val('Referral').change();
							$('#std_referral').val(result.data.username+" ("+result.data.firstname+")");
							$('#header_std').empty().html('FORM RESELLER | STUDENT');
							$('#modal_student').modal('show');
							show_kids_std();
						}else{
							// Form Reseller Data | MREvent, MRLA
							$("#form_participant").trigger('reset');
							$('#event_name option').filter(function(){
								return $(this).text().toLowerCase() == result.data.event.toLowerCase();
							}).attr('selected', true);
							$('#affiliate_id').val(result.data.id);
							$('#phone').val(result.data.hp);
							$('#email').val(result.data.email);
							$('#participant_name').val(result.data.nama);
							$('#source').val('Referral').change();
							$('#referral').val(result.data.username+" ("+result.data.firstname+")");
							$('#modal_participant').modal('show');
							$('#header_participant').empty().html('FORM RESELLER | PARTICIPANT');
							show_kids();
						}
					}else if(result.type == 'exist'){
						if(student == 1){
							// Form Existing Data | MRLC
							$("#form_student").trigger('reset');
							$('#std_event_name').val('').change();
							$('#header_std').empty().html('FORM EXISTING | STUDENT');
							$('#participant_id_std').val(result.data.participant_id);
							$('#std_participant_name').val(result.data.participant_name);
							$('#std_birthdate').val(result.data.birthdate).prop('readonly', true);;
							$('[name=std_gender]').filter('[value="'+result.data.gender+'"]').attr('checked', true).prop('readonly', true);;
							$('#std_phone').val(result.data.phone).prop('readonly', true);;
							$('#std_email').val(result.data.email).prop('readonly', true);;
							$('#std_address').val(result.data.address);
							$('#std_school').val(result.data.school);
							$('#std_dad_id').val(result.data.dad_id);
							$('#std_dad_phone').val(result.data.dad_phone).prop('readonly', true);;
							$('#std_dad_name').val(result.data.dad_name);
							$('#std_dad_email').val(result.data.dad_email);
							$('#std_dad_job').val(result.data.dad_job);
							$('#std_mom_id').val(result.data.mom_id);
							$('#std_mom_phone').val(result.data.mom_phone).prop('readonly', true);;
							$('#std_mom_name').val(result.data.mom_name);
							$('#std_mom_email').val(result.data.mom_email);
							$('#std_mom_job').val(result.data.mom_job);
							$('#std_show_kids').show('slide',{direction:'up'},500);
							$('.dad, .mom').show(500);
							$('.dad :input, .mom :input').prop('readonly', true);
							$('#std_dad_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
							$('#modal_student').modal('show');
							show_kids_std();
							show_referral_std();
						}else{
							// Form Existing Data | MREvent, MRLA
							$("#form_participant").trigger('reset');
							$('#event_name').val('').change();
							$('#header_participant').empty().html('FORM EXISTING | PARTICIPANT');
							$('#participant_id').val(result.data.participant_id);
							$('#participant_name').val(result.data.participant_name);
							$('#birthdate').val(result.data.birthdate).prop('readonly', true);;
							$('[name=gender]').filter('[value="'+result.data.gender+'"]').attr('checked', true).prop('readonly', true);;
							$('#phone').val(result.data.phone).prop('readonly', true);;
							$('#email').val(result.data.email).prop('readonly', true);;
							$('#address').val(result.data.address);
							$('#school').val(result.data.school);
							$('#dad_id').val(result.data.dad_id);
							$('#dad_phone').val(result.data.dad_phone).prop('readonly', true);;
							$('#dad_name').val(result.data.dad_name);
							$('#dad_email').val(result.data.dad_email);
							$('#dad_job').val(result.data.dad_job);
							$('#mom_id').val(result.data.mom_id);
							$('#mom_phone').val(result.data.mom_phone).prop('readonly', true);;
							$('#mom_name').val(result.data.mom_name);
							$('#mom_email').val(result.data.mom_email);
							$('#mom_job').val(result.data.mom_job);
							$('#show_kids').show('slide',{direction:'up'},500);
							$('.dad, .mom').show(500);
							$('.dad :input, .mom :input').prop('readonly', true);
							$('#dad_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
							$('#modal_participant').modal('show');
							show_kids();
							show_referral();
						}
					}
					$("#modal_add_signup").modal('hide');
					console.log(result);
				}, error: function(e){
					console.log(e);
				}
			})
		}else{

			if($('#no_phone').is(':checked')){
				if(student == 1){
					// Form New Data | MRLC
					$("#form_student").trigger('reset');
					$('#std_event_name').val('').change();
					$('#modal_student').modal('show');
					$('#participant_id_std, #affiliate_id_std, #mom_id, #dad_id, #std_birthdate, #std_email, #std_dad_phone, #std_mom_phone, #std_referral').val('').prop('readonly', false);
					$('#std_phone').val(phone);
					$('[name=std_gender]').attr('checked', false).prop('readonly', 'false');
					$('#header_std').empty().html('FORM NEW | STUDENT');
					show_kids_std();
				}else{
					// Form New Data | MREvent, MRLA
					$("#form_participant").trigger('reset');
					$('#event_name').val('').change();
					$('#modal_participant').modal('show');
					$('#participant_id, #affiliate_id, #mom_id, #dad_id, #birthdate, #email, #dad_phone, #mom_phone, #referral').val('').prop('readonly', false);
					$('#phone').val(phone);
					$('[name=gender]').attr('checked', false).prop('readonly', 'false');
					$('#header_participant').empty().html('FORM NEW | PARTICIPANT');
					show_kids();
				}
				$("#modal_add_signup").modal('hide');
				$('#no_phone').prop('checked', false);
			}else{
				$('#search_phone').focus();
			}
		}
	}
</script>
