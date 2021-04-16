       <div class="card">
        <div class="card-header">
          <h3 class="card-title">Report Overtime</h3>
        </div>
        <div class="card-body">
          <form action="<?= base_url('user/overtime/history')?>" method="POST">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Bulan</label>
              <div class="col-sm-4">
                <select class="form-control" name="bln" required="">
                  <option value="">Pilih Bulan</option>
                  <?php 
                  foreach($bulan as $key => $val){
                    if($bln == $key){
                      echo "<option value='".$key."' selected>".$val."</option>";
                    }else{
                      echo "<option value='".$key."'>".$val."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tahun</label>
              <div class="col-sm-4">
                <select class="form-control" name="thn" required="">
                  <option value="">Pilih tahun</option>
                  <option value="<?php echo date('Y') -1; ?>" <?= ($thn == date('Y') - 1)? 'selected':''?> ><?php echo date('Y') -1; ?></option>
                  <option value="<?php echo date('Y'); ?>" <?= ($thn == date('Y'))? 'selected':''?> ><?php echo date('Y'); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"></label>
              <div class="col-sm-4">
                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i>&nbsp; Filter</button>
              </div>
            </div>
          </form>
          <hr>
          <div class="table-responsive">
            <table class="table table-striped w-100" id="table1">
              <thead class="text-center">
                <tr style="background:#3d5e6c;color:#fff;">
                  <th>Tanggal</th>
                  <th>Deskripsi</th>
                  <th><i class="fa fa-plus-square" style="font-size: 18px;"></i></th>
                  <th><i class="fa fa-minus-square" style="font-size: 18px;"></i></th>
                  <th>Balance</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr class="laphr" style="font-weight:bold;">
                  <td class="akumulasi">Lemburan Awal</td>
                  <td class="akumulasi">-</td>
                  <td class="akumulasi">-</td>
                  <td class="akumulasi">-</td>
                  <td class="akumulasi"><?php echo ($hasil[0][4] - ($hasil[0][2]) - ($hasil[0][3])); ?></td>
                </tr>
                <?php													
                for($d=0;$d<$jmh_hari;$d++){
                 echo '<tr class="laphr">';
                 echo '<td>'.date("d-M-Y", strtotime($hasil[$d][0])).'</td>';
                 echo '<td>'.$hasil[$d][1].'</td>';
                 echo '<td>'.$hasil[$d][2].'</td>';
                 echo '<td>'.$hasil[$d][3].'</td>';
                 echo '<td>'.$hasil[$d][4].'</td>';
                 echo '</tr>';
               }
               ?>

             </tbody>
           </table>
         </div>
       </div>
     </div>


     <script type="text/javascript">
      $('#table1').DataTable({
        'scrollX':true,
        'order':false,
        'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]
        ],
        'rowReorder': {
  				'selector': 'td:nth-child(2)'
  			},
  			'responsive': true,
  			'stateSave': true
      });
    </script>