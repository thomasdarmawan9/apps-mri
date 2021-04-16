<div class="card">
	<div class="card-header">
		<h3 class="card-title">Report Detail Incentive</h3>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-3">
				<div class="card-body">
					<h5>
						Event &nbsp;&emsp;&emsp;: <label class="badge badge-info"><?= $results->event; ?></label><br>
						<!-- Lokasi &emsp;&emsp;: <label class="badge badge-info"><?= $results->location; ?></label><br> -->
						Tanggal &emsp;: <label class="badge badge-info"><?= date("d-M-Y", strtotime($results->date)); ?></label>
					</h5>
				</div>
			</div>
			<div class="col-md-9">
				<div class="alert alert-info" style="letter-spacing:0px;">
					<button class="close" data-dismiss="alert"></button>
					<b>Pilih Program Lain</b> : Digunakan jika saat Event ada jenis Event berbeda yg di closing, Misal saat SPLA ada program Life Mastery yang di closing. <br>Biarkan status "<b>Default</b>" untuk menyatakan closing sesuai dengan programnya.
				</div>
			</div>
		</div>
		<hr>

		<form method="post" action="<?= base_url('user/incentive/add_row/'.$id_event)?>" class="form-inline">
			<div class="form-group mb-2">
				<input type="number" name="baris" class="form-control col-sm-2"> 
				<div class="col-sm-4">
					<button class="btn teal"><i class="fa fa-plus"></i>&nbsp; Tambah Baris</button>
				</div>
			</div>
		</form>

		<form method="post" action="<?= base_url('user/incentive/update_incentive')?>">
			<?php if(!empty($_GET['row'])){ ?>
			<div style="display:none;">
				<input type="text" name="id_event" value="<?= $results->ti; ?>">
				<input type="text" name="jmh" value="<?= $hslnm + $_GET['row']; ?>">
			</div>
			<?php }else{ ?>

			<div style="display:none;">
				<input type="text" name="id_event" value="<?= $results->ti; ?>">
				<input type="text" name="jmh" value="<?= $hslnm; ?>">
			</div>

			<?php } ?>

			<table class="table table-striped table-bordered">
				<thead>
					<tr style="background-color: #0d4e6c;color:#fff;text-align: center">
						<th>No</th>
						<th>Warriors</th>
						<th>Pilih Program Lain</th>
						<th>Nama Peserta</th>
						<th>Total Bayar</th>
						<th>DP | Lunas</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php $jmh = $hslnm; $i=0; ?>
					<?php foreach ($hsl as $hs){ ?>
					<input type="text" name="id_incentive<?= $i; ?>" value="<?= $hs->ici; ?>" style="display:none;">

					<tr>
						<td><?= $i+1; ?></td>

						<td>

							<select name="user<?= $i; ?>" required class="form-control">
								<option value="<?= $hs->username; ?>"><?= ucfirst($hs->username); ?></option>
								<?php if(!empty($user)){ ?>
								<?php foreach($user as $u){ ?>
								<option value="<?= $u->username; ?>"><?= ucfirst($u->username); ?></option>
								<?php } ?>
								<?php } ?>
							</select>

						</td>

						<td>

							<select name="program_lain<?= $i; ?>" class="form-control">
								<?php if($hs->program_lain == null){ ?>
								<option value="default">Default</option>
								<?php }else{ ?>
								<option value="<?= $hs->program_lain; ?>"><?= $hs->program_lain; ?></option>
								<?php } ?>

								<?php if(!empty($listprogram)){ ?>
								<?php foreach($listprogram as $lp){ ?>
								<option value="<?= $lp->name; ?>"><?= ucfirst($lp->name); ?></option>
								<?php } ?>
								<?php } ?>
							</select>

						</td>

						<td><input type="text" value="<?= $hs->peserta; ?>" name="peserta<?= $i; ?>" class="form-control" required></td>
						<td><input type="number" name="bayar<?= $i; ?>" value="<?= $hs->total; ?>" class="form-control" required></td>
						<td><div class="form-group"  style="width:160px;">
							<div class="radio radio-primary">
								<?php if($hs->jenis_lunas == 'dp'){ ?>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="dp<?= $i; ?>" name="closing<?= $i; ?>" value="dp" class="custom-control-input" checked="" required="">
									<label class="custom-control-label" for="dp<?= $i; ?>" >Dp</label> 
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input id="lunas<?= $i; ?>" name="closing<?= $i; ?>" value="lunas" type="radio" required="" class="custom-control-input">
									<label class="custom-control-label" for="lunas<?= $i; ?>" >Lunas</label>
								</div>

								<?php }else{ ?>
								
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="dp<?= $i; ?>" name="closing<?= $i; ?>" value="dp" class="custom-control-input" required="">
									<label class="custom-control-label" for="dp<?= $i; ?>" >Dp</label> 
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input id="lunas<?= $i; ?>" name="closing<?= $i; ?>" value="lunas" type="radio" required="" checked="" class="custom-control-input">
									<label class="custom-control-label" for="lunas<?= $i; ?>" >Lunas</label>
								</div>

								<?php } ?>   
							</div>
						</div>
					</td>
					<td><a onclick="hapus(<?= $hs->ici?>,<?= $hs->id_task?>)"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></a></td>

				</tr>
				<?php $i++; ?>
				<?php } ?>

				<?php if(!empty($_GET['row'])){

					$target = $_GET['row'] + $i;
					for($i=$i; $i < $target; $i++){ ?>

					<tr>
						<input type="text" name="id_incentive<?= $i; ?>" value="null" style="display:none;">
						<td style="vertical-align: middle;text-align: center;"><?= $i+1; ?></td>
						<td>

							<select name="user<?= $i; ?>" required class="form-control">
								<option value="">Pilih Warriors</option>
								<?php if(!empty($user)){ ?>
								<?php foreach($user as $u){ ?>
								<option value="<?= $u->username; ?>"><?= ucfirst($u->username); ?></option>
								<?php } ?>
								<?php } ?>
							</select>

						</td>

						<td style="background: #ebf6fb;">

							<select name="program_lain<?= $i; ?>" class="form-control">
								<option value="default">Default</option>
								<?php if(!empty($listprogram)){ ?>
								<?php foreach($listprogram as $lp){ ?>
								<option value="<?= $lp->name; ?>"><?= ucfirst($lp->name); ?></option>
								<?php } ?>
								<?php } ?>
							</select>

						</td>

						<td><input type="text" value="" name="peserta<?= $i; ?>" class="form-control" required></td>
						<td><input type="number" name="bayar<?= $i; ?>" value="" required class="form-control"></td>
						<td>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="dp<?= $i; ?>" name="closing<?= $i; ?>" value="dp" class="custom-control-input" required="">
								<label class="custom-control-label" for="dp<?= $i; ?>" >Dp</label> 
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input id="lunas<?= $i; ?>" name="closing<?= $i; ?>" value="lunas" type="radio" required="" class="custom-control-input">
								<label class="custom-control-label" for="lunas<?= $i; ?>" >Lunas</label>
							</div>
						</td>
						<td></td>
					</tr>
					<?php } ?>

					<?php } ?>
					<tr>
						<td colspan="7">
							<a href="<?= base_url('user/incentive/report')?>">
								<button type="button" class="btn btn-blue-grey"> << Back </button>
							</a> 
							<button type="submit" class="btn btn-primary">Update</button>
						</td>

					</tr>

				</tbody>
			</table>
		</form>
	</div>

</div>

<script type="text/javascript">
	function reload_page(){
		window.location.reload();
	}

	function hapus(id_incentive, id_event){
		if(id_incentive != '' && id_event != ''){
			swal({
				title: 'Konfirmasi',
				text: "Data akan dihapus. \nLanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('user/incentive/del_list_incentive')?>",
						type: "POST",
						dataType: "json",
						data:{'id_incentive': id_incentive, 'id_event': id_event},
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