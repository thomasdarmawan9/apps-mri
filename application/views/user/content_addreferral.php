<style>
    .select2-container .select2-selection--single {
        height: 37px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 37px !important;
        margin-left: 5px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 37px !important;
    }
</style>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Referral</h3>
    </div>
    <div class="card-body">

        <a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Referral</a>
        <p>Here You Can do <code>Create, Edit and Delete</code>.
        </p>

        <br>
        <?php if (!empty($results)) { ?>
            <table class="table table-striped w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c;color:#fff;">
                        <th>No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Program</th>
                        <th>Referral</th>
                        <th>Status Tele</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $no = 1;
                    foreach ($results as $row) {  ?>
                        <tr>

                            <td><?php echo $no++ ?></td>
                            <td><?php echo ucfirst($row->name) ?></td>
                            <td><?php echo $row->phone ?></td>
                            <td><?php echo $row->email ?></td>
                            <td><label class="badge badge-info"><?php echo $row->program_name ?></label></td>
                            <td><?php echo ucfirst($row->referror) ?></td>

                            <?php if ($row->status_tele == 'signup_fp') { ?>
                                <td>
                                    <h5 data-toggle='tooltip' data-placement='top' title='Signup Lunas'><label class='badge black'><i class='fa fa-check'></i> <b>Lunas</b></label></h3>
                                </td>
                            <?php } elseif ($row->status_tele == 'signup_dp') { ?>
                                <td>
                                    <h5 data-toggle='tooltip' data-placement='top' title='Signup DP'><label class='badge purple'><i class='fa fa-bell'></i> <b>DP</b></label></h5>
                                </td>
                            <?php } elseif ($row->status_tele == 'v') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Hadir SP'><label class='badge badge-success'> <b>v</b></label></h3>
                                </td>
                            <?php } elseif ($row->status_tele == 'dot1') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Tidak Terhubung 1x'><label class='badge blue'><i class='fa fa-circle'></i> <b>1</b></label></h3>
                                </td>
                            <?php } elseif ($row->status_tele == 'dot2') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Tidak Terhubung 2x'><label class='badge lime accent-2'> <i class='fa fa-circle'></i> <b>2</b></label></h3>
                                </td>
                            <?php } elseif ($row->status_tele == 'dot3') { ?>
                                <td>
                                    ><h3 data-toggle='tooltip' data-placement='top' title='Tidak Terhubung 3x'><label class='badge badge-warning'><i class='fa fa-circle'></i> <b>3</b></label></h3>
                                </td>
                            <?php } elseif ($row->status_tele == 'cb') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Telfon Kembali'><label class='badge rgba-pink-strong'><i class='fa fa-phone'></i> <b>CB</b></label></h3>
                                </td>
                            <?php } elseif ($row->status_tele == 'x') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Tidak Datang SP'><label class='badge badge-danger'><b>x</b></label></h3>
                                </td>
                            <?php } else { ?>
                                <td>
                                    <h5 data-toggle='tooltip' data-placement='top' title='Not Contacted'><label class='badge badge-info'> <b>Not Contacted</b></label></h5>
                                </td>
                            <?php } ?>
                            <?php
                            if ($row->status_tele == 'signup_dp') {
                                echo " <td nowrap='nowrap'>
                                        <a class='btn btn-info' onclick='edit(" . $row->id_referral . ")' title='Edit Data' data-placement='top'><i class='fa fa-edit'></i> EDIT</a>
                                    </td>";
                            } elseif ($row->status_tele == 'signup_fp') {
                                echo " <td nowrap='nowrap'>
                                        <h5 data-toggle='tooltip' data-placement='top' title='Not Contacted'><label class='badge stylish-color'> <b>-</b></label></h5>
                                       </td>";
                            } else {
                                echo " <td nowrap='nowrap'>
                                <a class='btn btn-info' onclick='edit(" . $row->id_referral . ")' title='Edit Data' data-placement='top'><i class='fa fa-edit'></i> EDIT</a>
                                    <button type='button' class='btn  btn-danger' onclick='hapus(" . $row->id_referral . ")'><i class='fa fa-trash'></i> HAPUS</button>
                                </td>";
                            }
                            ?>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        <?php } else {
            echo "<center><p>Data Not found</p></center>";
        } ?>


    </div>
</div>

<!-- MODAL TAMBAH MASTER REFERRAL -->

<div class="modal fade" id="modal_tambah" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('user/referral/submit_form_referral') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Form Referral</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_referral" id="id_referral" value="">
                    
                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input name="name" id="name" class="form-control" type="text" placeholder="Name" required="" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Phone</label>
                            <input name="phone" id="phone" class="form-control numeric" type="text" placeholder="Phone" required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">E-mail</label>
                            <input name="email" id="email" class="form-control" type="text" placeholder="E-mail" required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Program</label>
                        <select class="form-control js-example-basic-single" name="program" id="program" required="" style="width: 100%">
                              <option value="">-Pilih Salah Satu-</option>
                                <?php if (!empty($program)) {
                                    foreach ($program as $p) { ?>
                                        <option value="<?= $p->alias ?>"><?= $p->name; ?></option>
                                <?php }
                                } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Referror</label>
                            <select class="form-control js-example-basic-single" name="referror" id="referror" required="" style="width: 100%">
                                <option value="">-Pilih Salah Satu-</option>
                                <?php if (!empty($referror)) {
                                    foreach ($referror as $r) { ?>
                                        <option value="<?= $r->id_referror; ?>"><?= $r->name; ?></option>
                                <?php }
                                } ?>
                            </select>
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

<!-- END MODAL TAMBAH MASTER REFERRAL -->

<!-- MODAL EDIT MASTER REFERRAL -->

<div class="modal fade" tabindex="-1" id="modal_edit" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('user/referral/submit_form_referral') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Form Referral</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_referral" id="editid_referral" value="">
                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input name="name" id="editname" class="form-control" type="text" placeholder="Name" required="" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Phone</label>
                        <input name="phone" id="editphone" class="form-control numeric" type="text" placeholder="Phone" required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">E-mail</label>
                        <input name="email" id="editemail" class="form-control" type="text" placeholder="E-mail" required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Program</label>
                        <select class="form-control js-example-basic-single" name="program" id="editprogram" required="">
                           <option value="">-Pilih Salah Satu-</option>
                            <?php if (!empty($program)) {
                                foreach ($program as $p) { ?>
                                    <option value="<?= $p->alias ?>"><?= $p->name; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Referror</label>
                        <select class="form-control js-example-basic-single" name="referror" id="editreferror" required="" style="width: 100%">
                            <option value="">-Pilih Salah Satu-</option>
                            <?php if (!empty($referror)) {
                                foreach ($referror as $r) { ?>
                                    <option value="<?= $r->id_referror; ?>"><?= $r->name; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group" hidden>
                        <label class="col-form-label">Status Tele</label>
                        <select class="form-control" name="status" id="editstatus">
                            <option value="-">Belum Dihubungi</option>
                            <option value="signup_fp">Signup Lunas</option>
                            <option value="signup_dp">Signup DP</option>
                            <option value="v">Tertarik</option>
                            <option value="dot1">Tidak Terhubung 1x</option>
                            <option value="dot2">Tidak Terhubung 2x</option>
                            <option value="dot3">Tidak Terhubung 3x</option>
                            <option value="cb">Telfon Kembali</option>
                            <option value="x">Tidak Tertarik</option>
                        </select>
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

<!-- END MODAL EDIT MASTER REFERRAL -->




<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table1').DataTable({
            'scrollX': true,
            'lengthMenu': [
                [10, 25, -1],
                [10, 25, "All"]
            ],
            'rowReorder': {
                'selector': 'td:nth-child(3)'
            },
            'responsive': true
        });

        edit();
    });

    $(".datepicker").datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
    });

    function reload_page() {
        window.location.reload();
    }
    
     $('.js-example-basic-single').select2();

    $('#showtambah').click(function() {
        $('#form_data').trigger("reset");
        $('#modal_tambah').modal('show');
    });

   function edit(id_referral) {
        var status = $('#editstatus').val();
        $('#form_data').trigger("reset");
        $.ajax({
            url: "<?= base_url('user/referral/json_get_referral_detail') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'id_referral': id_referral
            },
            success: function(result) {

                var tele = result.status_tele


                $('#editid_referral').val(result.id_referral);
                $('#editname').val(result.name);
                if ((tele == 'signup_fp') || (tele == 'signup_dp')) {
                    $('#editphone').val(result.phone).prop('readonly', true);
                    $('#editprogram').val(result.program).attr('disabled', true).change();
                    $('#editstatus').val(result.status_tele).attr('disabled', true);
                    $('#editreferror').val(result.referral).attr('disabled', 'disabled').change();
                } else {
                    $('#editphone').val(result.phone).prop('readonly', false);
                    $('#editprogram').val(result.program).attr('disabled', false).change();
                    $('#editstatus').val(result.status_tele).attr('disabled', false);
                    $('#editreferror').val(result.referral).attr('disabled', false).change();
                }
                $('#editemail').val(result.email);

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
                        url: "<?= base_url('user/referral/delete_referral') ?>",
                        type: "POST",
                        dataType: "json",
                        data: {
                            'id_referral': id
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

    $('.numeric').keyup(function(e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });
</script>