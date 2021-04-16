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
			<div class="table-responsive">
				<form method="post" action="<?= base_url('user/incentive/add_incentive')?>">

					<input type="hidden" name="id_event" value="<?= $results->ti; ?>">
					<input type="hidden" name="jmh" value="<?= $jumlah; ?>">

					<table class="table table-striped table-bordered">
						<thead>
							<tr style="background-color: #0d4e6c;color:#fff;text-align: center">
								<th>No</th>
								<th>Warriors</th>
								<th>Pilih Program Lain</th>
								<th>Nama Peserta</th>
								<th>Total Bayar</th>
								<th> DP | Lunas</th>
								
							</tr>
						</thead>
						<tbody class="text-center">
							<?php $jmh = $jumlah; $i=0; ?>
							<?php for ($jmh; $i < $jmh; $i++){ ?>

							<tr>
								<td style="vertical-align: middle;text-align: center;"><?= $i+1; ?></td>

								<td>

									<select name="user<?= $i; ?>" class="form-control">
										<option value="">Pilih Warrior...</option>
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

								<td><input type="text" name="peserta<?= $i; ?>" class="form-control"></td>
								<td><input type="number" name="bayar<?= $i; ?>" class="form-control"></td>
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

						</tr>

						<?php } ?>

						<tr>
							<td colspan="6" class="text-center">
								<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Submit</button>
							</td>
						</tr>

					</tbody>
				</table>
			</form>
		</div>

	</div>
</div>
</div>

</div>
</div>
