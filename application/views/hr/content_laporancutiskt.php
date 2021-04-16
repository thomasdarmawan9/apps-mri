	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Report Cuti Sakit</h3>
		</div>
		<div class="card-body">
			<form method="post" action="<?= base_url('hr/overtime/report_sakit_hr')?>">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Warrior</label>
					<div class="col-sm-4">
						<select class="form-control" name="name" required="">
							<option value="">- Pilih Nama -</option>
							<?php 
							foreach($allname as $an) {
								if($an->level <> 'admin'){ 
									if($an->username == $cekname){
										echo "<option value='".$an->username."' selected>".ucfirst($an->username)."</option>";
									}else{
										echo "<option value='".$an->username."'>".ucfirst($an->username)."</option>";
									}
								}
							} 
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label"></label>
					<div class="col-sm-4">
						<button type="submit" class="btn btn-info"><i class="fa fa-search"></i>&nbsp; Filter</button>
					</div>
				</div>
			</form>
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
							<th>Aksi</th>
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
							<td style="font-weight:bold;color:212529;" colspan="6"><?php echo date("F", mktime(0, 0, 0, $gett, 15)); ?></td>
							
						</tr>
						<tr>
							<td><?php echo $r->tgl; ?></td>
							<td style="text-align: center;"><label class="badge badge-success"><?php echo $r->plus; ?></label></td>
							<td style="text-align: center;"><label class="badge badge-danger"><?php echo $r->nilai; ?></label></td>
							<td style="text-align: center;"><label class="badge badge-info"><?php echo $balance; ?></label></td>
							<td><?php echo $r->deskripsi; ?></td>
							<td><!--<a onclick="hapus(<?= $r->id;?>)"><button class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete</button></a>--></td>
						</tr>
						<?php $cekbln = $namabln; ?>

						<?php }else{ ?>
						<tr>
							<td><?php echo $r->tgl; ?></td>
							<td style="text-align: center;"><label class="badge badge-success"><?php echo $r->plus; ?></label></td>
							<td style="text-align: center;"><label class="badge badge-danger"><?php echo $r->nilai; ?></label></td>
							<td style="text-align: center;"><label class="badge badge-info"><?php echo $balance; ?></label></td>
							<td><?php echo $r->deskripsi; ?></td>
							<td><!--<a onclick="hapus(<?= $r->id;?>)"><button class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete</button></a>--></td>
						</tr>
						
						<?php } ?>
						<?php } ?>
						<tr style="background: #ff3547;">
							<td style="color:white;">Total Cuti Saat Ini</td>
							<td></td>
							<td></td>
							<td style="font-weight:bold;color:white;text-align: center;"><?php echo $balance; ?></td>
							<td></td>
							<td></td>
						</tr>

						<?php } ?>
					</tbody>
				</table>


			</div>
		</div>
	</div>

	<script type="text/javascript">
		function reload_page(){
			window.location.reload();
		}
		
		function hapus(id){
			if(id != ''){
				swal({
					title: 'Konfirmasi',
					text: "Data akan dihapus, lanjutkan?",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#f35958',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya'
				}, function(result){
					if (result) {         
						$.ajax({
							url: "<?= base_url('hr/overtime/delete_cuti_sakit')?>",
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
	</script>


