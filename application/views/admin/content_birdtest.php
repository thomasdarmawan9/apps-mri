
			<div class="card">
			  <div class="card-header">
				  <h3 class="card-title">BirdTest <span class="semi-bold"></span></h3>
			  </div>
			  <div class="card-body">
				
				<p>LOCK adalah untuk mengunci jawaban agar tidak langsung tampil pada halaman BirdTest Warriors dan<br>
  					UNLOCK adalah untuk menampilkan jawaban secara langsung agar bisa melakukan penilaian dengan cepat, bertujuan jika HR meminta bantuan kepada Warriors untuk membantu Pengecekan BirdTest.</p>
  					<hr>
  					<?php if(!empty($lock)){ ?>

  					<form  method="post" action="<?= base_url(); ?>birdtest/birdtest_lock">
						<div class="form-inline form-group mb-2">
  						<?php if($lock=='yes'){ ?>

  						<input type="text" class="form-control" value="LOCKED" name="status" style="font-weight:bold;background: #bbffbb;color: green;" readonly>
  						<button type="submit" class="btn  btn-danger">Unlock NOW</button><br>
  						
						<?php $key = 'yes'; ?>

  						<?php }else{ ?>

  						<input type="text" class="form-control" value="UNLOCKED" name="status" style="font-weight:bold;background: #ff9393;color: #bf0808;" readonly>
  						<button type="submit" class="btn  btn-primary">Lock NOW</button><br>
  						
						<?php $key = 'no'; ?>
						
  						<?php } ?>
						</div>
						<?php if($key == 'yes'){ ?>
						<span><i style="font-size: 12px;color:green;">*) Jawaban BirdTest TERKUNCI</i></span>
						<?php }else{ ?>
						<span><i style="font-size: 12px;color:red;">*) Jawaban BirdTest TERBUKA</i></span> 
						<?php } ?>
						
  					</form>

  					<?php } ?>
  					<hr>
					<div class="table-responsive">
					<table class="table table-striped table-bordered w-100" id='table1'>
  						<thead class="text-center">
  							<tr class="text-center">
  								<th style="background: #0d4e6c !important;color: white;">No</th>
  								<th style="background: #0d4e6c !important;color: white;">Nama</th>
  								<th style="background: #0d4e6c !important;color: white;">Tanggal</th>
  								<th style="background: #0d4e6c !important;color: white;">Waktu</th>
  								<th style="background: #0d4e6c !important;color: white;">Peacock</th>
  								<th style="background: #0d4e6c !important;color: white;">Dove</th>
  								<th style="background: #0d4e6c !important;color: white;">Eagle</th>
  								<th style="background: #0d4e6c !important;color: white;">Owl</th>
  							</tr>
  						</thead>
  						<tbody class="text-center">
  							<?php $no = 1; ?>
  							<?php if (!empty($results)){ ?>
  							<?php foreach($results as $r){ ?>

  							<tr>
  								<td class="text-center"><?php echo $no; ?></td>
  								<?php $no = $no + 1; ?>
  								<td>

  									<?php echo ucfirst($r->username); ?>

  								</td>

  								<?php
	                    		//Untuk dapat data username
  								$this->db->where('username', $r->username);
  								$query = $this->db->get('user');

	                    						//Mendapatkan id user
  								foreach($query->result() as $r){
  									$id = $r->id;
  								}

	                    						//Dicari dalam data birdtest
  								$this->db->where('id_user', $id);
  								$queryb = $this->db->get('birdtest');


  								if ($queryb -> num_rows() <> null){
  									$status = 'ada';

  									foreach($queryb->result() as $r){
  										$waktu = $r->waktu;
  										$peacock = $r->peacock;
  										$dove = $r->dove;
  										$eagle = $r->eagle;
  										$owl = $r->owl;
  									}

  								}else{
  									$status = 'kosong';
  								}



  								?>

  								<?php if($status=='ada'){ ?>
  								<td>
                    <label class="badge badge-light">
  									<?php
  									$dt = new DateTime($waktu);
  									$date = $dt->format('m/d/Y');
  									$time = $dt->format('g:i A');
  									?>

  								<?php echo date("d-m-Y", strtotime($date)); ?>
                    </label>
  								</td>
  								<td>           				
                    <label class="badge badge-light">
  									<?php echo $time; ?>
                    </label>
  								</td>
  								<td>
								
									<div class="input-group">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">P</span>
									  </div>
									  <input type="text" class="form-control" value="<?php echo $peacock; ?>" aria-label="Username" aria-describedby="basic-addon1" readonly>
									</div>				

  								</td>
  								<td>
									<div class="input-group">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">D</span>
									  </div>
									  <input type="text" class="form-control" value="<?php echo $dove; ?>" aria-label="Username" aria-describedby="basic-addon1" readonly>
									</div>						
  								</td>
  								<td>								
									<div class="input-group">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">E</span>
									  </div>
									  <input type="text" class="form-control" value="<?php echo $eagle; ?>" aria-label="Username" aria-describedby="basic-addon1" readonly>
									</div>	
  								</td>
  								<td>
  									<div class="input-group">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">O</span>
									  </div>
									  <input type="text" class="form-control" value="<?php echo $owl; ?>" aria-label="Username" aria-describedby="basic-addon1" readonly>
									</div>	
  								</td>
  								<?php }else{ ?>
  								<td>

  									<!-- <input class="form-control" value="" type="text" readonly style="width:90px;text-align:center;font-weight:bold;"> -->

  								</td>
  								<td>

  									<!-- <input class="form-control" value="" type="text" readonly style="width:90px;text-align:center;font-weight:bold;"> -->
  								</td>
  								<td>
  									<div class="input-group ">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">P</span>
									  </div>
									  <input type="text" class="form-control" value="" aria-label="Username" aria-describedby="basic-addon1" readonly>
									</div>

  								</td>
  								<td>
  									<div class="input-group ">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">D</span>
									  </div>
									  <input type="text" class="form-control" value="" aria-label="Username" aria-describedby="basic-addon1" readonly>
									</div>

  								</td>
  								<td>
  									<div class="input-group ">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">E</span>
									  </div>
									  <input type="text" class="form-control" value="" aria-label="Username" aria-describedby="basic-addon1" readonly>
									</div>

  								</td>
  								<td>
  									<div class="input-group ">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">O</span>
									  </div>
									  <input type="text" class="form-control" value="" aria-label="Username" aria-describedby="basic-addon1" readonly>
									</div>

  								</td>
  								<?php } ?>

  							</tr>

  							<?php } ?>
  							<?php } ?>
  						</tbody>

  					</table>
					</div>
				
			  </div>
			</div>

<script>
	$(document).ready(function() {
		$('#table1').DataTable({
			'scrollX': true,
			'lengthMenu': [
				[10, 25, -1],
				[10, 25, "All"]
			],
			'rowReorder': {
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
		});
	});
</script>