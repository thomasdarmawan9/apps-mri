<style>
    .select2-container .select2-selection--single {
        height: 37px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 37px !important;
        margin-left: 5px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 37px !important;
    }
</style>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data PT</h3>
  </div>
  <div class="card-body">

    <p>LOCK merupakan penguncian action pada transaksi agar tidak bisa dilakukan penambahan dan pengubahan pada transaksi<br>
      UNLOCK merupakan pembukaan action kembali pada transaksi agar bisa dilakukan perubahan serta penambahan dan pengubahan. bertujuan jika Admin Finance meminta bantuan kepada Warriors untuk membantu Pengecekan Transaksi.</p>
    <hr>
   <?php if (!empty($lock)) {

      foreach ($lock as $key) {

    ?>

        <form method="post" action="<?= base_url(); ?>finance/accountant/transaction_lock">
          <div class="mb-2">
            <?php if ($key->lock == 'yes') { ?>

              <div class="col-md-3 row mb-2">
                <input type="text" class="form-control" id="id_bank" name="id_bank" value="<?php echo $key->bank ?> - <?php echo $key->pt ?>" readonly required>
              </div>

              <div class="form-inline form-group">

                <input type="text" class="form-control" value="LOCKED" name="status" style="font-weight:bold;background: #ff9393;color: #bf0808;" readonly>

                <button type="submit" class="btn btn-primary">UNLOCK NOW</button><br>

                <?php $key->lock = 'yes'; ?>
              </div>

            <?php } else { ?>

              <div class="col-md-3 row mb-2">

                <select class="form-control js-example-basic-single" name="id_bank" id="id_bank" required="">
                  <option value="" readonly>-Please Choose-</option>
                  <?php foreach ($bank as $b) { ?>
                    <option value="<?php echo $b->id_bank; ?>"><?php echo ucfirst($b->name); ?> - <?php echo $b->pt; ?></option>
                  <?php } ?>
                </select>

              </div>

              <div class="col-md-5 form-inline form-group row">
                <input type="text" class="form-control" value="UNLOCKED" name="status" style="font-weight:bold;background: #e1f5fe;color: #33b5e5;" readonly>

                <button type="submit" class="btn btn-danger">LOCK NOW</button><br>

                <?php $key->lock = ''; ?>
              </div>

            <?php } ?>
          </div>
          <?php if ($key->lock == 'yes') { ?>
            <span><i style="font-size: 12px;color:red;">*) TRANSAKSI TERKUNCI</i></span>
          <?php } else { ?>
            <span><i style="font-size: 12px;color:#33b5e5;">*) TRANSAKSI TERBUKA</i></span>
          <?php } ?>

        </form>
        <hr>

    <?php }
    } ?>


    <a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; ADD PT</a>

   <p>Here You Can do <code>Create, Edit and Delete</code>.
    </p>

    <br>
    <?php if (!empty($results)) { ?>

      <table class="table table-striped w-100" id="table1">
        <thead class="text-center">
          <tr style="background-color: #0d4e6c;color:#fff;">
            <th>No</th>
            <th>Nama PT</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            $no = 1;
            foreach ($results as $row) {
              echo "<tr>";
              echo "<td>" . $no++ . "</td>";
              echo "<td>" . $row->name . "</td>";
              echo "<td>" . $row->email . "</td>";
              echo "<td>" . $row->telepon . "</td>";
              echo "
       <td>

      <a class='btn btn-info' onclick='edit(" . $row->id_pt . ")' title='Edit Data' data-placement='top'><i class='fa fa-edit'></i> EDIT</a>

       <button type='button' class='btn  btn-danger' onclick='hapus(" . $row->id_pt . ")'><i class='fa fa-trash'></i> DELETE</button>

       </td>";
              echo "</tr>";
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

<div class="modal fade" tabindex="-1" id="modal_tambah" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('finance/accountant/submit_form_pt') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_pt" id="id_pt" value="">
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Nama PT</label>
            <div class="col-sm-8">
              <input name="name" id="name" class="form-control" type="text" placeholder="Nama PT" required="" autocomplete="off">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-sm-4">E-mail</label>
            <div class="col-sm-8">
              <input name="email" id="email" class="form-control" type="text" placeholder="E-mail" required="" autocomplete="off">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-sm-4">Telepon</label>
            <div class="col-sm-8">
              <input name="telepon" id="telepon" class="form-control" type="text" placeholder="Telepon" required="" autocomplete="off">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>


<script type="text/javascript">
  $(document).ready(function() {
    $('#table1').DataTable({
      'scrollX': true,
      'lengthMenu': [
        [10, 25, -1],
        [10, 25, "All"]
      ],
      'rowReorder': {
        'selector': 'td:nth-child(2)'
      },
      'responsive': true
    });
  });
  
  $('.js-example-basic-single').select2();

  function reload_page() {
    window.location.reload();
  }

  $('#showtambah').click(function() {
    $('#form_data').trigger("reset");
    $('#modal_tambah').modal('show');
  });

  function edit(id) {
    $('#form_data').trigger("reset");
    $.ajax({
      url: "<?= base_url('finance/accountant/json_get_pt_detail') ?>",
      type: "POST",
      dataType: "json",
      data: {
        'id_pt': id
      },
      success: function(result) {
        $('#id_pt').val(result.id_pt);
        $('#name').val(result.name).change();
        $('#email').val(result.email);
        $('#telepon').val(result.telepon);
        $('#modal_tambah').modal('show');
      },
      error: function(e) {
        console.log(e);
      }
    })
  }

  function hapus(id) {
    if (id != '') {
      swal({
        title: 'Konfirmasi',
        text: "Data Accountant Akan Dihapus, Lanjutkan?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f35958',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }, function(result) {
        if (result) {
          $.ajax({
            url: "<?= base_url('finance/accountant/delete_pt') ?>",
            type: "POST",
            dataType: "json",
            data: {
              'id_pt': id
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