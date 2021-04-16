    	<div class="card">
    		<div class="card-header">
    			<h3 class="card-title">Report Task</h3>
    		</div>
    		<div class="card-body">

    			<h5>Nama Event &emsp;: <label class="badge badge-info"><?= $event; ?></label><br>
    				Tanggal &emsp;&emsp;&emsp;: <label class="badge badge-info"><?= date('d-M-Y', strtotime($tgl)); ?></label></h5>
    				<hr>
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
    							<input type="text" value="<?php echo $idtask; ?>" name="idtask" style="display:none;" readonly>
    							<input type="text" value="<?php echo $jmh; ?>" name="jmhuser" style="display:none;" readonly>
    							<?php for($i=0;($jmh-1) >= $i;$i++){ ?>

    							<input type="text" value="<?php echo $hasil[$i][5]; ?>" name="<?php echo 'userid'.$i; ?>" style="display:none;">
    							<tr>
    								<td style="vertical-align: middle;"><b><?php echo ucfirst($hasil[$i][0]); ?></b></td>
    								<td style="vertical-align: middle;">
    									<div class="checkbox check-primary">
    										<input id="<?php echo 'checkbox'.$i; ?>" value="1" class="form-control" name="<?php echo 'hadir'.$i; ?>" disabled type="checkbox"
    										<?php if($hasil[$i][6]=='ya'){ ?>
    										checked
    										<?php } ?>
    										>
    										<label for="<?php echo 'checkbox'.$i; ?>"></label>
    									</div>
    								</td>
    								<td>
    									<?php if($this->session->userdata('username') == $hasil[$i][0]){ ?>
    									<input type="text" name="<?php echo 'tugas'.$i; ?>" value="pd" class="form-control" readonly>
    									<?php }elseif($hasil[$i][1]<>null){ ?>
    									<select name="<?php echo 'tugas'.$i; ?>" class="form-control" disabled>
    										<option value="<?php echo $hasil[$i][1]; ?>"><?php echo ucfirst($hasil[$i][1]); ?></option>
    										<option value="speaker">Speaker</option>
    										<option value="mc">Mc</option>
    										<option value="aviator">Aviator</option>
    										<option value="merchandise">Merchandise</option>
    										<option value="registration">Registration</option>
    										<option value="Usher Lt. 1">Usher Lt. 1</option>
    										<option value="Usher Lt. 2">Usher Lt. 2</option>
    										<option value="Usher Lt. 3">Usher Lt. 3</option>
    										<option value="kasir">Kasir</option>
    										<option value="admin">Admin</option>
    										<option value="others">Others</option>
    									</select>

    									<?php }else{ ?>

    									<select name="<?php echo 'tugas'.$i; ?>" class="form-control" disabled>
    										<option value="">Pilih Tugas...</option>
    										<option value="speaker">Speaker</option>
    										<option value="mc">Mc</option>
    										<option value="aviator">Aviator</option>
    										<option value="merchandise">Merchandise</option>
    										<option value="registration">Registration</option>
    										<option value="usher1">Usher Lt. 1</option>
    										<option value="usher2">Usher Lt. 2</option>
    										<option value="usher3">Usher Lt. 3</option>
    										<option value="kasir">Kasir</option>
    										<option value="admin">Admin</option>
    										<option value="others">Others</option>
    									</select>

    									<?php } ?>

    								</td>
    								<td>
    									<?php if($hasil[$i][2]<>null){ ?>
    									<input style="width:50px;" type="number" name="<?php echo 'dp'.$i; ?>" class="form-control" style="vertical-align: middle;" readonly value="<?php echo $hasil[$i][2]; ?>">
    									<?php }else{ ?>
    									<input style="width:50px;" type="number" name="<?php echo 'dp'.$i; ?>" class="form-control" readonly style="vertical-align: middle;">
    									<?php } ?>
    								</td>

    								<td>
    									<?php if($hasil[$i][4]<>null){ ?>
    									<input style="width:50px;" type="number" name="<?php echo 'lunas'.$i; ?>" class="form-control" readonly  style="vertical-align: middle;" value="<?php echo $hasil[$i][4]; ?>">
    									<?php }else{ ?>
    									<input style="width:50px;" type="number" name="<?php echo 'lunas'.$i; ?>" class="form-control" readonly style="vertical-align: middle;">
    									<?php } ?>
    								</td>
    							</tr>
    							<?php } ?>



    						</tbody>
    					</table>

    					<hr>
    					<?php if(!empty($hasil[0][7])){ ?>

    					<input type="text" value="<?php echo $hasil[0][7]; ?>" name="jns_report" style="display:none;" readonly>
    					<?php if($hasil[0][7] == 'peserta') { ?>
    					<table class="table table-striped table-bordered">
    						<thead>
    							<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
    								<th>Update</th>
    								<th>Peserta</th>
    							</tr>
    						</thead>
    						<tr>
    							<td style="width: 100px;vertical-align: middle;font-weight:bold;">Daftar</td>
    							<td>
    								<input style="width:80px;" type="number" name="daftar" min="0" style="vertical-align: middle;" value="<?php echo $hasil[0][8]; ?>" class="form-control" readonly >
    							</td>
    						</tr>
    						<tr>
    							<td style="width: 100px;vertical-align: middle;font-weight:bold;">OTS</td>
    							<td>
    								<input style="width:80px;" type="number" name="ots" min="0" style="vertical-align: middle;" value="<?php echo $hasil[0][9]; ?>" class="form-control" readonly >
    							</td>
    						</tr>
    						<tr>
    							<td style="width: 100px;vertical-align: middle;font-weight:bold;">Hadir</td>
    							<td>
    								<input style="width:80px;" type="number" name="hadir" min="0" style="vertical-align: middle;" value="<?php echo $hasil[0][10]; ?>" class="form-control" readonly >
    							</td>
    						</tr>
    						<tr>
    							<td style="width: 100px;vertical-align: middle;font-weight:bold;">Tidak Hadir</td>
    							<td>
    								<input style="width:80px;" type="number" name="tidak_hadir" min="0" style="vertical-align: middle;" value="<?php echo $hasil[0][11]; ?>" class="form-control" readonly >
    							</td>
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
    							<td style="width: 100px;vertical-align: middle;font-weight:bold;">Daftar</td>
    							<td style="width: 100px;">
    								<input style="width:80px;" type="number" name="daftark" style="vertical-align: middle;" value="<?php if(!empty($hasil[1][8])){ echo $hasil[1][8]; } ?>" class="form-control" readonly >
    							</td>
    							<td>
    								<input style="width:50px;" type="number" name="daftara" min="0" style="vertical-align: middle;" value="<?php if(!empty($hasil[2][8])){ echo $hasil[2][8]; } ?>" class="form-control" readonly >
    							</td>
    						</tr>
    						<tr>
    							<td style="width: 100px;vertical-align: middle;font-weight:bold;">OTS</td>
    							<td style="width: 100px;">
    								<input style="width:80px;" type="number" name="otsk" style="vertical-align: middle;" value="<?php if(!empty($hasil[1][9])){ echo $hasil[1][9]; } ?>" class="form-control" readonly >
    							</td>
    							<td>
    								<input style="width:50px;" type="number" name="otsa" min="0" style="vertical-align: middle;" value="<?php if(!empty($hasil[2][9])){ echo $hasil[2][9]; } ?>" class="form-control" readonly >
    							</td>
    						</tr>
    						<tr>
    							<td style="width: 100px;vertical-align: middle;font-weight:bold;">Hadir</td>
    							<td style="width: 100px;">
    								<input style="width:80px;" type="number" name="hadirk" style="vertical-align: middle;" value="<?php if(!empty($hasil[1][10])){ echo $hasil[1][10]; } ?>" class="form-control" readonly>
    							</td>
    							<td>
    								<input style="width:50px;" type="number" name="hadira" min="0" style="vertical-align: middle;" value="<?php if(!empty($hasil[2][10])){ echo $hasil[2][10]; } ?>" class="form-control" readonly >
    							</td>
    						</tr>
    						<tr>
    							<td style="width: 100px;vertical-align: middle;font-weight:bold;">Tidak Hadir</td>
    							<td style="width: 100px;">
    								<input style="width:80px;" type="number" name="tidak_hadirk" style="vertical-align: middle;" value="<?php if(!empty($hasil[1][11])){ echo $hasil[1][11]; } ?>" class="form-control" readonly >
    							</td>
    							<td>
    								<input style="width:50px;" type="number" name="tidak_hadira" min="0" style="vertical-align: middle;" value="<?php if(!empty($hasil[2][11])){ echo $hasil[2][11]; } ?>" class="form-control" readonly >
    							</td>
    						</tr>
    						<tbody>
    						</tbody>

    					</table>


    					<?php } ?>

    					<?php } ?>


    				</div>
    			</div>

    		</div>
