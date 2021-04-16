<div class="card">
	<div class="card-header">
		<h3 class="card-title">Monthly Report</h3>
	</div>
	<div class="card-body">
		<h4>Filter Data</h4>

		<form method="get" action="<?= base_url('finance/report?') ?>">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Date Start</label>
						<div class="col-sm-8">
							<input type="text" name="date_start" id="date_start" class="form-control" placeholder="Select Date" value="<?= !empty($this->input->get('date_start')) ? $this->input->get('date_start') : '' ?>" autocomplete="off" required>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Bank</label>
						<div class="col-sm-8">
							<select class="form-control" name="id_bank" id="id_bank" style="width: 100%;">
								<option value="all">All</option>
								<?php
								foreach ($bank as $row) {
									if ($row->id_bank == $this->input->get('id_bank')) {
										echo "<option value='" . $row->id_bank . "' selected>" . ucfirst($row->name) . "</option>";
									} else {
										echo "<option value='" . $row->id_bank . "'>" . ucfirst($row->name) . "</option>";
									}
								}
								?>

							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Divisi</label>
						<div class="col-sm-8">
							<select class="form-control js-example-basic-single" name="id_divisi" id="id_divisi" style="width: 100%;">
								<option value="all">All</option>
								<?php
								foreach ($divisi as $row) {
									if ($row->id_divisi == $this->input->get('id_divisi')) {
										echo "<option value='" . $row->id_divisi . "' selected>" . ucfirst($row->nama_divisi) . "</option>";
									} else {
										echo "<option value='" . $row->id_divisi . "'>" . ucfirst($row->nama_divisi) . "</option>";
									}
								}
								?>

							</select>
						</div>
					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Date End</label>
						<div class="col-sm-8" id="div_date_end">
							<input type="text" name="date_end" id="date_end" class="form-control" placeholder="Select Date" value="<?= !empty($this->input->get('date_end')) ? $this->input->get('date_end') : '' ?>" autocomplete="off" required>
						</div>
					</div>

					<div class="form-group row">
						<label class=" col-form-label col-sm-4">Indeks</label>
						<div class="col-sm-8">
							<select class="form-control js-example-basic-single" name="id_indeks" id="id_indeks" required="" style="width:100%">
								<option value="all">All</option>
								
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-sm-4"></label>
						<div class="col-sm-4">
							<div class="custom-control custom-checkbox">
								<?php if ($this->input->get('add_index') == 'on') { ?>
									<input type="checkbox" class="custom-control-input" id="add_index" name="add_index" checked="checked">
									<label class="custom-control-label" for="add_index">Add Index</label>
								<?php } else { ?>
									<input type="checkbox" class="custom-control-input" id="add_index" name="add_index">
									<label class="custom-control-label" for="add_index">Add Index</label>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="form-group row" id="show_index">
						<label class=" col-form-label col-sm-4">Indeks</label>
						<div class="col-sm-8">
							<select class="form-control js-example-basic-single" name="index" id="index" style="width:100%">
								<option value="all">All</option>
								<?php
								foreach ($indeks as $row) {
									if ($row->id_indeks == $this->input->get('index')) {
										echo "<option value='" . $row->id_indeks . "' selected>" . ucfirst($row->nama_indeks) . "</option>";
									} else {
										echo "<option value='" . $row->id_indeks . "'>" . ucfirst($row->nama_indeks) . "</option>";
									}
								}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class=" col-form-label col-sm-4">Transfer</label>
						<div class="col-sm-8">
							<select class="form-control" name="is_transfer" id="is_transfer" style="width:100%">
								<?php if (($this->input->get('is_transfer') == 'all') || (($this->input->get('is_transfer') == null))) { ?>
									<option value="all" selected>All</option>
									<option value="0">No</option>
									<option value="1">Yes</option>
								<?php	} else if ($this->input->get('is_transfer') == '0') { ?>
									<option value="all">All</option>
									<option value="0" selected>No</option>
									<option value="1">Yes</option>
								<?php } else if ($this->input->get('is_transfer') == '1') { ?>
									<option value="all">All</option>
									<option value="0">No</option>
									<option value="1" selected>Yes</option>
								<?php } ?>

							</select>
						</div>
					</div>

				</div>

			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label"></label>
				<div class="col-sm-6">
					<button type="submit" class="btn primary-color-dark" id="filter"><i class="fa fa-search"></i>&nbsp; FILTER</button>
					<button type="button" class="btn btn-success" id="export" title='Harap tekan tombol filter terlebih dahulu sebelum export data' data-toggle='tooltip' data-placement='right'><i class="fa fa-file-excel"></i>&nbsp; Export to Excel</button>
				</div>
			</div>
		</form>

		<!-- <div class="form-group row"> 
			<label class="col-sm-2 col-form-label"></label>
			<div class="col-sm-6">
				<button id="addindex" class="btn btn-warning "><i class="fa fa-plus"></i>&nbsp;ADD INDEX</button>
				<button onclick="return hapus_index()" class="btn btn-warning "><i class="fa fa-plus"></i>&nbsp;ADD INDEX</button> 
			</div>
		</div>-->

		<div class="table-responsive">
			<?php if ((!empty($results))) { ?>
				<table class="table table-bordered w-100" id="table1">
					<thead class="text-center">
						<tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
							<th class="text-center" style="vertical-align: middle;">No</th>
							<th style="vertical-align: middle">Date</th>
							<th style="vertical-align: middle">Receipt Number</th>
							<th style="vertical-align: middle">Payment Source</th>
							<th style="vertical-align: middle">Type</th>
							<th style="vertical-align: middle">Index</th>
							<th style="vertical-align: middle">Bon</th>
							<th style="vertical-align: middle">Transaction</th>
							<th style="vertical-align: middle">Qty</th>
							<th style="vertical-align: middle">Price</th>
							<th style="vertical-align: middle">Total</th>
							<th style="vertical-align: middle">Action</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php
							$no = 1;
							foreach ($results as $row) {
								echo "<tr style='font-size:0.9rem;'>";
								echo "<td class='text-center'>" . $no++ . "</td>";
								echo "<td>" . $row['tgl_nota'] . "</td>";
								echo "<td>" . $row['receipt_number'] . "</td>";
								echo "<td>" . $row['bank'] . "</td>";
								echo "<td>" . ucwords($row['jenis']) . "</td>";
								echo "<td>" . $row['nama_indeks'] . "</td>";
								echo "<td>" . ucwords($row['bon']) . "</td>";
								echo "<td>" . $row['transaksi'] . "</td>";
								echo "<td>" . number_format($row['jumlah']) . "</td>";
								echo "<td>Rp." . number_format($row['harga'], 2) . "</td>";
								// echo "<td>Rp." . $row['harga'] . "</td>";
								if ($row['jenis'] == 'income') {
									echo "<td>Rp." . number_format($row['income'], 2) . "</td>";
								} else {
									echo "<td>Rp." . number_format($row['expense'], 2) . "</td>";
								}

							    $this->db->where('id', 1);
    							$query = $this->db->get('fc_transaction_setting');
    
    							foreach ($query->result() as $r) {
    								$block = $r->id_bank;
    							}
    
    							$bank_table   = $row['id_bank'];
    
    							if (($bank_table == $block) && ($this->session->userdata('id') != '67')) {
									echo "<td nowrap='nowrap'>
									<button type='button' id='detail_trx' class='btn btn-blue-grey' onclick='detail_trx(" . $row['id_trans'] . "); hidden;'><i class='fa fa-info'></i> DETAIL</button>
									<button type='button' id='hapus_trx' class='btn btn-danger' onclick='hapus_trx(" . $row['id_trans'] . "); hidden;'><i class='fa fa-trash'></i> DELETE</button>
									</td>";
								} else {
									echo "<td nowrap='nowrap'>
    								<a href='" . base_url('finance/report/edit_report/' . $row['id_trans'] . '?' . http_build_query(array('date_start' => !empty($this->input->get('date_start')) ? $this->input->get('date_start') : '', 'date_end' => !empty($this->input->get('date_end')) ? $this->input->get('date_end') : '', 'id_bank' => $row['id_bank'], 'id_divisi' => $row['id_divisi'], 'id_indeks' => $row['id_indeks'], 'index' => !empty($this->input->get('index')) ? $this->input->get('index') : '', 'is_transfer' => !empty($this->input->get('is_transfer')) ? $this->input->get('is_transfer') : '0')))  . "'>
									    <button type='button' class='btn  btn-info'><i class='fa fa-edit'></i> EDIT</button>
									</a>
									<button type='button' id='detail_trx' class='btn btn-blue-grey' onclick='detail_trx(" . $row['id_trans'] . "); hidden;'><i class='fa fa-info'></i> DETAIL</button>
									<button type='button' id='hapus_trx' class='btn btn-danger' onclick='hapus_trx(" . $row['id_trans'] . "); hidden;'><i class='fa fa-trash'></i> DELETE</button>
									</td>";
								}
							}
							?>
					</tbody>
				</table>
			<?php } else {
				echo "<hr>";
				echo "<center><p>Data Not found</p></center>";
			} ?>
		</div>
	</div>
</div>



<!-- MODAL DETAIL INCOME TRX -->
<div class="modal fade" tabindex="-1" id="modal_detail" data-backdrop="static" style="overflow-y: auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="form_detail" style="padding-left:15px;padding-right: 15px;">
				<div class="modal-header" style="background-color:#78909c;color:#fff">
					<h4 class="modal-title" id="header_detail">Transaction Detail</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="card">
						<div class="card-body">
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Transaction Order</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_id_trans" value="" readonly="">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-sm-4">Bank</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_bank" value="" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Division</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_divisi" value="" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Index</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_indeks" value="" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Type</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_jenis" value="" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Date (Nota)</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_tgl_nota" value="" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Bill</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_bon" value="" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Transaction</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_trans" value="" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Qty</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_jumlah" value="" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-4">Price</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_harga" value="" readonly="">
								</div>
							</div>

							<div class="form-group row" id='income'>
								<label class="col-form-label col-sm-4">Income</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_income" value="" readonly="">
								</div>
							</div>

							<div class="form-group row" id='expense'>
								<label class="col-form-label col-sm-4">Expense</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="det_expense" value="" readonly="">
								</div>
							</div>

						</div>

					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>

	</div>
</div>
<!-- END MODAL DETAIL INCOME TRX -->

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/select2/select2.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>inc/select2/select2.min.js"></script>
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
			//'scrollX': true,
			'lengthMenu': [
				[10, 25, , 50, -1],
				[10, 25, 50, "All"]
			],
			'rowReorder': {
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
		});



		$('.datepicker').datepicker({
			todayHighlight: !0,
			dateFormat: 'yy-mm-dd',
			autoclose: !0,
			maxDate: 0
		});

		init_date_start();
		init_date_end();
		show_index();
		init_indeks();

		$('.js-example-basic-single').select2();

		/*$('#id_divisi').on('change', function() {
			var id_divisi = $('#id_divisi').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url('finance/accountant/tampil_chained_report') ?>',
				data: {
					'id': id_divisi
				},
				success: function(data) {
					$("#id_indeks").html(data);
					//$("#index").html(data);
				}
			})
		})*/



	});
	
	$('#id_divisi').change(function() {
		init_indeks();
	});

    function init_indeks() {
		var id_divisi = $('#id_divisi').val();
		var id_indeks = "<?= $this->input->get('id_indeks') ?>";

		$('#id_indeks').empty();
		if (id_divisi != 'all') {
			$.ajax({
				url: "<?= base_url('finance/accountant/json_get_indeks_list') ?>",
				type: "POST",
				dataType: "json",
				data: {
					'id_divisi': id_divisi
				},
				success: function(result) {
					$('#id_indeks').append('<option value="all">All</option>');
					$.each(result, function(index, item) {
						$('#id_indeks').append('<option value="' + item.id_indeks + '">' + item.nama_indeks + '</option>');

					});
					if (id_indeks != '') {
						$('#id_indeks').val(id_indeks).change();
					}
				},
				error: function(e) {
					console.log(e);
				}
			})
		} else {
			$('#id_indeks').append('<option value="all">All</option>');
		}
	}


	$('#export').click(function() {
		var query = "<?= $_SERVER['QUERY_STRING'] ?>";
		var url = "<?= base_url('finance/report/export_report_monthly?') ?>" + query;
		window.open(url, '_blank');
	});

	function init_date_end() {
		$('#date_end').datepicker({
			todayHighlight: !0,
			dateFormat: 'yy-mm-dd',
			autoclose: !0,
			minDate: $('#date_start').val(),
			maxDate: 0
		})
	}

	function init_date_start() {
		$('#date_start').datepicker({
			todayHighlight: !0,
			dateFormat: 'yy-mm-dd',
			autoclose: !0,
			//minDate: $('#date_start').val(),
			maxDate: 0
		})
	}

	function detail_trx(id) {
		$('#modal_detail').modal('show');
		$('#form_detail').trigger('reset');
		$.ajax({
			url: "<?= base_url('finance/report/json_get_report_monthly') ?>",
			type: "POST",
			dataType: "json",
			data: {
				'id': id
			},
			success: function(result) {
				$('#det_id_trans').val(result.id_trans);
				$('#det_bank').val(result.bank);
				$('#det_divisi').val(result.nama_divisi);
				$('#det_indeks').val(result.nama_indeks);
				$('#det_jenis').val(result.jenis);
				$('#det_tgl_nota').val(result.tgl_nota);
				$('#det_bon').val(result.bon);
				$('#det_trans').val(result.transaksi);
				$('#det_jumlah').val(result.jumlah);
				$('#det_harga').val(result.harga);
				$('#det_income').val(result.income);
				$('#det_expense').val(result.expense);
			},
			error: function(e) {
				console.log(e);
			}
		})
	}
	
	function hapus_trx(id) {
        if (id != '') {
            swal({
                title: 'Konfirmasi',
                text: "Data Akan Dihapus, Lanjutkan?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f35958',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }, function(result) {
                if (result) {
                    $.ajax({
                        url: "<?= base_url('finance/report/delete_report') ?>",
                        type: "POST",
                        dataType: "json",
                        data: {
                            'id_trans': id
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

	function show_index() {

		if ($('#add_index').is(":checked")) {
			$('#show_index').show('slide', {
				direction: 'up'
			}, 500);
		} else {
			$('#show_index').hide('slide', {
				direction: 'up'
			}, 500);
		}
	}

	$('#add_index').change(function() {
		show_index();
	});


	function reload_page() {
		window.location.reload();
	}
</script>