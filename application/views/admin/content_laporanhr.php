	<style>
	     .headcolbal {
            position: absolute;
            width: 102px;
            left: 180px;
        }
        
        .headcol {
                position: absolute;
                width: 110px;
                left: 70px;
        }
        .headcolno {
                position: absolute;
                width: 55px;
                left: 15px;
        }
        
	</style>
	
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Laporan HR</h3>
		</div>
		<div class="card-body">

			<form method="post" action="<?= base_url('admin/overtime/report_hr')?>">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Bulan</label>
              		<div class="col-sm-4">
						<select name="month" required="" class="form-control">
							<option value="">- Pilih Bulan -</option>
							<?php foreach($list_bulan as $key => $val){
								if($key == $bln){
									echo "<option value='".$key."' selected>".$val."</option>";
								}else{
									echo "<option value='".$key."'>".$val."</option>";
								}
							}?>
							
						</select>
					</div>
				</div>
				<div class="form-group row">
	              	<label class="col-sm-2 col-form-label">Tahun</label>
	              	<div class="col-sm-4">
						<?php $year = date('Y'); ?>
						<select name="year" required="" class="form-control">
							<option value="">- Pilih Tahun -</option>	  		
							<?php 
								for($y=2017; $y <= $year; $year--){ 
									if($year == $thn ){
										echo "<option value='".$year."' selected>".$year."</option>";
									}else{
										echo "<option value='".$year."'>".$year."</option>";
									}
							 } ?>


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

				<table class="table table-striped table-bordered w-100" style="margin-left: 261px;">
					<thead class="cf">
						<tr class="laphr">
							<th style="background: #3d5e6c !important;color: white;text-align: center;vertical-align: middle;height: 82px;height: 82px;height: 82px;" class="headcolno">No.</th>
							<th style="background: #3d5e6c !important;color: white;text-align: center;vertical-align: middle;height: 82px;height: 82px;" class="headcol">Name</th>
							<th style="background: #3d5e6c !important;color: white;text-align: center;vertical-align: middle;height: 82px;" class="headcolbal">Balance</th>

							<?php

							if(empty($bln) && empty($thn)){

								$bln = date("m");
								$thn = date("Y");

							}

							$jmh_hari = cal_days_in_month(CAL_GREGORIAN, $bln, $thn);


							?>

							<?php for($i=1;$i <= $jmh_hari;$i++) { ?>
							<th style="background: #3d5e6c !important;color: white;vertical-align: middle;"><?php echo $i; ?></th>
							<?php } ?>
							<th style="background: #3d5e6c !important;color: white;vertical-align: middle;">Bulan Lalu</th>
							<th style="background: #3d5e6c !important;color: white;vertical-align: middle;">Bulan Ini</th>

						</tr>
					</thead>
					<tbody>
						<?php if (!empty($hasil)) { ?>
						<?php $no = 1; ?>
						<?php
						for($x=0;$x<$jmh_user;$x++){
							echo '<tr class="laphr"><td  class="headcolno" style="background:#fafafc;">'.$no.'</td>';
					//Print Result name & their over time save
					if($hasil[$x][1] == null){ $bal = 0; }else{ $bal = $hasil[$x][1]; }
							echo '<td  class="headcol" style="background:#fafafc;">'.$hasil[$x][0].'</td><td class="headcolbal" style="background:#fafafc;">'.$bal.'</td>';
					//Looping to print their time of over time save 
							for($d=1;$d < $jmh_hari+1;$d++){
								if(strlen($d)==1){
									$d = '0'.$d;
								}
								if($hasil[$x][$d+1] > 0){
									echo '<td><a href="'.base_url('admin/overtime/detail_lembur/'.$hasil[$x][0].'/'.$thn.'-'.$bln.'-'.$d).'" class="badge badge-success">'.$hasil[$x][$d+1].'</a></td>';
								}else if ($hasil[$x][$d+1] < 0){
									echo '<td><a href="'.base_url('admin/overtime/detail_lembur/'.$hasil[$x][0].'/'.$thn.'-'.$bln.'-'.$d).'" class="badge badge-danger">'.$hasil[$x][$d+1].'</a></td>';
								}else if($hasil[$x][$d+1] == 0){
									echo '<td><a href="'.base_url('admin/overtime/detail_lembur/'.$hasil[$x][0].'/'.$thn.'-'.$bln.'-'.$d).'" class="badge badge-light">'.$hasil[$x][$d+1].'</a></td>';
								}else{
									echo '<td><a href="'.base_url('admin/overtime/detail_lembur/'.$hasil[$x][0].'/'.$thn.'-'.$bln.'-'.$d).'">'.$hasil[$x][$d+1].'</a></td>';
								}
							}
							echo '<td>'.$hasil[$x][$d+2].'</td>';
						//echo '<td>'.(($hasil[$x][1])-($hasil[$x][$d+1])).'</td>';
							echo '<td>'.$hasil[$x][$d+1].'</td>';
							$no = $no+1;
							echo '</tr>';
						}

						?>

						<?php } ?>

					</tbody>
				</table>

			</div>

		</div>
	</div>


