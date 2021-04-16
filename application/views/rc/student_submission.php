<style type="text/css">
.border-left-div{
	border-left: 2px solid #333;
}

</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item active" aria-current="page">Submission</li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Pengajuan Pindah Kelas</h3>
	</div>
	<div class="card-body">
		<a class="btn btn-primary" href="<?= base_url('rc/student/submission_add')?>"><i class="fa fa-plus"></i>&nbsp; Add Data | <b>Regular</b></a>
		<a class="btn btn-info" href="<?= base_url('rc/student/submission_adult_add')?>"><i class="fa fa-plus"></i>&nbsp; Add Data | <b>Adult</b></a>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Student</th>
						<th style="vertical-align: middle">Periode</th>
						<th style="vertical-align: middle">From</th>
						<th style="vertical-align: middle">To</th>
						<th style="vertical-align: middle">Input by</th>
						<th style="vertical-align: middle">Timestamp</th>
						<th style="vertical-align: middle">Status</th>
						<th style="vertical-align: middle;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($list as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td>".$row['participant_name']."</td>";
						echo "<td>".$row['periode_name']."</td>";
						echo "<td><label class='badge badge-info'>".$row['branch_from_name']."</label><br><label class='badge badge-light'>".$row['program_from_name']."</label><br><label class='badge badge-light'>".$row['class_from_name']."</label></td>";
						echo "<td><label class='badge badge-info'>".$row['branch_to_name']."</label><br><label class='badge badge-light'>".$row['program_to_name']."</label><br><label class='badge badge-light'>".$row['class_to_name']."</label></td>";
						echo "<td>".ucfirst($row['input'])."<br></td>";
						echo "<td><label class='badge badge-light'>".$row['timestamp']."</label></td>";
						if($row['change_status'] == 'waiting'){
							echo "<td><label class='badge badge-light'>Waiting</label></td>";
						}else if($row['change_status'] == 'approved'){
							echo "<td><label class='badge badge-success'>Approved</label></td>";
						}else{
							echo "<td><label class='badge badge-danger'>Rejected</label></td>";
						}
				
						echo "<td class='text-center'>";
						if($row['change_status'] == 'waiting'){
							echo "<a onclick='delete_submission(".$row['change_id'].")' class='btn btn-danger' title='Hapus pengajuan?' data-toggle='tooltip' data-placement='top'><i class='fa fa-trash'></i></a>";
						}
						echo "</td></tr>";

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

	function delete_submission(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Hapus data pengajuan, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('rc/student/delete_submission')?>",
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


	$('.numeric').keyup(function(e){
		if (/\D/g.test(this.value)){
			this.value = this.value.replace(/\D/g, '');
		}
	});


</script>
