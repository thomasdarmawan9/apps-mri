<style type="text/css">
	.custom-control-label::before{
		margin-left:20px;
	}
	.custom-control-label::after{
		margin-left:20px;
	}
</style>
<div class="card">
	<div class="card-header">
		<a href="<?= base_url('rc/branch')?>" class="text-gray"><i class="fa fa-caret-left"></i> Back</a><h3 class="card-title">Set Trainer - <b><?= $branch['branch_name']?></b></h3>
	</div>
	<div class="card-body">
		<a class="btn btn-elegant" id="showtambah"><i class="fa fa-user-plus"></i>&nbsp; Add Trainer</a>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Branch</th>
						<th style="vertical-align: middle">Trainer</th>
						<th style="vertical-align: middle">Action</th>
					</tr>
				</thead class="text-center">
				<tbody>
					<?php 
						$no = 1;
						foreach($list as $row){
							echo "<tr style='font-size:0.9rem;'>";
							echo "<td class='text-center'>".$no++."</td>";
							echo "<td>".$row['branch_name']."</td>";
							if($row['id'] == $row['branch_lead_trainer']){
								echo "<td>".ucfirst($row['username'])."<br><label class='badge badge-info'>Brach Leader</label></td>";
							}else{
								echo "<td>".ucfirst($row['username'])."</td>";
							}
							echo "<td>
									<a onclick='remove(".$row['id'].")' class='btn btn-danger' title='Hapus Trainer dari Cabang ini?' data-toggle='tooltip' data-placement='top'>
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
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('rc/branch/add_trainer')?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
				<div class="modal-header" style="background-color:#0d4e6c;color:#fff">
					<h4 class="modal-title" id="myModalLabel">Add Trainer</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="branch_id" id="branch_id" value="<?= $branch['branch_id']?>">
					<div class="table-responsive">
						<table class="table table-bordered table-hover w-100" id="table2">
							<!-- <thead>
								<tr style="background-color: #0d4e6c ;color:#fff;">
									<th class="text-center" style="vertical-align: middle;"></th>
								</tr>
							</thead> -->
							<tbody>
								<?php 
									$no = 1;
									foreach($trainer as $row){
										echo "<tr>";
										echo "	<td style='padding:0.4rem;'>
													<div class='pl-5 custom-control custom-checkbox my-1 mr-sm-2'>
											    		<input type='checkbox' class='custom-control-input' name='trainer[]' value='".$row['id']."' id='trainer".$row['id']."'>
											   			<label class='custom-control-label w-100' for='trainer".$row['id']."'>".ucfirst($row['username'])."</label>
													</div>
												</td>";
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
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
		});


	});

	function reload_page(){
		window.location.reload();
	}


	function remove(id){
		$.ajax({
			url: "<?= base_url('rc/branch/json_remove_trainer')?>",
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
