<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Bank</h3>
  </div>
  <div class="card-body">

    <?php if ($this->session->userdata('id') == '67') { ?>
      <a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Add Bank</a>
    <?php } ?>
   <p>Here You Can do <code>Create, Edit and Delete</code>.
    </p>

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
            <!-- <th>Transfer Out</th> -->
            <th>Income</th>
            <th>Expense</th>
            <th>Total Transaksi</th>
            <th>Saldo Akhir</th>
            <?php if ($this->session->userdata('id') == 67) { ?>
              <th>Action</th>
            <?php } ?>
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
              <!-- <td>Rp.<?php echo number_format($row->eps, 2) ?></td> -->
              <td>Rp.<?php echo number_format($row->ic, 2) ?></td>
              <td>Rp.<?php echo number_format($row->ex, 2) ?></td>
              <td>Rp.<?php echo number_format($row->tr, 2) ?></td>
              <?php if ($row->tr == null) { ?>
                <td>Rp.<?php echo number_format($row->saldo_awal, 2) ?></td>
              <?php } else { ?>
                <td>Rp.<?php echo number_format($row->nl, 2) ?></td>
              <?php } ?>
            <?php if ($this->session->userdata('id') == 67) {
                  echo "
       <td nowrap='nowrap'>
       <a class='btn btn-info' onclick='edit(" . $row->id_bank . ")' title='Edit Data' data-placement='top'><i class='fa fa-edit'></i> EDIT</a>

       <button type='button' class='btn  btn-danger' onclick='hapus(" . $row->id_bank . ")'><i class='fa fa-trash'></i> HAPUS</button>

       </td>";
                }
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

<!-- MODAL TAMBAH -->
<div class="modal fade" tabindex="-1" id="modal_tambah" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('finance/accountant/submit_form_bank') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_bank" id="id_bank" value="">
          <div class="form-group row">
            <label class="col-form-label col-sm-4">No Rekening</label>
            <div class="col-sm-8">
              <input name="rek_bank" id="rek_bank" class="form-control" type="text" placeholder="Nomor Rekening" autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Nama Bank</label>
            <div class="col-sm-8">
              <input name="name" id="name" class="form-control" type="text" placeholder="Nama Bank" required="" autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Atas Nama</label>
            <div class="col-sm-8">
              <input name="atas_nama" id="atas_nama" class="form-control" type="text" placeholder="Atas Nama" required="" autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">PT</label>
            <div class="col-sm-8">
              <!-- <select class="bootstrap-select form-control" name="id_pt" id="id_pt" data-width="100%" data-live-search="true" multiple required=""> -->
              <select class="form-control" name="id_pt" id="id_pt" data-width="100%" required="">
                <option value="">-Pilih Salah Satu-</option>
                <?php if (!empty($pt)) {
                  foreach ($pt as $p) { ?>
                    <option value="<?= $p->id_pt; ?>"><?= $p->name; ?></option>
                <?php }
                } ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Status</label>
            <div class="col-sm-8">
              <select class="form-control" name="is_active" id="is_active" required="">
                <option value="">-Pilih Salah Satu-</option>
                <option value="1">Active</option>
                <option value="0">Not Active</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-sm-4">Saldo awal</label>
            <div class="col-sm-8">
              <input name="saldo_awal" id="saldo_awal" class="form-control" type="text" placeholder="Saldo Awal" required="" data-separator='.' autocomplete="off">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- END MODAL TAMBAH -->

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

  $('#showtambah').click(function() {
    $('#form_data').trigger("reset");
    $('#modal_tambah').modal('show');
  });

  function edit(id) {
    $('#form_data').trigger("reset");
    $.ajax({
      url: "<?= base_url('finance/accountant/json_get_bank_detail') ?>",
      type: "POST",
      dataType: "json",
      data: {
        'id': id
      },
      success: function(result) {
        $('#id_bank').val(result.id_bank);
        $('#rek_bank').val(result.rek_bank);
        $('#name').val(result.name);
        $('#atas_nama').val(result.atas_nama);
        $('#id_pt').val(result.id_pt).change();
        $('#saldo_awal').val(result.saldo_awal);
        $('#is_active').val(result.is_active);
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
        text: "Data Bank Akan Dihapus, Lanjutkan?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f35958',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }, function(result) {
        if (result) {
          $.ajax({
            url: "<?= base_url('finance/accountant/delete_bank') ?>",
            type: "POST",
            dataType: "json",
            data: {
              'id_bank': id
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
  
  $('.numeric').keyup(function(e) {
    if (/\D/g.test(this.value)) {
      this.value = this.value.replace(/\D/g, '');
    }
  });
</script>