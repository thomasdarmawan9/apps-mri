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
		<h3 class="card-title">Pilih Periode | <small>Regular</small></h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center" style="vertical-align: middle;">No</th>
						<th style="vertical-align: middle">Branch</th>
						<th style="vertical-align: middle">Periode Name</th>
						<th style="vertical-align: middle">Start Date</th>
						<th style="vertical-align: middle">End Date</th>
						<th style="vertical-align: middle;min-width: 60px;">Action</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php 
					$no = 1;
					foreach($periode as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td><b>".$row['branch_name']."</b></td>";
						echo "<td><b>".$row['periode_name']."</b></td>";
						echo "<td>".$row['periode_start_date']."</td>";
						echo "<td>".$row['periode_end_date']."</td>";
			
						echo "<td>";
						echo "<a class='btn btn-dark' href='".base_url('rc/absensi/periode/'.$row['periode_id'])."/".$row['branch_id']."' title='Pilih' data-toggle='tooltip' data-placement='top'><i class='fa fa-play'></i> Pilih</a>";
						
						
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
