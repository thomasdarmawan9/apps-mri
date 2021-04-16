<style type="text/css">
	.border-left-div{
		border-left: 2px solid #333;
    	/*margin-left: 2px;*/
	}
	
</style>

<div class="card">
	<div class="card-header">
		<h3 class="card-title">Confirm Signup</h3>
	</div>
	<div class="card-body">
		<form method="get" action="<?= base_url('finance/signup/confirm')?>">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Program</label>
				<div class="col-sm-4">
					<select class="form-control js-example-basic-single" name="event">
						<option value="">All</option>
						<?php 
						foreach($event as $row) {
							if(strtolower($row['name']) == strtolower($filter['event_name'])){
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
				<label class="col-sm-2 col-form-label">SP</label>
				<div class="col-sm-4">
					<select class="form-control js-example-basic-single" name="sp">
						<option value="">All</option>
						<?php 
						foreach($list_task as $row) {
							if($row['id'] == $filter['id_task']){
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
					<button type="submit" class="btn  btn-info"><i class="fa fa-search"></i>&nbsp; FILTER</button>
				</div>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Paid Date</th>
						<th style="vertical-align: middle">Paid</th>
						<th style="vertical-align: middle">Payment</th>
						<th style="vertical-align: middle">Type</th>
						<th style="vertical-align: middle">Program</th>
						<th style="vertical-align: middle">Participant</th>
						<th style="vertical-align: middle;min-width: 100px;text-align: center;">SP</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
						$no = 1;
						foreach($waiting as $row){
							echo "<tr style='font-size:0.9rem;'>";
							echo "<td class='text-center'>".$no++."</td>";
							echo "<td>".$row['paid_date']."</td>";
							echo "<td>".number_format($row['paid_value'])."</td>";
							if(!empty($row['transfer_atas_nama'])){
								echo "<td>".$row['payment_type']."<br><label class='badge badge-default'>".$row['transfer_atas_nama']."</label></td>";
							}else{
								echo "<td>".$row['payment_type']."</td>";
							}
							if($row['closing_type'] == "Lunas" || $row['closing_type'] == "Full Program"){
								echo "<td class='text-center'><label class='badge badge-success'>".ucfirst($row['closing_type'])."</label></td>";
							}else{
								echo "<td class='text-center'><label class='badge badge-light'>".ucfirst($row['closing_type'])."</label></td>";		
							}
							echo "<td>".$row['event_name']."</td>";
							echo "<td>".ucwords($row['participant_name'])."</td>";
							echo "<td class='text-center'><label class='badge badge-light' style='white-space:normal;'>".($row['task'])."</label></td>";
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



	function reload_page(){
		window.location.reload();
	}

	function confirm(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Data akan diapprove, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#009688',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('finance/signup/approve')?>",
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
				text: "Data akan direject, lanjutkan?",
				type: 'error',
				showCancelButton: true,
				confirmButtonColor: '#ff3547',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('finance/signup/reject')?>",
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
