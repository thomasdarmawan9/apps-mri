<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="<?= base_url('rc/absensi/')?>">Absensi</a></li>
    	<li class="breadcrumb-item active" aria-current="page"><?= $periode['periode_name']?></li>
    	<li class="breadcrumb-item active"><?= $branch['branch_name']?></li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Pilih Kelas</h3>
	</div>
	<div class="card-body">
		<hr>

		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Program</th>
						<th style="vertical-align: middle">Modul</th>
						<th style="vertical-align: middle">Kelas</th>
						<th style="vertical-align: middle;" class="text-center">Sesi</th>
						<th style="vertical-align: middle;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($class as $row){
						echo "<tr>";
						echo "<td style='vertical-align:middle;' class='text-center'>".$no++."</td>";
						echo "<td style='vertical-align:middle;'>".$row['program']."</td>";
						echo "<td style='vertical-align:middle;'>".$row['periode_modul']."</td>";
						echo "<td style='vertical-align:middle;'>".$row['class_name']."</td>";
						echo "<td style='vertical-align:middle;' class='text-center' nowrap>";

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
								echo "<a href='".base_url('rc/absensi/sesi/'.$row['trainer_class_id'].'/'.$i)."' class='btn success-color' title='Hadir : ".$attend." Student' data-toggle='tooltip' data-placement='top'> ".$i."</a>&nbsp;";
							}else{
								echo "<a href='".base_url('rc/absensi/sesi/'.$row['trainer_class_id'].'/'.$i)."' class='btn stylish-color'> ".$i."</a>&nbsp;";
							}
						}
						echo "</td>";
						echo "<td style='vertical-align:middle;'><a href='".base_url('rc/absensi/export/'.$row['trainer_class_id'])."' target='_blank' class='btn success-color'><i class='fa fa-file-excel'></i> Export<a></td>";
						echo "</tr>";

					}
					?>
				</tbody>
			</table>
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
