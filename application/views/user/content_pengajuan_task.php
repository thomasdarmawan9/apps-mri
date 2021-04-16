	<div class="card">
		<div class="card-header">
			<h3 class="card-title">List Pengajuan Task</h3>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped w-100" id="table1">
					<thead class="text-center">
						<tr style="background-color: #0d4e6c;color:#fff;">
							<th>No</th>
							<th>Event</th>
							<th>Lokasi</th>
							<th>Tanggal</th>
							<th>Tugas</th>
							<th>Status</th>
							<th>Hadir</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php if(!empty($results)){ ?>
						<?php $no = 1; ?>
						<?php foreach($results as $r){ ?>
						<tr>
							<td style="vertical-align: middle;text-align: center;"><?php echo $no; ?></td>
							<td style="vertical-align: middle;"><b><?php echo $r->event; ?></b></td>
							<td style="vertical-align: middle;"><?php echo $r->location; ?></td>
							<td style="vertical-align: middle;"><label class="badge badge-info"><?php echo date('d-M-Y', strtotime($r->date)); ?></label></td>

							<?php if($r->id_pengganti == null){
								$pengganti= '<b>Saya Sendiri</b>';
								$disabled = '';
								$pgn = '<i class="fa fa-search"></i> Cari Pengganti';
							}elseif(($r->id_pengganti <> null) && ($r->persetujuan_pengganti == null)){
								$idp = $r->id_pengganti;
								$data['namapengganti'] = $this->model_task->get_username_penggantitask($idp);
								foreach ($data['namapengganti'] as $ganti){
									$pengganti = '<b>Menunggu</b> - '.ucfirst($ganti->username).'';
								}

								$disabled = '';
								$pgn = '<i class="fa fa-search"></i> Cari Pengganti';
							}else{
								if($r->id_pengganti == $this->session->userdata('id')){
									$pengganti = '<b>Menggantikan</b> - '.ucfirst($r->username).'';
									$disabled = '';
									$pgn = '<i class="fa fa-search"></i> Cari Pengganti';
								}else{
									$idp = $r->id_pengganti;
									$data['namapengganti'] = $this->model_task->get_username_penggantitask($idp);
									foreach ($data['namapengganti'] as $ganti){
										$pengganti = '<b>Diganti oleh</b> - '.ucfirst($ganti->username).'';
									}
									$disabled = 'disabled';
									$pgn = 'Telah Digantikan';
								}
							}
							?>


							<?php if($r->tugas == null){
								$tugas = '<label class="badge badge-light">Waiting by PD</label>';
							}else{
								$tugas = $r->tugas;
							}
							?>
							<td style="vertical-align: middle;"><?php echo $tugas; ?></td>           

							<td>
								<?php if($r->id_pengganti<>null){ ?>

								<a href="<?= base_url('user/task/batalkan_pertukaran/'.$r->tui.'/'.md5($r->tui))?>">
									<button onclick="cek(<?php echo $r->tui; ?>)" type="button" class="btn  btn-primary" style="cursor: pointer;" <?php if($r->id_pengganti<>null){ ?>data-toggle="tooltip" data-placement="top" title="Klik untuk Batalkan" <?php } ?> >
										<?php echo $pengganti; ?> 
									</button>
								</a>

								<?php }else{ ?>

								<button type="button" class="btn  btn-primary" style="cursor: auto;" > <?php echo $pengganti; ?> </button>

								<?php } ?>
							</td>
							<td>

								<?php if($r->hadir == null){ ?>
								<button type="button" class="btn btn-warning" style="cursor: auto;"><i class="fa fa-ellipsis-h"></i></button>
								<?php }elseif($r->hadir == 'ya'){ ?>
								<button type="button" class="btn btn-success" style="cursor: auto;"><span class="fa fa-check" aria-hidden="true"></span></button>
								<?php }else{ ?>
								<?php if($r->date < date("Y-m-d")){ ?>
								<button type="button" class="btn btn-danger" style="cursor: auto;"><span class="fa fa-times" aria-hidden="true"></span></button>
								<?php }else{ ?>
								<button type="button" class="btn btn-warning" style="cursor: auto;"><i class="fa fa-ellipsis-h"></i></button>
								<?php } ?>
								<?php } ?> 
							</td>
						</tr>
						<?php $no = $no + 1; ?>
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript">
	  $('#table1').DataTable({
	    'scrollX':true,
	    'order':false,
	    'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]
	    ],
	     'rowReorder': {
                 'selector': 'td:nth-child(2)'
             },
             'responsive': true,
             'stateSave': true
	  });
	</script>

