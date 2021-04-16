
<div class="card">
	<div class="card-header">
		<h3 class="card-title">List DP</h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Paid Date</th>
						<th style="vertical-align: middle">Paid</th>
						<th style="vertical-align: middle">Payment Type</th>
						<th style="vertical-align: middle">Program</th>
						<th style="vertical-align: middle">Participant</th>
						<th style="vertical-align: middle">Phone</th>
						<th style="vertical-align: middle">Email</th>
						<th style="vertical-align: middle">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($list as $row){
						echo "<tr style='font-size:0.9rem;'>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td>".$row['paid_date']."</td>";
						echo "<td>".number_format($row['paid_value'])."</td>";
						if(!empty($row['transfer_atas_nama'])){
							echo "<td>".$row['payment_type']."<br><label class='badge badge-danger'>".$row['transfer_atas_nama']."</label></td>";
						}else{
							echo "<td>".$row['payment_type']."</td>";
						}
						echo "<td>".$row['event_name']."</td>";
						echo "<td>".ucwords($row['participant_name'])."</td>";
						echo "<td>".$row['phone']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td><a onclick='paidoff(".$row['transaction_id'].")' class='btn btn-info' title='Bayar DP' data-toggle='tooltip' data-placement='top'><i class='fa fa-check-square'></i> Bayar DP</a></td>";
						
						echo "</tr>";

					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
	<div class="card-header">
		<h3 class="card-title">Status Pembayaran DP</h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table2">
				<thead class="text-center">
					<tr style="background-color: #00695c  ;font-size:0.9rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Paid Date</th>
						<th style="vertical-align: middle">Paid</th>
						<th style="vertical-align: middle">Payment Type</th>
						<th style="vertical-align: middle">Program</th>
						<th style="vertical-align: middle">Participant</th>
						<th style="vertical-align: middle">Status</th>
						<th style="vertical-align: middle">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($repayment as $row){
						echo "<tr style='font-size:0.9rem;'>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td>".$row['paid_date']."</td>";
						if(!empty($row['is_repayment_paid_off']) == 1){
							echo "<td>".number_format($row['paid_value'])."<br><label class='badge badge-success'>Lunas</label></td>";
						}else{
							echo "<td>".number_format($row['paid_value'])."</td>";
						}
						if(!empty($row['transfer_atas_nama'])){
							echo "<td>".$row['payment_type']."<br><label class='badge badge-default'>".$row['transfer_atas_nama']."</label></td>";
						}else{
							echo "<td>".$row['payment_type']."</td>";
						}
						echo "<td>".$row['event_name']."</td>";
						echo "<td>".ucwords($row['participant_name'])."</td>";
						if($row['is_approved'] == 1){
							echo "<td><label class='badge badge-success'>Approved</label></td>";
						}else if($row['is_rejected'] == 1){
							echo "<td><label class='badge badge-danger'>Rejected</label></td>";
						}else{
							echo "<td><label class='badge badge-light'>Waiting</label></td>";
						}

						echo "<td>
						<button type='button' class='btn btn-blue-grey detail' data-remark='".$row['remark']."' data-toggle='tooltip' data-placement='top'><i class='fa fa-info'></i></button>
						</td>";
						
						echo "</tr>";

					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_paidoff" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#0d4e6c;color:#fff">
				<h4 class="modal-title" id="myModalLabel">Pembayaran DP</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="transaction_id" id="transaction_id" value="">
				<div class="form-group row">
					<label class="col-form-label col-sm-4">Program</label>
					<div class="col-sm-8">
						<input name="event_name" id="event_name" class="form-control" type="text" readonly="">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-sm-4">Participant</label>
					<div class="col-sm-8">
						<input name="participant_name" id="participant_name" class="form-control" type="text" readonly="">
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
					<label class="col-form-label col-sm-4">Paid</label>
					<div class="col-sm-8">
						<input name="paid_value" id="paid_value" class="form-control numeric" required="" type="text">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Paid Date</label>
					<div class="col-sm-8">
						<input type="text" name="paid_date" id="paid_date" class="form-control datepicker" value="">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-sm-4">Notes</label>
					<div class="col-sm-8">
						<textarea class="form-control" name="remark" id="remark" readonly=""></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-sm-4"></label>
					<div class="col-sm-8">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="lunas" name="lunas">
							<label class="custom-control-label" for="lunas">Tandai Lunas</label>
						</div>
					</div>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="submit_paidoff"></i> Paid</button>
				<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/select2/select2.min.css"/>
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
		$('#table1, #table2').DataTable({
			'scrollX':true,
			'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]
			],
			'rowReorder': {
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
		});

		$('.datepicker').datepicker({
			todayHighlight: !0,
			dateFormat: 'yy-mm-dd',
			autoclose: !0,
			maxDate: 0
		});

		payment_type();
	});

	$('.numeric').keyup(function(e){
		if (/\D/g.test(this.value)){
			this.value = this.value.replace(/\D/g, '');
		}
	});

	$('#payment_type').on('change', function(){
		payment_type();
	});

	$('.detail').click(function(){
		var data = $(this).data('remark');
		alert(data);
	});

	$('#submit_paidoff').click(function(){
		var paid_value 		= $('#paid_value').val();
		var paid_date 		= $('#paid_date').val();
		var transaction_id 	= $('#transaction_id').val();
		var payment_type 	= $('#payment_type').val();
		var atas_nama 		= $('#atas_nama').val();
		var remark 			= $('#remark').val();
		var lunas 			= 0;
		if($('#lunas').is(":checked")){
			lunas = 1;
		}
		if(paid_value != ''){
			if(paid_date != ''){
				if(payment_type != ''){
					$.ajax({
						url: "<?= base_url('user/signup/submit_repayment')?>",
						type: "POST",
						dataType: "json",
						data:{'transaction_id': transaction_id, 'paid_value' : paid_value, 'paid_date': paid_date, 'remark': remark, 'payment_type' : payment_type, 'transfer_atas_nama' : atas_nama, 'is_repayment_paid_off' : lunas},
						success:function(result){
							reload_page();
						}, error: function(e){
							console.log(e);
						}
					})
				}else{
					alert('Pilih jenis pembayaran');
					$('#payment_type').focus();
				}
			}else{
				alert('Tanggal bayar harap diisi');
				$('#paid_date').focus();
			}
		}else{
			alert('Jumlah bayar harap diisi');
			$('#paid_value').focus();
		}
	});


	function reload_page(){
		window.location.reload();
	}

	function paidoff(id){
		if(id != ''){
			$.ajax({
				url: "<?= base_url('user/signup/json_get_data_transaksi')?>",
				type: "POST",
				dataType: "json",
				data:{'id': id},
				success:function(result){
					$('#transaction_id').val(result.transaction_id);
					$('#event_name').val(result.event_name);
					$('#participant_name').val(result.participant_name);
					if(result.is_repayment_update == 0){
						if(result.remark == ''){
							$('#remark').val(result.remark+"Jumlah DP = "+result.paid_value+"\nTanggal DP = "+result.paid_date);				
						}else{
							$('#remark').val(result.remark+"\n\nJumlah DP = "+result.paid_value+"\nTanggal DP = "+result.paid_date);	
						}
					}else{
						$('#remark').val(result.remark);
					}
					$('#modal_paidoff').modal('show');
				}, error: function(e){
					console.log(e);
				}
			})
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
</script>
