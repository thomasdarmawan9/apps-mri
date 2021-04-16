<div class="card">
    <div class="card-header">
        <h3 class="card-title">Report Merchandise - Waiting Approve</h3>
    </div>
    <div class="card-body">

        <?php if (!empty($results)) { ?>
            <table class="table table-striped w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c;color:#fff;">
                        <th>No</th>
                        <th>Product</th>
                        <th>Warrior</th>
                        <th>Date Buy</th>
                        <th>Date Approve</th>
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
                            <td><?php echo $row->size ?></td>
                            <td><?php echo $row->qty ?></td>
                            <?php if ($row->is_approve == '1') { ?>
                                <td><button type="button" class="btn btn-success" disabled>APPROVED</button></td>
                            <?php } else if ($row->is_reject == '1') { ?>
                                <td><button type='button' class='btn  btn-danger' disabled> REJECT BY HR</button></td>
                            <?php } else { ?>
                                <td><button type="button" class="btn btn-default">WAITING</button></td>
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