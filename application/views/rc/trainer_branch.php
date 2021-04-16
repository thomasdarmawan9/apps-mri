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
    	<li class="breadcrumb-item active" aria-current="page"><?= $periode['periode_name']?></li>
  	</ol>
</nav>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Pilih Branch</h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Branch Name</th>
						<th style="vertical-align: middle">Branch Leader</th>
						<th style="vertical-align: middle;min-width: 60px;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($branch as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td><b>".$row['branch_name']."</b></td>";
						echo "<td>".ucfirst($row['username'])."</td>";
			
						echo "<td><a class='btn btn-dark' href='".base_url('rc/trainer/branch/'.$periode['periode_id'].'/'.$row['branch_id'])."' title='Pilih' data-toggle='tooltip' data-placement='top'><i class='fa fa-play'></i> Pilih</a>";
						
						
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


</script>
