<div class="card">
	<div class="card-header">
		<h3 class="card-title">Acc Nomerator</h3>
	</div>
	<div class="card-body">
		<hr>
        <?php if (!empty($results)) { ?>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead>
					<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
						<th class="text-center">No</th>
						<th class="text-center" style="width:150px;">Tanggal</th>
						<th style="width:100px;">Nomerator</th>
						<th class="text-center">Peserta</th>
						<th class="text-center">Program</th>
						<th style="text-align:center;min-width: 160px;">Jumlah</th>
                        <th>Sales</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody class="text-center">
                    <?php 
                    $no = 1;
                    foreach($results as $row){ 
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo date('d-M-Y',strtotime($row->date)) ?></td>
                        <td><?php echo $row->nomerator ?></td>
                        <td><?php echo $row->nama_peserta ?></td>
						<td><?php echo $row->program ?></td>
                        <td>Rp. <?php echo number_format($row->jumlah) ?></td>
                        <td><?php echo $row->name ?></td>
                        <td nowrap="nowrap" style="vertical-align: middle;">
							<?php if ($row->status_acc == '') { ?>
								<a onclick="approve(<?= $row->id ?>)" class="btn btn-primary">
									APPROVE</a> |
								<a onclick="reject(<?= $row->id ?>)" class="btn btn-danger">REJECT</a>
							<?php } elseif ($row->status_acc == 'ya') { ?>
								<button class="btn btn-primary" style="cursor:default;">APPROVED</button>
							<?php } else { ?>
								<button class="btn btn-danger" style="cursor:default;">REJECTED</button>
							<?php } ?>
						</td>
                    </tr>
                    <?php } ?>
				</tbody>
			</table>
			<?php }else{
				echo "<center><p>Data Not Found</p></center>";
			} ?>
		</div>
	</div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script type="text/javascript">
	$('#table1').DataTable({
        'scrollX': true,
        'lengthMenu': [
            [10, 15, 20, -1],
            [10, 15, 20, "All"]
        ],
        'rowReorder': {
            'selector': 'td:nth-child(2)'
        },
        'responsive': true,
        'stateSave': true
    });

	function reload_page() {
		window.location.reload();
	}

	function approve(id) {
		if (id != '') {
			swal({
				title: 'Approve Nomerator',
				text: "Setujui Nomerator ini?",
				type: 'info',
				showCancelButton: true,
				confirmButtonColor: '#4285f4',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result) {
				if (result) {
					$.ajax({
						url: "<?= base_url('finance/nomerator/toapprove_nomerator') ?>",
						type: "POST",
						dataType: "json",
						data: {
							'id': id
						},
						success: function(result) {
							reload_page();
						},
						error: function(e) {
							console.log(e);
						}
					})
				}
			});
		}
	}

	function reject(id) {
		if (id != '') {
			swal({
				title: 'Konfirmasi',
				text: "Reject Nomerator.\n Lanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya'
			}, function(result) {
				if (result) {
					$.ajax({
						url: "<?= base_url('finance/nomerator/toreject_nomerator') ?>",
						type: "POST",
						dataType: "json",
						data: {
							'id': id
						},
						success: function(result) {
							reload_page();
						},
						error: function(e) {
							console.log(e);
						}
					})
				}
			});
		}
	}
</script>