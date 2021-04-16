<style type="text/css">
	.border-left-div{
		border-left: 2px solid #333;
    	/*margin-left: 2px;*/
	}
	
</style>

<div class="card">
	<div class="card-header">
		<h3 class="card-title">Confirm Pembayaran DP</h3>
	</div>
	<div class="card-body">
		<form method="get" action="<?= base_url('finance/signup/confirm_repayment')?>">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Program</label>
				<div class="col-sm-4">
					<select class="form-control js-example-basic-single" name="event" width="100%">
						<option value="">All</option>
						<?php 
						foreach($event as $row) {
							if($row['id'] == $filter['event']){
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
				<label class="col-sm-2 col-form-label"></label>
				<div class="col-sm-4">
					<button type="submit" class="btn  btn-info"><i class="fa fa-search"></i>&nbsp; FILTER</button>
				</div>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th class="text-center" style="vertical-align: middle;">ID</th>
						<th style="vertical-align: middle">Paid Date</th>
						<th style="vertical-align: middle">Paid</th>
						<th style="vertical-align: middle">Payment Type</th>
						<th style="vertical-align: middle">Program</th>
						<th style="vertical-align: middle">Total DP</th>
						<th style="vertical-align: middle">Participant</th>
						<th style="vertical-align: middle">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
						$no = 1;
						foreach($waiting as $row){
							echo "<tr style='font-size:0.9rem;'>";
							echo "<td class='text-center'>".$no++."</td>";
							echo "<td>".$row['transaction_id']."</td>";
							echo "<td>".$row['paid_date']."</td>";
							if(!empty($row['is_repayment_paid_off']) == 1){
								echo "<td>".number_format($row['paid_value'])."<br><label class='badge badge-success'>Lunas</label></td>";
							}else{
								echo "<td>".number_format($row['paid_value'])."</td>";
							}
							if(!empty($row['transfer_atas_nama'])){
								echo "<td>".$row['payment_type']."<br><label class='badge badge-danger'>".$row['transfer_atas_nama']."</label></td>";
							}else{
								echo "<td>".$row['payment_type']."</td>";
							}
							echo "<td>".$row['event_name']."</td>";
							echo "<td>".number_format($row['dp'])."</td>";
							echo "<td>".ucwords($row['participant_name'])."</td>";
							echo "<td>
								<button type='button' class='btn btn-blue-grey detail' data-remark='".$row['remark']."' data-toggle='tooltip' data-placement='top'><i class='fa fa-info'></i></button>
								<a onclick='confirm(".$row['repayment_id'].")' class='btn teal' title='Confirm data?'><i class='fa fa-check'></i> Approve</a>
								<a onclick='reject(".$row['repayment_id'].")' class='btn btn-danger' title='Reject data?'><i class='fa fa-times'></i> Reject</a>
							</td>";
							echo "</tr>";

						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?= base_url(); ?>inc/select2/select2.min.css"/>
<script type="text/javascript" src="<?= base_url();?>inc/select2/select2.min.js"></script>
<script>
	$(document).ready(function(){
		$('.js-example-basic-single').select2();
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
		
	});

	$('.detail').click(function(){
		var data = $(this).data('remark');
		alert(data);
	});


	function reload_page(){
		window.location.reload();
	}

	function confirm(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Data pembayaran akan diapprove dan status transaksi akan diupdate, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#009688',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('finance/signup/approve_repayment')?>",
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

	function reject(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Data pembayaran akan direject, lanjutkan?",
				type: 'error',
				showCancelButton: true,
				confirmButtonColor: '#ff3547',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('finance/signup/reject_repayment')?>",
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
</script>
