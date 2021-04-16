<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}
 
</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="<?= base_url('rc/trainer/')?>">Manage Trainer</a></li>
    	<li class="breadcrumb-item"><a href="<?= base_url('rc/trainer/periode_adult/'.$periode['periode_id'])?>"><?= $periode['periode_name']?></a></li>
    	<li class="breadcrumb-item active" aria-current="page"><?= $branch['branch_name']?></li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Manage Trainer Class</h3>
	</div>
	<div class="card-body">
		<a class="btn btn-dark" id="add_class"><i class="fa fa-plus"></i>&nbsp; Add Trainer Class</a>
		<hr>

		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Periode</th>
						<th style="vertical-align: middle">Branch</th>
						<th style="vertical-align: middle">Program</th>
						<th style="vertical-align: middle">Class</th>
						<th style="vertical-align: middle">Modul</th>
						<th style="vertical-align: middle">Trainer</th>
						<th style="vertical-align: middle;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($list as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td>".$row['periode_name']."</td>";
						echo "<td>".$row['branch_name']."</td>";
						echo "<td>".$row['program']."</td>";
						echo "<td>".$row['class_name']."</td>";
						echo "<td>".$row['periode_modul']."</td>";
						echo "<td><b>".ucfirst($row['username'])."</b></td>";
						echo "<td><a class='btn btn-danger' onclick='hapus(".$row['trainer_class_id'].")' title='Hapus data' data-toggle='tooltip' data-placement='top'><i class='fa fa-trash'></i></a>";
						
						
						echo "</td></tr>";

					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_trainer" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('rc/trainer/submit_form')?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
				<div class="modal-header" style="background-color:#0d4e6c;color:#fff">
					<h4 class="modal-title" id="modal-title">Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="periode_id" id="periode_id" value="<?= $periode['periode_id']?>">
					<input type="hidden" name="branch_id" id="branch_id" value="<?= $branch['branch_id']?>">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Program</label>
						<div class="col-sm-8">
							<select class="form-control" name="program_id" id="program_id" required="">
								<option value="">- Pilih Salah Satu -</option>
								<?php 
									foreach($program as $row){
										echo "<option value='".$row['id']."'>".ucfirst($row['name'])."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Class</label>
						<div class="col-sm-8">
							<select class="form-control" name="class_id" id="class_id" required="">
								<option value="">- Pilih Salah Satu -</option>
								<?php 
									foreach($class as $row){
										echo "<option value='".$row['class_id']."'>".ucfirst($row['class_name'])."</option>";
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Trainer</label>
						<div class="col-sm-8">
							<select class="form-control" name="trainer_id" id="trainer_id" required="">
								<option value="">- Pilih Salah Satu -</option>
								<?php 
									foreach($trainer as $row){
										echo "<option value='".$row['id']."'>".ucfirst($row['username'])."</option>";
									}
								?>
							</select>
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
		
	});

	function reload_page(){
		window.location.reload();
	}

	function hapus(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Hapus Data Trainer Class, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('rc/trainer/delete')?>",
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

	$('#add_class').click(function(){
		$('#form_data').trigger('reset');
		$('#modal-title').html('Add Trainer Class');
		$('#modal_trainer').modal('show');
	});


</script>
