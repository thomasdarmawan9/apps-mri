<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Accountant</h3>
  </div>
  <div class="card-body">

    <a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Add Accountant</a>

    <p>Here You Can do <code>Create, Edit and Delete</code>.
    </p>

    <br>
    <?php if (!empty($finance)) { ?>

      <table class="table table-striped w-100" id="table1">
        <thead class="text-center">
          <tr style="background-color: #0d4e6c;color:#fff;">
            <th>No</th>
            <th>Nama</th>
            <th>Status</th>
            <th>PT</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            $no = 1;
            foreach ($finance as $row) { ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row->name; ?></td>

              <?php
                  if ($row->status == null || $row->status == 'aktif') {
                    echo "<td><label class='badge badge-success'>Aktif</label></td>";
                  } else {
                    echo "<td><label class='badge badge-danger'>Tidak Aktif</label></td>";
                  }
                  ?>

              <td>
                <?php
                    $pt = unserialize($row->id_pt);
                    foreach ($pt as $d) {
                      $this->db->where('id_pt', $d);
                      $dvs = $this->db->get('fc_pt');
                      if ($dvs->num_rows() > 0) {
                        echo '<span class="badge badge-success">' . $dvs->row()->name . '</span> ';
                      } else {
                        echo '<span class="badge badge-secondary">Division has been deleted</span> ';
                      }
                    } ?>
              </td>
              <td><?= $row->email; ?></td>
              <td nowrap='nowrap'>
                <button class="btn btn-info" onclick="edit(<?= $row->id; ?>)"><i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-danger" onclick="hapus(<?= $row->id; ?>)"><i class="fa fa-times"></i> Delete</button>
              </td>
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
<!-- MODAL TAMBAH -->
<div class="modal fade" tabindex="-1" id="modal_tambah" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?= base_url('finance/accountant/submit_form_accountant_add') ?>" id="form_data" class="form-horizontal" style="width:100%">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id" value="">
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Nama</label>
            <div class="col-sm-8">
              <input name="nama" id="nama" class="form-control" type="text" placeholder="Nama Accountant" required="" autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Username</label>
            <div class="col-sm-8">
              <input name="username" id="username" class="form-control" type="text" placeholder="Username" required="" autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Password</label>
            <div class="col-sm-8">
              <input name="password" id="password" class="form-control" type="text" placeholder="Password" required="" autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">PT</label>
            <div class="col-sm-8">
              <select name="id_pt[]" id="id_pt" class="form-control" multiple="multiple" required>
                <option value="">-Pilih Salah Satu-</option>
                <?php if (!empty($results)) {
                  foreach ($results as $r) { ?>
                    <option value="<?= $r->id_pt; ?>"><?= $r->name; ?></option>
                <?php }
                } ?>
              </select>
            </div>
          </div>

          <div class="form-group row" id="myselect-1">
            <label class="col-form-label col-sm-4">Status</label>
            <div class="col-sm-8">
              <select class="form-control" name="status" id="status" required="">
                <option value="">-Pilih Salah Satu-</option>
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
              </select>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" id="btn-submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" tabindex="-1" id="modal_edit" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditAccountant" method="post" action="<?= base_url('finance/accountant/edit_accountant'); ?>">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editid" required>
          <div class="form-group row">
            <label class="col-form-label col-sm-4" for="editnama">Nama</label>
            <div class="col-sm-8">
              <input name="nama" id="editnama" class="form-control" type="text" placeholder="Nama Accountant" required="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4" for="editusername">Username</label>
            <div class="col-sm-8">
              <input name="username" id="editusername" class="form-control" type="text" placeholder="Username" required="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4"" for=" editpassword">Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" name="pass" id="editpassword" placeholder="Password" pattern=".{6,}" title="6 characters minimum">
              <small>Biarkan password dalam keadaan kosong, jika tidak ingin merubah password sebelumnya.</small>
            </div>

          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4" for="editpt">PT</label>
            <div class="col-sm-8">
              <select class="form-control" name="id_pt[]" id="editid_pt" data-width="100%" data-live-search="true" multiple='multiple' required="">
                <?php if (!empty($results)) {
                  foreach ($results as $r) { ?>
                    <option value="<?= $r->id_pt; ?>"><?= $r->name; ?></option>
                <?php }
                } ?>
              </select>
            </div>
          </div>

          <div class="form-group row" id="myselect-1">
            <label class="col-form-label col-sm-4">Status</label>
            <div class="col-sm-8">
              <select class="form-control" name="status" id="editstatus" required="">
                <option value="">-Pilih Salah Satu-</option>
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
              </select>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" id="btn-submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<link rel="stylesheet" href="<?= base_url('inc/bootstrap-select2/select2.min.css'); ?>">
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url('inc/bootstrap-select2/select2.min.js'); ?>"></script>

<script type="text/javascript">
  $("#id_pt,#editid_pt").select2({
    placeholder: "Select PT"
  });

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

  function reload_page() {
    window.location.reload();
  }

  $('#showtambah').click(function() {
    $('#form_data').trigger("reset");
    $("#id_pt").select2("val", []);
    $('#modal_tambah').modal('show');
  });

  /**function edit(id){
    $('#form_data').trigger("reset");
    $.ajax({
      url: "<?= base_url('finance/accountant/json_get_accountant_detail') ?>",
      type: "POST",
      dataType: "json",
      data:{'id': id},
      success:function(result){
        $('#id').val(result.id);
        $('#nama').val(result.nama).change();
        $('#username').val(result.email);
        $('#password').val(result.email);
        $('#id_pt').val(result.level);
        $('#status').val(result.status);
        $('#modal_tambah').modal('show');
      }, error: function(e){
        console.log(e);
      }
    })
  }**/

  function edit(id) {
    $.ajax({
      url: "<?= base_url('finance/accountant/push_data_accountant'); ?>",
      type: "post",
      dataType: "json",
      data: {
        'id': id
      },
      success: function(response) {
        $('#editid').val(response.detail.id);
        $('#editnama').val(response.detail.name);
        $('#editusername').val(response.detail.username);
        $("#editid_pt").select2("val", response.hr);
        $('#editstatus').val(response.detail.status);
        console.log(response);
      },
      error: function(e) {
        console.log(e);
      }
    });

    $('#modal_edit').modal('show');
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
            url: "<?= base_url('finance/accountant/delete_accountant') ?>",
            type: "POST",
            dataType: "json",
            data: {
              'id': id
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