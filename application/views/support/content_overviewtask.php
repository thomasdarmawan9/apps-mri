<style type="text/css">
	.jumlah{
		font-size:18pt;
	}
</style>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Overview Task Allocation</h3>
	</div>
	<div class="card-body">
		<div class="alert alert-info">
			<small><b>Jumlah Event (Default)</b> : Jumlah nominal event yang seharusnya bernilai sama dengan warriors lain. (Terkecuali yg tdk mendapatkan task : Driver atau OB dll)</small><br>
			<small><b>Jumlah Event Bayar</b> : Jumlah Event yang ditambahkan untuk mengurangi hutang event</small><br>
			<small><b>Hutang Bayar</b> : Nilai ketidak hadiran dari Event (Default) & Event (Bayar) yang dikalikan 2</small>
		</div>
		<hr>
		<div class="table-responsive">
		<table class="table table-striped table-bordered w-100" id="table1">
			<thead class="text-center">
				<tr style="background-color: #0d4e6c;font-size:1rem;color:#fff;">
					<th class="text-center">No</th>
					<th>Nama</th>
					<th class="text-center">Jmh. Event</th>
					<th class="text-center">Jmh. Event Bayar</th>
					<th class="text-center">Hutang Event</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?php $i=0; for($i;$baris > $i;$i++){ ?>
				<tr>
					<td class="text-center"><?php echo $i+1; ?></td>
					<td><b><?php echo ucfirst($hasil[$i][0]); ?></b></td>
					<td class="text-center jumlah"><label class="badge badge-info"><?php echo $hasil[$i][1]; ?></label></td>
					<td class="text-center jumlah"><label class="badge badge-success"><?php echo $hasil[$i][2]; ?></label></td>
					<td class="text-center jumlah">
						<?php 
							if(($hasil[$i][3] * 2) <> 0){
							 	$diff = ($hasil[$i][3] * 2) - $hasil[$i][2]; 
							 	if($diff < 0){
							 		echo "<label class='badge badge-success'>".$diff."</label>";
							 	}else if($diff > 0){
							 		echo "<label class='badge badge-danger'>".$diff."</label>";
							 	}else{
							 		echo "<label class='badge badge-light'>".$diff."</label>";
							 	}
							} ?>
							
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

	</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
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
	})
</script>

