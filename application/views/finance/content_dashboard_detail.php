<div class="card">
    <div class="card-header">
        <h3 class="card-title">Transaction Detail</h3>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-sm-4">
                <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                    <div class="card-header"><b>Profit/Loss</b></div>
                    <div class="card-body">
                        <?php if (!empty($transaction)) { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($transaction, 2) ?> </h3>
                        <?php } else { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.0</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-white mb-3" style="max-width: 30rem; background: #03fc52;">
                    <div class="card-header"><b>Income</b></div>
                    <div class="card-body">
                        <?php if (!empty($income)) { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($income, 2) ?></h3>
                        <?php } else { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.0</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-white mb-3" style="max-width: 30rem; background: #f33837">
                    <div class="card-header"><b>Expense </b></div>
                    <div class="card-body">
                        <?php if (!empty($expense)) { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($expense, 2) ?></h3>
                        <?php } else { ?>
                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.0</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>


        <br>
        <hr>
        <br>
        <?php if (!empty($results)) { ?>

            <table class="table table-striped w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c;color:#fff;">
                        <th>No</th>
                        <th>No. Rekening</th>
                        <th>Nama</th>
                        <th>PT</th>
                        <th>A/N</th>
                        <th>Saldo Awal</th>
                        <th>Income</th>
                        <th>Expense</th>
                        <th>Total Transaksi</th>
                        <th>Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                        $no = 1;
                        foreach ($results as $row) {  ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row->rek_bank ?></td>
                            <td><?php echo strtoupper($row->name) ?></td>
                            <td><?php echo strtoupper($row->pt) ?></td>
                            <td><?php echo ucwords($row->atas_nama) ?></td>
                            <td>Rp.<?php echo number_format($row->saldo_awal, 2) ?></td>
                            <td>Rp.<?php echo number_format($row->ic, 2) ?></td>
                            <td>Rp.<?php echo number_format($row->ex, 2) ?></td>
                            <td>Rp.<?php echo number_format($row->tr, 2) ?></td>
                            <?php if ($row->tr == null) { ?>
                                <td>Rp.<?php echo number_format($row->saldo_awal, 2) ?></td>
                            <?php } else { ?>
                                <td>Rp.<?php echo number_format($row->nl, 2) ?></td>
                            <?php } ?>
                        <?php echo "</tr>";
                            }
                            ?>
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