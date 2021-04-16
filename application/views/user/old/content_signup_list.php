    <div class="card">
    	<div class="card-header">
    		<h3 class="card-title">Signup List</h3>
    	</div>
    	<div class="card-body">
    		<form method="get" action="<?= base_url('user/signup/all')?>">
    			<div class="form-group row">
    				<label class="col-sm-2 col-form-label">Event</label>
    				<div class="col-sm-4">
    					<select class="form-control js-example-basic-single" name="event">
    						<option value="">All</option>
    						<?php 
    						foreach($event as $row) {
    							if(strtolower($row['name']) == strtolower($filter['event'])){
    								echo "<option value='".$row['name']."' selected>".ucfirst($row['name'])."</option>";
    							}else{
    								echo "<option value='".$row['name']."'>".ucfirst($row['name'])."</option>";
    							}
    						} 
    						?>

    					</select>
    				</div>
    			</div>
    			<div class="form-group row">
    				<label class="col-sm-2 col-form-label">Warrior Closing</label>
    				<div class="col-sm-4">
    					<select class="form-control js-example-basic-single" name="warrior">
    						<option value="">All</option>
    						<?php 
    						foreach($list_warrior as $row) {
    							if($row['id'] == $filter['warrior']){
    								echo "<option value='".$row['id']."' selected>".ucfirst($row['username'])."</option>";
    							}else{
    								echo "<option value='".$row['id']."'>".ucfirst($row['username'])."</option>";
    							}
    						} 
    						?>

    					</select>
    				</div>
    			</div>
    			<div class="form-group row">
    				<label class="col-sm-2 col-form-label">SP</label>
    				<div class="col-sm-4">
    					<select class="form-control js-example-basic-single" name="sp">
    						<option value="">All</option>
    						<?php 
    						foreach($list_task as $row) {
    							if($row['id'] == $filter['sp']){
    								echo "<option value='".$row['id']."' selected>".date('d-M-Y', strtotime($row['date'])).' | '.$row['event'].' | '.$row['location']."</option>";
    							}else{
    								echo "<option value='".$row['id']."'>".date('d-M-Y', strtotime($row['date'])).' | '.$row['event'].' | '.$row['location']."</option>";
    							}
    						} 
    						?>

    					</select>
    				</div>
    			</div>

    			<div class="form-group row">
    				<label class="col-sm-2 col-form-label"></label>
    				<div class="col-sm-4">
    					<button type="submit" class="btn btn-info"><i class="fa fa-search"></i>&nbsp; FILTER</button>
    					<button type="button" class="btn btn-success" id="export" title='Harap tekan tombol filter terlebih dahulu sebelum export data' data-toggle='tooltip' data-placement='right'><i class="fa fa-file-excel"></i>&nbsp; Export To Excel</button>
    				</div>
    			</div>
    		</form>
    		<div class="table-responsive">
    			<table class="table table-bordered w-100" id="table1">
    				<thead>
    					<tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
    						<th class="text-center" style="vertical-align: middle;">No</th>
    						<th style="vertical-align: middle">Event</th>
    						<th style="vertical-align: middle">Peserta</th>
    						<th style="vertical-align: middle">Kontak</th>
    						<th style="vertical-align: middle">Email</th>
    						<th style="vertical-align: middle">Bayar</th>
    						<th style="vertical-align: middle">Tgl Bayar</th>
    						<th style="vertical-align: middle">Status</th>
    						<th style="vertical-align: middle">Closing</th>
    						<th style="vertical-align: middle;min-width: 100px;text-align: center;">SP</th>
    						<th style="vertical-align: middle">Referral</th>
    						<th style="vertical-align: middle">Aksi</th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php 
    					$no = 1;
    					foreach($list as $row){
    						echo "<tr style='font-size:0.9rem;'>";
    						echo "<td class='text-center'>".$no++."</td>";
    						echo "<td>".$row['event_name']."</td>";
    						echo "<td>".ucwords($row['participant_name'])."</td>";
    						echo "<td>".$row['phone']."</td>";
    						echo "<td>".$row['email']."</td>";
    						echo "<td>".number_format($row['paid_value'])."</td>";
    						echo "<td>".$row['paid_date']."</td>";
    						if($row['closing_type'] == "lunas"){
    							echo "<td><label class='badge badge-success'>".ucfirst($row['closing_type'])."</label></td>";
    						}else{
    							echo "<td><label class='badge badge-warning'>".ucfirst($row['closing_type'])."</label></td>";

    						}
    						echo "<td><label class='badge badge-info'>".ucfirst($row['username'])."</label></td>";
    						echo "<td class='text-center'><label class='badge badge-light' style='white-space:normal;'>".($row['task'])."</label></td>";
    						echo "<td class='text-center'><label class='badge badge-primary'>".ucfirst($row['referral'])."</label></td>";

    						echo "<td>
    						<a onclick='detail(".$row['transaction_id'].")' class='btn unique-color' title='Detail Data' data-toggle='tooltip' data-placement='top'><i class='fa fa-search'></i></a>
    						</td>";
    						echo "</tr>";

    					}
    					?>
    				</tbody>
    			</table>
    		</div>    	  
    	</div>

    </div>
    
    <div class="modal fade" tabindex="-1" id="modal_detail" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<form method="#" id="form_detail" style="padding-left:15px;padding-right: 15px;">
    				<div class="modal-header">
    					<h4 class="modal-title" id="myModalLabel">DETAIL DATA TRANSAKSI</h4>
    					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    				</div>
    				<div class="modal-body">
    					<div class="form-group row">
    						<label class="col-form-label col-sm-4">Nama</label>
    						<div class="col-sm-8">
    							<input id="edit_participant_name" name="participant_name" class="form-control" type="text" readonly="">
    						</div>
    					</div>
    					<div class="form-group row">
    						<label class="col-form-label col-sm-4">Jenis Kelamin</label>
    						<div class="col-sm-8">
    							<div class="custom-control custom-radio custom-control-inline">
    								<input class="custom-control-input" type="radio" name="gender" id="edit_inlineRadio1" value="L" disabled="">
    								<label class="custom-control-label" for="edit_inlineRadio1">Laki-laki</label>
    							</div>
    							<div class="custom-control custom-radio custom-control-inline">
    								<input class="custom-control-input" type="radio" name="gender" id="edit_inlineRadio2" value="P" disabled="">
    								<label class="custom-control-label" for="edit_inlineRadio2">Perempuan</label>
    							</div>
    						</div>
    					</div>
    					<div class="form-group row">
    						<label class="col-form-label col-sm-4">Kontak</label>
    						<div class="col-sm-8">
    							<input id="edit_phone" name="phone" class="form-control" type="text" readonly="">
    						</div>
    					</div>

    					<div class="form-group row">
    						<label class="col-form-label col-sm-4">Email</label>
    						<div class="col-sm-8">
    							<input id="edit_email" name="email" class="form-control" type="email" readonly="">
    						</div>
    					</div>

    					<div class="form-group row">
    						<label class="col-form-label col-sm-4">Tgl Lahir</label>
    						<div class="col-sm-8">
    							<input name="birthdate" id="edit_birthdate" class="form-control" type="text" placeholder="Format: yyyy-mm-dd" readonly="">
    						</div>
    					</div>

    					<div id="edit_show_kids">
    						<div class="form-group row">
    							<label class="col-form-label col-sm-4">Address</label>
    							<div class="col-sm-8">
    								<input name="address" id="edit_address" class="form-control" type="text" placeholder="Alamat" readonly="">
    							</div>
    						</div>

    						<div class="form-group row">
    							<label class="col-form-label col-sm-4">School</label>
    							<div class="col-sm-8">
    								<input name="school" id="edit_school" class="form-control" type="text" placeholder="Nama sekolah" readonly="">
    							</div>
    						</div>

    						<div class="form-group row">
    							<label class="col-form-label col-sm-4">Khusus</label>
    							<div class="col-sm-8">
    								<div class="custom-control custom-checkbox custom-control-inline">
    									<input class="custom-control-input" type="checkbox" id="edit_is_vegetarian" name="is_vegetarian" value="1" disabled="">
    									<label class="custom-control-label" for="edit_is_vegetarian">Vegetarian</label>
    								</div>
    								<div class="custom-control custom-checkbox custom-control-inline">
    									<input class="custom-control-input" type="checkbox" id="edit_is_allergy" name="is_allergy" value="1" disabled="">
    									<label class="custom-control-label" for="edit_is_allergy">Alergi</label>
    								</div>
    							</div>
    						</div>
    						<hr>
    						<div class="row">
    							<div class="col-md-6">
    								<div class="form-group row">
    									<h5 class="text-center w-100">DATA AYAH</h5>
    								</div>
    								<div class="form-group row">
    									<label class="col-form-label col-sm-4">Nama</label>
    									<div class="col-sm-8">
    										<input name="dad_name" id="edit_dad_name" class="form-control" type="text" placeholder="Nama ayah" readonly="">
    									</div>
    								</div>
    								<div class="form-group row">
    									<label class="col-form-label col-sm-4">Kontak</label>
    									<div class="col-sm-8">
    										<input name="dad_phone" id="edit_dad_phone" class="form-control" type="text" placeholder="Kontak ayah" readonly="">
    									</div>
    								</div>
    								<div class="form-group row">
    									<label class="col-form-label col-sm-4">Email</label>
    									<div class="col-sm-8">
    										<input name="dad_email" id="edit_dad_email" class="form-control" type="email" placeholder="Email ayah" readonly="">
    									</div>
    								</div>
    								<div class="form-group row">
    									<label class="col-form-label col-sm-4">Pekerjaan</label>
    									<div class="col-sm-8">
    										<input name="dad_job" id="edit_dad_job" class="form-control" type="text" placeholder="Pekerjaan ayah" readonly="">
    									</div>
    								</div>
    							</div>
    							<div class="col-md-6">
    								<div class="form-group row">
    									<h5 class="text-center w-100">DATA IBU</h5>
    								</div>
    								<div class="form-group row border-left-div">
    									<label class="col-form-label col-sm-4">Nama</label>
    									<div class="col-sm-8">
    										<input name="mom_name" id="edit_mom_name" class="form-control" type="text" placeholder="Nama ibu" readonly="">
    									</div>
    								</div>
    								<div class="form-group row border-left-div">
    									<label class="col-form-label col-sm-4">Kontak</label>
    									<div class="col-sm-8">
    										<input name="mom_phone" id="edit_mom_phone" class="form-control" type="text" placeholder="Kontak ibu" readonly="">
    									</div>
    								</div>
    								<div class="form-group row border-left-div">
    									<label class="col-form-label col-sm-4">Email</label>
    									<div class="col-sm-8">
    										<input name="mom_email" id="edit_mom_email" class="form-control" type="email" placeholder="Email ibu" readonly="">
    									</div>
    								</div>
    								<div class="form-group row border-left-div">
    									<label class="col-form-label col-sm-4">Pekerjaan</label>
    									<div class="col-sm-8">
    										<input name="mom_job" id="edit_mom_job" class="form-control" type="text" placeholder="Pekerjaan ibu" readonly="">
    									</div>
    								</div>
    							</div>
    						</div>
    						<hr>
    						<div class="row">
    							<div class="col-md-12">
    								<div class="form-group row">
    									<h5 class="text-center w-100">DATA TRANSAKSI</h5>
    								</div>
    							</div>
    							<div class="col-md-6">
    								<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Event</label>
			    						<div class="col-sm-8">
			    							<input id="edit_event" class="form-control" type="text" readonly="">
			    						</div>
			    					</div>
			    					<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Batch</label>
			    						<div class="col-sm-8">
			    							<input id="edit_batch" class="form-control" type="text" readonly="" placeholder="Batch belum ditentukan">
			    						</div>
			    					</div>
			    					<div class="form-group row">
			    						<label class="col-form-label col-sm-4">SP</label>
			    						<div class="col-sm-8">
			    							<input id="edit_task" class="form-control" type="text" readonly="">
			    						</div>
			    					</div>
			    					<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Tipe Signup</label>
			    						<div class="col-sm-8">
			    							<input id="edit_signup_type" class="form-control" type="text" readonly="">
			    						</div>
			    					</div>
			    					<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Sumber</label>
			    						<div class="col-sm-8">
			    							<input id="edit_source" class="form-control" type="text" readonly="">
			    						</div>
			    					</div>
    							</div>
    							<div class="col-md-6">
			    					<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Status</label>
			    						<div class="col-sm-8">
			    							<input id="edit_status" class="form-control" type="text" readonly="">
			    						</div>
			    					</div>
    								<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Jumlah Bayar</label>
			    						<div class="col-sm-8">
			    							<input id="edit_paid_value" class="form-control" type="text" readonly="">
			    						</div>
			    					</div>
			    					<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Tanggal Bayar</label>
			    						<div class="col-sm-8">
			    							<input id="edit_paid_date" class="form-control" type="text" readonly="">
			    						</div>
			    					</div>
			    					<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Remark</label>
			    						<div class="col-sm-8">
			    							<textarea id="edit_remark" class="form-control" readonly=""></textarea>
			    						</div>
			    					</div>
			    					<div class="form-group row">
			    						<label class="col-form-label col-sm-4">Closing</label>
			    						<div class="col-sm-8">
			    							<input id="edit_closing" class="form-control" type="text" readonly="">
			    						</div>
			    					</div>
    							</div>
    						</div>
    						

    					</div>
    				</div>

    				<div class="modal-footer">
    					<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
    				</div>
    			</form>				
    		</div>

    	</div>
    </div>

    <link rel="stylesheet" href="<?= base_url(); ?>inc/select2/select2.min.css"/>
    <script type="text/javascript" src="<?= base_url();?>inc/select2/select2.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('.js-example-basic-single').select2();
    		$('[data-toggle="tooltip"]').tooltip(); 
    		$(document).ajaxStart(function(){
    			$("#wait").css("display", "block");
    		});
    		$(document).ajaxComplete(function(){
    			$("#wait").css("display", "none");
    		});
    		$('#table1').DataTable({
    			'scrollX':true,
    			'order':false,
    			'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]]
    		});
    		$('#form_detail').submit(function(e){
    			e.preventDefault();
    		})
    	})

    	$('#export').click(function(){
			var query 	= "<?= $_SERVER['QUERY_STRING']?>";
			var url 	= "<?= base_url('user/signup/export_data_transaction?')?>"+query;
			window.open(url, '_blank');
		});
    
    	function detail(id){
    		$('#form_detail').trigger('reset');
    		if(id != ''){
    			$.ajax({
    				url: "<?= base_url('user/signup/json_get_data_transaksi')?>",
    				type: "POST",
    				dataType: "json",
    				data:{'id': id},
    				success:function(result){
    					$('#edit_participant_name').val(result.participant_name);
    					$('#edit_birthdate').val(result.birthdate);
    					$('[name=gender][value="'+result.gender+'"').prop('checked', true);
    					$('#edit_phone').val(result.phone);
    					$('#edit_email').val(result.email);
    					$('#edit_address').val(result.address);
    					$('#edit_school').val(result.school);
    					if(result.is_vegetarian == 1){
    						$('[name=is_vegetarian]').prop('checked', true);
    					}
    					if(result.is_allergy == 1){
    						$('[name=is_allergy]').prop('checked', true);
    					}
    					$('#edit_dad_name').val(result.dad_name);
    					$('#edit_dad_phone').val(result.dad_phone);
    					$('#edit_dad_email').val(result.dad_email);
    					$('#edit_dad_job').val(result.dad_job);
    					$('#edit_mom_name').val(result.mom_name);
    					$('#edit_mom_phone').val(result.mom_phone);
    					$('#edit_mom_email').val(result.mom_email);
    					$('#edit_mom_job').val(result.mom_job);
    					$('#edit_event').val(result.event_name);
    					$('#edit_batch').val(result.batch_label);
    					$('#edit_signup_type').val(result.signup_type);
    					$('#edit_task').val(result.task);
    					$('#edit_source').val(result.source);
    					$('#edit_paid_value').val(result.paid_value);
    					$('#edit_paid_date').val(result.paid_date);
    					$('#edit_status').val(result.closing_type);
    					$('#edit_remark').val(result.remark);
    					$('#edit_closing').val(result.username);
    					$('#modal_detail').modal('show');
    				}, error: function(e){
    					console.log(e);
    				}
    			});
    		}
    	}
    </script>