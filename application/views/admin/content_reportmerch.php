<div class="card">
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
                    <div class="card-footer bg-transparent"><a href="<?php echo base_url('admin/merchandise/report_completed') ?>"><i class="fas fa-forward" style="float: right"></i><b>Detail Report</b></a></div>
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
                    <div class="card-footer bg-transparent"><a href="<?php echo base_url('admin/merchandise/report_hold') ?>"><i class="fas fa-forward" style="float: right"></i><b>Detail Report</b></a></div>
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
                    <div class="card-footer bg-transparent"><a href="<?php echo base_url('admin/merchandise/report_waiting_approve') ?>"><i class="fas fa-forward" style="float: right"></i><b>Detail Report</b></a></div>
                </div>
            </div>
        </div>


        <hr>
        <br>

        <?php if (!empty($results)) { ?>
            <table class="table table-striped w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c;color:#fff;">
                        <th>No</th>
                        <th>Product</th>
                        <th>Warrior</th>
                        <th>Date Buy</th>
                        <th>Date Approve</th>
                        <th>Date Given</th>
                        <th>Size</th>
                        <th>Qty</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                        $no = 1;
                        foreach ($results as $row) {  ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row->product ?></td>
                            <td><?php echo ucfirst($row->warrior) ?></td>
                            <td><?php echo $row->sell_on_date ?></td>
                            <?php if ($row->date_approved == null) { ?>
                                <td><label class='badge badge-default badge-lg' style='cursor:default;'>WAITING APPROVED HR </label></td>
                            <?php } else { ?>
                                <td><?php echo $row->date_approved ?></td>
                            <?php } ?>
                            <?php if (($row->date_done == null) && ($row->is_approve == '1') && ($row->is_reject == '0') && ($row->is_done) == '0') { ?>
                                <td><label class='badge badge-warning badge-lg' style='cursor:default;'>Barang Belum Diberikan </label></td>
                            <?php } else if (($row->date_done == null) && ($row->is_approve == '0') && ($row->is_reject == '1') && ($row->is_done) == '0') { ?>
                                <td><label class='badge badge-danger badge-lg' style='cursor:default;'>Transaksi Ditolak </label></td>
                            <?php } else if (($row->date_done != null) && ($row->is_approve == '1') && ($row->is_reject == '0') && ($row->is_done == '1')) { ?>
                                <td><?php echo $row->date_done ?></td>
                            <?php } else { ?>
                                <td><label class='badge badge-info badge-lg' style='cursor:default;'>Menunggu Approve HR</label></td>
                            <?php } ?>
                            <?php if ($row->size == null) { ?>
                                <td><label class='badge badge-info badge-lg' style='cursor:default;'>-</label></td>
                            <?php } else { ?>
                                <td><?php echo $row->size ?></td>
                            <?php } ?>
                            <td><?php echo $row->qty ?></td>
                            <?php if (($row->is_done == '1') && ($row->is_approve == '1') && ($row->is_reject == '0')) { ?>
                                <td><button type="button" class="btn btn-success" disabled>SUCCESS</button></td>
                            <?php } else if (($row->is_done == '0') && ($row->is_approve == '1') && ($row->is_reject == '0')) { ?>
                                <td><button type='button' class='btn  btn-info' disabled>HOLD | APPROVE HR</button></td>
                            <?php } else if (($row->is_done == '0') && ($row->is_approve == '0') && ($row->is_reject == '1')) { ?>
                                <td><button type='button' class='btn  btn-info' disabled>FAILED</button></td>
                            <?php } else { ?>
                                <td><button type="button" class="btn btn-default" disabled>WAITING</button></td>
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

    function reload_page() {
        window.location.reload();
    }

    
</script>