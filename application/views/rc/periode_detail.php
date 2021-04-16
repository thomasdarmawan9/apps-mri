<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>

<div class="card">
	<div class="card-header">
		<h3 class="card-title">Set Modul</h3>
	</div>
	<div class="card-body">
		<form action="<?= base_url('rc/periode/submit_modul')?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
			<div class="modal-body">
				<input type="hidden" name="periode_id" id="periode_id" value="<?= $periode['periode_id']?>">
				<div class="form-group row">
					<label class="col-form-label col-sm-4"><b>Periode Name</b></label>
					<div class="col-sm-8">
						<input name="periode_name" id="periode_name" class="form-control" required="" type="text" placeholder="" autocomplete="off" value="<?= $periode['periode_name']?>" readonly="">
					</div>
				</div> 
				<?php 
					foreach($program as $row){
						foreach($detail as $d){
							if($row['id'] == $d['program_id']){
								echo "	<hr><div class='form-group row'>
											<label class='col-form-label col-sm-4'><b>".$row['name']."</b></label>
											<div class='col-sm-8'>
												<input type='hidden' name='periode_detail_id[]' value='".$d['periode_detail_id']."'>
												<input type='hidden' name='program_id[]' value='".$d['program_id']."'>
												<input name='periode_modul[]'class='form-control' type='text' placeholder='Nama Modul' autocomplete='off' value='".$d['periode_modul']."' required=''>

											</div>
										</div>";
								echo "	<div class='form-group row'>
									<label class='col-form-label col-sm-4'>Jumlah Pertemuan</label>
									<div class='col-sm-8'>
										<input name='presence[]' class='form-control' type='text' placeholder='Jumlah pertemuan' autocomplete='off' value='".$d['presence']."' required=''>

									</div>
								</div>";
										break;
							}
						}			
					}
				?>
				
			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary"">Save</button>
				<a href="<?= base_url('rc/periode')?>"><button type="button" class="btn btn-blue-grey" data-dismiss="modal">Back</button></a>
			</div>
		</form>
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
			'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
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

</script>
