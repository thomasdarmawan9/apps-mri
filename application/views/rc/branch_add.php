<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>

<div class="card">
	<div class="card-header">
		<h3 class="card-title">Add Branch</h3>
	</div>
	<div class="card-body">
		<a class="btn btn-dark" id="add_branch"><i class="fa fa-plus"></i>&nbsp; Add Branch</a>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Branch Name</th>
						<th style="vertical-align: middle">Address</th>
						<th style="vertical-align: middle">Contact</th>
						<th style="vertical-align: middle">Branch Leader</th>
						<th style="vertical-align: middle">Status</th>
						<th style="vertical-align: middle">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($branch as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td><b>".$row['branch_name']."</b></td>";
						echo "<td>".$row['branch_address']."</td>";
						echo "<td>".$row['branch_contact']."</td>";
						echo "<td>".ucfirst($row['name'])."</td>";
						
						if($row['branch_status'] == 1){
							echo "<td><label class='badge badge-success'>Aktif</label></td>";
						}else{
							echo "<td><label class='badge badge-light'>Nonaktif</label></td>";
						}
				
						echo "<td nowrap><a class='btn btn-pink' title='Set Trainer' data-toggle='tooltip' data-placement='top' href='".base_url('rc/branch/trainer/'.$row['branch_id'])."'><i class='fa fa-users'></i></a>&nbsp;
							<a class='btn btn-info' onclick='edit(".$row['branch_id'].")' title='Edit Data' data-toggle='tooltip' data-placement='top'><i class='fa fa-edit'></i></a>&nbsp;
						";
						if($row['branch_status'] == 1){
							echo "<a onclick='nonaktif(".$row['branch_id'].")' class='btn btn-warning' title='Nonaktifkan cabang?' data-toggle='tooltip' data-placement='top'><i class='fa fa-ban'></i></a>";
						}else{
							echo "<a onclick='aktif(".$row['branch_id'].")' class='btn btn-success' title='Aktifkan cabang?' data-toggle='tooltip' data-placement='top'><i class='fa fa-check'></i></a>&nbsp;";
							echo "<a onclick='delete_branch(".$row['branch_id'].")' class='btn btn-danger' title='Hapus data?' data-toggle='tooltip' data-placement='top'><i class='fa fa-trash'></i></a>";
						}
						
						echo "</td></tr>";

					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_branch" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('rc/branch/submit_form')?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
				<div class="modal-header" style="background-color:#0d4e6c;color:#fff">
					<h4 class="modal-title" id="modal-title">Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="branch_id" id="branch_id" value="">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Branch Name</label>
						<div class="col-sm-8">
							<input name="branch_name" id="branch_name" class="form-control" required="" type="text" placeholder="" autocomplete="off" required="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Address</label>
						<div class="col-sm-8">
							<input name="branch_address" id="branch_address" class="form-control" type="text" placeholder="" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Contact</label>
						<div class="col-sm-8">
							<input name="branch_contact" id="branch_contact" class="form-control" type="text" placeholder="" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-sm-4">Branch Leader</label>
						<div class="col-sm-8">
							<select class="form-control" name="branch_lead_trainer" id="branch_lead_trainer" required="">
								<option value="">- Pilih Salah Satu -</option>
								<?php 
									foreach($trainer as $row){
										echo "<option value='".$row['id']."'>".ucfirst($row['name'])."</option>";
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

	function nonaktif(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Nonaktifkan cabang, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('rc/branch/nonaktif')?>",
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

	function delete_branch(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Hapus data cabang, lanjutkan?",
				type: 'error',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('rc/branch/delete')?>",
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
				text: "Aktifkan cabang, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('rc/branch/aktif')?>",
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

	function edit(id){
		$('#form_data').trigger("reset");
		$.ajax({
			url: "<?= base_url('rc/branch/json_get_detail_branch')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				$('#modal-title').html('FORM EDIT');
				$('#branch_id').val(result.branch_id);
				$('#branch_name').val(result.branch_name);
				$('#branch_address').val(result.branch_address);
				$('#branch_contact').val(result.branch_contact);
				$('#branch_lead_trainer').val(result.branch_lead_trainer).change();
				$('#modal_branch').modal('show');
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
	
	$('#add_branch').click(function(){
		$('#form_data').trigger('reset');
		$('#branch_id').val('');
		$('#modal-title').html('FORM ADD');
		$('#modal_branch').modal('show');
	});

</script>
