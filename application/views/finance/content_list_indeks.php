<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Indeks</h3>
  </div>
  <div class="card-body">

    <a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Add Indeks</a>

   <p>Here You Can do <code>Create, Edit and Delete</code>.
    </p>

    <br>
    <?php if (!empty($results)) { ?>

      <table class="table table-striped w-100" id="table1">
        <thead class="text-center">
          <tr style="background-color: #0d4e6c;color:#fff;">
            <th>No</th>
            <th>No.Indeks</th>
            <th>Nama Indeks</th>
            <th>No.Divisi</th>
            <th>Nama Divisi</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            $no = 1;
            foreach ($results as $row) {
              echo "<tr>";
              echo "<td>" . $no++ . "</td>";
              echo "<td>" . $row->no_indeks . "</td>";
              echo "<td>" . $row->nama_indeks . "</td>";
              echo "<td>" . $row->no_divisi . "</td>";
              echo "<td>" . $row->nama_divisi . "</td>";
              echo "
       <td nowrap='nowrap'>

      <a class='btn btn-info' onclick='edit(" . $row->id_indeks . ")' title='Edit Data' data-placement='top'><i class='fa fa-edit'></i> EDIT</a>

       <button type='button' class='btn  btn-danger' onclick='hapus(" . $row->id_indeks . ")'><i class='fa fa-trash'></i> DELETE</button>

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

<div class="modal fade" id="modal_tambah" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('finance/accountant/submit_form_indeks') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_indeks" id="id_indeks" value="">
          
          <div class="form-group row" hidden>
            <label class="col-form-label col-sm-4">Head Divisi</label>
            <div class="col-sm-8">
              <select class="form-control js-example-basic-single" name="head_divisi" id="head_divisi" required="" style="width: 100%">
                <option value="" readonly>-Pilih Salah Satu-</option>
                <?php foreach ($hdivisi as $hd) { ?>
                  <option value="<?php echo $hd->id_hdivisi; ?>"><?php echo ucfirst($hd->nama_hdivisi); ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-sm-4">Nama Divisi</label>
            <div class="col-sm-8">
              <select class="form-control js-example-basic-single" name="id_divisi" id="id_divisi" required="" style="width: 100%">
                <option value="" readonly>-Pilih Salah Satu-</option>
                <?php foreach ($divisi as $d) { ?>
                  <option value="<?php echo $d->id_divisi; ?>"><?php echo ucfirst($d->no_divisi); ?> - <?php echo ucfirst($d->nama_divisi); ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-sm-4">Nomor Indeks</label>
            <div class="col-sm-8">
              <input name="no_indeks" id="no_indeks" class="form-control" type="text" placeholder="Nomor Indeks" required="" autocomplete="off">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-sm-4">Nama Indeks</label>
            <div class="col-sm-8">
              <input name="nama_indeks" id="nama_indeks" class="form-control" type="text" placeholder="Nama Indeks" required="" autocomplete="off">
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

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
    
    $('#id_divisi').on('change', function() {
      var id_divisi = $('#id_divisi').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('finance/accountant/tampil_chained_head') ?>',
        data: {
          'id': id_divisi
        },
        success: function(data) {
          $("#head_divisi").html(data);
        }
      })
    })

    $('.js-example-basic-single').select2();
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
      url: "<?= base_url('finance/accountant/json_get_indeks_detail') ?>",
      type: "POST",
      dataType: "json",
      data: {
        'id_indeks': id
      },
      success: function(result) {
        $('#id_indeks').val(result.id_indeks);
        $('#head_divisi').val(result.head_divisi).change();
        $('#id_divisi').val(result.id_divisi).change();
        $('#no_indeks').val(result.no_indeks);
        $('#nama_indeks').val(result.nama_indeks);
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
            url: "<?= base_url('finance/accountant/delete_indeks') ?>",
            type: "POST",
            dataType: "json",
            data: {
              'id_indeks': id
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