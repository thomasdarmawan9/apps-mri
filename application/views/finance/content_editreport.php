<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Monthly Report</h3>
    </div>
    <div class="card-body">
        <?php foreach ($results as $r) { ?>
            <form method="post" action="<?= base_url('finance/report/edit_monthly_report'); ?>">

                <div class="row">
                    <div class="col-md-6">

                        <input type="hidden" name="id_trans" id="id_trans" value="<?php echo $r->id_trans; ?>">
                        <input type="hidden" name="url" value="<?= $_SERVER['QUERY_STRING']; ?>">
                          <?php if ((($r->jenis == 'income') || ($r->jenis == 'expense')) && ($r->is_transfer == '0') && ($r->receipt_number != null)) { ?>
                            <div class="form-group">
                                <label class="col-form-label">Receipt Number</label>
                                <div class="col-sm-12">
                                    <input name="receipt_number" id="receipt_number" class="form-control" value="<?php echo $r->receipt_number; ?>" type="text" placeholder="Receipt Number" required="" autocomplete="off">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group" hidden>
                                <label class="col-form-label">Receipt Number</label>
                                <div class="col-sm-12">
                                    <input name="receipt_number" id="receipt_number" class="form-control" value="" type="text" placeholder="Receipt Number" autocomplete="off">
                                </div>
                            </div>
                        <?php } ?>
                        
                        <div class="form-group">
                            <label class="col-form-label">Payment Source</label>
                            <div class="col-sm-12">
                                <!-- <select class="form-control" name="id_bank" id="id_bank" onchange="isi_otomatis()" required=""> -->
                                <select class="form-control" name="id_bank" id="id_bank" required="">
                                    <option value="">-Pilih Salah Satu-</option>
                                    <?php foreach ($bank as $d) {
                                            if ($d->id_bank == $r->id_bank) { ?>
                                            <option value="<?php echo $d->id_bank; ?>" selected><?php echo ucfirst($d->name); ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $d->id_bank; ?>"><?php echo ucfirst($d->name); ?></option>
                                    <?php  }
                                        } ?>
                                </select>
                            </div>
                        </div>

                        <?php if (($r->jenis == 'income') && ($r->is_transfer == '0')) { ?>
                            <div class="form-group">
                                <label class="col-form-label">Division</label>
                                <div class="col-sm-12">
                                    <select class="form-control js-example-basic-multiple" name="id_divisi" id="id_divisi" required="" style="width: 100%">
                                        <?php foreach ($income as $i) {
                                                    if ($i->id_divisi == $r->id_divisi) { ?>
                                                <option value="<?php echo $i->id_divisi; ?>" selected><?php echo $i->no_divisi; ?> - <?php echo ucfirst($i->nama_divisi); ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $i->id_divisi; ?>"><?php echo $i->no_divisi; ?> - <?php echo ucfirst($i->nama_divisi); ?></option>
                                        <?php  }
                                                } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } else if (($r->jenis == 'expense') && ($r->is_transfer == '0')) { ?>
                            <div class="form-group">
                                <label class="col-form-label">Division</label>
                                <div class="col-sm-12">
                                    <select class="form-control js-example-basic-multiple" name="id_divisi" id="id_divisi" required="" style="width: 100%">
                                        <?php foreach ($expense as $e) {
                                                    if ($e->id_divisi == $r->id_divisi) { ?>
                                                <option value="<?php echo $e->id_divisi; ?>" selected><?php echo $e->no_divisi; ?> - <?php echo ucfirst($e->nama_divisi); ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $e->id_divisi; ?>"><?php echo $e->no_divisi; ?> - <?php echo ucfirst($e->nama_divisi); ?></option>
                                        <?php  }
                                                } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <?php if ($r->is_transfer == '0') { ?>
                            <div class="form-group">
                                <label class="col-form-label">Head Division</label>
                                <div class="col-sm-12">
                                    <select class="form-control js-example-basic-multiple" name="head_divisi" id="head_divisi" required="" style="width: 100%">
                                        <option value="">-Please Choose-</option>

                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        
                        
                        <?php if ($r->is_transfer == '0') { ?>
                        <div class="form-group">
                            <label class="col-form-label">Index</label>
                            <div class="col-sm-12">
                                <select class="form-control js-example-basic-multiple" name="id_indeks" id="id_indeks" required="" style="width: 100%">
                                    
                                </select>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if ($r->jenis == 'income') { ?>

                            <div class="form-group" hidden>
                                <label class="col-form-label">Jenis Transaksi</label>
                                <div class="col-sm-12">
                                    <input name="jenis" id="jenis" class="form-control" type="text" placeholder="Jenis Transaksi" value="income" readonly="" required="">
                                </div>
                            </div>

                       <?php } else if (($r->jenis == 'expense') && ($r->is_transfer == '0')) { ?>

                            <div class="form-group" hidden>
                                <label class="col-form-label">Jenis Transaksi</label>
                                <div class="col-sm-12">
                                    <input name="jenis" id="jenis" class="form-control" type="text" placeholder="Jenis Transaksi" value="expense" readonly="" required="">
                                </div>
                            </div>

                        <?php } ?>


                        <div class="form-group">
                            <label class="col-form-label">Date</label>
                            <div class="col-sm-12">
                                <input name="tgl_nota" id="tgl_nota" class="form-control datepicker" type="input" placeholder="Date (Nota)" required="" value="<?php echo $r->tgl_nota; ?>" autocomplete="off">
                            </div>
                        </div>
                        
                        <?php if ($r->is_transfer == '1') { ?>
                            <div class="form-group">
                                <label class="col-form-label">Note</label>
                                <div class="col-sm-12">
                                    <input name="note" id="note" class="form-control" type="input" placeholder="Note" required="" value="Transfered" autocomplete="off" disabled>
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="col-md-6">
                        
                     <?php if ($r->is_transfer == '0') { ?>
                        <div class="form-group">
                            <label class="col-form-label">Bill</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="bon" id="bon" required="">

                                    <?php if ($r->bon == null) { ?>
                                        <option value="y_writen">Y (Written)</option>
                                        <option value="y_print">Y (Print)</option>
                                        <option value="n_self">N (Self)</option>
                                        <option value="n">N</option>
                                    <?php  } elseif ($r->bon == 'y_writen') { ?>
                                        <option value="y_writen">Y (Written)</option>
                                        <option value="y_print">Y (Print)</option>
                                        <option value="n_self">N (Self)</option>
                                        <option value="n">N</option>
                                    <?php  } elseif ($r->bon == 'y_print') { ?>
                                        <option value="y_print">Y (Print)</option>
                                        <option value="y_writen">Y (Written)</option>
                                        <option value="n_self">N (Self)</option>
                                        <option value="n">N</option>
                                    <?php } elseif ($r->bon == 'n_self') { ?>
                                        <option value="n_self">N (Self)</option>
                                        <option value="y_writen">Y (Written)</option>
                                        <option value="y_print">Y (Print)</option>
                                        <option value="n">N</option>
                                    <?php } else { ?>
                                        <option value="n">N</option>
                                        <option value="y_writen">Y (Written)</option>
                                        <option value="y_print">Y (Print)</option>
                                        <option value="n_self">N (Self)</option>
                                    <?php  } ?>

                                </select>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if ($r->jenis == 'income') { ?>

                            <div class="form-group">
                                <label class="col-form-label">Qty</label>
                                <div class="col-sm-12">
                                    <input name="jumlah" id="jumlah" class="form-control" onkeyup="hitung_income();" value="<?php echo $r->jumlah; ?>" type="text" placeholder="Qty" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Price</label>
                                <div class="col-sm-12">
                                    <input name="harga" id="harga" class="form-control" onkeyup="hitung_income();" value="<?php echo $r->harga; ?>" type="text" placeholder="Price" required="" autocomplete="off">
                                </div>
                            </div>

                        <?php } else { ?>

                            <div class="form-group">
                                <label class="col-form-label">Qty</label>
                                <div class="col-sm-12">
                                    <input name="jumlah" id="jumlah" class="form-control" onkeyup="hitung_expense();" value="<?php echo $r->jumlah; ?>" type="text" placeholder="Qty" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Price</label>
                                <div class="col-sm-12">
                                    <input name="harga" id="harga" class="form-control" onkeyup="hitung_expense();" value="<?php echo $r->harga; ?>" type="text" placeholder="Price" required="" autocomplete="off">
                                </div>
                            </div>

                        <?php } ?>

                        <?php if ($r->jenis == 'expense') { ?>
                            <div class="form-group" hidden>
                                <label class="col-form-label">Income</label>
                                <div class="col-sm-12">
                                    <input name="income" id="income" class="form-control" readonly="" type="text" value="0" placeholder="Income" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Expense</label>
                                <div class="col-sm-12">
                                    <input name="expense" id="expense" class="form-control" readonly="" value="<?php echo $r->expense; ?>" type="text" placeholder="Expense" value="0" required="">
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="form-group">
                                <label class="col-form-label">Income</label>
                                <div class="col-sm-12">
                                    <input name="income" id="income" class="form-control" readonly="" type="text" value="<?php echo $r->income; ?>" placeholder="Income" required="">
                                </div>
                            </div>

                            <div class="form-group" hidden>
                                <label class="col-form-label">Expense</label>
                                <div class="col-sm-12">
                                    <input name="expense" id="expense" class="form-control" readonly="" value="0" type="text" placeholder="Expense" value="0" required="">
                                </div>
                            </div>
                        <?php } ?>
                        
                        <div class="form-group" hidden>
                            <label class="col-form-label">PT</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="id_pt" id="id_pt" required="" style="width: 100%">
                                    <option value="<?php echo $r->id_pt; ?>"><?php echo ucfirst($r->pt); ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="form-group"> 
                  <label class="col-form-label">Total Transaksi Sebelumnya</label>  
                    <div class="col-sm-12">                
                      <input name="saldo" id="saldo" class="form-control" readonly="" type="text"  value="<?php echo $r->tr; ?>" placeholder="Saldo Bank" required="">
                    </div>                  
                </div>

                 <div class="form-group">
                  <label class="col-form-label">Saldo Akhir</label> 
                    <div class="col-sm-12">
                      <input name="saldo_akhir" id="saldo_akhir" class="form-control" readonly=""  value="<?php echo $r->tr; ?>" type="text" placeholder="Saldo Akhir" required="">
                    </div>
                </div>-->

                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <center>
                                <label class="col-form-label">Transaction</label>
                            </center>
                            <div class="col-sm-12">
                                <input name="transaksi" id="transaksi" class="form-control" type="text" placeholder="Transaction" required="" value="<?php echo $r->transaksi ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <?php if ((($this->input->get('is_transfer') == 'all') || ($this->input->get('is_transfer') == '0')) && ($this->input->get('id_divisi') != null) && ($this->input->get('id_indeks') != null)) { ?>
                        <?php echo "
                            <a href='" . base_url('finance/report' . '?' . $_SERVER['QUERY_STRING']) . "'>
                            <button type='button' class='btn  btn-info'> CANCEL</button>
                            </a> " ?>
                    <?php } else if ((($this->input->get('is_transfer') == 'all') || ($this->input->get('is_transfer') == '0')) && ($this->input->get('id_divisi') == null) && ($this->input->get('id_indeks') == null)) { ?>
                        <?php echo "
                            <a href='" . base_url('finance/report/' . '?' . http_build_query(array('date_start' => !empty($this->input->get('date_start')) ? $this->input->get('date_start') : '', 'date_end' => !empty($this->input->get('date_end')) ? $this->input->get('date_end') : '', 'id_bank' => 'all', 'id_divisi' => !empty($this->input->get('id_divisi')) ? $this->input->get('id_divisi') : 'all', 'id_indeks' => !empty($this->input->get('id_indeks')) ? $this->input->get('id_indeks') : 'all', 'index' => !empty($this->input->get('index')) ? $this->input->get('index') : '', 'is_transfer' => !empty($this->input->get('is_transfer')) ? $this->input->get('is_transfer') : '1')))  . "'>
                            <button type='button' class='btn  btn-info'> CANCEL</button>
                            </a> " ?>
                    <?php } else if (($this->input->get('is_transfer') == '1') && ($this->input->get('id_divisi') == null) && ($this->input->get('id_indeks') == null)) { ?>
                        <?php echo "
                            <a href='" . base_url('finance/report/' . '?' . http_build_query(array('date_start' => !empty($this->input->get('date_start')) ? $this->input->get('date_start') : '', 'date_end' => !empty($this->input->get('date_end')) ? $this->input->get('date_end') : '', 'id_bank' => !empty($this->input->get('id_bank')) ? $this->input->get('id_bank') : '', 'id_divisi' => !empty($this->input->get('id_divisi')) ? $this->input->get('id_divisi') : 'all', 'id_indeks' => !empty($this->input->get('id_indeks')) ? $this->input->get('id_indeks') : 'all', 'index' => !empty($this->input->get('index')) ? $this->input->get('index') : '', 'is_transfer' => !empty($this->input->get('is_transfer')) ? $this->input->get('is_transfer') : '1')))  . "'>
                            <button type='button' class='btn  btn-info'> CANCEL</button>
                            </a> " ?>
                    <?php } ?>
                    <!-- <a href="" class="btn btn-blue-grey"> Cancel</a> -->

                </div>
            </form>
        <?php } ?>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.js-example-basic-multiple').select2();
        
        init_indeks();

        /*$('#id_divisi').on('change', function() {
            var id_divisi = $('#id_divisi').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('finance/accountant/tampil_chained') ?>',
                data: {
                    'id': id_divisi
                },
                success: function(data) {
                    $("#id_indeks").html(data);
                }
            })
        })*/

    });
    
     $('#id_divisi').change(function() {
        init_indeks();
    });

    function init_indeks() {
        var id_divisi = $('#id_divisi').val();
        var id_indeks = "<?= $this->input->get('id_indeks') ?>";

        $('#head_divisi').empty();
        $('#id_indeks').empty();
        if (id_divisi != 'all') {
            $.ajax({
                url: "<?= base_url('finance/accountant/json_get_indeks_list') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    'id_divisi': id_divisi
                },
                success: function(result) {
                    $.each(result, function(index, item) {
                        $('#id_indeks').append('<option value="' + item.id_indeks + '">' + item.nama_indeks + '</option>');
                        $('#head_divisi').append('<option value="' + item.head_divisi + '">' + item.hdivisi + '  </option>');
                    });
                    if (id_indeks != '') {
                        $('#id_indeks').val(id_indeks).change();
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            })
        } else {
            $('#id_indeks').append('<option value="all">All</option>');
            $('#head_divisi').append('<option value="all">All</option>');
        }
    }

    $(".datepicker").datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
    });

    function reload_page() {
        window.location.reload();
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

    /**function sum() {
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
    }**/

    /**function isi_otomatis(){
      var id_bank = $("#id_bank").val();
      $.ajax({
          url: '<?= base_url('finance/accountant/get_autocomplete_bank') ?>',
          data:"id_bank="+id_bank,
          success: (function (data) {
          var json = data,
          obj = JSON.parse(json);
          $('#saldo').val(obj.saldo);
          
          var receive = $("#receive").val();
          var saldo = $('#saldo').val();

          saldo_akhir = parseInt(receive) + parseInt(saldo);

          $("#saldo_akhir").val(saldo_akhir);

          return true;

        })
      })
    }*/
    
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

    function hitung_income() {
        //var re = /^[\w\s]+$/g;
        var txtFirstNumberValue = document.getElementById('jumlah').value;
        var txtSecondNumberValue = document.getElementById('harga').value;
        // var txtFourthNumberValue = document.getElementById('saldo').value;
        var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
        //var resultss = result + parseInt(txtFourthNumberValue);
        if (!isNaN(result)) {
            document.getElementById('income').value = parseFloat(result);
            //document.getElementById('saldo_akhir').value = resultss;
        } else {
            document.getElementById('income').value = '0';
            //document.getElementById('saldo_akhir').value = '0';
        }
    }

    function hitung_expense() {
        //var re = /^[\w\s]+$/g;
        var txtFirstNumberValue = document.getElementById('jumlah').value;
        var txtSecondNumberValue = document.getElementById('harga').value;
        // var txtFourthNumberValue = document.getElementById('saldo').value;
        var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
        //var resultss = result + parseInt(txtFourthNumberValue);
        if (!isNaN(result)) {
            document.getElementById('expense').value = parseFloat(result);
            //document.getElementById('saldo_akhir').value = resultss;
        } else {
            document.getElementById('expense').value = '0';
            //document.getElementById('saldo_akhir').value = '0';
        }
    }
    
    $('.numeric').keyup(function(e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });
</script>