<link rel="stylesheet" href="<?= base_url('inc/fancybox/source/jquery.fancybox.css?v=2.1.7'); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url('inc/fancybox/source/jquery.fancybox.pack.js?v=2.1.7'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
</script>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pembelian Merchandise</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info" style="letter-spacing:0px;font-weight:bold;margin-bottom:30px">
            <button class="close" data-dismiss="alert"></button>
            Info: List Ini akan selalu otomatis terhapus 1 Bulan setelah Pembelian Merchandise.
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <button data-toggle="modal" data-target="#transactionModal" class="btn btn-primary btn-cons waves-effect waves-light" type="submit"><i class="icon-ok"></i><i class="fas fa-plus"></i> Add Request</button>
                <hr>
                <table class="table w-100" id="table1">
                    <thead class="text-center">
                        <tr style="background-color: #0d4e6c;color:#fff;">
                            <th class="align-middle">No</th>
                            <th class="align-middle">Merchandise</th>
                            <th class="align-middle">Overtime</th>
                            <th class="align-middle">Qty</th>
                            <th class="align-middle">Size</th>
                            <th class="align-middle">Total</th>
                            <th class="align-middle">Menunggu Approve</th>
                            <th class="align-middle">Status</th>

                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (!empty($results)) { ?>
                            <?php $no = 1; ?>
                            <?php foreach ($results as $r) { ?>
                                <tr>
                                    <td style="vertical-align: middle;"><?php echo $no; ?></td>
                                    <td style="vertical-align: middle;"><?php echo $r->product; ?></td>
                                    <td style="vertical-align: middle;"><?php echo $r->overtime; ?></td>
                                    <td style="vertical-align: middle;"><?php echo $r->qty; ?></td>
                                    <?php if ($r->size == null) { ?>
                                        <td style="vertical-align: middle;"><label class='badge badge-info badge-lg' style='cursor:default;'>-</label></td>
                                    <?php } else { ?>
                                        <td style="vertical-align: middle;"><?php echo $r->size; ?></td>
                                    <?php } ?>
                                    <td style="vertical-align: middle;"><?php echo ($r->overtime * $r->qty); ?></td>

                                    <?php if (($r->is_approve == '0') && ($r->is_reject) == '0') { ?>
                                        <td style="vertical-align: middle;"><label class='badge cyan darken-4'>HR</label></td>
                                    <?php } else { ?>
                                        <td style="vertical-align: middle;"><label>-</label></td>
                                    <?php } ?>

                                    <?php if (($r->is_approve == '1') && ($r->is_reject == '0') && ($r->is_done == '1')) { ?>
                                        <td style="vertical-align: middle;" nowrap="nowrap">
                                            <label class='badge badge-info badge-lg' style='cursor:default;'>Barang Sudah Dikasih </label>
                                            |
                                            <label class='badge badge-success badge-lg' style='cursor:default;'>APPROVED</label>
                                        </td>
                                    <?php } else if (($r->is_approve == '1') && ($r->is_reject == '0') && ($r->is_done == '0')) { ?>
                                        <td style="vertical-align: middle;" nowrap="nowrap">
                                            <label class='badge badge-warning badge-lg' style='cursor:default;'>Barang Belum Dikasih </label>
                                            |
                                            <label class='badge badge-success badge-lg' style='cursor:default;'>APPROVED</label>
                                        </td>
                                    <?php } else if (($r->is_approve == '0') && ($r->is_reject == '0') && ($r->is_done == '0')) { ?>
                                        <td style="vertical-align: middle;" nowrap="nowrap">
                                            <label class='badge badge-default badge-lg' style='cursor:default;'>WAITING APPROVED HR </label>
                                            |
                                            <!--<button class="btn btn-info" onclick="edit(<?= $r->id_log_product; ?>)"><i class="fa fa-edit"></i>Edit</button>-->
                                            <button class="btn btn-danger" onclick="hapus(<?= $r->id_log_product; ?>)"><i class="fa fa-times"></i> Delete</button>
                                        </td>
                                    <?php } else if (($r->is_reject == '1') && ($r->is_approve == '0')) { ?>
                                        <td nowrap="nowrap">
                                            <label class='badge badge-danger badge-lg' style='cursor:default;'>Transaksi Ditolak </label>
                                            |
                                            <label class='badge badge-danger badge-lg' style='cursor:default;'>REJECT</label>
                                        </td>
                                    <?php } ?>

                                </tr>
                                <?php $no = $no + 1; ?>
                            <?php } ?>
                        <?php } ?>


                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- END PAGE -->
</div>


<!-- Modal Add Transaction -->
<div class="modal fade" id="transactionModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title orange-text" id="kodeTransaction">MERCHANDISE FORM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url('user/merchandise/apply_buy_merch') ?>" method="post">
                <div class="modal-body">

                    <?php if (!empty($warrior)) {
                        foreach ($warrior as $row) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6 col-md-3">Warrior</div>
                                                <div>:</div>
                                                <div class="col-6 col-md-3"> <?php echo $row->name ?> </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-3">Your Overtime</div>
                                                <div>:</div>
                                                <div class="col-6 col-md-3"> <?php echo $row->nl ?> </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-3">Tanggal</div>
                                                <div>:</div>
                                                <div class="col-6 col-md-3"> <?php echo date('Y-m-d') ?> </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    <?php }
                    } ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dynamic_field">
                                    <thead>
                                        <tr class="primary-color-dark text-white text-center">
                                            <th style="width: 300px">Merchandise</th>
                                            <th style="width: 100px">Overtime</th>
                                            <!--<th style="width: 300px" hidden>Merchandise</th>-->
                                            <th style="width: 100px">Qty</th>
                                            <th style="width: 100px">Size</th>
                                            <th style="width: 200px">Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select id="merch" class="form-control js-example-basic-single" type="text" name="merch" style="width:100%" required>
                                                    <option value="">Pilih Product</option>
                                                    <?php if (!empty($product)) {
                                                        foreach ($product as $row) { ?>
                                                            <option value="<?= $row->id_product; ?>"><?= $row->nama_product; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="overtime" class="form-control" type="text" name="overtime" style="width:100%" readonly>

                                                </select>
                                            </td>
                                            <!--<td hidden>-->
                                            <!--    <select id="merch_name" class="form-control" type="text" name="merch_name" style="width:100%" readonly>-->

                                            <!--    </select>-->
                                            <!--</td>-->
                                            <td><input type="text" name="qty" placeholder="Qty" class="form-control numeric" id="qty" required onkeyup="count();" />
                                            <td><input type="text" name="size" placeholder="Size" class="form-control" id="size" required/>
                                            <td><input type="text" name="total" placeholder="Total" id="total" class="form-control" readonly required/></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: inherit;">

                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Tombol proses akan mengurangi jumlah overtime anda apabila HR sudah melakukan approve atas pembelian Merchandise anda, jika proses ini sudah dilakukan maka tidak dapat dikembalikan.
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block" id="btnProccess">Process Now</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal Add Transaction -->


<!-- Modal Edit Transaction -->
<div class="modal fade" id="updateModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title orange-text" id="kodeTransaction">MERCHANDISE FORM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url('user/merchandise/edit_buy_merch') ?>" method="post">
                <div class="modal-body">

                    <?php if (!empty($warrior)) {
                        foreach ($warrior as $row) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6 col-md-3">Warrior</div>
                                                <div>:</div>
                                                <div class="col-6 col-md-3"> <?php echo $row->name ?> </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-3">Your Overtime</div>
                                                <div>:</div>
                                                <div class="col-6 col-md-3"> <?php echo $row->nl ?> </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-3">Tanggal</div>
                                                <div>:</div>
                                                <div class="col-6 col-md-3"> <?php echo date('Y-m-d') ?> </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    <?php }
                    } ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dynamic_field">
                                    <thead>
                                        <tr class="primary-color-dark text-white text-center">
                                            <th style="width: 300px" hidden>ID Merchandise</th>
                                            <th style="width: 300px">Merchandise</th>
                                            <th style="width: 100px">Overtime</th>
                                            <!--<th style="width: 300px" hidden>Merchandise</th>-->
                                            <th style="width: 100px">Qty</th>
                                            <th style="width: 100px">Size</th>
                                            <th style="width: 200px">Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td hidden><input type="text" name="id_log_product" id="editid" required /></td>
                                            <td>
                                                <select id="editmerch" class="form-control" type="text" name="merch" style="width:100%" required>
                                                    <option value="">Pilih Product</option>
                                                    <?php foreach ($product as $row) { ?>
                                                        <option value="<?php echo $row->id_product; ?>"><?php echo ucfirst($row->nama_product); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            </td>
                                            <td>
                                                <select id="editovertime" class="form-control" type="text" name="overtime" style="width:100%" readonly>

                                                </select>
                                            </td>
                                            <!--<td hidden>-->
                                            <!--    <select id="editmerch_name" class="form-control" type="text" name="merch_name" style="width:100%" readonly>-->

                                            <!--    </select>-->
                                            <!--</td>-->
                                            <td><input type="text" name="qty" placeholder="Qty" class="form-control numeric" id="editqty" required onkeyup="count_edit();" /></td>
                                            <!-- <td> 
                                                <select id="editqty" class="form-control" type="text" name="qty" style="width:100%" onchange="count_edit()">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>-->
                                            </td>
                                            <td><input type="text" name="size" placeholder="Size" class="form-control" id="editsize" required /></td>
                                            <td><input type="text" name="total" placeholder="Total" class="form-control" id="edittotal" readonly required/></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: inherit;">

                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Tombol proses akan mengurangi jumlah overtime anda apabila HR sudah melakukan approve atas pembelian Merchandise anda, jika proses ini sudah dilakukan maka tidak dapat dikembalikan.
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block" id="btnProccess">Process Now</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal Edit Transaction -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover();

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

        $('.js-example-basic-single').select2();

      

    });

   
    function edit(id_log_product) {
        $.ajax({
            url: "<?= base_url('user/merchandise/push_data_merchandise'); ?>",
            type: "post",
            dataType: "json",
            data: {
                'id_log_product': id_log_product
            },
            success: function(response) {
                $('#editid').val(response.detail.id_log_product);
                $('#editmerch').val(response.detail.id_product).change();
                $('#editovertime').val(response.detail.overtime);
                // $('#editmerch_name').val(response.detail.nama_product);
                $('#editqty').val(response.detail.qty);
                $('#editsize').val(response.detail.size);
                $('#edittotal').val(Math.abs(response.detail.total));
                console.log(response);
            },
            error: function(e) {
                console.log(e);
            }
        });

        $('#updateModal').modal('show');
    }

    function hapus(id_log_product) {
        if (id_log_product != '') {
            swal({
                title: 'Konfirmasi',
                text: "Yakin nih Kamu Mau Batal Beli Merch yang Kece ini, Lanjutkan?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f35958',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }, function(result) {
                if (result) {
                    $.ajax({
                        url: "<?= base_url('user/merchandise/delete_merchandise') ?>",
                        type: "POST",
                        dataType: "json",
                        data: {
                            'id_log_product': id_log_product
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


    $('#merch').change(function() {
        init_overtime();
    });

    function init_overtime() {
        var merch = $('#merch').val();

        $('#overtime').empty();
        document.getElementById('qty').value = ''
        document.getElementById('size').value = ''
        // $('#merch_name').empty();

        $.ajax({
            url: "<?= base_url('user/merchandise/get_autocomplete_overtime') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'merch': merch
            },
            success: function(result) {
                $.each(result, function(index, item) {
                    $('#overtime').append('<option value="' + item.ot + '">' + item.ot + '</option>');
                    // $('#merch_name').append('<option value="' + item.nama_product + '">' + item.nama_product + '</option>');
                });
            },
            error: function(e) {
                console.log(e);
            }
        })

    }

    function reload_page() {
        window.location.reload();
    }

    $('#editmerch').change(function() {
        init_edit_overtime();
    });

    function init_edit_overtime() {
        var merch = $('#editmerch').val();
        
        // var merch_name = $('#editmerch_name').val();

        $('#editovertime').empty();
        document.getElementById('editqty').value = ''
        document.getElementById('editsize').value = ''
        
        // $('#editmerch_name').empty();

        $.ajax({
            url: "<?= base_url('user/merchandise/get_autocomplete_overtime') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'merch': merch
            },
            success: function(result) {
                $.each(result, function(index, item) {
                    $('#editovertime').append('<option value="' + item.ot + '">' + item.ot + '</option>');
                    // $('#editmerch_name').append('<option value="' + item.nama_product + '">' + item.nama_product + '</option>');
                });
                count_edit();
            },
            error: function(e) {
                console.log(e);
            }
        })

    }

    function count() {
        //var re = /^[\w\s]+$/g;
        var txtFirstNumberValue = document.getElementById('overtime').value;
        var txtSecondNumberValue = document.getElementById('qty').value;
        var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('total').value = parseInt(result);
        } else {
            document.getElementById('total').value = '0';
        }
    }

    function count_edit() {
        //var re = /^[\w\s]+$/g;
        var txtFirstNumberValue = document.getElementById('editovertime').value;
        var txtSecondNumberValue = document.getElementById('editqty').value;
        var result = (txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
        if (!isNaN(result)) {
            document.getElementById('edittotal').value = parseFloat(result);
        } else {
            document.getElementById('edittotal').value = '0';
        }
    }

    $('.numeric').keyup(function(e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });
</script>