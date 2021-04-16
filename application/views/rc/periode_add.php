<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>

<div class="card">
	<div class="card-header">
		<h3 class="card-title">Add Periode Regular Class</h3>
	</div>
	<div class="card-body">
		<a class="btn btn-dark" id="add_periode"><i class="fa fa-plus"></i>&nbsp; Add Periode</a> 
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Periode Name</th>
						<th style="vertical-align: middle">Start Date</th>
						<th style="vertical-align: middle">End Date</th>
						<th style="vertical-align: middle">Status</th>
						<th style="vertical-align: middle;min-width: 120px;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($periode as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td><b>".$row['periode_name']."</b></td>";
						echo "<td>".$row['periode_start_date']."</td>";
						echo "<td>".$row['periode_end_date']."</td>";
						 
						if($row['periode_status'] == 1){
							echo "<td><label class='badge badge-success'>Aktif</label></td>";
						}else{
							echo "<td><label class='badge badge-light'>Nonaktif</label></td>";
						}
				
						echo "<td nowrap><a class='btn btn-pink' href='".base_url('rc/periode/modul/'.$row['periode_id'])."' title='Set Modul' data-toggle='tooltip' data-placement='top'><i class='fa fa-book'></i></a>&nbsp;<a class='btn btn-info' onclick='edit(".$row['periode_id'].", 0)' title='Edit' data-toggle='tooltip' data-placement='top'><i class='fa fa-edit'></i></a>&nbsp;";
						if($row['periode_status'] == 1){
							echo "<a onclick='nonaktif(".$row['periode_id'].")' class='btn btn-danger' title='Nonaktifkan periode?' data-toggle='tooltip' data-placement='top'><i class='fa fa-ban'></i></a>";
						}else{
							echo "<a onclick='aktif(".$row['periode_id'].")' class='btn btn-success' title='Aktifkan periode?' data-toggle='tooltip' data-placement='top'><i class='fa fa-check'></i></a>";
						}
						
						echo "</td></tr>";

					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card mt-3">
	<div class="card-header">
		<h3 class="card-title">Add Periode Adult Class</h3>
	</div>
	<div class="card-body">
		<a class="btn btn-dark" id="add_periode_adult"><i class="fa fa-plus"></i>&nbsp; Add Adult Periode</a>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Periode Name</th>
						<th style="vertical-align: middle">Start Date</th>
						<th style="vertical-align: middle">End Date</th>
						<th style="vertical-align: middle">Status</th>
						<th style="vertical-align: middle;min-width: 120px;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($periode_adult as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td><b>".$row['periode_name']."</b></td>";
						echo "<td>".$row['periode_start_date']."</td>";
						echo "<td>".$row['periode_end_date']."</td>";
						
						if($row['periode_status'] == 1){
							echo "<td><label class='badge badge-success'>Aktif</label></td>";
						}else{
							echo "<td><label class='badge badge-light'>Nonaktif</label></td>";
						}
				
						echo "<td nowrap><a class='btn btn-pink' href='".base_url('rc/periode/modul/'.$row['periode_id'])."' title='Set Modul' data-toggle='tooltip' data-placement='top'><i class='fa fa-book'></i></a>&nbsp;<a class='btn btn-info' onclick='edit(".$row['periode_id'].", 1)' title='Edit' data-toggle='tooltip' data-placement='top'><i class='fa fa-edit'></i></a>&nbsp;";
						if($row['periode_status'] == 1){
							echo "<a onclick='nonaktif(".$row['periode_id'].")' class='btn btn-danger' title='Nonaktifkan periode?' data-toggle='tooltip' data-placement='top'><i class='fa fa-ban'></i></a>";
						}else{
							echo "<a onclick='aktif(".$row['periode_id'].")' class='btn btn-success' title='Aktifkan periode?' data-toggle='tooltip' data-placement='top'><i class='fa fa-check'></i></a>";
						}
						
						echo "</td></tr>";

					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_periode" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('rc/periode/submit_form')?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
				<div class="modal-header" style="background-color:#0d4e6c;color:#fff">
					<h4 class="modal-title" id="modal-title">Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="periode_id" id="periode_id" value="">
					<input type="hidden" name="is_adult_class" id="is_adult_class" value="">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Periode Name</label>
						<div class="col-sm-8">
							<input name="periode_name" id="periode_name" class="form-control" required="" type="text" placeholder="" autocomplete="off" required="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Start Date</label>
						<div class="col-sm-8">
							<input name="periode_start_date" id="periode_start_date" class="form-control datepicker" type="text" placeholder="" autocomplete="off" required="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">End Date</label>
						<div class="col-sm-8">
							<input name="periode_end_date" id="periode_end_date" class="form-control datepicker" type="text" placeholder="" autocomplete="off" required="">
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
		$(".datepicker").datepicker({
			changeYear:true,
			changeMonth:true,
			dateFormat : 'yy-mm-dd',
		});
	});

	function reload_page(){
		window.location.reload();
	}

	function nonaktif(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Nonaktifkan periode, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('rc/periode/nonaktif')?>",
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

	function aktif(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Aktifkan periode, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('rc/periode/aktif')?>",
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

	function edit(id, adult){
		$('#form_data').trigger("reset");
		$.ajax({
			url: "<?= base_url('rc/periode/json_get_detail_periode')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				$('#modal-title').html('FORM EDIT');
				$('#is_adult_periode').val(result.is_adult_periode);
				$('#periode_id').val(result.periode_id);
				$('#periode_name').val(result.periode_name);
				$('#periode_start_date').val(result.periode_start_date);
				$('#periode_end_date').val(result.periode_end_date);
				if(adult == 1){
					$('#is_adult_class').val(1);
				}else{
					$('#is_adult_class').val(0);
				}
				$('#modal_periode').modal('show');
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
	
	$('#add_periode').click(function(){
		$('#form_data').trigger('reset');
		$('#is_adult_class').val(0);
		$('#modal-title').html('FORM ADD');
		$('#modal_periode').modal('show');
	});

	$('#add_periode_adult').click(function(){
		$('#form_data').trigger('reset');
		$('#is_adult_class').val(1);
		$('#modal-title').html('FORM ADD');
		$('#modal_periode').modal('show');
	});

</script>
