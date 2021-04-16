<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 37px !important;
    }

    .select2-container .select2-selection--single {
        margin-left: 10px !important;
        height: 37px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 35px !important;
    }

    .input-group .form-control {
        padding-top: 2px;
        padding-bottom: 1px;
    }
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Nomerator</h3>
    </div>
    <div class="card-body">
        <a class="btn btn-primary" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
        <hr>
        <?php if (!empty($results)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="table1">
                    <thead>
                        <tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
                            <th class="text-center">No</th>
                            <th class="text-center" width="200">Tanggal</th>
                            <th class="text-center">Nomerator</th>
                            <th class="text-center">Peserta</th>
                            <th class="text-center">Program</th>
                            <th class="text-center" width="200">Jumlah</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Approved</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $no = 1;
                        foreach ($results as $row) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo date('d-M-Y', strtotime($row->date)) ?></td>
                                <td><?php echo $row->nomerator ?></td>
                                <td><?php echo $row->nama_peserta ?></td>
                                <?php if ($row->program != 'Others') { ?>
                                    <td><?php echo $row->program ?></td>
                                <?php } else { ?>
                                    <td><?php echo $row->program ?> - <?php echo $row->description ?></td>
                                <?php } ?>
                                <td>Rp. <?php echo number_format($row->jumlah) ?></td>
                                <td><?php if ($row->status_acc == '') {
                                        echo "<label class='badge badge-light'>Waiting Accountant</label>";
                                    } elseif ($row->status_acc == 'tidak') {
                                        echo "<label class='badge badge-danger'>Rejected</label";
                                    } else {
                                        echo "<label class='badge badge-success'>Approved</label";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($row->tgl_approve == '') {
                                        echo "<label class='badge badge-light'>-</label>";
                                    } else {
                                        echo date('d-M-Y', strtotime($row->tgl_approve));
                                    }
                                    ?>
                                </td>
                                <?php
                                if ($row->status_acc == '') {
                                    echo "<td nowrap='nowrap'>
                                    
                                    <button type='button' class='btn  btn-danger' onclick='hapus(" . $row->id . ")'><i class='fa fa-trash'></i> HAPUS</button>
                                </td>";
                                } else {
                                    echo "<td>-</td>";
                                }
                                ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else {
            echo "<center><p>Data Not Found</p></center>";
        } ?>
            </div>
    </div>
</div>

<!--<a class='btn btn-warning' onclick='edit(" . $row->id . ")' title='Edit Data'><i class='fa fa-edit'></i> EDIT</a>-->

<!-- MODAL EVENT -->
<div class="modal fade" id="modal_tambah" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('user/nomerator/submit_form_nomerator') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
                <input type="text" id="branch" name="branch" value="<?php echo $this->session->userdata('branch') ?>" hidden>
                <div class="modal-header" style="background-color: #33b5e5">
                    <h4 class="modal-title" id="myModalLabel" style="color:honeydew"><b>List Nomerator</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Nomerator</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <select name="headnumber" id="headnumber" class="custom-select" required="">
                                        <option value="">Pilih</option>
                                        <option value="ME">ME</option>
                                        <option value="M1">M1</option>
                                        <option value="M2">M2</option>
                                        <option value="M3">M3</option>
                                        <option value="MRLC">MRLC</option>
                                        <option value="LA1">LA1</option>
                                        <option value="LA2">LA2</option>
                                    </select>
                                </div>
                                <select class="form-control loopnomor" type="text" name="bodynumber" id="bodynumber" style="width:72%" required="">
                                    <option value="">Pilih</option>
                                    <?php
                                    for ($i = 1; $i <= 1000; $i++) {
                                    ?>
                                        <option value="<?php echo str_pad($i, 5, 0, STR_PAD_LEFT); ?>"><?php echo str_pad($i, 5, 0, STR_PAD_LEFT); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Nama Peserta</label>
                        <div class="col-sm-8">
                            <input name="nama_peserta" id="nama_peserta" value="<?= $this->session->userdata('nama_peserta') ?>" class="form-control" type="text" placeholder="e.g. rizki" required="">
                        </div>
                    </div>

                    <!--<div class="form-group row">-->
                    <!--    <label class="col-form-label col-sm-4">Pemilik Kartu</label>-->
                    <!--    <div class="col-sm-8">-->
                    <!--        <input name="pemilik_kartu" id="pemilik_kartu" value="<?= $this->session->userdata('pemilik_kartu') ?>" class="form-control" type="text" placeholder="e.g. rizki">-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Program</label>
                        <div class="col-sm-8">
                            <select name="program" id="program" class="form-control">
                                <option value="">- Please Choose - </option>
                                <?php foreach ($program as $n) { ?>
                                    <option value="<?php echo $n->id ?>"><?php echo $n->name ?></option>
                                <?php } ?>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="std_show_hp">
                        <label class="col-form-label col-sm-4">Tipe</label>
                        <div class="col-sm-8">
                            <select name="holiday" id="holiday" class="form-control">
                                <option value="">- Please Choose - </option>
                                <option value="ps">Public Speaking</option>
                                <option value="sl">Smart Learning</option>
                                <option value="ls">Life and Success</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row" id="std_others_program">
                        <label class="col-form-label col-sm-4">Keterangan</label>
                        <div class="col-sm-8">
                            <input name="keterangan" id="keterangan" class="form-control" type="text" placeholder="e.g. Merchandise">
                        </div>
                    </div>

                    <!--<?php if ($this->session->userdata('branch') == '0') { ?>-->
                    <!--    <div class="form-group row" id="std_show_location">-->
                    <!--        <label class="col-form-label col-sm-4">Location</label>-->
                    <!--        <div class="col-sm-8">-->
                    <!--            <select name="location" id="location" class="form-control">-->
                    <!--                <option value="">- Please Choose - </option>-->
                    <!--                <option value="Puri Indah">Puri</option>-->
                    <!--                <option value="BSD">BSD</option>-->
                    <!--                <option value="Kelapa Gading">KG</option>-->
                    <!--                <option value="Permata Hijau">PH</option>-->
                    <!--                <option value="Banjar Wijaya">BW</option>-->
                    <!--                <option value="Surabaya">SBY</option>-->
                    <!--            </select>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--<?php } ?>-->
                    
                    <div class="form-group row" id="std_show_location">
                        <label class="col-form-label col-sm-4">Location</label>
                        <div class="col-sm-8">
                            <select name="location" id="location" class="form-control">
                                <option value="">- Please Choose - </option>
                                <!-- <option value="Puri Indah">Puri</option>
                                    <option value="BSD">BSD</option>
                                    <option value="Kelapa Gading">KG</option>
                                    <option value="Permata Hijau">PH</option>
                                    <option value="Banjar Wijaya">BW</option>
                                    <option value="Surabaya">SBY</option> -->
                                <?php foreach ($branch as $row) { ?>
                                    <option value="<?php echo $row->branch_name ?>"><?php echo $row->branch_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="" id="std_coloumn_type">
                        <div class="form-group row" id="std_show_type">
                            <label class="col-form-label col-sm-4">Jenis Program</label>
                            <div class="col-sm-8">
                                <select name="type" id="type" class="form-control">
                                    <option value="">- Please Choose - </option>
                                    <option value="fp">Full Program</option>
                                    <option value="modul">Modul</option>
                                    <option value="upgrade">Upgrade</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="std_show_type2">
                        <label class="col-form-label col-sm-4">Jenis Program</label>
                        <div class="col-sm-8">
                            <select name="type_psa" id="type_psa" class="form-control">
                                <option value="">- Please Choose - </option>
                                <option value="fp">Full Program</option>
                                <option value="modul">Modul</option>
                                <option value="sp">Sesi Perkenalan</option>
                                <option value="upgrade">Upgrade</option>
                            </select>
                        </div>
                    </div>

                    <div class="" id="std_coloumn_payment">
                        <div class="form-group row" id="std_show_payment">
                            <label class="col-form-label col-sm-4">Pembayaran</label>
                            <div class="col-sm-8">
                                <select name="payment" id="payment" class="form-control">
                                    <option value="">- Please Choose - </option>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Cicilan">Cicilan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="std_payment_include_sp">
                        <label class="col-form-label col-sm-4">Pembayaran</label>
                        <div class="col-sm-8">
                            <select name="payment_isp" id="payment_isp" class="form-control">
                                <option value="">- Please Choose - </option>
                                <option value="Sesi Perkenalan">Sesi Perkenalan</option>
                                <option value="Lunas OTS">Lunas OTS</option>
                                <option value="Lunas Cicilan">Lunas Cicilan</option>
                                <option value="DP">DP</option>
                                <option value="Pelunasan">Pelunasan</option>
                                <option value="Re-Attendance">Re-Attendance</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="std_payment_ninclude_sp">
                        <label class="col-form-label col-sm-4">Pembayaran</label>
                        <div class="col-sm-8">
                            <select name="payment_nisp" id="payment_nisp" class="form-control">
                                <option value="">- Please Choose - </option>
                                <option value="Lunas OTS">Lunas OTS</option>
                                <option value="Lunas Cicilan">Lunas Cicilan</option>
                                <option value="DP">DP</option>
                                <option value="Pelunasan">Pelunasan</option>
                                <option value="Re-Attendance">Re-Attendance</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" hidden>
                        <label class="col-form-label col-sm-4">Bank</label>
                        <div class="col-sm-8">
                            <input name="bank" id="bank" value="" class="form-control" type="text" placeholder="Bank" autocomplete="off" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Jumlah</label>
                        <div class="col-sm-8">
                            <input name="jumlah" id="jumlah" value="<?= $this->session->userdata('jumlah') ?>" class="form-control jumlah" type="text" placeholder="" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Tanggal</label>
                        <div class="col-sm-8">
                            <input name="date" id="date" value="<?= $this->session->userdata('date') ?>" class="form-control datepicker" type="text" autocomplete="off" required="">
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


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#jumlah').maskMoney({
            allowZero: false,
            allowNegative: true,
            thousands: '.',
            decimal: ',',
            precision: 0
        });

        show_others_program();
        show_others_location();
        show_others_hp();
        show_others_type();
        show_others_payment_isp();

    });
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

    $('#showtambah').click(function() {
        $('#form_data').trigger("reset");
        $('#modal_tambah').modal('show');
    });

    $('#program').change(function() {
        show_others_program();
        show_others_location();
        show_others_hp();
        show_others_type();
        show_others_payment_isp();
        show_bank_payment();
    });
    
    function show_others_program() {
        var program = $('#program').val();
        if (program == 'others') {
            $('#std_others_program').show('slide', {
                direction: 'up'
            }, 500);
            $('#std_coloumn_type').addClass('d-none');
            $('#std_coloumn_payment').addClass('d-none');
        } else {
            $('#std_coloumn_type').removeClass();
            $('#std_coloumn_payment').removeClass();
            $('#std_others_program').hide('slide', {
                direction: 'up'
            }, 500);
        }
    }

    function show_others_location() {
        var program = $('#program').val();
        var branch = $('#branch').val();
        if ((program == '2') || (program == '10') || (program == '24')) {
            if (branch == '0') {
                $('#std_show_location').show('slide', {
                    direction: 'up'
                }, 500);
            }
        } else if (program == '11') {
            $('#std_show_location').show('slide', {
                direction: 'up'
            }, 500);
        } else {
            $('#std_show_location').hide('slide', {
                direction: 'up'
            }, 500);
        }
    }

    function show_others_hp() {
        var program = $('#program').val();
        if ((program == '11')) {
            $('#std_show_hp').show('slide', {
                direction: 'up'
            }, 500);
        } else {
            $('#std_show_hp').hide('slide', {
                direction: 'up'
            }, 500);
        }
    }

    function show_others_type() {
        var program = $('#program').val();
        if ((program == '24')) {
            $('#std_show_type2').show('slide', {
                direction: 'up'
            }, 500);
            $('#std_show_type').hide('slide', {
                direction: 'up'
            }, 500);
        } else {
            $('#std_show_type2').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_show_type').show('slide', {
                direction: 'up'
            }, 500);
        }
    }

    $('#type_psa').change(function() {
        show_others_payment();
    });

    function show_others_payment() {
        var type_psa = $('#type_psa').val();
        if (type_psa == 'sp') {
            $('#std_show_payment').hide('slide', {
                direction: 'up'
            }, 500);
        } else {
            $('#std_show_payment').show('slide', {
                direction: 'up'
            }, 500);

        }
    }

    function show_bank_payment() {
        var program = $('#program').val();
        var is_branch = $('#branch').val();
        if ((program == '1') || (program == '26')) {
            document.getElementById('bank').value = 'BCA MRI';
        } else if ((program == '4') || (program == '5') || (program == '3') || (program == '19')) {
            document.getElementById('bank').value = 'BCA MRM';
        } else if (((program == '2') || (program == '10') || (program == '11') || (program == '24')) && is_branch == '5') {
            document.getElementById('bank').value = 'BCA Palem';
        } else if (((program == '2') || (program == '10') || (program == '11') || (program == '24')) && is_branch == '6') {
            document.getElementById('bank').value = 'BCA BW';
        } else {
            document.getElementById('bank').value = 'BCA MRE';
        }

    }

    function show_others_payment_isp() {
        var program = $('#program').val();
        if ((program == '1') || (program == '4') || (program == '5') || (program == '3') || (program == '19')) {
            $('#std_show_type').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_show_type2').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_show_payment').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_payment_ninclude_sp').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_payment_include_sp').show('slide', {
                direction: 'up'
            }, 500);

        } else if (program == '26') {
            $('#std_show_type').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_show_type2').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_show_payment').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_payment_include_sp').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_payment_ninclude_sp').show('slide', {
                direction: 'up'
            }, 500);
        } else {
            $('#std_show_payment').show('slide', {
                direction: 'up'
            }, 500);
            $('#std_payment_ninclude_sp').hide('slide', {
                direction: 'up'
            }, 500);
            $('#std_payment_include_sp').hide('slide', {
                direction: 'up'
            }, 500);
        }
    }




    function reload_page() {
        window.location.reload();
    }

    function edit(id) {
        $('#form_data_edit').trigger("reset");
        $.ajax({
            url: "<?= base_url('user/nomerator/json_get_tt_detail') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            },
            success: function(result) {
                $('#edit_id').val(result.id);
                var nomerator = result.nomerator;
                var rupiah = result.jumlah;
                var reverse = rupiah.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                // Slice(potong) nomerator ME | M1 | M2 | M3
                if (nomerator.length == '7') {
                    var head = nomerator.slice(0, 2);
                    var body = nomerator.slice(2, 8);
                    $('#edit_headnumber').val(head);
                    $('#edit_bodynumber').val(body).change();
                    // Slice(potong) Nomerator LA1 | LA2
                } else if (nomerator.length == '8') {
                    var head = nomerator.slice(0, 3);
                    var body = nomerator.slice(3, 8);
                    $('#edit_headnumber').val(head);
                    $('#edit_bodynumber').val(body).change();
                    // Slice(potong) Nomerator MRLC
                } else if (nomerator.length == '9') {
                    var head = nomerator.slice(0, 4);
                    var body = nomerator.slice(4, 9);
                    $('#edit_headnumber').val(head);
                    $('#edit_bodynumber').val(body).change();
                }
                $('#edit_nama_peserta').val(result.nama_peserta);
                // $('#edit_pemilik_kartu').val(result.pemilik_kartu);
                $('#edit_program').val(result.program);
                $('#edit_jumlah').val(ribuan);
                $('#edit_date').val(result.date);
                $('#modal_edit').modal('show');
            },
            error: function(e) {
                console.log(e);
            }
        })
    }

    function hapus(id) {
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
                        url: "<?= base_url('user/nomerator/delete_nomerator') ?>",
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

    $('#bodynumber, #edit_bodynumber').select2({
        placeholder: "Pilih"
    });

    $(".datepicker").datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
    });
</script>