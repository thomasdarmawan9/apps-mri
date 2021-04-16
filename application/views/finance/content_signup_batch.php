
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Set Signup Batch </h3>
	</div>
	<div class="card-body">
		<a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Tambah Batch</a>
		<h4>FILTER DATA</h4>
		<br>
		<form method="post" action="<?= base_url('finance/signup/batch')?>">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Program</label>
				<div class="col-sm-4">
					<select class="form-control" name="event">
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
				<label class="col-sm-2 col-form-label"></label>
				<div class="col-sm-4">
					<button type="submit" class="btn  btn-info"><i class="fa fa-search"></i>&nbsp; FILTER</button>
				</div>
			</div>
		</form>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center">No</th>
						<th>Program</th>
						<th>Batch</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
						$no = 1;
						foreach($list as $row){
							echo "<tr>";
							echo "<td class='text-center'>".$no++."</td>";
							echo "<td>".$row['event_name']."</td>";
							echo "<td>".$row['batch_label']."</td>";
							echo "<td>".date('Y-m-d', strtotime($row['event_date']))."</td>";
							echo "<td>
									<a class='btn btn-info' onclick='edit(".$row['batch_id'].")' title='Edit Data' data-toggle='tooltip' data-placement='top'><i class='fa fa-edit'></i></a>
									<a class='btn btn-primary' href='".base_url('finance/signup/batch_detail/'.$row['batch_id'])."' title='Manajemen Peserta' data-toggle='tooltip' data-placement='top'><i class='fa fa-list'></i></a>
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
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('finance/signup/submit_form')?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="batch_id" id="batch_id" value="">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Pilih Program</label>
						<div class="col-sm-8">
							<select class="form-control" name="event_name" id="event_name" required="">
								<option value="">- Pilih Salah Satu -</option>
								<?php 
									foreach($event as $row){
										echo "<option value='".$row['name']."' data-kids='".$row['is_program_kids']."'>".$row['name']."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Nama Batch</label>
						<div class="col-sm-8">
							<input name="batch_label" id="batch_label" class="form-control" required="" type="text" placeholder="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Tanggal</label>
						<div class="col-sm-8">
							<input name="event_date" id="event_date" class="form-control datepicker" required="" type="text" placeholder="">
						</div>
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
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
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


	function edit(id){
		$('#form_data').trigger("reset");
		$.ajax({
			url: "<?= base_url('finance/signup/json_get_batch_detail')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				$('#batch_id').val(result.batch_id);
				$('#event_name').val(result.event_name).change();
				$('#batch_label').val(result.batch_label);
				$('#event_date').val(result.event_date);
				$('#modal_tambah').modal('show');
			}, error: function(e){
				console.log(e);
			}
		})
	}
	
	$('#showtambah').click(function(){
		$('#form_data').trigger("reset");
		$('#modal_tambah').modal('show');
	});


</script>
