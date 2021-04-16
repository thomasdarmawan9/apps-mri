	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Detail Overtime</h3>
		</div>
		<div class="card-body">
			
			
			
			
			<h5 class="card-title">
				User &emsp;&emsp;&emsp;: &nbsp;<label class='badge badge-info'><?= $user?></label> <br>
				Tanggal &emsp;: &nbsp;<label class='badge badge-info'><?= $tgl; ?></label>
			</h5>

			
			<table class="table table-hover no-more-tables">
				<thead>
					<tr>
						<th>No.</th>
						<th>Tanggal</th>
						<th>Deskripsi</th>
						<th>Nilai</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; $total = 0; ?>
					<?php foreach($results as $r) { ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $r->tgl; ?></td>
						<td><?php echo $r->deskripsi; ?></td>
						<td><?php echo $r->nilai; ?></td>
						<td><a onclick="hapus('<?= $r->id?>')"><button type="button" class="btn  btn-danger" id="showtambah"><i class="fa fa-trash"></i> Hapus</button></a></td>
					</tr>
					<?php $total = $total + $r->nilai; ?>
					<?php $no = $no + 1; ?>
					<?php } ?>
					<tr>
						<td colspan="3" style="background: #33b5e5;color: white;"><b>TOTAL OVERTIME</b></td>
						<td style="background: #33b5e5;color: white;" ><b><?php echo $total ?></b></td>
						<td style="background: #33b5e5;color: white;" ></td>
					</tr>
				</tbody>
			</table>


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
							url: "<?= base_url('admin/overtime/delete_detail')?>",
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
