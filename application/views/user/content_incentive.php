 	<div class="card">
 		<div class="card-header">
 			<h3 class="card-title">Incentive</h3>
 		</div>
 		<div class="card-body">
 			<div class="table-responsive">

 				<div class="row">
 					<div class="col-md-4" style="padding: 30px;background: #0d4e6c;color: white;margin:10px;">
 						<span style="font-weight:bold;">PAID :</span><br>
 						<h3 style="font-size: 1.5em;color: white;font-weight:bold;text-align: center;"><?php if(!empty($paid)){ echo $paid; }else{ ?> - <?php } ?></h3>
 					</div>

 					<div class="col-md-4" style="padding: 30px;background: #ff3547 ;color: white;margin:10px;">
 						<span style="font-weight:bold;">UNPAID :</span><br>
 						<h3 style="font-size: 1.5em;color: white;font-weight:bold;text-align: center;"><?php if(!empty($unpaid)){ echo $unpaid; }else{ ?> - <?php } ?></h3>
 					</div>

 					<div class="col-md-2" style="-ms-transform: rotate(7deg);-webkit-transform: rotate(7deg);transform: rotate(7deg);">
 						<span style="font-size: 5em;font-weight: bold;color: lightgray;">Rp</span>
 					</div>
 				</div>
 				<hr>
 				<div class="table-responsive">
 					<table class="table w-100" id="table1">
 						<thead class="text-center">
 							<tr style="background-color: #0d4e6c;color:#fff;">
 								<th class="text-center">No</th>
 								<th>Event</th>
 								<th>Tanggal</th>
 								<th style="width: 150px;">Peserta</th>
 								<th>Total Bayar</th>
 								<th>Komisi</th>
 								<th>Dp</th>
 								<th>Lunas</th>
 								<th>Status</th>
 							</tr>
 						</thead>
 						<tbody class="text-center">

 							<?php $no = 1; if(!empty($results)){ foreach($results as $r) { ?>

 							<tr>
 								<td class="text-center"><?= $no++;?></td>
 								<td>
 									<?php   
 									$singkat = $r->program_lain;
 									if(!empty($singkat)){
 										$words = explode(" ", $singkat);
 										$acronym = "";
 										foreach ($words as $w) {
 											$acronym .= $w[0];
 										}

 										echo "<span class='badge badge-primary' data-toggle='popover' data-content='Program $r->program_lain' data-placement='top' data-trigger='hover'>".$acronym."</span>";
 									}else{
 										echo "<span class='badge badge-light' data-toggle='popover' data-content='".$r->event."' data-placement='top' data-trigger='hover'>DF</span>";
 									}
 									?>
 								</td>
 								<td><?= date("d-M-Y", strtotime($r->date)); ?></td>
 								<td><?= $r->peserta; ?></td>
 								<td><?= 'Rp '.number_format($r->total); ?></td>
 								<?php if($r->jenis_lunas == 'lunas'){
 									$lunas = '<i class="fas fa-check"></i>';
 									$dp = '';
 									$komisi = $r->komisi_lunas;
 								}else{
 									$lunas = '';
 									$dp = '<i class="fas fa-check"></i>';
 									$komisi = $r->komisi_dp;
 								} ?>
 								<td><?php if($r->komisi_program_lain <> null) { echo 'Rp '.number_format($r->komisi_program_lain); }else{ echo 'Rp '.number_format($komisi); } ?></td>
 								<td><?= $dp; ?></td>
 								<td><?= $lunas; ?></td>
 								<td><?php if($r->status_paid == 'paid'){ echo '<label class="badge badge-info" style="cursor: auto;font-weight:bold;">paid</label>'; }else{ echo '<label class="badge badge-danger" style="cursor: auto;font-weight:bold;">unpaid</label>'; } ?></td>
 							</tr> 

 							<?php }} ?>

 						</tbody>
 					</table>

 				</div>
 			</div>

 		</div>
 		<!-- END PAGE -->
 	</div>


 	<script type="text/javascript">
 		$('#table1').DataTable({
 			'order' : false,
 			'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]
 			],
 			 'rowReorder': {
                 'selector': 'td:nth-child(2)'
             },
             'responsive': true,
             'stateSave': true
 		});
 	</script>
