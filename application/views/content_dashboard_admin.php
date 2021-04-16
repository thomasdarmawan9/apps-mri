  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Dashboard</h3>
    </div>
    <div class="card-body">
     <br>
     <!-- <hr> -->
      <a href="<?= base_url('dashboard/export')?>" class="btn btn-primary float-right mb-3 mr-3"><i class="fa fa-download" aria-hidden="true"></i> Export</a>
     <div class="table-responsive">
       <table class="table table-striped w-100" id="table1">
        <thead class="cf">
         <tr class="laphr">
          <th style="background: #0d4e6c !important;color: white;text-align: center;">No.</th>
          <th style="background: #0d4e6c !important;color: white;">Name</th>
          <th style="background: #0d4e6c !important;color: white;text-align: center;">Jam Overtime</th>
          <th style="background: #0d4e6c !important;color: white;text-align: center;">Cuti Izin</th>
          <th style="background: #0d4e6c !important;color: white;text-align: center;">Cuti Sakit</th>
        </tr>
      </thead>
      <tbody class="text-center">
       <?php 
       $no = 1;
       foreach($results as $row){
         echo "<tr>";
         echo "<td class='text-center'>".$no++."</td>";
         echo "<td>".ucfirst($row['username'])."</td>";
         if($row['total_lembur'] < 0){
          echo "<td class='text-center'><label class='badge badge-danger'>".$row['total_lembur']."</label></td>";
         }else{
          echo "<td class='text-center'><label class='badge badge-success'>".$row['total_lembur']."</label></td>";
         }
          echo "<td class='text-center'>".$row['total_cuti_izin']."</td>";
         echo "<td class='text-center'>".$row['total_cuti_sakit']."</td>";
         echo "</tr>";
       }
       ?>
     </tbody>
   </table>
 </div>
</div>
</div>

<script type="text/javascript" src="<?= base_url('inc/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js'); ?>"></script>
<!--<script type="text/javascript" src="<?= base_url('inc/datatables/RowReorder-1.2.4/js/dataTables.rowReorder.min.js'); ?>"></script>-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#table1').DataTable({
			'scrollX':true,
			'lengthMenu': [[10, 25, -1], [10, 25, "All"]],
            'responsive': true
		});
	});
</script>

