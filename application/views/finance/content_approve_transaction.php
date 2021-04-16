<div class="card">
    <div class="card-header">
        <h3 class="card-title">Approve Transaction </h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info" style="letter-spacing:0px;font-weight:bold;margin-bottom:30px">
            <button class="close" data-dismiss="alert"></button>
            Info: Setelah Nomerator di Approve maka Data yang di Approve akan Masuk kedalam Laporan Keuangan dan Nomerator
        </div>
    <?php if ((!empty($results))) { ?>
        
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modalExport"><i class="fa fa-file-excel"></i>&nbsp; Export to Excel</button>
            </div>
        </div>
        
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table table-striped w-100" id="table1">
                    <thead class="text-center">
                        <tr style="background: #0d4e6c;color:white;">
                            <th class="text-center">No</th>
                            <th>From</th>
                            <th>Nomerator</th>
                            <th>Bank</th>
                            <th>Nama Peserta</th>
                            <th>Program</th>
                            <th>Jumlah</th>
                            <th width="300px">Receipt | Transaksi</th>
                            <th style="width:170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $no = 1;
                        foreach ($results as $row) {  ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo ucfirst($row->username) ?></td>
                                <td><?php echo $row->nomerator ?></td>
                                <td><?php echo $row->bank_name ?></td>
                                <td><?php echo $row->nama_peserta ?></td>
                                <td><?php echo $row->program ?></td>
                                <td>Rp.<?php echo number_format($row->jumlah, 2) ?></td>
                                <?php if (($row->status_acc == 'ya') && ($row->to_transaction == 'ya')) { ?>
                                    <td><label class="badge badge-success">Success</label> | <label class="badge badge-success">Success</label></td>
                                <?php } elseif (($row->status_acc == 'ya') && ($row->to_transaction == NULL)) { ?>
                                    <td><label class="badge badge-success">Success</label> | <label class="badge badge-info">Hold</label></td>
                                <?php } else { ?>
                                    <td><label class="badge badge-info">Hold</label> | <label class="badge badge-info">Hold</label></td>
                                <?php } ?>
                                <?php if (($row->status_acc == NULL) && ($row->to_transaction == NULL)) { ?>
                                    <td><a onclick="approve(<?= $row->id ?>)"><button class="btn btn-info">APPROVE</button></a></td>
                                <?php } else if (($row->status_acc != NULL) && ($row->to_transaction == NULL)) { ?>
                                    <td><a onclick="to_transaction(<?= $row->id ?>)"><button class="btn btn-danger">TO TRANSACTION</button></a></td>
                                <?php } else { ?>
                                    <td><label class="badge special-color">-</label></td>
                                <?php } ?>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
         <?php } else {
          echo "<center><p>Data Not found</p></center>";
        } ?>

    </div>

    <div class="modal fade" id="modal_add_transaction" data-backdrop="static" data-keyboard="false" style="overflow-y: auto;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="<?= base_url('finance/nomerator/approve_nomerator') ?>" method="post" id="form_transaction" style="padding-left:15px;padding-right: 15px;">
                    <div class="modal-header" style="background-color:#17a2b8;color:#fff">
                        <h4 class="modal-title" id="header_transaction">FROM TO TRANSACTION</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <input name="id_tt" id="id_tt" class="form-control" type="text" placeholder="" autocomplete="off" hidden>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Key Number</label>
                                    <div class="col-sm-8">
                                        <input name="key_number" id="key_number" value="<?php echo strtoupper($key) ?>" class="form-control" type="text" placeholder="" autocomplete="off" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Receipt Number</label>
                                    <div class="col-sm-8">
                                        <input name="receipt_number" id="receipt_number" class="form-control" type="text" placeholder="" autocomplete="off" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Payment Source</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="payment_source" id="payment_source" required="">
                                            <option value="">- Choose an option -</option>
                                            <?php foreach ($bank as $b) { ?>
                                                <option value="<?php echo $b->id_bank; ?>"><?php echo ucfirst($b->name); ?> - <?php echo $b->pt; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Bill</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="bon" id="bon" required="">
                                            <option value="">- Choose an option -</option>
                                            <option value="y_writen">Y (Writen)</option>
                                            <option value="y_print">Y (Print)</option>
                                            <option value="n_self">N (Self)</option>
                                            <option value="n">N</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Date</label>
                                    <div class="col-sm-8">
                                        <input name="tgl_nota" id="tgl_nota" class="form-control datepicker" type="input" placeholder="Date Transfered" required="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Indeks</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="id_indeks" id="id_indeks" required="">
                                            <option value="">- Choose an option -</option>
                                            <?php foreach ($indeks as $n) { ?>
                                                <option value="<?php echo $n->id_indeks; ?>"><?php echo $n->no_indeks; ?> - <?php echo ucfirst($n->nama_indeks); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Description</label>
                                    <div class="col-sm-8">
                                        <textarea name="description" id="description" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Total</label>
                                    <div class="col-sm-8">
                                        <input name="total" id="total" class="form-control" type="text" placeholder="" autocomplete="off" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                            <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    
    <!-- Modal Export-->
    <div class="modal fade" id="modalExport" data-backdrop="static" data-keyboard="false" style="overflow-y: auto;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="<?= base_url('finance/accountant/export_data_nomerator') ?>" method="get" id="form_transaction" style="padding-left:15px;padding-right: 15px;">
                    <div class="modal-header" style="background-color:#00c851;color:#fff">
                        <h4 class="modal-title" id="header_transaction">Export Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Dari Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control datepicker" name="date_start" id="date_start" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4">Sampai Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control datepicker" name="date_end" id="date_end" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-block">Export to Excel</button>
                        </div>
                </form>
            </div>

        </div>
    </div>
    
    <link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>inc/select2/select2.min.css" />
    <script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>inc/select2/select2.min.js"></script>


    <script type="text/javascript">
    	$(document).ready(function() {
            $('#table1').DataTable({
                'lengthMenu': [
                    [20, 30, -1],
                    [20, 30, "All"]
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
    	});

        function approve(id) {
            if (id != '') {
                swal({
                    title: 'Approve Nomerator',
                    text: "Setujui Transaksi Ini?",
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#4285f4',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }, function(result) {
                    if (result) {
                        $.ajax({
                            url: "<?= base_url('finance/accountant/approve_nomerator') ?>",
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

        function to_transaction(id) {
            $('#modal_add_transaction').modal('show');
            $('#form_transaction').trigger('reset');
            $.ajax({
                url: "<?= base_url('finance/accountant/json_get_nomerator') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    'id': id
                },
                success: function(result) {
                    $('#id_tt').val(result.id);
                    $('#receipt_number').val(result.nomerator);
                    $('#payment_source').val(result.bank);
                    $('#tgl_nota').val(result.date);
                    $('#id_indeks').val(result.indeks);
                    $('#description').val(result.description);
                    $('#total').val(result.jumlah);
                },
                error: function(e) {
                    console.log(e);
                }
            })
        };

        function reload_page() {
            window.location.reload();
        }
        
    </script>