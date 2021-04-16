
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Detail Batch </h3>
	</div>
	<div class="card-body">
		<div class="alert alert-info">
			<h5>Program &emsp;: <b><?= $detail['event_name']?></b><br>Batch&emsp;: <b><?= $detail['batch_label']?></b></h5>
		</div>
		<a class="btn btn-primary" id="showtambah"><i class="fa fa-user-plus"></i>&nbsp; Tambah Peserta</a>
		<a class="btn btn-success" href="<?= base_url('finance/signup/export_batch/'.$detail['batch_id'])?>"><i class="fa fa-file-excel"></i>&nbsp; Export to Excel</a>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th class="text-center" style="vertical-align: middle;">ID</th>
						<th style="vertical-align: middle">Program</th>
						<th style="vertical-align: middle">Participant</th>
						<th style="vertical-align: middle">Paid</th>
						<th style="vertical-align: middle">Paid Date</th>
						<th style="vertical-align: middle">Payment Type</th>
						<th style="vertical-align: middle">Closing Type</th>
						<th style="vertical-align: middle">Branch</th>
						<th style="vertical-align: middle">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
						$no = 1;
						foreach($peserta as $row){
							echo "<tr style='font-size:0.9rem;'>";
							echo "<td class='text-center'>".$no++."</td>";
							echo "<td>".$row['transaction_id']."</td>";
							echo "<td>".$row['event_name']."</td>";
							if($row['is_reattendance'] == 1){
								echo "<td>".ucwords($row['participant_name'])."<br><label class='badge badge-danger'>Re-Attendance</label></td>";
							}else{
								echo "<td>".ucwords($row['participant_name'])."</td>";
							}
							echo "<td>".number_format($row['paid_value'])."</td>";
							echo "<td>".$row['paid_date']."</td>";
							echo "<td>" . $row['payment_type'] . "</td>";
						    echo "<td>" . $row['closing_type'] . "</td>";
						    echo "<td>" . $row['branch_name'] . "</td>";
														
							echo "<td>
									<a onclick='remove(".$row['transaction_id'].")' class='btn btn-danger' title='Hapus data peserta dari Batch ini?' data-toggle='tooltip' data-placement='top'>
										<i class='fa fa-trash'></i>
									</a>
								</td>";
							echo "</tr>";

						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_tambah" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?= base_url('finance/signup/add_to_batch')?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Tambah Peserta</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="batch_id" id="batch_id" value="<?= $detail['batch_id']?>">
					<div class="table-responsive">
						<table class="table table-bordered w-100" id="table2">
							<thead>
								<tr style="background-color: #0d4e6c ;color:#fff;">
									<th class="text-center" style="vertical-align: middle;">Peserta</th>
									<th style="vertical-align: middle">ID</th>
									<th>Program</th>
									<th style="vertical-align: middle">Paid Date</th>
									<th style="vertical-align: middle">Payment</th>
									<th style="vertical-align: middle">Type</th>
									<th style="vertical-align: middle">Closing Type</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$no = 1;
									foreach($signup as $row){
										echo "<tr>";
										echo "	<td>
													<div class='custom-control custom-checkbox my-1 mr-sm-2'>
											    		<input type='checkbox' class='custom-control-input' name='transaction_id[]' value='".$row['transaction_id']."' id='peserta".$row['transaction_id']."'>
											   			<label class='custom-control-label' for='peserta".$row['transaction_id']."'>".ucwords($row['participant_name'])."</label>
													</div>
												</td>";
										echo "<td>".$row['transaction_id']."</td>";	
										echo "<td>".$row['event_name']."</td>";		
									    echo "<td>" . $row['paid_date'] . "</td>";
    									echo "<td> RP." . number_format($row['paid_value']) . "</td>";
    									echo "<td>" . $row['payment_type'] . "</td>";
    									echo "<td>" . $row['closing_type'] . "</td>";
										echo "</tr>";

									}
								?>
							</tbody>
						</table>
					</div>
					
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"">Submit</button>
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

	  	$('[data-toggle="tooltip"]').tooltip()
		
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});

		$('#table1').DataTable({
			'scrollX':true,
			'lengthMenu': [[10, 15, 25, -1], [10, 15, 25, "All"]
			],
			 'rowReorder': {
                'selector': 'td:nth-child(2)',
                'stateSave': true
              },
              'responsive': true
		});

		$('#table2').DataTable({
			'order': false,
			'lengthMenu': [[10, 15, 25, -1], [10, 15, 25, "All"]]
		});

		$(".datepicker").datepicker({
			changeYear:true,
			changeMonth:true,
			dateFormat : 'yy-mm-dd',
		});
	});

	function reload_page(){
		window.location.reload();
	}


	function remove(id){
		$.ajax({
			url: "<?= base_url('finance/signup/json_remove_participant')?>",
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
	
	$('#showtambah').click(function(){
		$('#modal_tambah').modal('show');
	});


</script>
