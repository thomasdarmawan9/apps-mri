    <div class="card">
    	<div class="card-header">
    		<h4 class="card-title">Event Baru</h4>
    	</div>
    	<div class="card-body">
    		<form method="post" action="<?= base_url('support/task/add_newevent')?>">
    			<div class="form-group row">
    				<label class="col-form-label col-sm-2">Nama Event</label>
    				<div class="col-sm-4">
    					<input class="form-control input-lg" type="text" placeholder="Nama Event" name="name" required="">
    				</div>
    			</div>
    			<div class="form-group row">
    				<label class="col-form-label col-sm-2">Komisi DP</label>
    				<div class="col-sm-4">
    					<input class="form-control input-lg" type="number" placeholder="Komisi Dp" name="dp">
    				</div>
    			</div>
    			<div class="form-group row">
    				<label class="col-form-label col-sm-2">Komisi Lunas</label>
    				<div class="col-sm-4">
    					<input class="form-control input-lg" type="number" placeholder="Komisi Lunas" name="lunas">
    				</div>
    			</div>
    			<div class="form-group row">
    				<label class="col-form-label col-sm-2"></label>
    				<div class="col-sm-4">
    					<button class="btn btn-primary" type="submit">Tambah</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
    <div class="card mt-4">
    	<div class="card-header">
    		<h4 class="card-title">Daftar Incentive Event</h4>
    	</div>
    	<div class="card-body">
    			<div class="table-responsive">
    				<table class="table table-striped table-bordered w-100" id="table1">
    					<thead class="text-center">
    						<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
    							<th class="text-center">No.</th>
    							<th>Nama Event</th>
    							<th>Dp</th>
    							<th>Lunas</th>
    							<th>Aksi</th>
    						</tr>
    					</thead>
    					<tbody class="text-center">
    						<?php $no = 1; ?>
    						<?php foreach($results as $r){ ?>
    						<tr>
    							<td class="text-center"><?php echo $no; ?></td>
    							<td><?php echo ucwords($r->name); ?></td>
    							<td><?php echo 'Rp '.number_format($r->dp); ?></td>
    							<td><?php echo 'Rp '.number_format($r->lunas); ?></td>
    							<td><a onclick="hapus(<?= $r->id?>)"><button class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete</button></a></td>
    						</tr>
    						<?php $no = $no+1; ?>
    						<?php } ?>
    					</tbody>
    				</table>




    			</div>
    		</div>

    	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#table1').DataTable({
				'scrollX':true,
				'lengthMenu': [[10, 15, 25, -1], [10, 15, 25, "All"]
				],
				'rowReorder': {
    				'selector': 'td:nth-child(2)'
    			},
    			'responsive': true,
    			'stateSave': true
			});

			
		});

		function reload_page(){
			window.location.reload();
		}

		function hapus(id){
			if(id != ''){
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
							url: "<?= base_url('support/task/delete_event_incent')?>",
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