   <div class="card">
    <div class="card-header">
      <h3 class="card-title">List Permohonan Task</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped w-100" id="table1">
          <thead class="text-center">
            <tr style="background-color: #0d4e6c;color:#fff;">
              <th>No</th>
              <th>Event</th>
              <th>Lokasi</th>
              <th>Tanggal</th>
              <th>Tugas</th>
              <th>Status</th>
              <th>Hadir</th>
            </tr>
          </thead>
          <tbody class="text-center">
           <?php if(!empty($results)){ ?>
           <?php $no = 1; ?>
           <?php foreach($results as $r){ ?>
           <tr>
            <td style="vertical-align: middle; text-align: center;"><?php echo $no; ?></td>
            <td style="vertical-align: middle;"><b><?php echo $r->event; ?></b></td>
            <td style="vertical-align: middle;"><?php echo $r->location; ?></td>
            <td style="vertical-align: middle;"><label class="badge badge-info"><?php echo date('d-M-Y', strtotime($r->date)); ?></label></td>

            <?php if($r->id_pengganti == null){
             $pengganti= '<b>Saya Sendiri</b>';
             $disabled = '';
             $pgn = '<i class="fa fa-search"></i> Cari Pengganti';
           }elseif(($r->id_pengganti <> null) && ($r->persetujuan_pengganti == null)){
             $pengganti = '<b>Permohonan</b> - '.ucfirst($r->username).'';
             $disabled = '';
             $pgn = 'APPROVE';
           }else{
             if($r->id_pengganti == $this->session->userdata('id')){
              $pengganti = '<b>Menggantikan</b> - '.ucfirst($r->username).'';
              $disabled = '';
              $pgn = '<i class="fa fa-search"></i> Cari Pengganti';
            }else{
              $idp = $r->id_pengganti;
              $data['namapengganti'] = $this->model_task->get_username_penggantitask($idp);
              foreach ($data['namapengganti'] as $ganti){
               $pengganti = '<b>Diganti oleh</b> - '.ucfirst($ganti->username).'';
             }
             $disabled = 'disabled';
             $pgn = 'Telah Digantikan';
           }
         }
         ?>

         <?php if($r->tugas == null){
           $tugas = '<label class="badge badge-light">Waiting by PD</label>';
         }else{
           $tugas = $r->tugas;
         }
         ?>
         <td style="vertical-align: middle;"><?php echo $tugas; ?></td>
         <td>
          <?php if($disabled <> 'disabled'){ ?>

          <a href="<?= base_url('user/task/approve_request/'.$r->id_pengganti.'/'.$r->tui)?>">
            <button type="button" class="btn  btn-success" data-idtask="<?php echo $r->tui; ?>" data-id="<?php echo $r->event; ?>" data-tgl="<?php echo date('d-M-Y', strtotime($r->date)); ?>" data-toggle="modal" data-target="#myModal" style="text-align:center;cursor: pointer;"> <?php echo $pgn; ?></button>
          </a> 
          <a href="<?= base_url('user/task/reject_konfirmasi_pertukaran/'.$r->tui.'/'.md5($r->tui))?>"><button type="button" class="btn btn-danger">REJECT</button></a>

          <?php }else{ ?> 
          <button type="button" class="btn  btn-success" style="cursor: pointer;" <?php echo $disabled; ?> ><?php echo $pgn; ?></button>
          <?php } ?>

          <label class="badge badge-light" style="cursor: auto;"> <?php echo $pengganti; ?> </label>
        </td>
        <td>
          <?php if($r->hadir == null){ ?>
          <button type="button" class="btn btn-warning" style="cursor: auto;"><i class="fa fa-ellipsis-h"></i></button>
          <?php }elseif($r->hadir == 'ya'){ ?>
          <button type="button" class="btn btn-primary" style="cursor: auto;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
          <?php }else{ ?>
          <?php if($r->date < date("Y-m-d")){ ?>
          <button type="button" class="btn btn-danger" style="cursor: auto;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
          <?php }else{ ?>
          <button type="button" class="btn btn-warning" style="cursor: auto;"><i class="fa fa-ellipsis-h"></i></button>
          <?php } ?>
          <?php } ?> 
        </td>
      </tr>
      <?php $no = $no + 1; ?>
      <?php } ?>
      <?php } ?>
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


