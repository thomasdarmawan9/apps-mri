<div class="card">
    <div class="card-header">
        <h3 class="card-title">Finance Summary</h3>
    </div>
    <div class="card-body">
        <form method="get" action="<?= base_url('finance/report/finance_summary?') ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">PT</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="id_pt" id="id_pt" style="width: 100%;" required="">
                                <option value="">- Please Choose -</option>
                                <?php
                                foreach ($pt as $row) {
                                    if ($row->id_pt == $this->input->get('id_pt')) {
                                        echo "<option value='" . $row->id_pt . "' selected>" . ucfirst($row->name) . "</option>";
                                    } else {
                                        echo "<option value='" . $row->id_pt . "'>" . ucfirst($row->name) . "</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Month</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="month" id="month" style="width: 100%;" required="">
                                <option value="">- Please Choose -</option>
                                <?php foreach ($list_bulan as $key => $val) {
                                    if ($key == $this->input->get('month')) {
                                        echo "<option value='" . $key . "' selected>" . $val . "</option>";
                                    } else {
                                        echo "<option value='" . $key . "'>" . $val . "</option>";
                                    }
                                } ?>
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Year</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="tahun" id="tahun" style="width: 100%;" required="">
                                <?php $year = date('Y'); ?>
                                <option value="">- Please Choose -</option>
                                <?php
                                for ($y = 2017; $y <= $year; $year--) {
                                    if ($year == $this->input->get('tahun')) {
                                        echo "<option value='" . $year . "' selected>" . $year . "</option>";
                                    } else {
                                        echo "<option value='" . $year . "'>" . $year . "</option>";
                                    }
                                } ?>

                            </select>
                        </div>
                    </div>


                </div>

                <div class="col-md-6">

                </div>

            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-6">
                    <button type="submit" class="btn primary-color-dark" id="filter"><i class="fa fa-search"></i>&nbsp; FILTER</button>
                </div>
            </div>
        </form>

        <?php if ((!empty($initial_balance)) && (!empty($final_balance)) && (!empty($balance)) && (!empty($income)) && (!empty($expense))) { ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                        <?php
                            foreach ($results_pt as $row) { ?>
                            <div class="card-header"><b style="float: left"><?php echo $row['pt'] ?></b> <i class="fa fa-bank" style="float:right"></i></div>
                        <?php } ?>
                        <div class="card-body">
                            <span style="font-weight:bold;margin-left: 1px; float:left">Saldo Bulan <?php echo date('M', strtotime('-1 month')) ?> :</span><br>
                            <?php
                                foreach ($initial_balance as $ib) { ?>
                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($ib['ibalance'], 2) ?></h3>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                        <?php
                            foreach ($results_pt as $row) { ?>
                            <div class="card-header"><b style="float: left"><?php echo $row['pt'] ?></b> <i class="fa fa-bank" style="float:right"></i></div>
                        <?php } ?>
                        <div class="card-body">
                            <span style="font-weight:bold;margin-left: 1px; float:left">Saldo Bulan <?php echo date('M') ?> :</span><br>
                            <?php
                                foreach ($final_balance as $fb) { ?>
                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($fb['fbalance'], 2) ?></h3>
                            <?php  } ?>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                        <?php
                            foreach ($results_pt as $row) { ?>
                            <div class="card-header"><b style="float: left"><?php echo $row['pt'] ?></b> <i class="fa fa-bank" style="float:right"></i></div>
                        <?php } ?>
                        <div class="card-body">
                            <span style="font-weight:bold;margin-left: 1px; float:left">Profit/Loss :</span><br>
                            <?php
                                foreach ($final_balance as $fb) {
                                    foreach ($initial_balance as $ib) { ?>
                                    <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format(($fb['fbalance']) - ($ib['ibalance']), 2) ?></h3>
                            <?php  }
                                } ?>

                        </div>
                    </div>
                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-sm-4">
                    <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                        <?php
                            foreach ($results_pt as $row) { ?>
                            <div class="card-header"><b style="float: left"><?php echo $row['pt'] ?></b> <i class="fa fa-bank" style="float:right"></i></div>
                        <?php } ?>
                        <div class="card-body">
                            <span style="font-weight:bold;margin-left: 1px; float:left">Balance :</span><br>
                            <?php
                                foreach ($balance as $row) { ?>
                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($row['blnc'], 2) ?></h3>
                            <?php } ?>
                        </div>
                        <a id="show_finsum_detail">
                            <div class="card-footer bg-transparent"><i class="fas fa-forward" style="float: right"></i><b>Transaction Detail</b></div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-white mb-3" style="max-width: 30rem; background: #03fc52;">
                        <?php
                            foreach ($results_pt as $row) { ?>
                            <div class="card-header"><b style="float: left"><?php echo $row['pt'] ?></b> <i class="fa fa-bank" style="float:right"></i></div>
                        <?php } ?>
                        <div class="card-body">
                            <span style="font-weight:bold;margin-left: 1px; float:left">Income :</span><br>
                            <?php
                                foreach ($income as $row) { ?>
                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($row['inc'], 2) ?></h3>
                            <?php } ?>
                        </div>

                        <a id="show_finsum_income_detail">
                            <div class="card-footer bg-transparent"><i class="fas fa-forward" style="float: right"></i><b>Transaction Detail</b></div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-white mb-3" style="max-width: 30rem; background: #f33837;">
                        <?php
                            foreach ($results_pt as $row) { ?>
                            <div class="card-header"><b style="float: left"><?php echo $row['pt'] ?></b> <i class="fa fa-bank" style="float:right"></i></div>
                        <?php } ?>
                        <div class="card-body">
                            <span style="font-weight:bold;margin-left: 1px; float:left">Expense :</span><br>
                            <?php
                                foreach ($expense as $row) { ?>
                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($row['exp'], 2) ?></h3>
                            <?php } ?>
                        </div>

                        <a id="show_finsum_expense_detail">
                            <div class="card-footer bg-transparent"><i class="fas fa-forward" style="float: right"></i><b>Transaction Detail</b></div>
                        </a>
                    </div>
                </div>

            </div>
        <?php } else {
            echo "<hr>";
            echo "<center><p>Data Not found</p></center>";
        } ?>

    </div>
</div>

<!--START OF MODAL FINSUM DETAIL-->

<div class="modal fade" id="modal_detail" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#000; color:#fff">
                <h4 class="modal-title" id="myModalLabel">Finance Summary Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <?php if ((!empty($results)) && (!empty($lock))) { ?>
                        <table class="table table-bordered w-100" id="table1">
                            <thead class="text-center">
                                <tr style="background-color: #000 ;font-size:0.9rem;color:#fff;">
                                    <th class="text-center" style="vertical-align: middle;">No</th>
                                    <th style="vertical-align: middle">Date</th>
                                    <th style="vertical-align: middle">Payment Source</th>
                                    <th style="vertical-align: middle">Indeks</th>
                                    <th style="vertical-align: middle">Transaction</th>
                                    <th style="vertical-align: middle">Qty</th>
                                    <th style="vertical-align: middle">Price</th>
                                    <th style="vertical-align: middle">Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                    $no = 1;
                                    foreach ($results as $row) {
                                        echo "<tr style='font-size:0.9rem;'>";
                                        echo "<td class='text-center'>" . $no++ . "</td>";
                                        echo "<td>" . $row['tgl_nota'] . "</td>";
                                        echo "<td>" . $row['bank'] . "</td>";
                                        echo "<td>" . $row['indeks'] . "</td>";
                                        echo "<td>" . $row['transaksi'] . "</td>";
                                        echo "<td>" . $row['qty'] . "</td>";
                                        echo "<td>" . number_format($row['price'], 2) . "</td>";
                                        echo "<td>" . number_format($row['income'], 2) . "</td>";
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

            <div class="modal-footer">
                <button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--END OF MODAL FINSUM DETAIL-->

<!--START OF MODAL FINSUM INCOME DETAIL-->

<div class="modal fade" tabindex="-1" id="modal_detail_income" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#03fc52;color:#fff">
                <h4 class="modal-title" id="myModalLabel">Finance Summary Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <?php if ((!empty($results_income)) && (!empty($lock))) { ?>
                        <table class="table table-bordered w-100" id="table2">
                            <thead class="text-center">
                                <tr style="background-color: #03fc52 ;font-size:0.9rem;color:#fff;">
                                    <th class="text-center" style="vertical-align: middle;">No</th>
                                    <th style="vertical-align: middle">Date</th>
                                    <th style="vertical-align: middle">Payment Source</th>
                                    <th style="vertical-align: middle">Indeks</th>
                                    <th style="vertical-align: middle">Transaction</th>
                                    <th style="vertical-align: middle">Qty</th>
                                    <th style="vertical-align: middle">Price</th>
                                    <th style="vertical-align: middle">Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                    $no = 1;
                                    foreach ($results_income as $row) {
                                        echo "<tr style='font-size:0.9rem;'>";
                                        echo "<td class='text-center'>" . $no++ . "</td>";
                                        echo "<td>" . $row['tgl_nota'] . "</td>";
                                        echo "<td>" . $row['bank'] . "</td>";
                                        echo "<td>" . $row['indeks'] . "</td>";
                                        echo "<td>" . $row['transaksi'] . "</td>";
                                        echo "<td>" . $row['qty'] . "</td>";
                                        echo "<td>" . number_format($row['price'], 2) . "</td>";
                                        echo "<td>" . number_format($row['income'], 2) . "</td>";
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

            <div class="modal-footer">
                <button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--END OF MODAL FINSUM INCOME DETAIL-->


<!--START OF MODAL FINSUM EXPENSE DETAIL-->

<div class="modal fade" id="modal_detail_expense" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#f33837;color:#fff">
                <h4 class="modal-title" id="myModalLabel">Finance Summary Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <?php if ((!empty($results_expense)) && (!empty($lock))) { ?>
                        <table class="table table-bordered w-100" id="table3">
                            <thead class="text-center">
                                <tr style="background-color: #f33837 ;font-size:0.9rem;color:#fff;">
                                    <th class="text-center" style="vertical-align: middle;">No</th>
                                    <th style="vertical-align: middle">Date</th>
                                    <th style="vertical-align: middle">Payment Source</th>
                                    <th style="vertical-align: middle">Indeks</th>
                                    <th style="vertical-align: middle">Transaction</th>
                                    <th style="vertical-align: middle">Qty</th>
                                    <th style="vertical-align: middle">Price</th>
                                    <th style="vertical-align: middle">Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                    $no = 1;
                                    foreach ($results_expense as $row) {
                                        echo "<tr style='font-size:0.9rem;'>";
                                        echo "<td class='text-center'>" . $no++ . "</td>";
                                        echo "<td>" . $row['tgl_nota'] . "</td>";
                                        echo "<td>" . $row['bank'] . "</td>";
                                        echo "<td>" . $row['indeks'] . "</td>";
                                        echo "<td>" . $row['transaksi'] . "</td>";
                                        echo "<td>" . $row['qty'] . "</td>";
                                        echo "<td>" . number_format($row['price'], 2) . "</td>";
                                        echo "<td>" . number_format($row['income'], 2) . "</td>";
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

            <div class="modal-footer">
                <button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--END OF MODAL FINSUM EXPENSE DETAIL-->


<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>

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
        });

        $('#table2').DataTable({
            //'scrollX': true,
            'lengthMenu': [
                [10, 25, , 50, -1],
                [10, 25, 50, "All"]
            ],
            'rowReorder': {
                'selector': 'td:nth-child(2)'
            },
            'responsive': true,
        });

        $('#table3').DataTable({
            //'scrollX': true,
            'lengthMenu': [
                [10, 25, , 50, -1],
                [10, 25, 50, "All"]
            ],
            'rowReorder': {
                'selector': 'td:nth-child(2)'
            },
            'responsive': true,
        });

    });

    function reload_page() {
        window.location.reload();
    }

    $('#show_finsum_detail').click(function() {
        $('#modal_detail').modal('show');
    });

    $('#show_finsum_income_detail').click(function() {
        $('#modal_detail_income').modal('show');
    });

    $('#show_finsum_expense_detail').click(function() {
        $('#modal_detail_expense').modal('show');
    });
</script>