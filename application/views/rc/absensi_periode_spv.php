<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active" aria-current="page">Absensi</li>
	</ol>
</nav>
<div class="row mb-3">
    <div class="col-md-12">
        <ul class="list-group inline" id="list-tab" role="tablist" style="flex-direction:row;list-style-type:none;">
            <li>
                <a class="list-group-item list-group-item-action <?= ($tab == 'regular')? 'active':'' ?>"
                    href="<?= base_url('rc/absensi')?>" role="tab" aria-controls="data">Regular Class</a>
            </li>
            <li>
                <a class="list-group-item list-group-item-action <?= ($tab == 'adult')? 'active':'' ?>"
                    href="<?= base_url('rc/absensi/adult')?>" role="tab" aria-controls="kode">Adult Class</a>
            </li>
        </ul>
    </div>
</div>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Absensi | <small>Regular</small></h3>
	</div>
	<div class="card-body">
		<h4>Filter Data</h4>
		<form method="get" action="<?= base_url('rc/absensi/index?')?>">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Periode</label>
						<div class="col-sm-8">
							<select class="form-control js-example-basic-single" name="periode" id="periode">
								<option value="all">All</option>
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
						<label class="col-sm-4 col-form-label">Branch</label>
						<div class="col-sm-8">
							<select class="form-control js-example-basic-single" name="branch" id="branch">
								<option value="all">All</option>
								<?php 
								foreach($branch as $row) {
									if(strtolower($row['branch_id']) == strtolower($this->input->get('branch'))){
										echo "<option value='".$row['branch_id']."' selected>".ucfirst($row['branch_name'])."</option>";
									}else{
										echo "<option value='".$row['branch_id']."'>".ucfirst($row['branch_name'])."</option>";
									}
								} 
								?>

							</select>
						</div>
					</div>
				</div>
				<div class="col-md-6">
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
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-2 col-form-label"></label>
				<div class="col-sm-4">
					<button type="submit" class="btn primary-color-dark"><i class="fa fa-search"></i>&nbsp; FILTER</button>
				</div>
			</div>
		</form>
		<div class="table-responsive">
		<?php if(!empty($absen)){?>
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Periode Name</th>
						<th style="vertical-align: middle">Branch</th>
						<th style="vertical-align: middle">School</th>
						<th style="vertical-align: middle">Class</th>
						<th style="vertical-align: middle">Trainer</th>
						<th style="vertical-align: middle" class="text-center">Sesi</th>
						<th style="vertical-align: middle;min-width: 60px;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($absen as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td><label class='badge badge-light'>".$row['periode_name']."</label></td>";
						echo "<td><label class='badge badge-primary'>".$row['branch_name']."</label></td>";
						echo "<td>".$row['program']."</td>";
						echo "<td>".$row['class_name']."</td>";
						echo "<td><label class='badge badge-info'>".ucfirst($row['name'])."</label></td>";
						echo "<td nowrap>";
						for($i = 1; $i <= $row['presence']; $i++){

							$attend = 0;
							$done = false;
							foreach($rekap as $row2){
								if($row2['periode_detail_id'] == $row['periode_detail_id'] && $row2['branch_id'] == $row['branch_id'] && $row2['program_id'] == $row['program_id'] && $row2['class_id'] == $row['class_id'] && $row2['session'] == $i){
									$attend = $row2['total_attendance'];
									$done = true;
								}
							}
							if($attend > 0 || $done){
								echo "<a href='".base_url('rc/absensi/sesi/'.$row['trainer_class_id'].'/'.$i.'?'.$_SERVER['QUERY_STRING'])."' class='btn success-color' title='Hadir : ".$attend." Student' data-toggle='tooltip' data-placement='top'> ".$i."</a>&nbsp;";
							}else{
								echo "<a href='".base_url('rc/absensi/sesi/'.$row['trainer_class_id'].'/'.$i.'?'.$_SERVER['QUERY_STRING'])."' class='btn stylish-color'> ".$i."</a>&nbsp;";
							}
						
						}
						echo "</td>";
						echo "<td style='vertical-align:middle;'><a href='".base_url('rc/absensi/export/'.$row['trainer_class_id'])."' target='_blank' class='btn success-color'><i class='fa fa-file-excel'></i> Export<a></td>";
						echo "</tr>";

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
</script>
