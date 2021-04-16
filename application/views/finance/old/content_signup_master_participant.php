
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Master Data Peserta</h3>
	</div>
	<div class="card-body">
		<h4>Filter Data</h4>
		<form method="get" action="<?= base_url('finance/signup/master_participant?')?>" id="form_filter">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Email</label>
						<div class="col-sm-8">
							<input type="email" name="email" id="email" class="form-control" placeholder="Email peserta" value="">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Kontak</label>
						<div class="col-sm-8">
							<input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor Handphone peserta" value="">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Range Umur</label>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-md-4">
									<input type="number" name="age1" id="age1" min="0" max="100" value="" placeholder="min" class="form-control">
								</div>
								<div class="col-md-1">
									-
								</div>
								<div class="col-md-4">
									<input type="number" name="age2" id="age2" min="0" max="100" value="" placeholder="max" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Kondisi</label>
						<div class="col-sm-8">
							<select class="form-control" name="kondisi" id="kondisi">
								<option value="all">All</option>
								<option value="is_vegetarian">Vegetarian</option>
								<option value="is_allergy">Alergi</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Date Start</label>
						<div class="col-sm-8">
							<input type="text" name="date_start" id="date_start" class="form-control" value="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Date End</label>
						<div class="col-sm-8" id="div_date_end">
							<input type="text" name="date_end" id="date_end" class="form-control" value="">
						</div>
					</div>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					<button type="submit" class="btn btn-info"><i class="fa fa-search"></i>&nbsp; FILTER</button>
					<button type="button" class="btn btn-blue-grey" onclick="reset()">RESET</button>
					<button type="button" class="btn btn-success" id="export" title='Harap tekan tombol filter terlebih dahulu sebelum export data' data-toggle='tooltip' data-placement='right'><i class="fa fa-file-excel"></i>&nbsp; Export to Excel</button>
				</div>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead>
					<tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Nama</th>
						<th style="vertical-align: middle">Kontak</th>
						<th style="vertical-align: middle">Email</th>
						<th style="vertical-align: middle">Umur</th>
						<th style="vertical-align: middle">Tgl Lahir</th>
						<th style="vertical-align: middle">Gender</th>
						<th style="vertical-align: middle">Alamat</th>
						<th style="vertical-align: middle">Kondisi</th>
						<th style="vertical-align: middle">Date Created</th>
						<th style="vertical-align: middle">Jmlh Trx</th>
						<th style="vertical-align: middle;min-width: 70px;">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					foreach($list as $row){
						echo "<tr style='font-size:0.9rem;'>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td>".ucwords($row['participant_name'])."</td>";
						echo "<td>".$row['phone']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td>".$row['age']."</td>";
						echo "<td>".$row['birthdate']."</td>";
						if($row['gender'] == "L"){
							echo "<td><label class='badge orange'>Laki-laki</label></td>";
						}else{
							echo "<td><label class='badge pink lighten-2'>Perempuan</label></td>";
						}
						echo "<td>".$row['address']."</td>";
						echo "<td>";
						if(!$row['is_vegetarian'] && !$row['is_allergy']){
							echo "-";
						}else{
							if($row['is_vegetarian']){
								echo "<label class='badge default-color'>Vegetarian</label>";
							}
							if($row['is_allergy']){
								echo "<label class='badge secondary-color'>Alergi</label>";
							}
						}
						echo "</td>";
						echo "<td class='text-center'><label class='badge badge-light' style='white-space:normal;'>".($row['date_created'])."</label></td>";
						echo "<td class='text-center'><label class='badge badge-primary'>".$row['jmlh_trx']."</label></td>";
						echo "<td>
								<a onclick='edit(".$row['participant_id'].")' class='btn btn-info' title='Edit Data' data-toggle='tooltip' data-placement='top'><i class='fa fa-edit'></i></a>
								<a onclick='detail(".$row['participant_id'].")' class='btn elegant-color' title='Detail Transaksi' data-toggle='tooltip' data-placement='top'><i class='fas fa-id-card'></i></a>
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
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">List Transaksi</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-stripped" id="table_detail">
						<thead>
							<tr style="background-color:#00695c;color:#fff">
								<th>No</th>
								<th>Peserta</th>
								<th>Event</th>
								<th>Batch</th>
								<th>Paid Value</th>
								<th>Paid Date</th>
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

<div class="modal fade" tabindex="-1" id="modal_edit" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?= base_url('finance/signup/update_participant')?>" method="post" id="form_edit" style="padding-left:15px;padding-right: 15px;">
				<div class="modal-header" style="color:#fff;background-color: #33b5e5;">
					<h4 class="modal-title" id="myModalLabel">FORM DATA PESERTA</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="participant_id" id="participant_id" value="">
					<input type="hidden" name="redirect" id="redirect" value="">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Nama</label>
						<div class="col-sm-8">
							<input id="edit_participant_name" name="participant_name" class="form-control" type="text">
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
							<input id="edit_phone" name="phone" class="form-control" type="text">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-sm-4">Email</label>
						<div class="col-sm-8">
							<input id="edit_email" name="email" class="form-control" type="email">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-sm-4">Tgl Lahir</label>
						<div class="col-sm-8">
							<input name="birthdate" id="edit_birthdate" class="form-control" type="text" placeholder="Format: yyyy-mm-dd">
						</div>
					</div>

					<div id="edit_show_kids">
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Address</label>
							<div class="col-sm-8">
								<input name="address" id="edit_address" class="form-control" type="text" placeholder="Masukkan alamat">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-sm-4">School</label>
							<div class="col-sm-8">
								<input name="school" id="edit_school" class="form-control" type="text" placeholder="Masukkan nama sekolah">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-sm-4">Khusus</label>
							<div class="col-sm-8">
								<div class="custom-control custom-checkbox custom-control-inline">
								  	<input class="custom-control-input" type="checkbox" id="edit_is_vegetarian" name="is_vegetarian" value="1">
								  	<label class="custom-control-label" for="edit_is_vegetarian">Vegetarian</label>
								</div>
								<div class="custom-control custom-checkbox custom-control-inline">
								  	<input class="custom-control-input" type="checkbox" id="edit_is_allergy" name="is_allergy" value="1">
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
										<input name="dad_name" id="edit_dad_name" class="form-control" type="text" placeholder="Nama ayah">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-sm-4">Kontak</label>
									<div class="col-sm-8">
										<input name="dad_phone" id="edit_dad_phone" class="form-control" type="text" placeholder="Kontak ayah">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-sm-4">Email</label>
									<div class="col-sm-8">
										<input name="dad_email" id="edit_dad_email" class="form-control" type="email" placeholder="Email ayah">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-sm-4">Pekerjaan</label>
									<div class="col-sm-8">
										<input name="dad_job" id="edit_dad_job" class="form-control" type="text" placeholder="Pekerjaan ayah">
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
										<input name="mom_name" id="edit_mom_name" class="form-control" type="text" placeholder="Nama ibu">
									</div>
								</div>
								<div class="form-group row border-left-div">
									<label class="col-form-label col-sm-4">Kontak</label>
									<div class="col-sm-8">
										<input name="mom_phone" id="edit_mom_phone" class="form-control" type="text" placeholder="Kontak ibu">
									</div>
								</div>
								<div class="form-group row border-left-div">
									<label class="col-form-label col-sm-4">Email</label>
									<div class="col-sm-8">
										<input name="mom_email" id="edit_mom_email" class="form-control" type="email" placeholder="Email ibu">
									</div>
								</div>
								<div class="form-group row border-left-div">
									<label class="col-form-label col-sm-4">Pekerjaan</label>
									<div class="col-sm-8">
										<input name="mom_job" id="edit_mom_job" class="form-control" type="text" placeholder="Pekerjaan ibu">
									</div>
								</div>
							</div>
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
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
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
			'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});

		$("#edit_birthdate").datepicker({
			dateFormat : 'yy-mm-dd',
			changeMonth: true,
      		changeYear: true,
			yearRange: '1930:'+new Date().getFullYear()
		});

		$('#date_start').datepicker({
			todayHighlight: !0,
			dateFormat: 'yy-mm-dd',
			autoclose: !0,
			maxDate: "<?= date('y-m-d')?>"
		});
		init_date_end();
		init_filter();
	});

	$('#date_start').change(function(e){
		$('#date_end').datepicker('destroy').remove();
		$('#div_date_end').append('<input type="text" name="date_end" id="date_end" class="form-control">');
		$('#date_end').datepicker({
			todayHighlight: !0,
			dateFormat: 'yy-mm-dd',
			autoclose: !0,
			minDate: $('#date_start').val(),
			maxDate: 0
		})
	});

	$('#export').click(function(){
		var query 	= "<?= $_SERVER['QUERY_STRING']?>";
		var url 	= "<?= base_url('finance/signup/export_data_participant?')?>"+query;
		window.open(url, '_blank');
	});

	function reset(){
		$('#form_filter').trigger('reset');
	}

	function init_filter(){
		var email = "<?= $this->input->get('email')?>";
		var phone = "<?= $this->input->get('phone')?>";
		var age1 = "<?= $this->input->get('age1')?>";
		var age2 = "<?= $this->input->get('age2')?>";
		var kondisi = "<?= $this->input->get('kondisi')?>";
		var date_start = "<?= $this->input->get('date_start')?>";
		var date_end = "<?= $this->input->get('date_end')?>";

		if(email != ''){
			$('#email').val(email);
		}
		if(phone != ''){
			$('#phone').val(phone);
		}
		if(age1 != ''){
			$('#age1').val(age1);
		}
		if(age2 != ''){
			$('#age2').val(age2);
		}
		if(kondisi != ''){
			$('#kondisi').val(kondisi).change();
		}
		if(date_start != ''){
			$('#date_start').val(date_start);
		}
		if(date_end != ''){
			$('#date_end').val(date_end);
		}
	}

	function init_date_end(){
		$('#date_end').datepicker({
			todayHighlight: !0,
			dateFormat: 'yy-mm-dd',
			autoclose: !0,
			minDate: $('#date_start').val(),
			maxDate: 0
		})
	}

	function detail(id){
		if(id != ''){
			$.ajax({
				url: "<?= base_url('finance/signup/json_participant_get_transaction')?>",
				type: "POST",
				dataType: "json",
				data:{'id': id},
				success:function(result){
					$('#table_detail').DataTable().destroy();
					$('#table_detail').find('tbody').empty();
					var no = 1;
					$.each(result, function(index, element){

						$('#table_detail').find('tbody').append('<tr>\
							<td class="text-center">'+no+'</td>\
							<td>'+element.participant_name+'</td>\
							<td>'+element.event_name+'</td>\
							<td>'+element.batch_label+'</td>\
							<td>'+element.paid_value+'</td>\
							<td>'+element.paid_date+'</td></tr>\
							');
						no += 1;
					});
					
					$('#table_detail').DataTable({
						'destroy' :true,
						'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
					});

					$('#modal_detail').modal('show');
				}, error: function(e){
					console.log(e);
				}
			});
		}
	}

	function edit(id){
		$('#form_edit').trigger('reset');
		if(id != ''){
			$.ajax({
				url: "<?= base_url('finance/signup/json_get_data_participant_by_id')?>",
				type: "POST",
				dataType: "json",
				data:{'id': id},
				success:function(result){
					var query 	= "<?= $_SERVER['QUERY_STRING']?>";
					$('#redirect').val(query);
					$('#participant_id').val(result.participant_id);
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
					$('#modal_edit').modal('show');
				}, error: function(e){
					console.log(e);
				}
			});
		}
	}

	function reload_page(){
		window.location.reload();
	}

</script>
