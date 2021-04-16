 <div class="card">
  <div class="card-header">
    <h3 class="card-title">My Task</h3>
  </div>
  <div class="card-body">

    <div class="col-md-4" style="text-align: center;font-size: 4em;padding: 10px;border: 1px solid #acd8f7;background: #0d4e6c;color: white;"><?php echo $sp; ?>    <p style="font-size: 12px;font-style: italic;color:#fff"><?php if($sp < 0){ ?>Minus <?php }elseif($sp > 0){ ?>Plus<?php } ?> Task Allocation</p>
    </div>
    <div class="col-md-8" style="text-align:right;">
      <i class="fa fa-thumb-tack" aria-hidden="true" style="font-size: 10em;-ms-transform: rotate(30deg);-webkit-transform: rotate(30deg);transform: rotate(30deg);"></i>
    </div>
    <div class="alert alert-info" style="letter-spacing:0px;font-weight:bold;margin-bottom:30px">
      <button class="close" data-dismiss="alert"></button>
      Info: List Event akan selalu otomatis terhapus +7 Hari setelah Tanggal Event.
    </div>              
    <h4 class="card-title">List Task Allocation</h4>
    <div class="table-responsive">
      <div class="table-responsive">
        <table class="table table-striped w-100" id="table1">
        <thead class="text-center">
          <tr style="background: #0d4e6c;color:white;">
            <th class="text-center">No</th>
            <th >Event</th>
            <th >Location</th>
            <th >Date</th>
            <th >Task</th>
            <th class="text-center" style="width:170px;">DP | Lunas</th>
            <th style="width:250px;">Aksi | Status</th>
            <th >Attend</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php if(!empty($results)){ ?>
          <?php $no = 1; ?>
          <?php foreach($results as $r){ ?>
          <tr>
            <td style="vertical-align: middle;text-align: center;"><?php echo $no; ?></td>
            <td style="vertical-align: middle;width:120px;"><b><?php echo $r->event; ?></b></td>
            <td style="vertical-align: middle;"><?php echo $r->location; ?></td>
            <td style="vertical-align: middle;">
              <label class="badge badge-light" style="cursor: auto;font-weight:bold;"><?php echo date('d-M-Y', strtotime($r->date)); ?></label>
            </td>

            <?php 
            if($r->id_pengganti == null){
              $pengganti= '<b>ME</b>';
              $disabled = '';
              $pgn = '<i class="fa fa-search"></i>';
            }elseif(($r->id_pengganti <> null) && ($r->persetujuan_pengganti == null)){
              $idp = $r->id_pengganti;
              $data['namapengganti'] = $this->model_task->get_username_penggantitask($idp);
              foreach ($data['namapengganti'] as $ganti){
                $pengganti = '<b>Waiting</b> - '.ucfirst($ganti->username).'';
              }
              $disabled = '';
              $pgn = '<i class="fa fa-search"></i>';
            }else{
              if($r->id_pengganti == $this->session->userdata('id')){
                $pengganti = '<b>Cover for</b> - '.ucfirst($r->username).'';
                $disabled = '';
                $pgn = '<i class="fa fa-search"></i>';
              }else{
                $idp = $r->id_pengganti;
                $data['namapengganti'] = $this->model_task->get_username_penggantitask($idp);
                foreach ($data['namapengganti'] as $ganti){
                  $pengganti = '<b>Changed by</b> - '.ucfirst($ganti->username).'';
                }
                $disabled = 'disabled';
                $pgn = 'Has Changed';
              }
            }
            ?>


            <?php if($r->tugas == null){
              $tugas = '<label data-toggle="popover" data-content="Menunggu Input PD" data-placement="top" data-trigger="hover" class="badge badge-primary" style="cursor: auto;font-weight:bold;"> ? </label>';
            }elseif($r->tugas == 'pd'){
              if(empty($r->id_pengganti) || $r->id_pengganti == $this->session->userdata('id')){
                $tugas = ' <a href="'.base_url('user/task/report_pd/'.$r->id_task.'/'.md5($r->id_task)).'"><button class="btn btn-deep-orange" data-toggle="popover" data-original-title="Anda sebagai PD" data-content="Klik untuk memberikan posisi Tugas Warriors & Hasil Laporan Tentang Event" data-placement="top" data-trigger="hover"><b>R</b></button></a>';
              }else{
                $tugas = '-';
              }
            }else{
              $tugas = '<label class="badge badge-info" style="cursor: auto;font-weight:bold;" data-toggle="popover" data-content="Tugas Anda" data-placement="top" data-trigger="hover">'.ucfirst($r->tugas).'</label>';
            }
            ?>
            <td style="vertical-align: middle;text-align:center;"><?php echo $tugas; ?></td>
            <?php if($r->dp == null){
              $dp = '-';
            }else{
              $dp = $r->dp;
            }
            ?>
            <?php if($r->lunas == null){
              $lunas = '-';
            }else{
              $lunas = $r->lunas;
            }
            ?>
            <td style="text-align:center;">
              <?php if($disabled <> 'disabled'){ ?>
              <button type="button" class="btn  btn-info" style="cursor: auto;" data-toggle="popover" data-content="DP" data-placement="top" data-trigger="hover"> <?php echo $dp; ?> </button> 
              <button type="button" class="btn  btn-secondary" style="cursor: auto;" data-toggle="popover" data-content="Lunas" data-placement="top" data-trigger="hover"> <?php echo $lunas; ?> </button>
              <?php } ?>
            </td>



            <td style="text-align:left;">
              <?php if($disabled <> 'disabled'){ ?>

              <button type="button" data-toggle="popover" data-content="Cari Pengganti" data-placement="top" data-trigger="hover" class="btn  btn-info" data-idtask="<?php echo $r->tui; ?>" data-idtaskbnr="<?php echo $r->id_task; ?>" data-id="<?php echo $r->event; ?>" data-tgl="<?php echo date('d-M-Y', strtotime($r->date)); ?>" data-toggle="modal" data-target="#myModal" style="text-align:center;cursor: pointer;"> <?php echo $pgn; ?></button>

              <?php }else{ ?> 
              <!--<button type="button" class="btn  btn-success" style="cursor: pointer;" <?php echo $disabled; ?> > <?php echo $pgn; ?></button>-->
              <?php } ?>

              <?php if($r->id_pengganti<>null){ ?>

              <a href="<?= base_url('user/task/batalkan_pertukaran/'.$r->tui.'/'.md5($r->tui))?>"><button onclick="cek(<?= $r->tui; ?>)" type="button" class="btn  badge-light" style="cursor:pointer;" <?php if($r->id_pengganti<>null){ ?> data-toggle="tooltip" data-placement="top" title="Klik untuk Batalkan" <?php } ?> > <?php echo $pengganti; ?> </button></a>

              <?php }else{ ?>

              <button type="button" class="btn teal" style="cursor: auto;" > <?php echo $pengganti; ?> </button>

              <?php } ?>

            </td>
            <td>

              <?php if($r->hadir == null){ ?>
              <button type="button" class="btn btn-warning" style="cursor: auto;"><i class="fa fa-ellipsis-h"></i></button>
              <?php }elseif($r->hadir == 'ya'){ ?>
              <button type="button" class="btn btn-success" style="cursor: auto;"><span class="fa fa-check" aria-hidden="true"></span></button>
              <?php }else{ ?>

              <?php if($r->date < date("Y-m-d")){ ?>
              <button type="button" class="btn btn-danger" style="cursor: auto;"><span class="fa fa-times" aria-hidden="true"></span></button>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header"">
      <!-- <h4 class="modal-title"></h4> -->
      <div class="">
        <input checked="checked" class="form-check-input" name="switch"  type="checkbox" id="my-checkbox" onchange="ChangeCheckboxLabel()" >
        <h4 class="modal-title"><span id="my-checkbox-checked" class="modal-title">BERI EVENT</span></h4>
        <span id="my-checkbox-unchecked" class="modal-title"><b>TUKAR</b> EVENT.</span>
      </div>
      <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <form name="userForm" id="userForm" action="<?= base_url('user/task/event_digantikan')?>" method="post">
      <div class="modal-body">
        <div class="form-row">
          <div class="col">
            <div id="beri">
              <div class="alert alert-success">
                <button class="close" data-dismiss="alert"></button>
                Info:&nbsp; <b>Beri Event</b> artinya kamu tidak perlu mengganti event yang ia miliki.
              </div>
            </div>
            <div id="tukar">
              <div class="alert alert-warning">
                <button class="close" data-dismiss="alert"></button>
                Info:&nbsp; <b>Tukar Event</b> artinya kamu kamu wajib untuk memilih salah satu event yang ia miliki.
              </div>
            </div>
            <div id="idevent"></div>
            <div id="idtask"></div>
            <div class="form-group row">
                <label class="col-form-label col-sm-4 text-center">Warrior</label>
                <div class="col-sm-8">
                  <select id="getname_task" name="getname" id="getname" class="form-control" required>
                    <option value="">- Pilih Salah Satu -</option>
                    <?php foreach($hasil as $gn){ ?>
                    <?php if(($gn->username<>'admin')&&($gn->username<>$this->session->userdata('username'))){ ?>

                    <option value="<?php echo $gn->username; ?>"><?php echo ucfirst($gn->username); ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btn-checked" type="submit" class="btn btn-primary" >Terapkan</button>
        <button id="btn-unchecked" type="button" class="btn btn-primary" >Pilih Event</button>
        <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Tutup</button>
      </div>
    </form> 
  </div>
</div>
</div>

<script type="text/javascript">
  $('#table1').DataTable({
    'lengthMenu': [[20, 30, -1], [20, 30, "All"]
    ],
       'rowReorder': {
         'selector': 'td:nth-child(2)'
       },
       'responsive': true,
       'stateSave': true
  });
</script>

<script>
  $(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
    $('[data-toggle="tooltip"]').tooltip(); 
    ChangeCheckboxLabel();
  });

  function ChangeCheckboxLabel(){
    if($('#my-checkbox').prop('checked') == true ){
      $('#my-checkbox').hide();
      document.getElementById("my-checkbox-checked").style.display = "inline";
      document.getElementById("beri").style.display = "inline";
      document.getElementById("tukar").style.display = "none";
      document.getElementById("btn-checked").style.display = "inline";
      document.getElementById("btn-unchecked").style.display = "none";
      document.getElementById("my-checkbox-unchecked").style.display = "none";
    }
  }

  $(function () {
    $('#myModal').modal({
      keyboard: true,
      backdrop: "static",
      show: false,

    }).on('show', function () {

    });

    $(".table-striped").find('button[data-id]').on('click', function () {
      $('#orderDetails').html($('<b style="padding: 5px;background: #866e4c99;background: rgba(210, 180, 142, 0.55);">' + $(this).data('id') + ' | ' + $(this).data('tgl') + '</b>'));

      $('#idevent').html($('<input type="text" id="idevent" name="idevent" value="'+ $(this).data('idtask') +'"  style="display:none;" >'));

      $('#myModal').modal('show');
    });
  });
</script>
