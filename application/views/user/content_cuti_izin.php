	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Laporan Cuti Izin</h3>
		</div>
		<div class="card-body">

			<?php if(!empty($cekname)){?>
			<h4>Nama : <b><?php echo ucwords($cekname); ?></b></h4>
			<?php } ?>
			<hr>
			<div class="table-responsive">
				<table class="table table-bordered" id="table1">
					<thead>
						<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
							<th>Tanggal</th>
							<th>Plus</th>
							<th>Minus</th>
							<th>Balance</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($results) or (!empty($cutisblm))){ ?>
						<tr style="background: #f8f9fa;">
							<td style="font-weight:bold;color:#333;">Total Cuti Tahun Sebelumnya</td>
							<td></td>
							<td></td>
							<td style="text-align: center;"><label class="badge badge-info"><?php echo $cutisblm; ?></label></td>
							<td></td>
						</tr>

						<?php $namabln = 01; $balance = $cutisblm; $cekbln = 0; ?>
						<?php foreach($results as $r) { ?>
						<?php
							//Make Balance
						if($r->nilai == null || $r->nilai == 0){
							$balance = $balance + $r -> plus;

						}else{
							$balance = $balance - $r -> nilai;
						}
						?>

						<?php 
							//Mengambil nilai bulan awal
						$namabln = date('m', strtotime( $r->tgl ));

						?>


						<?php if($namabln <> $cekbln){ ?>
						<?php 
						$tgl = $namabln;

						if(substr($tgl,0,1)==0){
							$gett = substr($tgl,1,1);
						}else{
							$gett = $tgl;
						}
						?>

						<tr style="background: #f8f9fa;">
							<td style="font-weight:bold;color:#333;" colspan="5"><?php echo date("F", mktime(0, 0, 0, $gett, 15)); ?></td>
						</tr>
						<tr>
							<td><?php echo $r->tgl; ?></td>
							<td style="text-align: center;"><label class="badge badge-success"><?php echo $r->plus; ?></label></td>
							<td style="text-align: center;"><label class="badge badge-danger"><?php echo $r->nilai; ?></label></td>
							<td style="text-align: center;"><label class="badge badge-info"><?php echo $balance; ?></label></td>
							<td><?php echo $r->deskripsi; ?></td>
						</tr>
						<?php $cekbln = $namabln; ?>
						<?php }else{ ?>
						<tr>
							<td><?php echo $r->tgl; ?></td>
							<td style="text-align: center;"><label class="badge badge-success"><?php echo $r->plus; ?></label></td>
							<td style="text-align: center;"><label class="badge badge-danger"><?php echo $r->nilai; ?></label></td>
							<td style="text-align: center;"><label class="badge badge-info"><?php echo $balance; ?></label></td>
							<td><?php echo $r->deskripsi; ?></td>
						</tr>

						<?php } ?>
						<?php } ?>
						<tr style="background: #0d4e6c;">
							<td style="font-weight:bold;color:white;">Total Cuti Saat Ini</td>
							<td></td>
							<td></td>
							<td style="font-weight:bold;color:white;text-align: center;"><?php echo $balance; ?></td>
							<td></td>
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
			'lengthMenu': [[10, 25, -1], [10, 25, "All"]],
            'responsive': true
		});
	});
</script>

