<style type="text/css">
	.border-left-div {
		border-left: 2px solid #333;
		/*margin-left: 2px;*/
	}
</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />

<div class="card">
	<div class="card-header">
		<h3 class="card-title">History Transfer</h3>
	</div>
	<div class="card-body">
		
		<a class="btn btn-dark" id="add_transfer"><i class="fa fa-user-plus"></i>&nbsp; Add Transfer</a>
		<hr>
	
		<div class="table-responsive">
			<?php if ((!empty($results))) { ?>

				<table class="table table-bordered w-100" id="table1">
					<thead class="text-center">
						<tr style="background-color: #0d4e6c;color:#fff;">
							<th>No</th>
							<th>Transfer Date</th>
							<th>Transfer From/To</th>
							<th>Type</th>
							<th>Description</th>
							<th>Transfer In</th>
							<th>Transfer Out</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php
							$no = 1;
							foreach ($results as $row) { ?>
							<tr>
								<td><?php echo $no++ ?></td>
								<td><?php echo $row->tgl_nota ?></td>
								<td><?php echo $row->bank ?></td>
								<?php if ($row->jenis == 'income') { ?>
									<td><label class='badge badge-success'>Transfer</label></td>
								<?php	} else { ?>
									<td><label class='badge badge-danger'>Transfer</label></td>
								<?php } ?>
								<td><?php echo $row->transaksi ?></td>
								<td>Rp.<?php echo number_format($row->income, 2) ?></td>
								<td>Rp.<?php echo number_format($row->expense, 2) ?></td>
    							<?php
                                $this->db->where('id', 1);
                                $query = $this->db->get('fc_transaction_setting');
                
                                foreach ($query->result() as $r) {
                                  $block = $r->id_bank;
                                }
                
                                $bank_table   = $row->id_bank;
                
                               if (($bank_table == $block) && ($this->session->userdata('id') != '67')) { ?>
									<td><span class="badge grey">Locked</span></td>
								<?php } else { ?>
									<td>
										<a href=<?php echo base_url('finance/transfer/delete_transfer/' . $row->transfer_code) ?>>
											<button type='button' class='btn btn-danger delete_transfer'><i class='fa fa-trash'></i> DELETE</button></a>
									</td>
								<?php } ?>
							</tr>
						<?php	}
							?>

					</tbody>
				</table>
			<?php } else {
				echo "<center><p>Data Not found</p></center>";
			} ?>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_add_transfer" data-backdrop="static" data-keyboard="false" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?= base_url('finance/transfer/submit_form_transfer') ?>" method="post" id="form_add_transfer" style="padding-left:15px;padding-right: 15px;">
				<div class="modal-header" style="background-color:#17a2b8;color:#fff">
					<h4 class="modal-title" id="header_transfer">TRANSFER TRANSACTION</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="card">
						<input type="hidden" name="transfer_code" id="transfer_code" value="">
						<div class="card-body">

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Bank From</label>
								<div class="col-sm-8">
									<select class="form-control" name="bank_from" id="bank_from" required="">
										<option value="">- Choose an option -</option>
										<?php foreach ($bank_detail as $row) {
											echo "<option value='" . $row->id_bank . "'>" . ucfirst($row->name) . "</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">PT</label>
								<div class="col-sm-8">
									<select class="form-control" name="id_pt" id="id_pt" required="" readonly>
										<option value="">- Choose an option -</option>

									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Bank To</label>
								<div class="col-sm-8">
									<select class="form-control" name="bank_to" id="bank_to" required="">
										<option value="">- Choose an option -</option>
										<?php foreach ($bank as $row) {
											echo "<option value='" . $row->id_bank . "'>" . ucfirst($row->name) . "</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Date Transfered</label>
								<div class="col-sm-8">
									<input name="tgl_nota" id="tgl_nota" class="form-control datepicker" type="input" placeholder="Date Transfered" required="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Description</label>
								<div class="col-sm-8">
									<input name="description" id="description" class="form-control" required="" type="text" placeholder="" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Amount Transferred</label>
								<div class="col-sm-8">
									<input name="amount" id="amount" class="form-control numeric" type="text" onkeyup="count_total();" placeholder="" autocomplete="off">
								</div>
							</div>


						</div>
						<div class="card text-white elegant-color" style="border-radius: 0px;">
							<div class="card-body text-right text-white py-2">
								<span>Total :</span>
								<input name="test" id="test" type="text" placeholder="" autocomplete="off" value="0" readonly style="text-align: center">
							</div>
						</div>
					</div>
					<div class="card mt-3">
						<div class="card-body">
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Bank</label>
								<div class="col-sm-8">
									<select class="form-control" name="bank_name" id="bank_name" required="" readonly>
										<option value="">- Choose an option -</option>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">PT</label>
								<div class="col-sm-8">
									<select class="form-control" name="pt_name" id="pt_name" required="" readonly>
										<option value="">- Choose an option -</option>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Atas Nama</label>
								<div class="col-sm-8">
									<select class="form-control" name="atas_nama" id="atas_nama" required="" readonly>
										<option value="">- Choose an option -</option>
									</select>
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" id="submit">Submit</button>
						<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
					</div>
			</form>
		</div>

	</div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<script>
	$(document).ready(function() {

		$(document).ajaxStart(function() {
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function() {
			$("#wait").css("display", "none");
		});

		$('[data-toggle="tooltip"]').tooltip();
		$('#table1').DataTable({
			'scrollX': true,
			'lengthMenu': [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			'rowReorder': {
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
		});

	});

	$(".datepicker").datepicker({
		changeYear: true,
		changeMonth: true,
		dateFormat: 'yy-mm-dd',
	});

	function reload_page() {
		window.location.reload();
	}

	$('#add_transfer').click(function() {
		$('#modal_add_transfer').modal('show');

	});

	/*function isi_bank_from() {
		var bank_from = $("#bank_from").val();
		$.ajax({
			url: '<?= base_url('finance/transfer/get_autocomplete_bank_from_test') ?>',
			data: "bank_from=" + bank_from,
			success: (function(data) {
				var json = data,
					obj = JSON.parse(json);
				var result = obj.id_pt;
				document.getElementById('id_pt').value = result;
			})
		})
	}*/

	$('#bank_from').change(function() {
		init_pt_from();
	});

	function init_pt_from() {
		var bank_from = $('#bank_from').val();

		$('#id_pt').empty();
		$.ajax({
			url: "<?= base_url('finance/transfer/get_autocomplete_bank_from') ?>",
			type: "POST",
			dataType: "json",
			data: {
				'bank_from': bank_from
			},
			success: function(result) {
				$.each(result, function(index, item) {
					$('#id_pt').append('<option value="' + item.id_pt + '">' + item.pt + '</option>');

				});

			},
			error: function(e) {
				console.log(e);
			}
		})

	}

	$('#bank_to').change(function() {
		init_pt_to();
	});

	function init_pt_to() {
		var bank_to = $('#bank_to').val();

		$('#bank_name').empty();
		$('#pt_name').empty();
		$('#atas_nama').empty();

		$.ajax({
			url: "<?= base_url('finance/transfer/get_autocomplete_bank_to') ?>",
			type: "POST",
			dataType: "json",
			data: {
				'bank_to': bank_to
			},
			success: function(result) {
				$.each(result, function(index, item) {
					$('#bank_name').append('<option value="' + item.id_bank + '">' + item.name + '</option>');
					$('#pt_name').append('<option value="' + item.id_pt + '">' + item.pt + '</option>');
					$('#atas_nama').append('<option value="' + item.id_bank + '">' + item.atas_nama + '</option>');
				});

			},
			error: function(e) {
				console.log(e);
			}
		})

	}

	function count_total() {

		var txtFirstNumberValue = document.getElementById('amount').value;
		var txtFourthNumberValue = document.getElementById('before').value;
		var resultss = parseFloat(txtFirstNumberValue) + parseFloat(txtFourthNumberValue);
		if (!isNaN(result)) {
			document.getElementById('after').value = resultss;
		} else {
			document.getElementById('after').value = txtSecondNumberValue;
		}
	}


	$('.numeric').keyup(function(e) {
		if (/\D/g.test(this.value)) {
			this.value = this.value.replace(/\D/g, '');
		}
		var result = document.getElementById('amount').value;
		document.getElementById('test').value = result;
	});
</script>