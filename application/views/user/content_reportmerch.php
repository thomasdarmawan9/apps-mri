x<div class="card">
    <div class="card-header">
        <h3 class="card-title">Report Merchandise</h3>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-sm-4">
                <div class="card text-white mb-3" style="max-width: 30rem; background: #03fc52;">
                    <div class="card-header"><b>Completed Merchandise</b></div>
                    <div class="card-body">
                        <?php if (!empty($completed)) { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;"><?php echo $completed ?></h3>
                        <?php } else { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">0</h3>
                        <?php } ?>
                    </div>
                    <div class="card-footer bg-transparent"><a href="<?php echo base_url('user/merchandise/report_completed') ?>"><i class="fas fa-forward" style="float: right"></i><b>Detail Report</b></a></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-white mb-3" style="max-width: 30rem; background: #f33837">
                    <div class="card-header"><b>Hold Merchandise</b></div>
                    <div class="card-body">
                        <?php if (!empty($hold)) { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;"><?php echo $hold ?></h3>
                        <?php } else { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">0</h3>
                        <?php } ?>
                    </div>
                    <div class="card-footer bg-transparent"><a href="<?php echo base_url('user/merchandise/report_hold') ?>"><i class="fas fa-forward" style="float: right"></i><b>Detail Report</b></a></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                    <div class="card-header"><b>Waiting Approve</b></div>
                    <div class="card-body">
                        <?php if (!empty($waiting)) { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;"><?php echo $waiting ?></h3>
                        <?php } else { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">0</h3>
                        <?php } ?>
                    </div>
                    <div class="card-footer bg-transparent"><a href="<?php echo base_url('user/merchandise/report_waiting_approve') ?>"><i class="fas fa-forward" style="float: right"></i><b>Detail Report</b></a></div>
                </div>
            </div>
        </div>


        <hr>
        <br>
        
        <h4>Filter Data</h4>
        <form method="get" action="<?= base_url('user/merchandise/report_merchandise?') ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Date Start</label>
                        <div class="col-sm-8">
                            <input type="text" name="date_start" id="date_start" class="form-control datepicker" placeholder="Select Date" value="<?= !empty($this->input->get('date_start')) ? $this->input->get('date_start') : '' ?>" autocomplete="off" required>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Date End</label>
                        <div class="col-sm-8" id="div_date_end">
                            <input type="text" name="date_end" id="date_end" class="form-control datepicker" placeholder="Select Date" value="<?= !empty($this->input->get('date_end')) ? $this->input->get('date_end') : '' ?>" autocomplete="off" required>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-6">
                    <button type="submit" class="btn primary-color-dark" id="filter"><i class="fa fa-search"></i>&nbsp; FILTER</button>
                </div>
            </div>
        </form>
        
        <hr>

        <?php if (!empty($results)) { ?>
            <table class="table table-striped w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c;color:#fff;">
                
                        <th style="width: 3%">No</th>
                        <th style="width: 10%">Product</th>
                        <th style="width: 8%">Warrior</th>
                        <th style="width: 8%">Overtime</th>
                        <th style="width: 10%">Date Buy</th>
                        <th style="width: 10%">Date Approve</th>
                        <th style="width: 5%">Date Given</th>
                        <th style="width: 10%">Size</th>
                        <th style="width: 10%">Qty</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 10%">Action</th>
                        
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                        $no = 1;
                        foreach ($results as $row) {  ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['product'] ?></td>
                            <td><?php echo ucfirst($row['warrior']) ?></td>
                            <td><?php echo $row['total'] ?></td>
                            <td><?php echo $row['sell_on_date'] ?></td>
                            <?php if ($row['date_approved'] == null) { ?>
                                <td><label class='badge badge-default badge-lg' style='cursor:default;'>WAITING APPROVED HR </label></td>
                            <?php } else { ?>
                                <td><?php echo $row['date_approved'] ?></td>
                            <?php } ?>
                            <?php if (($row['date_done'] == null) && ($row['is_approve'] == '1') && ($row['is_reject'] == '0') && ($row['is_done']) == '0') { ?>
                                <td><label class='badge badge-warning badge-lg' style='cursor:default;'>Barang Belum Diberikan </label></td>
                            <?php } else if (($row['date_done'] == null) && ($row['is_approve'] == '0') && ($row['is_reject'] == '1') && ($row['is_done']) == '0') { ?>
                                <td><label class='badge badge-danger badge-lg' style='cursor:default;'>Transaksi Ditolak </label></td>
                            <?php } else if (($row['date_done'] != null) && ($row['is_approve'] == '1') && ($row['is_reject'] == '0') && ($row['is_done'] == '1')) { ?>
                                <td><?php echo $row['date_done'] ?></td>
                            <?php } else { ?>
                                <td><label class='badge badge-info badge-lg' style='cursor:default;'>Menunggu Approve HR</label></td>
                            <?php } ?>
                            <?php if ($row['size'] == null) { ?>
                                <td><label class='badge badge-info badge-lg' style='cursor:default;'>-</label></td>
                            <?php } else { ?>
                                <td><?php echo $row['size'] ?></td>
                            <?php } ?>
                            <td><?php echo $row['qty'] ?></td>
                            <?php if ($row['is_approve'] == '1') { ?>
                                <td><button type="button" class="btn btn-success" disabled>APPROVED BY HR</button></td>
                            <?php } else if ($row['is_reject'] == '1') { ?>
                                <td><button type='button' class='btn  btn-danger' disabled> REJECT BY HR</button></td>
                            <?php } else { ?>
                                <td><button type="button" class="btn btn-default" disabled>WAITING</button></td>
                            <?php } ?>
                            <?php if (($row['is_approve'] == '1') && ($row['is_done'] == '1')) { ?>
                                <td><button type="button" class="btn btn-success" disabled>DONE</button></td>
                            <?php } else if (($row['is_reject'] == '1') && ($row['is_done'] == '0')) { ?>
                                <td><button type='button' class='btn  btn-danger' disabled>FAILED</button></td>
                            <?php } else if (($row['is_approve'] == '1') && ($row['is_done'] == '0')) { ?>
                                <td>
                                    <button class="btn btn-info" onclick="edit(<?= $row['id_log_product']; ?>)"><i class="fa fa-check"></i></button>
                                </td>
                            <?php } else { ?>
                                <td><button type="button" class="btn btn-default" disabled>HOLD</button></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo "<center><p>Data Not found</p></center>";
        } ?>


    </div>

    <!-- <a href='http://apps.mri.co.id/?auth=hapususer&id=<?php echo $r->id; ?>'></a> -->
</div>


<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>

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
    });
    
     $('.datepicker').datepicker({
        todayHighlight: !0,
        dateFormat: 'yy-mm-dd',
        autoclose: !0,
        maxDate: 0
    });

    function reload_page() {
        window.location.reload();
    }

    function edit(id_log_product) {
        if (id_log_product != '') {
            swal({
                title: 'Konfirmasi',
                text: "Pastikan Barang Sudah diterima Warrior, Lanjutkan?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f35958',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }, function(result) {
                if (result) {
                    $.ajax({
                        url: "<?= base_url('user/merchandise/done_merch') ?>",
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
</script>