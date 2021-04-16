<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
<div class="row mb-3">
    <div class="col-md-12">
        <ul class="list-group inline" id="list-tab" role="tablist" style="flex-direction:row;list-style-type:none;">
            <li>
                <a class="list-group-item list-group-item-action <?= ($tab == 'regular')? 'active':'' ?>"
                    href="<?= base_url('rc/student/manage')?>" role="tab" aria-controls="data">Regular Class</a>
            </li>
            <li>
                <a class="list-group-item list-group-item-action <?= ($tab == 'adult')? 'active':'' ?>"
                    href="<?= base_url('rc/student/manage_adult')?>" role="tab" aria-controls="kode">Adult Class</a>
            </li>
        </ul>
    </div>
</div>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Manage Student | <small>Regular</small></h3>
	</div>
	<div class="card-body">
		<h4>Filter Data</h4>
		<form method="get" action="<?= base_url('rc/student/manage?')?>">
			
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Periode</label>
				<div class="col-sm-8">
					<select class="form-control js-example-basic-single" name="periode" id="periode" required="">
						<option value="all">All</option>
						<?php 
						foreach($periode as $row) {
							if(strtolower($row['periode_id']) == strtolower($this->input->get('periode'))){
								echo "<option value='".$row['periode_id']."' selected>".ucfirst($row['periode_name'])."</option>";
							}else{
								echo "<option value='".$row['periode_id']."'>".ucfirst($row['periode_name'])."</option>";
							}
						} 
						?>

					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">School</label>
				<div class="col-sm-8">
					<select class="form-control js-example-basic-single" name="school" id="school">
						<option value="all">All</option>
						<?php 
						foreach($school as $row) {
							if(strtolower($row['id']) == strtolower($this->input->get('school'))){
								echo "<option value='".$row['id']."' selected>".ucfirst($row['name'])."</option>";
							}else{
								echo "<option value='".$row['id']."'>".ucfirst($row['name'])."</option>";
							}
						} 
						?>

					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Class</label>
				<div class="col-sm-8">
					<select class="form-control js-example-basic-single" name="class" id="class">
						<option value="all">All</option>
						<?php 
						foreach($class as $row) {
							if(strtolower($row['class_id']) == strtolower($this->input->get('class'))){
								echo "<option value='".$row['class_id']."' selected>".ucfirst($row['class_name'])."</option>";
							}else{
								echo "<option value='".$row['class_id']."'>".ucfirst($row['class_name'])."</option>";
							}
						} 
						?>

					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Status</label>
				<div class="col-sm-8">
					<select class="form-control js-example-basic-single" name="status">
						<option value="all">All</option>
						<?php 
						foreach($status as $row) {
							if($row == $this->input->get('status')){
								echo "<option value='".$row."' selected>".ucfirst($row)."</option>";
							}else{
								echo "<option value='".$row."'>".ucfirst($row)."</option>";
							}
						} 
						?>

					</select>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-4 col-form-label"></label>
				<div class="col-sm-8">
					<button type="submit" class="btn primary-color-dark"><i class="fa fa-search"></i>&nbsp; FILTER</button>
					<?php if(!empty($_SERVER['QUERY_STRING'])){?>
					<button type="button" class="btn btn-success" id="export"><i class="fa fa-file-excel"></i>&nbsp; EXPORT</button>
					<?php }?>
				</div>
			</div>
		</form>
		<div class="table-responsive">
			<?php if(!empty($list)){?>
				<table class="table table-bordered w-100" id="table1">
					<thead class="text-center">
						<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
							<th class="text-center" style="vertical-align: middle;">No</th>
							<th style="vertical-align: middle">Student</th>
							<th style="vertical-align: middle">Age</th>
							<th style="vertical-align: middle">Type</th>
							<th style="vertical-align: middle">Start Date</th>
							<th style="vertical-align: middle">End Date</th>
							<th style="vertical-align: middle">Branch</th>
							<th style="vertical-align: middle">School</th>
							<th style="vertical-align: middle">Class</th>
							<th style="vertical-align: middle">Status</th>
							<th style="vertical-align: middle">Action</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php 
						$no = 1;
						foreach($list as $row){
							echo "<tr>";
							echo "<td class='text-center'>".$no++."</td>";
							echo "<td><b>".$row['participant_name']."</b></td>";
							echo "<td class='text-center'><b>".$row['age']."</b></td>";
							echo "<td>".ucwords($row['program_type'])."</td>";
							echo "<td nowrap>".$row['start_date']."</td>";
							echo "<td nowrap>".$row['end_date']."</td>";
							echo "<td>".$row['branch_name']."</td>";
							echo "<td>".$row['program']."</td>";
							echo "<td>".$row['class_name']."</td>";
							echo "<td>";
							if($row['status'] == 'Active'){
								echo "<label class='badge badge-success'>".ucfirst($row['status'])."</label>";
							}else if($row['status'] == 'Dropout'){
								echo "<label class='badge badge-danger'>".ucfirst($row['status'])."</label>";
							}else if($row['status'] == 'Need to upgrade'){
								echo "<label class='badge orange'>".ucfirst($row['status'])."</label>";
							}else if($row['status'] == 'Graduate soon'){
								echo "<label class='badge unique-color'>".ucfirst($row['status'])."</label>";
							}else{
								echo "<label class='badge unique-color-dark'>".ucfirst($row['status'])."</label>";
							}

							if($row['upgrade_to_newmodul'] == 1){
								echo "<br><label class='badge badge-dark'>New Modul</label>";
							}
							echo "</td>";
							echo "<td class='text-center' nowrap>
							<a class='btn btn-warning' onclick='edit(".$row['student_id'].")' title='Edit' data-toggle='tooltip' data-placement='top'><i class='fa fa-edit'></i></a>&nbsp;
							<a class='btn btn-primary' onclick='history_trx(".$row['student_id'].")' title='Riwayat Transaksi' data-toggle='tooltip' data-placement='top'><i class='fa fa-history'></i></a>&nbsp;
							";


							echo "</td></tr>";

						}
						?>
					</tbody>
				</table>
			<?php }else{
				echo "<div class='col-md-12 text-center'><hr><label class='text-red'>Not found</label></div>";
			}?>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_history" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">List Transaction</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-stripped table-bordered" id="table_history">
						<thead>
							<tr style="background-color:#343a40;color:#fff">
								<th style="vertical-align: middle;">No</th>
								<th style="vertical-align: middle;">Participant</th>
								<th style="vertical-align: middle;">Program</th>
								<th style="vertical-align: middle;">Type</th>
								<th style="vertical-align: middle;">Paid Value</th>
								<th style="vertical-align: middle;">Paid Date</th>
								<th style="vertical-align: middle;">Sales</th>
								<th style="vertical-align: middle;">Remark</th>
								<th style="vertical-align: middle;">Status</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_detail" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?= base_url('rc/student/submit_edit_form')?>" method="post" id="form_edit">
				<div class="modal-header" style="color:#fff;background-color: #33b5e5;">
					<h4 class="modal-title" id="myModalLabel">FORM DATA STUDENT</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="participant_id" id="participant_id" value="">
					<input type="hidden" name="student_id" id="student_id" value="">
					<input type="hidden" name="redirect" id="redirect" value="<?= $_SERVER['QUERY_STRING'];?>">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Nama</label>
						<div class="col-sm-8">
							<input id="participant_name" name="participant_name" class="form-control" type="text" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Jenis Kelamin</label>
						<div class="col-sm-8">
							<div class="custom-control custom-radio custom-control-inline">
								<input class="custom-control-input" type="radio" name="gender" id="edit_inlineRadio1" value="L" required="">
								<label class="custom-control-label" for="edit_inlineRadio1">Laki-laki</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input class="custom-control-input" type="radio" name="gender" id="edit_inlineRadio2" value="P" required="">
								<label class="custom-control-label" for="edit_inlineRadio2">Perempuan</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Kontak</label>
						<div class="col-sm-8">
							<input id="phone" name="phone" class="form-control" type="text" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-sm-4">Email</label>
						<div class="col-sm-8">
							<input id="email" name="email" class="form-control" type="email" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-sm-4">Tgl Lahir</label>
						<div class="col-sm-8">
							<input name="birthdate" id="birthdate" class="form-control" type="text" placeholder="Format: yyyy-mm-dd" autocomplete="off">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<h5 class="text-center w-100">DATA AYAH</h5>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Kontak</label>
								<div class="col-sm-8">
									<input name="dad_phone" id="dad_phone" class="form-control numeric" type="text" placeholder="" autocomplete="off">
									<input name="dad_id" id="dad_id" class="dad" type="hidden">
								</div>
							</div>
							<div class="form-group row dad">
								<label class="col-form-label col-sm-4">Nama</label>
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
								<label class="col-form-label col-sm-4">Pekerjaan</label>
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
								<h5 class="text-center w-100">DATA IBU</h5>
							</div>
							<div class="form-group row border-left-div">
								<label class="col-form-label col-sm-4">Kontak</label>
								<div class="col-sm-8">
									<input name="mom_phone" id="mom_phone" class="form-control numeric" type="text" placeholder="" autocomplete="off">
									<input name="mom_id" id="mom_id" type="hidden">
								</div>
							</div>
							<div class="form-group row border-left-div mom">
								<label class="col-form-label col-sm-4">Nama</label>
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
								<label class="col-form-label col-sm-4">Pekerjaan</label>
								<div class="col-sm-8">
									<input name="mom_job" id="mom_job" class="form-control" type="text" placeholder="" autocomplete="off">
								</div>
							</div>
							<div class="col-12 text-right px-0">
								<label class="blockquote-footer badge-light px-3" id="mom_message"></label>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Cabang</label>
						<div class="col-sm-8">
							<input id="branch_name" name="branch_name" class="form-control" type="text" autocomplete="off" readonly="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Program</label>
						<div class="col-sm-8">
							<input id="program" name="program" class="form-control" type="text" autocomplete="off" readonly="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Kelas</label>
						<div class="col-sm-8">
							<input id="class_name" name="class_name" class="form-control" type="text" autocomplete="off" readonly="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Tipe Program</label>
						<div class="col-sm-8">
							<select class="form-control" name="program_type" id="program_type" required="">
								<option value="">- Pilih Tipe -</option>
								<?php 
								foreach($type as $row) {
									echo "<option value='".$row."'>".ucfirst($row)."</option>";
								} 
								?>

							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Tanggal Mulai</label>
						<div class="col-sm-8">
							<input name="start_date" id="start_date" class="form-control datepicker" type="text" placeholder="Format: yyyy-mm-dd" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Tanggal Berakhir</label>
						<div class="col-sm-8">
							<input name="end_date" id="end_date" class="form-control datepicker" type="text" placeholder="Format: yyyy-mm-dd" autocomplete="off">
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-info"">Update</button>
					<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
				</div>
			</form>				
		</div>

	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>inc/jquery-ui/jquery-ui.min.js"></script>

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
			'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]
			],
			'rowReorder': {
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
		});

		$("#birthdate").datepicker({
			dateFormat : 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: '1930:'+new Date().getFullYear()
		});

		$(".datepicker").datepicker({
			dateFormat : 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});

		$('#dad_phone').on('change',function(){
			is_dad_phone_exist();
		});

		$('#mom_phone').on('change',function(){
			is_mom_phone_exist();
		});
	});

	function reload_page(){
		window.location.reload();
	}

	function edit(id){
		$('#form_edit').trigger("reset");
		$('#mom_message, #dad_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
		$('#modal_detail').modal('show');
		$.ajax({
			url: "<?= base_url('rc/student/json_get_data_participant_by_id')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				$('#participant_id').val(result.participant_id);
				$('#student_id').val(result.student_id);
				$('#participant_name').val(result.participant_name);
				$('[name=gender][value="'+result.gender+'"]').prop('checked', true);
				$('#phone').val(result.phone);
				$('#email').val(result.email);
				$('#birthdate').val(result.birthdate);
				$('#dad_id').val(result.dad_id);
				$('#dad_name').val(result.dad_name);
				$('#dad_phone').val(result.dad_phone);
				$('#dad_email').val(result.dad_email);
				$('#dad_job').val(result.dad_job);
				$('#mom_id').val(result.mom_id);
				$('#mom_name').val(result.mom_name);
				$('#mom_phone').val(result.mom_phone);
				$('#mom_email').val(result.mom_email);
				$('#mom_job').val(result.mom_job);
				$('#participant_name').val(result.participant_name);
				$('#branch_name').val(result.branch_name);
				$('#program').val(result.program);
				$('#class_name').val(result.class_name);
				$('#program_type').val(result.program_type).change();
				$('#start_date').val(result.start_date);
				$('#end_date').val(result.end_date);
				$('#modal_detail').modal('show');
			}, error: function(e){
				console.log(e);
			}
		})
	}

	function history_trx(id){
		$.ajax({
			url: "<?= base_url('rc/student/json_get_history_trx')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				$('#table_history').DataTable().destroy();
				$('#table_history').find('tbody').empty();
				var no = 1;
				$.each(result, function(index, element){
					if(element.is_paid_off == 1){
						var status = '<td><label class="badge badge-success">Approved</label></td>';
					}else{
						var status = '<td><label class="badge blue-grey">Waiting</label></td>';
					}
					$('#table_history').find('tbody').append('<tr>\
						<td class="text-center">'+no+'</td>\
						<td>'+element.participant_name+'</td>\
						<td>'+element.event_name+'</td>\
						<td>'+element.closing_type+'</td>\
						<td>'+parseInt(element.paid_value).toLocaleString()+'</td>\
						<td nowrap>'+element.paid_date+'</td>\
						<td>'+element.sales+'</td>\
						<td>'+element.remark+'</td>'+status+'\
						</tr>\
						');
					no += 1;
				});
				
				// $('#table_history').DataTable({
				// 	'destroy' :true,
				// 	'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
				// });
				$('#modal_history').modal('show');
			}, error: function(e){
				console.log(e);
			}
		})
	}

	$('.numeric').keyup(function(e){
		if (/\D/g.test(this.value)){
			this.value = this.value.replace(/\D/g, '');
		}
	});

	$('#export').click(function(){
		var query 	= "<?= $_SERVER['QUERY_STRING']?>";
		var url 	= "<?= base_url('rc/student/export_data_student?')?>"+query;
		window.open(url, '_blank');
	});

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
						$('#dad_name').val(result.participant_name);
						$('#dad_id').val(result.participant_id);
						$('#dad_job').val(result.job);
						$('#dad_email').val(result.email);
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
						$('#mom_name').val(result.participant_name);
						$('#mom_id').val(result.participant_id);
						$('#mom_job').val(result.job);
						$('#mom_email').val(result.email);
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

	

</script>
