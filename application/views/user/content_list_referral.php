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
        <h3 class="card-title">Referral List</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('user/referral?') ?>" method="get" id="form_data" class="form-horizontal" style="width:100%">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-form-label">Program</label>
                        <select class="form-control" name="program" id="program">
                            <option value="all">All</option>
                            <?php if (!empty($program)) {
                                foreach ($program as $r) {
                                    if ($r->alias == $_GET['program']) {
                                        echo "<option value='" . $r->alias . "' selected>" . $r->name . "</option>";
                                    } else {
                                        echo "<option value='" . $r->alias . "'>" . $r->name . "</option>";
                                    }
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Referrorr</label>
                        <select class="form-control js-example-basic-single" name="referror" id="referror" style="width: 100%">
                            <option value="all">All</option>
                            <?php if (!empty($referror)) {
                                foreach ($referror as $r) {
                                    if ($r->id_referror == $_GET['referror']) {
                                        echo "<option value='" . $r->id_referror . "' selected>" . $r->name . "</option>";
                                    } else {
                                        echo "<option value='" . $r->id_referror . "'>" . $r->name . "</option>";
                                    }
                                }
                            } ?>
                        </select>
                    </div>


                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-form-label">Status Tele</label>
                        <select class="form-control" name="status_tele" id="status_tele">

                            <?php if (($this->input->get('status_tele') == 'all') || ($this->input->get('status_tele') == '')) { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot1">Tidak Terhubung 1x</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else if ($this->input->get('status_tele') == 'signup_fp') { ?>
                                <option value="all">All</option>
                                <option value="signup_fp" selected>Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot1">Tidak Terhubung 1x</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else if ($this->input->get('status_tele') == 'signup_dp') { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp" selected>Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot1">Tidak Terhubung 1x</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else if ($this->input->get('status_tele') == 'v') { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v" selected>Tertarik</option>
                                <option value="dot1">Tidak Terhubung 1x</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else if ($this->input->get('status_tele') == 'dot1') { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot1" selected>Tidak Terhubung 1x</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else if ($this->input->get('status_tele') == 'dot2') { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot1">Tidak Terhubung 1x</option>
                                <option value="dot2" selected>Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else if ($this->input->get('status_tele') == 'dot3') { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot1">Tidak Terhubung 1x</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3" selected>Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else if ($this->input->get('status_tele') == 'cb') { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot1">Tidak Terhubung 1x</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb" selected>Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else if ($this->input->get('status_tele') == 'x') { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x" selected>Tidak Tertarik</option>
                                <option value="-">Belum Dihubungi</option>
                            <?php } else { ?>
                                <option value="all">All</option>
                                <option value="signup_fp">Signup Lunas</option>
                                <option value="signup_dp">Signup DP</option>
                                <option value="v">Tertarik</option>
                                <option value="dot2">Tidak Terhubung 2x</option>
                                <option value="dot3">Tidak Terhubung 3x</option>
                                <option value="cb">Telfon Kembali</option>
                                <option value="x">Tidak Tertarik</option>
                                <option value="-" selected>Belum Dihubungi</option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-block" type="submit" style="margin-top: 35px"><i class="fa fa-search"></i>&nbsp; Search</button>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-success btn-block" id="export_referral" style="margin-top: 35px"><i class="fa fa-download"></i>&nbsp; Export</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>


        <hr>
        <br>
        <?php if (!empty($filter)) { ?>
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
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $no = 1;
                    foreach ($filter as $row) {  ?>
                        <tr>

                            <td><?php echo $no++ ?></td>
                            <td><?php echo ucfirst($row['name']) ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><label class="badge badge-info"><?php echo $row['program_name'] ?></label></td>
                            <td><?php echo ucfirst($row['referror']) ?></td>
                            <?php if ($row['status_tele'] == 'signup_fp') { ?>
                                <td>
                                    <h5 data-toggle='tooltip' data-placement='top' title='Signup Lunas'><label class='badge black'><i class='fa fa-check'></i> <b>Lunas</b></label></h3>
                                        <?php if (($row['signup_date'] != null) && ($row['date_referral'] != null)) { ?>
                                            <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                        <?php } elseif (($row['signup_date'] == null) && ($row['date_referral'] != null)) { ?>
                                            <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                        <?php } else { ?>
                                            <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                        <?php } ?>
                                </td>
                            <?php } elseif ($row['status_tele'] == 'signup_dp') { ?>
                                <td>
                                    <h5 data-toggle='tooltip' data-placement='top' title='Signup DP'><label class='badge purple'><i class='fa fa-bell'></i> <b>DP</b></label></h5>
                                    <?php if (($row['signup_date'] != null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                    <?php } elseif (($row['signup_date'] == null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                    <?php } else { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                    <?php } ?>
                                </td>
                            <?php } elseif ($row['status_tele'] == 'v') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Hadir SP'><label class='badge badge-success'> <b>v</b></label></h3>
                                    <?php if (($row['signup_date'] != null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                    <?php } elseif (($row['signup_date'] == null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                    <?php } else { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                    <?php } ?>
                                </td>
                            <?php } elseif ($row['status_tele'] == 'dot1') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Tidak Terhubung 1x'><label class='badge blue'><i class='fa fa-circle'></i> <b>1</b></label></h3>
                                    <?php if (($row['signup_date'] != '') && ($row['date_referral'] != '')) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                    <?php } elseif (($row['signup_date'] == '') && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                    <?php } else { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                    <?php } ?>
                                </td>
                            <?php } elseif ($row['status_tele'] == 'dot2') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Tidak Terhubung 2x'><label class='badge lime accent-2'> <i class='fa fa-circle'></i> <b>2</b></label></h3>
                                    <?php if (($row['signup_date'] != null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                    <?php } elseif (($row['signup_date'] == null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                    <?php } else { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                    <?php } ?>
                                </td>
                            <?php } elseif ($row['status_tele'] == 'dot3') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Tidak Terhubung 3x'><label class='badge badge-warning'><i class='fa fa-circle'></i> <b>3</b></label></h3>
                                    <?php if (($row['signup_date'] != null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                    <?php } elseif (($row['signup_date'] == null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                    <?php } else { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                    <?php } ?>
                                </td>
                            <?php } elseif ($row['status_tele'] == 'cb') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Telfon Kembali'><label class='badge rgba-pink-strong'><i class='fa fa-phone'></i> <b>CB</b></label></h3>
                                    <?php if (($row['signup_date'] != null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                    <?php } elseif (($row['signup_date'] == null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                    <?php } else { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                    <?php } ?>
                                </td>
                            <?php } elseif ($row['status_tele'] == 'x') { ?>
                                <td>
                                    <h3 data-toggle='tooltip' data-placement='top' title='Tidak Datang SP'><label class='badge badge-danger'><b>x</b></label></h3>
                                    <?php if (($row['signup_date'] != null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                    <?php } elseif (($row['signup_date'] == null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                    <?php } else { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                    <?php } ?>
                                </td>
                            <?php } else { ?>
                                <td>
                                    <h5 data-toggle='tooltip' data-placement='top' title='Not Contacted'><label class='badge badge-info'> <b>Not Contacted</b></label></h5>
                                    <?php if (($row['signup_date'] != null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['signup_date'])) ?></small>
                                    <?php } elseif (($row['signup_date'] == null) && ($row['date_referral'] != null)) { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_referral'])) ?></small>
                                    <?php } else { ?>
                                        <small class="text-info" style="font-size: 11px"><?php echo date('d F Y', strtotime($row['date_created'])) ?></small>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                            <?php if ($row['description'] != NULL) { ?>
                                <td><span><?php echo $row['description'] ?></span></td>
                            <?php } else { ?>
                                <td><span>Belum ada Keterangan</span></td>
                            <?php } ?>
                            <?php if ($row['status_tele'] == 'signup_fp') {
                                echo "<td nowrap='nowrap'>
                                            <h5 data-toggle='tooltip' data-placement='top' title='Not Contacted'><label class='badge stylish-color'> <b>-</b></label></h5>
                                        </td>";
                            } else {
                                echo "<td nowrap='nowrap'>
                                            <a class='btn btn-info btn-block' onclick='edit(" . $row['id_referral'] . ")' title='Process Data' data-placement='top'><i class='fa fa-edit'></i> PROCESS DATA</a>
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


<div class="modal fade" id="modal_update" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('user/referral/submit_data_referral') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Form Referror</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_referral" id="id_referral" value="">
                    <input type="hidden" name="url" id="url" value="<?= $_SERVER['QUERY_STRING'] ?>">

                    <div class="col-md-12">
                        <!-- <div class="form-group">-->
                        <!--    <label class="col-form-label">Date</label>-->
                        <!--    <input name="date_referral" id="date_referral" class="form-control datepicker" type="text" placeholder="Date Referral" required="" autocomplete="off">-->
                        <!--</div>-->
                        <div class="form-group">
                            <label class="col-form-label">Status Tele</label>
                            <select class="form-control" name="status" id="status" required>
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
                        <div class="form-group" id="show_signup_date">
                            <label class="col-form-label">Signup Date</label>
                            <input name="signup_date" id="signup_date" class="form-control datepicker" type="text" placeholder="Signup Date" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" type="text" placeholder="Description" autocomplete="off"></textarea>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- END MODAL REFERROR -->




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

        $("#date_start").datepicker({
            todayHighlight: !0,
            dateFormat: 'yy-mm-dd',
            autoclose: !0,
            maxDate: "<?= date('Y-m-d') ?>"
        });
    });

    $("#date_start").change(function(event) {
        $('#date_end').datepicker("destroy").remove();
        $('#div_date_end').append(
            '<input type="text" name="date_end" id="date_end" class="form-control" autocomplete="off">');
        var min = $('#date_start').val();
        var max = new Date();
        $("#date_end").datepicker({
            todayHighlight: !0,
            dateFormat: 'yy-mm-dd',
            autoclose: !0,
            minDate: min,
            maxDate: max
        });
        
         show_signup_column();
    });
    
    $('#status').change(function() {
        show_signup_column();
    });

    function show_signup_column() {
        var status = $('#status').val();
        if ((status == 'signup_fp') || (status == 'signup_dp')) {
            $('#show_signup_date').show('slide', {
                direction: 'up'
            }, 500);
        } else {
            $('#show_signup_date').hide('slide', {
                direction: 'up'
            }, 500);
        }
    }

    $('#export_referral').click(function() {
        var query = "<?= $_SERVER['QUERY_STRING'] ?>";
        var url = "<?= base_url('user/referral/export_referral?') ?>" + query;
        window.open(url, '_blank');
    });

    $('.js-example-basic-single').select2();

    $(".datepicker").datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
    });

    function edit(id) {
        $('#form_data').trigger("reset");
        $.ajax({
            url: "<?= base_url('user/referral/json_get_referral_detail') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'id_referral': id
            },
            success: function(result) {
                $('#id_referral').val(result.id_referral);
                var status = result.status_tele;
                var signup = result.signup_date;
                var signup_dp = result.date_referral;
                if ((status == 'signup_fp') || (status == 'signup_dp')) {
                    $('#show_signup_date').show();
                    if (status == 'signup_fp') {
                        $('#signup_date').val(signup);
                    } else {
                        $('#signup_date').val(signup_dp);
                    }
                } else {
                    $('#show_signup_date').hide();
                }
                // $('#date_referral').val(result.date_referral).attr('readonly', true);
                $('#status').val(status);
                $('#description').val(result.description);
                $('#modal_update').modal('show');
            },
            error: function(e) {
                console.log(e);
            }
        })
    }


    function reload_page() {
        window.location.reload();
    }

    $('#showdata').click(function() {
        $('#form_data').trigger("reset");
        $('#modal_search').modal('show');
    });


    $('.numeric').keyup(function(e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });
</script>