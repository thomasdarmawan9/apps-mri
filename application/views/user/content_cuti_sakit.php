<div class="card">
	<div class="card-header">
		<h3 class="card-title">Laporan Cuti Sakit</h3>
	</div>
	<div class="card-body">
		<?php if(!empty($cekname)){?>
		<h4>Nama : <b><?php echo ucwords($cekname); ?></b></h4>
		<?php } ?>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr style="background-color: #ff3547 ;font-size:1rem;color:#fff;">
						<th>Tanggal</th>
						<th style="text-align: center;">Plus</th>
						<th style="text-align: center;">Minus</th>
						<th style="text-align: center;">Balance</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($results) or (!empty($cutisblm))){ ?>

					<?php $balance = 0; $cekbln = 0; ?>

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
					<tr style="background: #ff3547;">
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
