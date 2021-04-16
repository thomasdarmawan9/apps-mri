	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Report Incentive</h3>
		</div>
		<div class="card-body">
			<div class="alert alert-info" style="letter-spacing:0px;">
				<button class="close" data-dismiss="alert"></button>
				Info: List Event akan selalu otomatis terhapus +7 Hari setelah Tanggal Event.
			</div>
			<!-- <h4 class='card-title'>Hak Akses PD</h4> -->
			<div class="table-responsive">
				<table class="table w-100" id="table1">
					<thead class="text-center">
						<tr style="background-color: #0d4e6c;color:#fff;">
							<th class="text-center">No</th>
							<th>Event</th>
							<th>Lokasi</th>
							<th>Tanggal</th>
							<th>Jumlah Closing</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php if(!empty($results)){ ?>
						<?php $no=1; ?>
						<?php foreach ($results as $r){ ?>
						<tr>
							<td class="text-center"><?php echo $no; ?></td>
							<td><?php echo $r->event; ?></td>
							<td><?php echo $r->location; ?></td>
							<td><?php echo date("d-M-Y", strtotime($r->date)); ?></td>
							<td>



								<?php
								$this->db->where('id_task',$r->id_task);
								$query = $this->db->get('incentive');

								if ($query -> num_rows() == null){?>

								<form action="<?= base_url('user/incentive/report_jumlah')?>" method="post">
									<div style="display:none;">
										<input type="text" name="id" value="<?php echo $r->id_task; ?>">
										<input type="text" name="token" value="<?php echo md5($r->id_task); ?>">
									</div>
									<div class="form-group form-inline">
										<input type="number" name="jmh" class="form-control col-sm-2" required>
										<div class="col-sm-4">
											<button type="submit" class="btn teal"> Report Incentive</button>
										</div>
									</div>

								</form>

								<?php }else{ ?>
								<div class="form-group form-inline">
									<input type="number" name="jmh" value="<?php echo $query -> num_rows(); ?>" class="form-control col-sm-2" disabled>
									<div class="col-sm-4">
										<a href="<?= base_url('user/incentive/report_detail/'.$r->id_task.'/'.md5($r->id_task))?>"> <button type="button" class="btn btn-info"><i class="fa fa-edit"></i>&nbsp; Edit</button></a>
									</div>
								</div>

								<?php } ?>

							</td>
						</tr>
						<?php $no= $no + 1; ?>
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>

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
