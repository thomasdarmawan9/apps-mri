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
        <h3 class="card-title">Add Transaction Data</h3>
    </div>
    <div class="card-body">

        <form method="post" action="<?= base_url(); ?>finance/accountant/add_row_expense_finance">

            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id_trans" id="id_trans" value="">
                    <div class="form-group">
                        <label class="col-form-label">Key Number<small class="text-danger"><b>&nbsp;*</b></small></label>
                        <div class="col-sm-12">
                            <input name="key_number" id="key_number" class="form-control" type="text" placeholder="Key Number" required="" readonly value=<?php echo strtoupper($key) ?> autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label">Receipt Number</label>
                        <div class="col-sm-12">
                            <input name="receipt_number" id="receipt_number" class="form-control" type="text" value="<?= (!empty($_GET['receipt_number'])) ? $_GET['receipt_number'] : '' ?>" placeholder="Receipt Number" autocomplete="off">
                        </div>
                    </div>
                </div>

            </div>

            <hr>

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label">Payment Source<small class="text-danger"><b>&nbsp;*</b></small></label>
                        <div class="col-sm-12">
                            <select class="form-control js-example-basic-single" name="id_bank" id="id_bank" required>
                                <option value="" readonly>-Please Choose-</option>
                                <?php if (!empty($_GET['id_bank'])) {
                                    $id_bank = $_GET['id_bank'];
                                } else {
                                    $id_bank = "";
                                } ?>

                                <?php foreach ($bank as $b) {
                                    if ($b->id_bank == $id_bank) {
                                        echo "<option value='" . $b->id_bank . "' selected>" . ucfirst($b->name). ' - '. ucfirst($b->pt) . "</option>";
                                    } else {
                                        echo "<option value='" . $b->id_bank . "'>" . ucfirst($b->name) . ' - '. ucfirst($b->pt). "</option>";
                                    } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <td>

                </td>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label">Bill</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="bon" id="bon" required="">
                                <?php if ($this->input->get('bon') == 'y_writen') { ?>
                                    <option value="">-Please Choose-</option>
                                    <option value="y_writen" selected>Y (Writen)</option>
                                    <option value="y_print">Y (Print)</option>
                                    <option value="n_self">N (Self)</option>
                                    <option value="n">N</option>
                                <?php } else if ($this->input->get('bon') == 'y_print') { ?>
                                    <option value="">-Please Choose-</option>
                                    <option value="y_writen">Y (Writen)</option>
                                    <option value="y_print" selected>Y (Print)</option>
                                    <option value="n_self">N (Self)</option>
                                    <option value="n">N</option>
                                <?php } else if ($this->input->get('bon') == 'n_self') { ?>
                                    <option value="">-Please Choose-</option>
                                    <option value="y_writen">Y (Writen)</option>
                                    <option value="y_print">Y (Print)</option>
                                    <option value="n_self" selected>N (Self)</option>
                                    <option value="n">N</option>
                                <?php } else if ($this->input->get('bon') == 'n') { ?>
                                    <option value="">-Please Choose-</option>
                                    <option value="y_writen">Y (Writen)</option>
                                    <option value="y_print">Y (Print)</option>
                                    <option value="n_self">N (Self)</option>
                                    <option value="n" selected>N</option>
                                <?php } else { ?>
                                    <option value="">-Please Choose-</option>
                                    <option value="y_writen">Y (Writen)</option>
                                    <option value="y_print">Y (Print)</option>
                                    <option value="n_self">N (Self)</option>
                                    <option value="n">N</option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label">Date<small class="text-danger"><b>&nbsp;*</b></small></label>
                        <div class="col-sm-12">
                            <input name="date" id="date" class="form-control datepicker" type="text" placeholder="Receipt Number" value="<?= (!empty($_GET['date'])) ? $_GET['date'] : '' ?>" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">

                <?php if (empty($_GET['baris'])) { ?>
                    <input type="text" name="redirect" style="display:none;" value="<?= base_url(); ?>finance/accountant/add_transaction_expense/?">

                    <div class="form-row align-items-center">
                        <div class="col-sm-2">
                            <input type="number" min="0" name="baris" class="form-control ml-3" value="1" style="width: 93%" hidden>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-success" type="submit"> Tambah Row</button>
                        </div>
                    </div>
            </div>
        <?php } ?>
        </form>
    </div>
</div>

<hr>

<?php if (!empty($_GET['baris'])) { ?>

    <div class="card">
        <h5 class="card-header">Add Transaction</h5>
        <div class="card-body">

            <div class="alert alert-info" role="alert" style="text-align: left;">Silahkan isi list dibawah ini untuk menambahkan data transaksi.</div>

            <div class="well clearfix">
                <a class="btn btn-primary pull-right add-record" data-added="0"><i class="fa fa-plus"></i>&nbsp; Tambah Row</a>
            </div>


            <form action="<?= base_url(); ?>finance/accountant/submit_form_expense" method="post">
                <input type="text" name="baris" value="<?php echo $_GET['baris']; ?>" hidden required>
                <input type="text" name="key_number" value="<?php echo $_GET['key_number']; ?>" hidden required>
                <input type="text" name="receipt_number" value="<?php echo $_GET['receipt_number']; ?>" hidden>
                <input type="text" name="jenis" value="<?php echo $_GET['jenis']; ?>" hidden>
                <input type="text" name="id_bank" value="<?php echo $_GET['id_bank']; ?>" hidden required>
                <input type="text" name="id_pt" value="<?php echo $_GET['id_pt']; ?>" hidden required>
                <input type="text" name="bon" value="<?php echo $_GET['bon']; ?>" hidden required>
                <input type="text" name="date" value="<?php echo $_GET['date']; ?>" hidden required>
                <input type="text" name="row" id="row" value="1" hidden required>

                <table class="table table-striped w-100" id="tbl_posts">
                    <thead class="cf">
                        <tr style="background: #5d9ceb;color: white;">

                            <th>Division</th>
                            <th>Index</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody id="tbl_posts_body">

                        <tr id="rec-0">
                            <td hidden><span class="sn">0</span>.</td>
                            <td>
                                <select class="form-control js-example-basic-single" name="id_divisi0" id="id_divisi0" style="width: 150px">
                                    <option value="" readonly>-Please Choose-</option>
                                    <?php foreach ($divisi as $d) { ?>
                                        <option value="<?php echo $d->id_divisi; ?>"><?php echo $d->no_divisi; ?> - <?php echo ucfirst($d->nama_divisi); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <select name="id_indeks0" id="id_indeks0" class="form-control" required style="width: 200px">
                                    <option value="">Choose Index</option>

                                </select>
                            </td>
                            <td hidden>
                                <select name="head_divisi0" id="head_divisi0" class="form-control" required style="width: 160px" readonly>

                                </select>
                            </td>

                            <td><input type="text" name="transaksi0" id="transaksi0" class="form-control" required style="width: 280px"></td>
                            <td><input type="text" name="jumlah0" id="jumlah0" onkeyup="cek_indeks();" class="form-control" required style="width: 80px"></td>

                            <td><input type="text" name="harga0" id="harga0" onkeyup="cek_indeks();" class="form-control" required style="width: 130px"></td>
                            <td><input type="text" name="expense0" id="expense0" class="form-control" required style="width: 160px"></td>
                            <td><a class="btn btn-danger delete-record" data-id="0"><i class="fa fa-trash"></i></a></td>
                            <!--<td hidden>-->
                            <!--    <select name="id_pt0" id="id_pt0" class="form-control" required style="width: 160px" readonly>-->
                            <!--        <?php foreach ($pt as $p) { ?>-->
                            <!--            <option value="<?php echo $p->id_pt; ?>"><?php echo ucfirst($p->pt); ?></option>-->
                            <!--        <?php } ?>-->
                            <!--    </select>-->
                            <!--</td>-->
                        </tr>



                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary btn-cons">Save</button>
            </form>
        </div>
    </div>

<?php } ?>

<div style="display:none;">
    <table id="sample_table">
        <tr id="">
            <td hidden><span class="sn"></span>.</td>
            <td>
                <select class="form-control id_divisi" name="" id="" style="width: 150px">
                    <option value="" readonly>-Please Choose-</option>
                    <?php foreach ($divisi as $d) { ?>
                        <option value="<?php echo $d->id_divisi; ?>"><?php echo $d->no_divisi; ?> - <?php echo ucfirst($d->nama_divisi); ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select name="" id="" class="form-control id_indeks" required style="width: 200px">
                    <option value="">Choose Index</option>

                </select>
            </td>
            <td hidden>
                <select name="" id="" class="form-control head_divisi" required style="width: 160px" readonly>

                </select>
            </td>

            <td><input type="text" name="" id="" class="form-control transaksi" required style="width: 280px"></td>
            <td><input type="text" name="" id="" onkeyup="cek_indeks();" class="form-control jumlah" required style="width: 80px"></td>

            <td><input type="text" name="" id="" onkeyup="cek_indeks();" class="form-control harga" required style="width: 130px"></td>
            <td><input type="text" name="" id="" class="form-control expense" required style="width: 160px"></td>
            <!--<td hidden>-->
            <!--    <select name="" id="" class="form-control id_pt" required style="width: 160px" readonly>-->
            <!--        <?php foreach ($pt as $p) { ?>-->
            <!--            <option value="<?php echo $p->id_pt; ?>"><?php echo ucfirst($p->pt); ?></option>-->
            <!--        <?php } ?>-->
            <!--    </select>-->
            <!--</td>-->
            <td><a class="btn btn-danger delete-record" data-id=""><i class="fa fa-trash"></i></a></td>

        </tr>
    </table>
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

        //FUNCTION OF SELECT2

        $('.js-example-basic-single').select2();

    });

    // START OF APPEND ROW TABLE

    jQuery(document).delegate('a.add-record', 'click', function(e) {
        e.preventDefault();
        var content = jQuery('#sample_table tr'),
            size = jQuery('#tbl_posts >tbody >tr').length + 0,
            element = null,
            element = content.clone();

        element.attr('id', 'rec-' + size);
        element.find('.id_divisi').attr('id', 'id_divisi' + size);
        element.find('.id_divisi').attr('name', 'id_divisi' + size);
        element.find('.id_indeks').attr('id', 'id_indeks' + size);
        element.find('.id_indeks').attr('name', 'id_indeks' + size);
        element.find('.head_divisi').attr('id', 'head_divisi' + size);
        element.find('.head_divisi').attr('name', 'head_divisi' + size);
        element.find('.transaksi').attr('id', 'transaksi' + size);
        element.find('.transaksi').attr('name', 'transaksi' + size);
        element.find('.jumlah').attr('id', 'jumlah' + size);
        element.find('.jumlah').attr('name', 'jumlah' + size);
        element.find('.harga').attr('id', 'harga' + size);
        element.find('.harga').attr('name', 'harga' + size);
        element.find('.expense').attr('id', 'expense' + size);
        element.find('.expense').attr('name', 'expense' + size);
        // element.find('.id_pt').attr('id', 'id_pt' + size);
        // element.find('.id_pt').attr('name', 'id_pt' + size);
        element.find('.delete-record').attr('data-id', size);
        element.appendTo('#tbl_posts_body');
        element.find('.sn').html(size);

        var row = $('#row').val();
        document.getElementById('row').value++

        // START OF SELECT2 FROM APPEND ROW TABLE

        $('#id_divisi' + size).select2();

        // END OF SELECT2 FROM APPEND ROW TABLE

        // START OF AUTOCOMPLETE INDEKS AND HEAD DIVISI FROM APPEND ROW TABLE

        $('#id_divisi' + size).change(function() {

            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;

            $('#head_divisi' + size).empty();
            $('#id_indeks' + size).empty();

            $.ajax({
                url: "<?= base_url('finance/accountant/get_autocomplete_divisi') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    'id_divisi': valueSelected,
                },
                success: function(result) {
                    $.each(result, function(index, item) {
                        $('#head_divisi' + size).append('<option value="' + result[index].head_divisi + '">' + result[index].head_divisi + '</option>');
                        $('#id_indeks' + size).append('<option value="' + result[index].id_indeks + '">' + result[index].nama_indeks + '</option>');
                    });
                },
                error: function(e) {
                    console.log(e);
                }
            })
        });

        // END OF AUTOCOMPLETE INDEKS AND HEAD DIVISI FROM APPEND ROW TABLE

        // START OF CALCULATE FROM APPEND ROW TABLE (INPUT HARGA)

        $('#harga' + size).keyup(function() {

            $('#expense' + size).empty();

            var txtFirstNumberValue = document.getElementById('jumlah' + size).value;
            var txtSecondNumberValue = document.getElementById('harga' + size).value;


            var secondNumber = txtSecondNumberValue.replace(/,/g, '');
            // console.log(secondNumber);


            var result = parseFloat(txtFirstNumberValue) * parseFloat(secondNumber);
            var num_parts = result.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            results = num_parts.join(".");

            total = results

            if (!isNaN(result)) {
                document.getElementById('expense' + size).value = total;
            } else {
                $('#expense' + size).empty();
            }

        });

        // END OF CALCULATE FROM APPEND ROW TABLE (INPUT HARGA)

        // START OF CALCULATE FROM APPEND ROW TABLE (INPUT JUMLAH)

        $('#jumlah' + size).keyup(function() {

            $('#expense' + size).empty();

            var txtFirstNumberValue = document.getElementById('jumlah' + size).value;
            var txtSecondNumberValue = document.getElementById('harga' + size).value;


            var secondNumber = txtSecondNumberValue.replace(/,/g, '');
            // console.log(secondNumber);


            var result = parseFloat(txtFirstNumberValue) * parseFloat(secondNumber);
            var num_parts = result.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            results = num_parts.join(".");

            total = results

            if (!isNaN(result)) {
                document.getElementById('expense' + size).value = total;
            } else {
                $('#expense' + size).empty();
            }

        });

        // END OF CALCULATE FROM APPEND ROW TABLE (INPUT HARGA)

        // MASK MONEY FROM APPEND ROW TABLE (INPUT HARGA)

        // $('#harga' + size).maskMoney({
        //     precision: 3
        // });
        // $('#jumlah' + size).maskMoney({
        //     precision: 3
        // });

        // END FUNCTION

    });

    // END OF APPEND ROW TABLE

    // START OF REMOVE ROW TABLE

    jQuery(document).delegate('a.delete-record', 'click', function(e) {
        e.preventDefault();
        var didConfirm = confirm("Are you sure You want to delete");
        if (didConfirm == true) {
            var id = jQuery(this).attr('data-id');
            var targetDiv = jQuery(this).attr('targetDiv');
            jQuery('#rec-' + id).remove();

            //regnerate index number on table
            $('#tbl_posts_body tr').each(function(index) {
                //alert(index);
                $(this).find('span.sn').html(index + 1);
            });

            var row = $('#row').val();
            document.getElementById('row').value--

            return true;
        } else {
            return false;
        }
    });

    // END OF REMOVE ROW TABLE

    // START OF FUNCTION DATEPICKER

    $(".datepicker").datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
    });

    // END OF FUNCTION DATEPICKER

    // START OF FUNCTION RELOAD PAGE

    function reload_page() {
        window.location.reload();
    }

    // START OF AUTOCOMPLETE INDEKS AND HEAD DIVISI

    $('#id_divisi0').change(function() {

        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;

        $('#head_divisi0').empty();
        $('#id_indeks0').empty();

        $.ajax({
            url: "<?= base_url('finance/accountant/get_autocomplete_divisi') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'id_divisi': valueSelected,
            },
            success: function(result) {
                $.each(result, function(index, item) {
                    $('#head_divisi0').append('<option value="' + result[index].head_divisi + '">' + result[index].head_divisi + '</option>');
                    $('#id_indeks0').append('<option value="' + result[index].id_indeks + '">' + result[index].nama_indeks + '</option>');
                });
            },
            error: function(e) {
                console.log(e);
            }
        })
    });

    // END OF AUTOCOMPLETE INDEKS AND HEAD DIVISI

    // START OF CALCULATE 

    function cek_indeks() {

        $('#expense0').empty();

        var txtFirstNumberValue = document.getElementById('jumlah0').value;
        var txtSecondNumberValue = document.getElementById('harga0').value;


        var secondNumber = txtSecondNumberValue.replace(/,/g, '');
        // console.log(secondNumber);

        var result = parseFloat(txtFirstNumberValue) * parseFloat(secondNumber);
        var num_parts = result.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        results = num_parts.join(".");
        
        total = results;

        if (!isNaN(result)) {
            document.getElementById('expense0').value = total;

        } else {
            $('#expense0').empty();
        }

    }


    // END OF CALCULATE

    // START OF FUNCTION MASK MONEY

    $('.money').maskMoney({
        precision: 3
    });

    // END OF FUNCTION MASK MONEY

    // START OF FUNCTION NUMERIC

    $('.numeric').keyup(function(e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });

    // END OF FUNCTION NUMERIC
</script>