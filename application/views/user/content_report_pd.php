  	<div class="card">
  		<div class="card-header">
  			<h3 class="card-title">Report PD</h3>
  		</div>
  		<div class="card-body">
  			<div class="row">
  				<div class="col-md-3">
  					<!-- <div class="card"> -->
  						<div class="card-body">
  							<h5>Nama Event &emsp;: <label class="badge badge-info"><?= $event; ?></label><br>
  								Tanggal &emsp;&emsp;&emsp;: <label class="badge badge-info"><?= date('d-M-Y', strtotime($tgl)); ?></label></h5>
  							</div>
  						<!-- </div> -->
  					</div>
  					<div class="col-md-9">
  						<div class="alert alert-info">
  							Untuk Warrior yang additional hanya bertugas sebagai EC tidak perlu di centang. <br> Jika ada tugas dari awal event baru dicentang. <br>
  							Jika warrior additional dicentang hadir maka, task warriors tersebut akan +1 (telah membayar 1 Event).
  						</div>
  					</div>
  				</div>


  				<div class="striped">
  					<button type="button" class="btn  btn-primary" data-toggle="modal" data-target="#myModal" style="text-align:center;cursor: pointer;"> <i class="fa fa-user-plus"></i> Add Warrior</button>
  				</div>
  				<hr>


  				<form method="post" action="<?= base_url('user/task/update_report_pd')?>">
  					<div class="table-responsive">
  						<table class="table table-striped table-bordered">
  							<thead>
  								<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
  									<th>Nama</th>
  									<th>Hadir</th>
  									<th>Tugas</th>
  									<th>Dp / Modul</th>
  									<th>Lunas</th>
  								</tr>
  							</thead>
  							<tbody>


  								<input type="text" value="<?php echo $idtask; ?>" name="idtask" style="display:none;">
  								<input type="text" value="<?php echo $jmh; ?>" name="jmhuser" style="display:none;">
  								<?php for($i=0;($jmh-1) >= $i;$i++){ ?>

  								<input type="text" value="<?php echo $hasil[$i][5]; ?>" name="<?php echo 'userid'.$i; ?>" style="display:none;">
  								<tr>
  									<td style="vertical-align: middle;"><b><?php echo ucfirst($hasil[$i][0]); ?></b></td>
  									<td style="vertical-align: middle;">
  										<div class="custom-control custom-checkbox">
  											<input id="<?php echo 'checkbox'.$i; ?>" value="1" name="<?php echo 'hadir'.$i; ?>" type="checkbox" class="custom-control-input"
  											<?php if($hasil[$i][6]=='ya'){ ?>
  											checked
  											<?php } ?>
  											>
  											<label for="<?php echo 'checkbox'.$i; ?>" class="custom-control-label"></label>
  										</div>
  									</td>
  									<td>
  										<?php if($this->session->userdata('username') == $hasil[$i][0]){ ?>
  										<input type="text" name="<?php echo 'tugas'.$i; ?>" value="pd" readonly class="form-control">
  										<?php }elseif($hasil[$i][1]<>null){ ?>
  										<select name="<?php echo 'tugas'.$i; ?>" class="form-control">
  											<option value="<?php echo $hasil[$i][1]; ?>"><?php echo ucfirst($hasil[$i][1]); ?></option>
  											<option value="speaker">Speaker</option>
  											<option value="trainer">Trainer</option>
  											<option value="aviator">Aviator</option>
  											<option value="merchandise">Merchandise</option>
  											<option value="registration 1">Registration 1</option>
  											<option value="registration 2">Registration 2</option>
  											<option value="coach 1">coach 1</option>
  											<option value="coach 2">coach 2</option>
  											<option value="coach 3">coach 3</option>
  											<option value="coach 4">coach 4</option>
  											<option value="usher Lt. 1">Usher Lt. 1</option>
  											<option value="usher Lt. 3">Usher Lt. 3</option>
  											<option value="mc">Mc</option>
  											<option value="kasir">Kasir</option>
  											<option value="admin">Admin</option>
  											<option value="others">Others</option>
  										</select>

  										<?php }else{ ?>

  										<select name="<?php echo 'tugas'.$i; ?>" class="form-control">
  											<option value="">Pilih Tugas...</option>
  											<option value="speaker">Speaker</option>
  											<option value="trainer">Trainer</option>
  											<option value="aviator">Aviator</option>
  											<option value="merchandise">Merchandise</option>
  											<option value="registration 1">Registration 1</option>
  											<option value="registration 2">Registration 2</option>
  											<option value="coach 1">coach 1</option>
  											<option value="coach 2">coach 2</option>
  											<option value="coach 3">coach 3</option>
  											<option value="coach 4">coach 4</option>
  											<option value="usher Lt. 1">Usher Lt. 1</option>
  											<option value="usher Lt. 3">Usher Lt. 3</option>
  											<option value="mc">Mc</option>
  											<option value="kasir">Kasir</option>
  											<option value="admin">Admin</option>
  											<option value="others">Others</option>
  										</select>

  										<?php } ?>

  									</td>
  									<td>
  										<?php if($hasil[$i][2]<>null){ ?>
  										<input style="width:70px;" type="number" name="<?php echo 'dp'.$i; ?>" style="vertical-align: middle;" value="<?php echo $hasil[$i][2]; ?>" class="form-control">
  										<?php }else{ ?>
  										<input style="width:70px;" type="number" name="<?php echo 'dp'.$i; ?>" style="vertical-align: middle;" class="form-control">
  										<?php } ?>
  									</td>

  									<td style="align-items: center;">
  										<?php if($hasil[$i][4]<>null){ ?>
  										<input style="width:70px;" type="number" name="<?php echo 'lunas'.$i; ?>" style="vertical-align: middle;" value="<?php echo $hasil[$i][4]; ?>" class="form-control">
  										<?php }else{ ?>
  										<input style="width:70px;" type="number" name="<?php echo 'lunas'.$i; ?>" style="vertical-align: middle;" class="form-control">
  										<?php } ?>
  									</td>
  								</tr>
  								<?php } ?>



  							</tbody>
  						</table>

  						<input type="text" value="<?php echo $hasil[0][7]; ?>" name="jns_report" style="display:none;">
  						<?php if($hasil[0][7] == 'peserta') { ?>
  						<table class="table table-striped table-bordered">
  							<thead>
  								<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
  									<th>Update</th>
  									<th>Peserta</th>
  								</tr>
  							</thead>
  							<tr>
  								<td style="width: 100px;vertical-align: middle;">Daftar</td>
  								<td><input style="width:80px;" class="form-control" type="number" name="daftar" min="0" style="vertical-align: middle;" value="<?php echo $hasil[0][8]; ?>" ></td>
  							</tr>
  							<tr>
  								<td style="width: 100px;vertical-align: middle;">OTS</td>
  								<td><input style="width:80px;" class="form-control" type="number" name="ots" min="0" style="vertical-align: middle;" value="<?php echo $hasil[0][9]; ?>" ></td>
  							</tr>
  							<tr>
  								<td style="width: 100px;vertical-align: middle;">Hadir</td>
  								<td><input style="width:80px;" class="form-control" type="number" name="hadir" min="0" style="vertical-align: middle;" value="<?php echo $hasil[0][10]; ?>" ></td>
  							</tr>
  							<tr>
  								<td style="width: 100px;vertical-align: middle;">Tidak Hadir</td>
  								<td><input style="width:80px;" class="form-control" type="number" name="tidak_hadir" min="0" style="vertical-align: middle;" value="<?php echo $hasil[0][11]; ?>" ></td>
  							</tr>
  							<tbody>
  							</tbody>

  						</table>
  						<?php }else{ ?>
  						<table class="table table-striped table-bordered">
  							<thead>
  								<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
  									<th>Update</th>
  									<th>Keluarga</th>
  									<th>Anak</th>
  								</tr>
  							</thead>
  							<tr>
  								<td style="width: 100px;vertical-align: middle;">Daftar</td>
  								<td><input style="width:80px;" type="number" class="form-control" name="daftark" value="<?php if(!empty($hasil[1][8])){ echo $hasil[1][8]; } ?>" ></td>
  								<td><input style="width:50px;" type="number" name="daftara" min="0" style="vertical-align: middle;" value="<?php if(!empty($hasil[2][8])){ echo $hasil[2][8]; } ?>" ></td>
  							</tr>
  							<tr>
  								<td style="width: 100px;vertical-align: middle;">OTS</td>
  								<td><input style="width:80px;" type="number" class="form-control" name="otsk" value="<?php if(!empty($hasil[1][9])){ echo $hasil[1][9]; } ?>"  ></td>
  								<td><input style="width:50px;" type="number" name="otsa" min="0" style="vertical-align: middle;" value="<?php if(!empty($hasil[2][9])){ echo $hasil[2][9]; } ?>"  ></td>
  							</tr>
  							<tr>
  								<td style="width: 100px;vertical-align: middle;">Hadir</td>
  								<td><input style="width:80px;" type="number" class="form-control" name="hadirk" value="<?php if(!empty($hasil[1][10])){ echo $hasil[1][10]; } ?>" ></td>
  								<td><input style="width:50px;" type="number" name="hadira" min="0" style="vertical-align: middle;" value="<?php if(!empty($hasil[2][10])){ echo $hasil[2][10]; } ?>" ></td>
  							</tr>
  							<tr>
  								<td style="width: 100px;vertical-align: middle;">Tidak Hadir</td>
  								<td><input style="width:80px;" type="number" class="form-control" name="tidak_hadirk" value="<?php if(!empty($hasil[1][11])){ echo $hasil[1][11]; } ?>" ></td>
  								<td><input style="width:50px;" type="number" name="tidak_hadira" min="0" style="vertical-align: middle;" value="<?php if(!empty($hasil[2][11])){ echo $hasil[2][11]; } ?>" ></td>
  							</tr>
  							<tbody>
  							</tbody>

  						</table>
  						<?php } ?>
  					</div>
					<div class="col-12" style="text-align: center;">
						<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp; Simpan</button>
  					</div>
  				</form>

  			</div>
  		</div>

  		<!-- Modal -->
  		<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
  			<div class="modal-dialog">
  				<div class="modal-content">
  					<form method="post" action="<?= base_url('user/task/paytask_adding')?>">
  						<div class="modal-header">
  							<h4 class="modal-title">Pay Task Warriors</h4>
  							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  						</div>
  						<div class="modal-body">
  							<input type="hidden" name="idevent" value="<?= $idevent ?>">
  							<input type="hidden" name="eventname" value="<?= $event ?>">
  							<input type="hidden" name="tgl" value="<?= $tgl ?>">
  							<div class="form-group row">
  								<div class="col-md-4">
  									<label class="col-form-label">Warrior</label>
  								</div>
  								<div class="col-md-8">
  									<select id="nama" name="username" class="form-control">
  										<option value="">- Pilih Warriors -</option>
  										<?php if(!empty($nm)){ ?>
  										<?php foreach($nm as $r){ ?>
  										<option value="<?php echo $r->username; ?>"><?php echo ucfirst($r->username); ?></option>
  										<?php } ?>
  										<?php } ?>
  									</select>
  								</div>
  							</div>

  						</div>
  						<div class="modal-footer">
  							<button type="submit" class="btn btn-primary">Tambahkan</button>
  							<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
  						</div>
  					</form>
  				</div>
  			</div>
  		</div>
