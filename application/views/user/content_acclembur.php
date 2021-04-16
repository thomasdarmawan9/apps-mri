  	<div class="card">
  		<h5 class="card-header">Apply List</h5>
  		<div class="card-body">

  			<div class="alert alert-info" role="alert">
  				Data yang sudah diproses tidak dapat dikembalikan, maka bisa <b>pastikan sebelum melakukan Approve atau Reject</b>.<br>
  				Spv mempunyai Hak Approve Max 2 Jam untuk Overtime dalam 1 Hari.
  			</div>
  			<hr> 
  			<div class="table-responsive">
  				<table class="table table-striped w-100" id="table1">
  					<thead class="text-center">
  						<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
  							<th>No</th>
  							<th>User</th>
  							<th>Date</th>
  							<th>Overtime</th>
  							<th>Description</th>		                 
  							<th>Status</th>

  						</tr>
  					</thead>
  					<tbody class="text-center">
  						<?php if(!empty($hsl)){ ?>
  						<?php $no = 1; ?>
  						<?php foreach ($hsl as $r) { ?>
  						<tr>
  							<td style="vertical-align: middle;"><?php echo $no; ?></td>
  							<td style="vertical-align: middle;"><?php echo ucfirst($r->username); ?></td>
  							<td style="vertical-align: middle;"><?php echo strtoupper(date("d-M-Y", strtotime($r->tgl))); ?></td>
  							<td style="vertical-align: middle;"><?php echo $r->nilai; ?></td>
  							<?php $desc = explode("</jam>",$r->deskripsi); ?>
  							<td style="vertical-align: middle;"><?php echo $desc[0].'</jam>'; ?> <button type="button" data-content="<?php echo $desc[1]; ?>" id="popover" title="" data-toggle="popover" class="btn btn-info" data-placement="top" data-original-title="Tujuan" data-trigger="hover">...</button> </td>
  							<td style="vertical-align: middle;">

  								<?php if($r->lass == null){ ?>
  								<a onclick="approve(<?= $r->idt?>)" class="btn btn-primary">
  									APPROVE</a> | 
								<a onclick="reject(<?= $r->idt?>)" class="btn btn-danger">REJECT</a>
  								<?php }elseif($r->lass == 'ya'){ ?>
  								<button class="btn btn-primary" style="cursor:default;">APPROVED</button>
  								<?php }else{ ?>
  								<button class="btn btn-danger" style="cursor:default;">REJECTED</button>
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

  	<script>
  		$(document).ready(function(){
  			$('[data-toggle="popover"]').popover(); 
  		});

  		$('#table1').DataTable({
  			'scrollX':true,
  			'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]
  			],
  			'rowReorder': {
  				'selector': 'td:nth-child(2)'
  			},
  			'responsive': true,
  			'stateSave': true
  		});

  		function reload_page(){
  			window.location.reload();
  		}

  		function approve(id){
  			if(id != ''){
  				swal({
  					title: 'Approve Pengajuan',
  					text: "Setujui Pengajuan Overtime?",
  					type: 'info',
  					showCancelButton: true,
  					confirmButtonColor: '#4285f4',
  					cancelButtonColor: '#d33',
  					confirmButtonText: 'Ya'
  				}, function(result){
  					if (result) {         
  						$.ajax({
  							url: "<?= base_url('user/overtime/toapprove_lembur_spv')?>",
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

  		function reject(id){
  			if(id != ''){
  				swal({
  					title: 'Konfirmasi',
  					text: "Reject Pengajuan Overtime.\n Lanjutkan?",
  					type: 'warning',
  					showCancelButton: true,
  					confirmButtonColor: '#f35958',
  					cancelButtonColor: '#d33',
  					confirmButtonText: 'Ya'
  				}, function(result){
  					if (result) {         
  						$.ajax({
  							url: "<?= base_url('user/overtime/toreject_lembur_spv')?>",
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

