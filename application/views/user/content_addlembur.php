<div class="page-content" data-ng-app="" data-ng-init="msk=0;plg=0;msk2=0;plg2=0;">


	
			
			<div class="card mb-3">
				<h5 class="card-header">Apply</h5>
				<div class="card-body">
					<br>
					
					<form action="<?= base_url('user/overtime/addlembur')?>" method="post">
						<div class="panel panel-info" id="tambah" style="overflow: hidden;">

							<div class="alert alert-info" style="letter-spacing:0px;font-weight:bold;">
								<button class="close" data-dismiss="alert"></button> <b>Apply</b> : Input data untuk apply overtime hanya bisa dilakukan paling lambat 7 hari dari tanggal overtime.
							</div>
							
							<div style="padding:20px;">
								<div class="grid-body no-border">
									<br>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="form-label">Jam Overtime</label> <span class="help"></span>
												<div class="row">
													<div class="col-md-6">
														<div class="input-with-icon right">
															<i class=""></i> <input class="form-control" id="tgl" name="tgl" required="" type="date">
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="form-label">Jam Awal</label><br>
														<input type="time" ng-model="msk" name="msk" class="form-control" id='msk' onchange='cek_minutes_msk()' required>
														<input id="nilai" min="0" name="nilai" type="hidden" value="{{ (plg | date:'HH') - (msk | date:'HH') }}">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="form-label">Jam Akhir</label><br>
														<input type="time" ng-model="plg" name="plg" class="form-control" id='plg' onchange='cek_minutes_plg()' required>
														<input id="nilai"  name="plus" type="hidden" value="{{ (plg | date:'mm') - (msk | date:'mm') }}" >
													</div>
												</div>

											</div>
										</div><!-- col-md-6-->
										<div class="col-md-6">
											<h1 style="color:#0d4e6c;">Durasi Overtime</h1>
											<div style="text-align: center;font-size: 50px;margin-top: 10px;border: 1px solid lightgray;padding-top:20px;padding-bottom:20px;" class="ng-binding"> {{ (plg | date:'HH') - (msk | date:'HH') }} <span style="font-size:20px;">Jam</span> {{ (plg | date:'mm') - (msk | date:'mm') }} <span style="font-size:20px;">Menit</span></div>
										</div>
									</div><!-- angularjs-->

									<div class="form-group">
										<label class="form-label">Tujuan Overtime</label> <span class="help">e.g. "Tele"</span>
										<div class="input-with-icon right">
											<i class=""></i> 
											<textarea class="form-control" id="deskrispi" name="deskripsi" rows="5" required></textarea>
										</div>
									</div>
									<div class="form-actions">
										<div class="pull-right" style="margin-bottom: 30px;">
											<button class="btn btn-primary btn-cons" type="submit"><i class="icon-ok"></i> Save</button>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</form>
					
					
					
					
				</div>
			</div><!-- END CARD-->
			
			

			<div class="alert alert-info" style="letter-spacing:0px;font-weight:bold;">
				<button class="close" data-dismiss="alert"></button> Info: List Approve & Reject akan selalu otomatis terhapus +7 Hari setelah HR Melakukan Approved.
			</div>
					
			<div class="card">
				<div class="card-body">					
					<div style="overflow-x:scroll;">

						<table class="table table-striped table-bordered w-100" id="table1">
							<thead class="text-center">
								<tr style="background: #0d4e6c;color: white;">
									<th class="text-center">No</th>
									<th>Tanggal</th>
									<th class="text-center">Durasi</th>
									<th class="text-center">Tujuan</th>
									<th class="text-center">Menunggu Acc</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody class="text-center">
								<?php 
								if(!empty($hsl)){ 
									$no = 1;
									foreach ($hsl as $r){ 
										?>
										<tr>
											<td class="text-center" style="vertical-align:middle;"><?php echo $no; ?></td>
											<td style="vertical-align: middle;"><div style=""><?php echo strtoupper(date("d-M-Y", strtotime($r->tgl))); ?></div></td>
											<td style="vertical-align: middle;text-align:center;">
												<label class="badge teal"><?php echo $r->nilai; ?> Jam</label>
											</td>
											<?php $desc = explode("</jam>",$r->deskripsi); ?>
											<td class="text-center"><?php echo $desc[0].'</jam>'; ?> <button type="button" data-content="<?php echo $desc[1]; ?>" id="popover" title="" data-toggle="popover" class="btn btn-primary" data-placement="top" data-original-title="Tujuan" data-trigger="hover">...</button> </td>
											<td class="text-center" style="vertical-align: middle;">
												<?php 
												if($r->acc_hr == 'ya'){ 
													echo "-";
												}else if($r->acc_hr == 'tidak'){ 
													echo "-"; 
												}else if($r->status == 'ya'){ 
													echo "<label class='badge cyan darken-4'>HR</label>";
												}else if($r->status == 'tidak'){ 
													if($r->nilai > 2){ 
														echo "-"; 
													}else{ 
														echo "-"; 
													} 
												}else if (($r->nilai > 2) && ($r->status == null)){
													echo "<label class='badge teal lighten-1'>MANAGER</label>";
												}else if(($r->nilai <= 2) && ($r->status == null)){ 
													echo "<label class='badge light-blue darken-3'>SUPERVISOR</label>";
												}else{ 
													echo "-"; 
												} 
												?> 
											</td>
											<td style="vertical-align: middle;">
												<?php 
												if($r->acc_hr == 'ya'){ 
													echo "<label class='badge badge-success'>APPROVED </label> | ".date('d-M-Y', strtotime($r->tgl_approved)).""; 
												}else if($r->acc_hr == 'tidak'){ 
													echo "<label class='badge badge-danger'>REJECT BY HR</label>";
												}else if($r->status == 'ya'){
													echo "<label class='badge badge-light'>WAITING</label>";
												}else if($r->status == 'tidak'){ 
													if($r->nilai > 2){ 
														echo "<label class='badge badge-danger' style='cursor:default;'>REJECT BY MANAGER</label>";
													}else{ 
														echo "<label class='badge badge-danger' style='cursor:default;'>REJECT BY SPV</label>";
													} 
												}else{ 
													echo "
													<label class='badge badge-light'>WAITING</label> | 
													<a onclick='edit(".$r->id.")' class='btn btn-warning'><i class='fa fa-edit'></i>&nbsp;EDIT</a> 
													<a onclick='hapus(".$r->id.")' class='btn btn-danger'><i class='fa fa-trash'></i>&nbsp;DELETE</a>";
												}
												?>
											</td>
										</tr>
										<?php $no++; 
									} 
								}
								?>
							</tbody>
						</table>

					</div>

				</div>
			</div><!-- END CARD-->
	



	<div class="modal fade" tabindex="-1" id="modalEdit" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="<?= base_url('user/overtime/editlembur')?>" method="post" class="form-horizontal" style="width:100%">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Form Edit Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="id" id="id_edit" value="">
						<div class="col">	
							<div class="form-group">
								<label class="col-form-label">Tanggal Overtime</label>
								<input class="form-control" id="tgl_edit" name="tgl" required="" type="date">
							</div>
							<div class="form-group">
								<label class="col-form-label">Jam Awal</label>
								<input type="time" ng-model="msk2" name="msk2" class="form-control" id="msk2" required>
								<input id="nilai1" min="0" name="nilai" type="hidden" value="{{ (plg2 | date:'HH') - (msk2 | date:'HH') }}">
							</div>
							<div class="form-group">
								<label class="col-form-label">Jam Akhir</label>
								<input type="time" ng-model="plg2" name="plg2" class="form-control" id="plg2" required>
								<input  id="nilai2" name="plus" type="hidden" value="{{ (plg2 | date:'mm') - (msk2 | date:'mm') }}">
							</div>
							<div class="form-group">
								<label class="col-form-label">Tujuan Overtime</label>
								<textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
							</div>
							<div class="form-group">
								<label class="col-form-label">Durasi Overtime</label>
								<div style="text-align: center;font-size: 30px;" class="ng-binding">  
									{{ (plg2 | date:'HH') - (msk2 | date:'HH') }} <span style="font-size:20px;">Jam</span> : {{ (plg2 | date:'mm') - (msk2 | date:'mm') }} <span style="font-size:20px;">Menit</span>
								</div>
							</div>

						</div>
					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
					</div>
				</form>				
			</div>

		</div>
	</div>
</div><!-- END CONTAINER -->

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

<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover(); 
	});

	function reload_page(){
		window.location.reload();
	}

	function edit(id){
		reset();
		$.ajax({
			url: "<?= base_url('user/overtime/json_get_data_overtime')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				// console.log(result.data.id);
				$('#tgl_edit').val(result.data.tgl);
				$('#id_edit').val(result.data.id);
				$('#deskripsi').val(result.deskripsi);
				$('#modalEdit').modal('show');
			}, error: function(e){
				console.log(e);
			}
		})
	}

	function hapus(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Data Overtime akan dihapus, lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('user/overtime/deletelembur')?>",
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

	function reset(){
		$('#id_edit, #deskripsi, #tgl_edit').val('');
	}
	
	function cek_minutes_msk()
	{
	    var minutes = $('#msk').val();
        var minute = minutes.substr(3, 4);
        var hour = minutes.substr(0, 2);
	   // console.log(minutes);
	   // console.log(res);
	   
	   if(hour != null && minute == '30')
	   {
	   //   document.getElementById("msk").value = "";
	        console.log('bisa')
	   }else if(hour != null && minute == '00'){
	       console.log('bisa')
	   }else{
	        document.getElementById("msk").value = "";
	        console.log('gak bisa')
	   }
	}
	
	function cek_minutes_plg()
	{
	    var minutes = $('#plg').val();
        var minute = minutes.substr(3, 4);
        var hour = minutes.substr(0, 2);
	   // console.log(res);
	   
	   if(hour != null && minute == '30')
	   {
	   //   document.getElementById("msk").value = "";
	        console.log('bisa')
	   }else  if(hour != null && minute == '00'){
	       console.log('bisa')
	   }else{
	        document.getElementById("plg").value = "";
	        console.log('gak bisa')
	   }
	}


</script>