<div class="card">
    <div class="card-header">
        <h3 class="card-title">Report Nomerator</h3>
    </div>
    <div class="card-body">
        <form method="get" action="<?= base_url('finance/nomerator/report_nomerator') ?>">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nomerator</label>
                        <div class="col-sm-8">
                            <input name="nomerator" id="nomerator" class="form-control" value="<?= !empty($this->input->get('nomerator')) ? $this->input->get('nomerator') : '' ?>" type="text" placeholder="e.g. MRLC00001">
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-6">
                    <button type="submit" class="btn primary-color-dark" id="filter"><i class="fa fa-search"></i>&nbsp; FILTER</button>
                    <button type="button" class="btn btn-success" id="export" title='Harap tekan tombol filter terlebih dahulu sebelum export data' data-toggle='tooltip' data-placement='right'><i class="fa fa-file-excel"></i>&nbsp; Export to Excel</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c; font-size: 0.9rem; color:#fff;">
                        <th class="text-center" style="vertical-align: middle;">No</th>
                        <th style="vertical-align: middle">Tanggal</th>
                        <th style="vertical-align: middle">Nomerator</th>
                        <th style="vertical-align: middle">Peserta</th>
                        <th style="vertical-align: middle">Program</th>
                        <th style="vertical-align: middle">Jumlah</th>
                        <th style="vertical-align: middle">Sales</th>
                        <th style="vertical-align: middle">Status</th>
                        <th style="vertical-align: middle">Approved</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $no = 1;
                    foreach ($results as $row) 
                    {
                        echo "<tr style='font-size:0.9rem;'>";
                        echo "<td class='text-center'>" . $no++ . "</td>";
                        echo "<td>" . date('d-M-Y',strtotime($row['date'])) . "</td>";
                        echo "<td>" . $row['nomerator'] . "</td>";
                        echo "<td>" . $row['nama_peserta'] . "</td>";
                        echo "<td>" . $row['program'] . "</td>";
                        echo "<td>Rp. " . number_format($row['jumlah']) . "</td>";
                        echo "<td>". $row['name']."</td>";
                        if($row['status_acc'] == ''){
                            echo "<td><label class='badge badge-light'>Waiting Approval</label></td>";
                        }elseif($row['status_acc']== 'tidak'){
                            echo "<td><label class='badge badge-danger'>Rejected</label></td>";
                        }else{
                            echo "<td><label class='badge badge-success'>Approved</label></td>";
                        }
                        if($row['tgl_approve'] == ''){
                            echo "<td><label class='badge badge-light'>Waiting Approval</label></td>";
                        }else{
                            echo "<td>" . date('d-M-Y',strtotime($row['tgl_approve'])) . "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

<script type="text/javascript">
    $('#table1').DataTable({
        'scrollX': true,
        'lengthMenu': [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        'rowReorder': {
            'selector': 'td:nth-child(2)'
        },
        'responsive': true,
        'stateSave': true
    });

    $('#export').click(function() {
		var query = "<?= $_SERVER['QUERY_STRING'] ?>";
		var url = "<?= base_url('finance/nomerator/export_report_nomerator?') ?>" + query;
		window.open(url, '_blank');
	});
</script>