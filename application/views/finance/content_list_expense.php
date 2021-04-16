<div class="card">
  <div class="card-header">
    <h3 class="card-title">Expense Transaction Data</h3>
  </div>
  <div class="card-body">

    
        <!--<a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Add Transaction</a>-->
    <a href="<?= base_url('finance/accountant/add_transaction_expense/?baris=""') ?>"><button type="button" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Add Transaction</button></a>
  

    <p>Here You Can do <code>Create, Edit and Delete</code>.
    </p>

    <br>
    <?php if ((!empty($results))) { ?>

      <table class="table table-striped table-responsive w-100" id="table1">
        <thead class="text-center">
          <tr style="background-color: #0d4e6c;color:#fff;">
            <th>No</th>
            <th>Date</th>
            <th>Payment Source</th>
            <th>Index</th>
            <th>Transaction</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            $no = 1;
            foreach ($results as $row) { ?>
            <tr>
              <td><?php echo $no++ ?></td>
              <td><?php echo $row->tgl_nota ?></td>
              <td><?php echo $row->bank ?></td>
              <td><?php echo $row->nama_indeks ?></td>
              <td><?php echo $row->transaksi ?></td>
              <td><?php echo $row->jumlah ?></td>
              <td>Rp.<?php echo number_format($row->harga, 2) ?></td>
              <td>Rp.<?php echo number_format(($row->jumlah) * ($row->harga), 2) ?></td>

              <td nowrap='nowrap'>

               <?php

                $this->db->where('id', 1);
                $query = $this->db->get('fc_transaction_setting');

                foreach ($query->result() as $r) {
                  $block = $r->id_bank;
                }

                $bank_table   = $row->id_bank;

                if (($bank_table == $block) && ($this->session->userdata('id') != '67')) { ?>
                  <button type='button' id='detail_trx' class='btn btn-blue-grey' onclick='detail_trx(<?php echo $row->id_trans ?>)'><i class='fa fa-info'></i> DETAIL</button>
                <?php } else { ?>
                  <button type='button' id='detail_trx' class='btn btn-blue-grey' onclick='detail_trx(<?php echo $row->id_trans ?>)'><i class='fa fa-info'></i> DETAIL</button>
                 <a href=<?php echo base_url('finance/accountant/edit_expense/' . $row->id_trans . '?' . http_build_query(array('id_trans' => $row->id_trans, 'id_bank' => $row->id_bank, 'id_divisi' => $row->id_divisi, 'id_indeks' => $row->id_indeks))) ?>>
                    <button type='button' class='btn  btn-info'><i class='fa fa-edit'></i> EDIT</button></a>
                  <button type='button' class='btn  btn-danger' onclick='hapus(<?php echo $row->id_trans ?>)'><i class='fa fa-trash'></i> DELETE</button>
                <?php } ?>

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
<div class="modal fade" id="modal_tambah" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="<?= base_url('finance/accountant/submit_form_expense') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Form Expense Transaction</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">

              <input type="hidden" name="id_trans" id="id_trans" value="">

              <div class="form-group">
                <label class="col-form-label">Payment Source</label>
                <div class="col-sm-12">
                  <select class="form-control" name="id_bank" id="id_bank" required="">
                    <option value="" readonly>-Please Choose-</option>
                    <?php foreach ($bank as $b) { ?>
                      <option value="<?php echo $b->id_bank; ?>"><?php echo ucfirst($b->name); ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label">Divisi</label>
                <div class="col-sm-12">
                  <select class="form-control js-example-basic-multiple" name="id_divisi" id="id_divisi" required="" style="width: 100%">
                    <option value="" readonly>-Please Choose-</option>
                    <?php foreach ($divisi as $d) { ?>
                      <option value="<?php echo $d->id_divisi; ?>"><?php echo ucfirst($d->no_divisi); ?> - <?php echo ucfirst($d->nama_divisi); ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group" hidden>
                <label class="col-form-label">Head Division</label>
                <div class="col-sm-12">
                  <select class="form-control js-example-basic-multiple" name="head_divisi" id="head_divisi" required="" style="width: 100%">
                    <option value="">-Please Choose-</option>

                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label">Index</label>
                <div class="col-sm-12">
                  <select class="form-control js-example-basic-multiple" name="id_indeks" id="id_indeks" required="" style="width: 100%">

                  </select>
                </div>
              </div>

              <div class="form-group" hidden>
                <label class="col-form-label">Type</label>
                <div class="col-sm-12">
                  <input name="jenis" id="jenis" class="form-control" type="text" placeholder="Type" value="expense" readonly="" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label">Date (Nota)</label>
                <div class="col-sm-12">
                  <input name="tgl_nota" id="tgl_nota" class="form-control datepicker" type="input" placeholder="Tanggal Nota" required="" autocomplete="off">
                </div>
              </div>


            </div>

            <div class="col-md-6">
                
              <div class="form-group">
                <label class="col-form-label">Bill</label>
                <div class="col-sm-12">
                  <select class="form-control" name="bon" id="bon" required="">
                    <option value="" readonly>-Please Choose-</option>
                    <option value="y_writen">Y (Written)</option>
                    <option value="y_print">Y (Print)</option>
                    <option value="n_self">N (Self)</option>
                    <option value="n">N</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label">Qty</label>
                <div class="col-sm-12">
                  <input name="jumlah" id="jumlah" class="form-control" onkeyup="cek_total();" type="text" placeholder="Qty" required="" autocomplete="off">
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label">Price</label>
                <div class="col-sm-12">
                  <input name="harga" id="harga" class="form-control" onkeyup="cek_total();" type="text" placeholder="Price" required="" autocomplete="off">
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label">Expense</label>
                <div class="col-sm-12">
                  <input name="expense" id="expense" class="form-control" readonly="" type="text" placeholder="Expense" value="" required="">
                </div>
              </div>

              <div class="form-group" hidden>
                <label class="col-form-label">Income</label>
                <div class="col-sm-12">
                  <input name="income" id="income" class="form-control" readonly="" type="text" value="0" placeholder="Income" required="">
                </div>
              </div>

             <div class="form-group" hidden>
                <label class="col-form-label">PT</label>
                <div class="col-sm-12">
                  <select class="form-control" name="id_pt" id="id_pt" required="" style="width: 100%">

                  </select>
                </div>
              </div>

            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <center>
                <label class="col-form-label">Transaction</label>
              </center>
              <div class="col-sm-12">
                <textarea name="transaksi" id="transaksi" class="form-control" type="text" placeholder="Transaction" required="" autocomplete="off"></textarea>
              </div>
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

<!-- MODAL DETAIL EXPENSE TRX -->
<div class="modal fade" tabindex="-1" id="modal_detail" data-backdrop="static" style="overflow-y: auto;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form_detail" style="padding-left:15px;padding-right: 15px;">
        <div class="modal-header" style="background-color:#78909c;color:#fff">
          <h4 class="modal-title" id="header_detail">Transaction Detail</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <div class="form-group row">
                <label class="col-form-label col-sm-4">Bank</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_bank" value="" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-sm-4">Division</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_divisi" value="" readonly="">
                </div>
              </div>

              <div class="form-group row" id="show_task">
                <label class="col-form-label col-sm-4">Index</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_indeks" value="" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-sm-4">Type</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_jenis" value="" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-sm-4">Date (Nota)</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_tgl_nota" value="" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-sm-4">Bill</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_bon" value="" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-sm-4">Transaction</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_trans" value="" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-sm-4">Qty</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_jumlah" value="" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-sm-4">Price</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_harga" value="" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-sm-4">Expense</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="det_expense" value="" readonly="">
                </div>
              </div>

            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- END MODAL DETAIL EXPENSE TRX -->



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    -
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

    $('.js-example-basic-multiple').select2();

  });
  
   $('#id_divisi').change(function() {
    init_indeks();
  });

  function init_indeks() {
    var id_divisi = $('#id_divisi').val();

    $('#head_divisi').empty();
    $('#id_indeks').empty();

    $.ajax({
      url: "<?= base_url('finance/accountant/get_autocomplete_divisi') ?>",
      type: "POST",
      dataType: "json",
      data: {
        'id_divisi': id_divisi
      },
      success: function(result) {
        $.each(result, function(index, item) {
          $('#head_divisi').append('<option value="' + item.head_divisi + '">' + item.hdivisi + '</option>');
          $('#id_indeks').append('<option value="' + item.id_indeks + '">' + item.nama_indeks + '</option>');
        });

      },
      error: function(e) {
        console.log(e);
      }
    })

  }

  $(".datepicker").datepicker({
    changeYear: true,
    changeMonth: true,
    dateFormat: 'yy-mm-dd',
  });

  function reload_page() {
    window.location.reload();
  }
  
  $('#id_bank').change(function() {
    init_pt();
  });

  function init_pt() {
    var id_bank = $('#id_bank').val();

    $('#id_pt').empty();
    $.ajax({
      url: "<?= base_url('finance/accountant/json_get_bank_list') ?>",
      type: "POST",
      dataType: "json",
      data: {
        'id_bank': id_bank
      },
      success: function(result) {
        $.each(result, function(index, item) {
          $('#id_pt').append('<option value="' + item.id_pt + '">' + item.pt + '</option>');

        });

      },
      error: function(e) {
        console.log(e);
      }
    })

  }

  $('#showtambah').click(function() {
    $('#form_data').trigger("reset");
    $('#modal_tambah').modal('show');
  });

  /*function edit(id){
    $('#form_data').trigger("reset");
    $.ajax({
      url: "<?= base_url('finance/accountant/json_get_receive_detail') ?>",
      type: "POST",
      dataType: "json",
      data:{'id_trans': id},
      success:function(result){
        $('#id_trans').val(result.id_trans);
        $('#id_bank').val(result.id_bank).change();
        $('#id_divisi').val(result.id_divisi);
        $('#id_indeks').val(result.id_indeks);
        $('#jenis').val(result.jenis);
        $('#tgl_nota').val(result.tgl_nota);
        $('#bon').val(result.bon);
        $('#transaksi').val(result.transaksi);
        $('#jumlah').val(result.jumlah);
        $('#price').val(result.price);
        $('#disbursment').val(result.disbursment);
        $('#receive').val(result.receive);
        $('#saldo_akhir').val(result.saldo_akhir);
        $('#modal_tambah').modal('show');
      }, error: function(e){
        console.log(e);
      }
    })
  }*/

  function detail_trx(id) {
    $('#modal_detail').modal('show');
    $('#form_detail').trigger('reset');
    $.ajax({
      url: "<?= base_url('finance/accountant/json_get_expense_transaction') ?>",
      type: "POST",
      dataType: "json",
      data: {
        'id': id
      },
      success: function(result) {
        $('#det_bank').val(result.bank);
        $('#det_divisi').val(result.nama_divisi);
        $('#det_indeks').val(result.nama_indeks);
        $('#det_jenis').val(result.jenis);
        $('#det_tgl_nota').val(result.tgl_nota);
        $('#det_bon').val(result.bon);
        $('#det_trans').val(result.transaksi);
        $('#det_jumlah').val(result.jumlah);
        $('#det_harga').val(result.harga);
        $('#det_expense').val(result.expense);
        //$('#det_saldo_akhir').val(result.saldo_akhir);
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
        text: "Data Expense Cash Akan Dihapus, Lanjutkan?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f35958',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }, function(result) {
        if (result) {
          $.ajax({
            url: "<?= base_url('finance/accountant/delete_transaction') ?>",
            type: "POST",
            dataType: "json",
            data: {
              'id_trans': id
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

  /**function cek_database(){
      var id_bank = $("#id_bank").val();
       $.ajax({
           url: "<?= base_url('finance/accountant/get_autocomplete_bank') ?>",
           data:"id_bank="+id_bank ,
         }).success(function (data) {
           var json = data,
           obj = JSON.parse(json);
           $('#saldo').val(obj.saldo);
         console.log(json);
       })
     }**/


  /**function autofill(){
     var id_bank =document.getElementById('id_bank').value;
     $.ajax({
                    url:"<?php echo base_url(); ?>finance/accountant/get_autocomplete_bank",
                    data:'&id_bank='+id_bank,
                    success:function(data){
                        var hasil = JSON.parse(data);  
                  
         $.each(hasil, function(key,val){ 
              
            document.getElementById('id_bank').value=val.id_bank;
            document.getElementById('saldo').value=val.saldo;
                             
                  
             });
         }
     });
   }**/

  /*function cek_indeks() {
  var txtFirstNumberValue = document.getElementById('jumlah').value;
  var txtSecondNumberValue = document.getElementById('price').value;
  var txtThirdNumberValue = document.getElementById('receive').value;
  var txtFourthNumberValue = document.getElementById('saldo').value;    
  var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
  var results = parseInt(txtThirdNumberValue) + parseInt(txtFourthNumberValue);
  if (!isNaN(result)) {
     document.getElementById('receive').value = result;
     document.getElementById('saldo_akhir').value = results;
    }
  }*/


  function cek_total() {
    //var re = /^[\w\s]+$/g;
    var txtFirstNumberValue = document.getElementById('jumlah').value;
    var txtSecondNumberValue = document.getElementById('harga').value;
    var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
    if (!isNaN(result)) {
      document.getElementById('expense').value = parseFloat(result);
    } else {
      document.getElementById('expense').value = '0';
    }
  }
  
   $('.numeric').keyup(function(e) {
    if (/\D/g.test(this.value)) {
      this.value = this.value.replace(/\D/g, '');
    }
  });
</script>