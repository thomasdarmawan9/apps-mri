<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?= base_url('rc/student/submission')?>">Submission</a></li>
		<li class="breadcrumb-item active" aria-current="page">Add - Regular</li>
	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Tambah Data Pengajuan Pindah Kelas</h3>
	</div>
	<div class="card-body">
		<h4>Filter Data | Regular</h4>
		<form method="get" action="<?= base_url('rc/student/submission_add?')?>">
			<input type="hidden" name="branch" id="branch" value="<?= $branch['branch_id']?>">
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Branch</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" value="<?= $branch['branch_name']?>" readonly>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Periode</label>
				<div class="col-sm-8">
					<select class="form-control js-example-basic-single" name="periode" id="periode" required="">
						<option value="">- Pilih Periode -</option>
						<?php 
						foreach($periode as $row) {
							if(strtolower($row['periode_id']) == strtolower($this->input->get('periode'))){
								echo "<option value='".$row['periode_id']."' selected>".ucfirst($row['periode_name'])."</option>";
							}else{
								echo "<option value='".$row['periode_id']."'>".ucfirst($row['periode_name'])."</option>";
							}
						} 
						?>

					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">School</label>
				<div class="col-sm-8">
					<select class="form-control js-example-basic-single" name="school" id="school">
						<option value="all">All</option>
						<?php 
						foreach($school as $row) {
							if(strtolower($row['id']) == strtolower($this->input->get('school'))){
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
				<label class="col-sm-4 col-form-label">Class</label>
				<div class="col-sm-8">
					<select class="form-control js-example-basic-single" name="class" id="class">
						<option value="all">All</option>
						<?php 
						foreach($class as $row) {
							if(strtolower($row['class_id']) == strtolower($this->input->get('class'))){
								echo "<option value='".$row['class_id']."' selected>".ucfirst($row['class_name'])."</option>";
							}else{
								echo "<option value='".$row['class_id']."'>".ucfirst($row['class_name'])."</option>";
							}
						} 
						?>

					</select>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-4 col-form-label"></label>
				<div class="col-sm-8">
					<button type="submit" class="btn primary-color-dark"><i class="fa fa-search"></i>&nbsp; FILTER</button>
				</div>
			</div>
		</form>
		<div class="table-responsive">
			<?php if(!empty($list)){?>
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Student</th>
						<th style="vertical-align: middle">Type</th>
						<th style="vertical-align: middle">Branch</th>
						<th style="vertical-align: middle">School</th>
						<th style="vertical-align: middle">Class</th>
						<th style="vertical-align: middle;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($list as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td><b>".$row['participant_name']."</b></td>";
						echo "<td>".ucwords($row['program_type'])."</td>";
						echo "<td>".$row['branch_name']."</td>";
						echo "<td>".$row['program']."</td>";
						echo "<td>".$row['class_name']."</td>";
						
						echo "<td class='text-center'>
						<a class='btn btn-info' onclick='add(".$row['student_id'].")' title='Pindah Kelas?' data-toggle='tooltip' data-placement='top'><i class='fa fa-plus'></i></a>&nbsp;
						";
						
						
						echo "</td></tr>";

					}
					?>
				</tbody>
			</table>
		<?php }else{
			echo "<div class='col-md-12 text-center'><hr><label class='text-red'>Not found</label></div>";
		}?>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_branch" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('rc/student/submission_submit')?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
				<div class="modal-header" style="background-color:#0d4e6c;color:#fff">
					<h4 class="modal-title" id="modal-title">Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="student_id" id="student_id" value="">
					<input type="hidden" name="periode_id" id="periode_id" value="">
					<input type="hidden" name="branch_from" id="branch_from" value="">
					<input type="hidden" name="program_from" id="program_from" value="">
					<input type="hidden" name="class_from" id="class_from" value="">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Student</label>
						<div class="col-sm-8">
							<input name="student_name" id="student_name" class="form-control" type="text" readonly="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Branch</label>
						<div class="col-sm-8">
							<select class="form-control js-example-basic-single" name="branch_to" id="branch_to" required="">
								<option value="">- Pilih Cabang -</option>
								<?php 
								foreach($list_branch as $row) {
									echo "<option value='".$row['branch_id']."'>".ucfirst($row['branch_name'])."</option>";
								} 
								?>

							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">School</label>
						<div class="col-sm-8">
							<select class="form-control js-example-basic-single" name="program_to" id="program_to" required="">
								<option value="">- Pilih Program -</option>
								<?php 
								foreach($school as $row) {
									echo "<option value='".$row['id']."'>".ucfirst($row['name'])."</option>";
								} 
								?>

							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Class</label>
						<div class="col-sm-8">
							<select class="form-control js-example-basic-single" name="class_to" id="class_to" required="">
								<option value="">- Pilih Kelas -</option>
								<?php 
								foreach($class as $row) {
									echo "<option value='".$row['class_id']."'>".ucfirst($row['class_name'])."</option>";
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

	function add(id){
		$('#form_data').trigger("reset");
		$.ajax({
			url: "<?= base_url('rc/student/json_get_detail_student')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				$('#modal-title').html('FORM PENGAJUAN PINDAH KELAS');
				$('#student_id').val(id);
				$('#periode_id').val($('#periode').val());
				$('#student_name').val(result.participant_name);
				$('#branch_from').val(result.branch_id);
				$('#program_from').val(result.program_id);
				$('#class_from').val(result.class_id);
				$('#branch_to').val(result.branch_id).change();
				$('#program_to').val(result.program_id).change();
				$('#class_to').val(result.class_id).change();
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
	

</script>
