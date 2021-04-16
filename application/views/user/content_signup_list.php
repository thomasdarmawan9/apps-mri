
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Transaksi</h3>
    </div>
    <div class="card-body">
        <h4>Filter Data</h4>
        <form method="get" action="<?= base_url('user/signup/all?')?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Program</label>
                        <div class="col-sm-8">
                            <select class="form-control js-example-basic-single" name="event" id="event">
                                <option value="all">All</option>
                                <?php 
                                foreach($event as $row) {
                                    if(strtolower($row['name']) == strtolower($this->input->get('event'))){
                                        echo "<option value='".$row['name']."' selected>".ucfirst($row['name'])."</option>";
                                    }else{
                                        echo "<option value='".$row['name']."'>".ucfirst($row['name'])."</option>";
                                    }
                                } 
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Batch</label>
                        <div class="col-sm-8" id="div_batch">
                            <select class="form-control js-example-basic-single" name="batch" id="batch">
                                <option value="all">All</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">SP</label>
                        <div class="col-sm-8">
                            <select class="form-control js-example-basic-single" name="sp" id="sp">
                                <option value="all">All</option>
                                <?php 
                                foreach($list_task as $row) {
                                    if($row['id'] == $this->input->get('sp')){
                                        echo "<option value='".$row['id']."' selected>".date('d-M-Y', strtotime($row['date'])).' | '.$row['event'].' | '.$row['location']."</option>";
                                    }else{
                                        echo "<option value='".$row['id']."'>".date('d-M-Y', strtotime($row['date'])).' | '.$row['event'].' | '.$row['location']."</option>";
                                    }
                                } 
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Type</label>
                        <div class="col-sm-8" id="div_batch">
                            <select class="form-control" name="type" id="type">
                                <option value="all">All</option>
                                <option value="Lunas">Lunas</option>
                                <option value="DP">DP</option>
                                
                                <?php if(($this->session->userdata('student_privilege') == 1) || ($this->session->userdata('id') == '32')){?>
                                <option value="Full Program">Full Program</option>
                                <option value="Modul">Modul</option>
                                <?php }?>
                            
                            </select>
                        </div>
                    </div>
                </div>
                <?php if(($this->session->userdata('student_privilege') == 1) || ($this->session->userdata('id') == '32')){?>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control js-example-basic-single" name="branch" id="branch">
                                <option value="all">All</option>
                                <?php 
                                foreach($branch as $row) {
                                    if($row['branch_id'] == $this->input->get('branch')){
                                        echo "<option value='".$row['branch_id']."' selected>".ucfirst($row['branch_name'])."</option>";
                                    }else{
                                        echo "<option value='".$row['branch_id']."'>".ucfirst($row['branch_name'])."</option>";
                                    }
                                } 
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Class</label>
                        <div class="col-sm-8">
                            <select class="form-control js-example-basic-single" name="class" id="class">
                                <option value="all">All</option>
                                <?php 
                                foreach($class as $row) {
                                    if($row['class_id'] == $this->input->get('class')){
                                        echo "<option value='".$row['class_id']."' selected>".ucfirst($row['class_name'])."</option>";
                                    }else{
                                        echo "<option value='".$row['class_id']."'>".ucfirst($row['class_name'])."</option>";
                                    }
                                } 
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <button type="submit" class="btn primary-color-dark"><i class="fa fa-search"></i>&nbsp; FILTER</button>
                    <button type="button" class="btn btn-success" id="export" title='Harap tekan tombol filter terlebih dahulu sebelum export data' data-toggle='tooltip' data-placement='right'><i class="fa fa-file-excel"></i>&nbsp; Export to Excel</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
                        <th class="text-center" style="vertical-align: middle;">No</th>
                        <th style="vertical-align: middle">Program</th>
                        <?php 
                            if(($this->session->userdata('student_privilege') == 1) || ($this->session->userdata('id') == '32')){
                                echo "<th style='vertical-align:middle;'>Cabang</th>";
                            }
                        ?>
                        <th style="vertical-align: middle">Participant</th>
                        <th style="vertical-align: middle">Phone</th>
                        <th style="vertical-align: middle">Email</th>
                        <th style="vertical-align: middle">Paid</th>
                        <th style="vertical-align: middle">Paid Date</th>
                        <th style="vertical-align: middle">Payment</th>
                        <th style="vertical-align: middle">Type</th>
                        <!-- <th style="vertical-align: middle">Sales</th> -->
                        <!-- <th style="vertical-align: middle;min-width: 100px;text-align: center;">SP</th> -->
                        <!-- <th style="vertical-align: middle">Referral</th> -->
                        <th style="vertical-align: middle">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php 
                    $no = 1;
                    foreach($list as $row){
                        echo "<tr style='font-size:0.9rem;'>";
                        echo "<td class='text-center'>".$no++."</td>";
                        echo "<td>".$row['event_name']."</td>";
                        if(($this->session->userdata('student_privilege') == 1) || ($this->session->userdata('id') == '32')){
                            echo "<td><label class='badge badge-light'>".$row['branch_name']." - ".$row['class_name']."</label></td>";
                        }
                        echo "<td>".ucwords($row['participant_name'])."</td>";
                        echo "<td>".$row['phone']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".number_format($row['paid_value'])."</td>";
                        if($row['is_reattendance'] == 1){
                            echo "<td>".$row['paid_date']."<br><label class='badge badge-danger'>Re-Attendance</label></td>";
                        }else if($row['is_upgrade'] == 1){
                            echo "<td>".$row['paid_date']."<br><label class='badge badge-danger'>Upgrade</label></td>";
                        }else{
                            echo "<td>".$row['paid_date']."</td>";
                        }
                        if(!empty($row['transfer_atas_nama'])){
                            echo "<td>".$row['payment_type']."<br><label class='badge badge-danger'>".$row['transfer_atas_nama']."</label></td>";
                        }else{
                            echo "<td>".$row['payment_type']."</td>";
                        }
                        if($row['closing_type'] == "Lunas"){
                            echo "<td><label class='badge badge-success'>".ucfirst($row['closing_type'])."</label></td>";
                        }else if($row['closing_type'] == "DP"){
                            echo "<td><label class='badge badge-light'>".ucfirst($row['closing_type'])."</label></td>";
                        }else if($row['closing_type'] == "Full Program"){
                            echo "<td><label class='badge badge-primary'>".ucfirst($row['closing_type'])."</label></td>";
                        }else{
                            echo "<td><label class='badge badge-warning'>".ucfirst($row['closing_type'])."</label></td>";
                        }
                        // echo "<td><label class='badge badge-info'>".ucfirst($row['username'])."</label></td>";
                        // echo "<td class='text-center'><label class='badge badge-light' style='white-space:normal;'>".($row['task'])."</label></td>";
                        // echo "<td class='text-center'><label class='badge warning-color-dark'>".ucfirst($row['referral'])."</label></td>";
                        echo "<td class='text-center'><button type='button' id='detail_trx' class='btn btn-blue-grey' onclick='detail_trx(".$row['transaction_id'].")'><i class='fa fa-info'></i></button></td>";
                        echo "</tr>";

                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_participant" data-backdrop="static" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_participant" style="padding-left:15px;padding-right: 15px;">
                <div class="modal-header" style="background-color:#78909c;color:#fff">
                    <h4 class="modal-title" id="header_participant">Transaction Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Program Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="event_name" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Signup Method</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="signup_type" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row" id="show_task">
                                <label class="col-form-label col-sm-4">Session</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="id_task" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Re-Attendance</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="is_reattendance" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Closing Type</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="closing_type" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Payment Type</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="payment_type" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Atas Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="atas_nama" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Amount Paid</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="paid_value" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Paid Date</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="paid_date" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Sales</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="sales" value="" readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="card text-white elegant-color" style="border-radius: 0px;">
                            <div class="card-body text-right text-white py-2">
                                <span>Sales Commision : <b>Rp <span id="event_commision">0</span></b></span>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="participant_name" value="" readonly="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Birthdate</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="birthdate" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Gender</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="gender" value="" readonly="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Phone</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="phone" value="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Email</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="email" value="" readonly="">
                                </div>
                            </div>
                            <hr class="parent">
                            <div class="row parent">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <h5 class="text-center w-100">Dad's Data</h5>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-sm-4">Phone</label>
                                        <div class="col-sm-8">
                                            <input name="dad_phone" id="dad_phone" class="form-control numeric dad" type="text" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row dad">
                                        <label class="col-form-label col-sm-4">Name</label>
                                        <div class="col-sm-8">
                                            <input name="dad_name" id="dad_name" class="form-control dad" type="text" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row dad">
                                        <label class="col-form-label col-sm-4">Email</label>
                                        <div class="col-sm-8">
                                            <input name="dad_email" id="dad_email" class="form-control dad" type="email" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row dad">
                                        <label class="col-form-label col-sm-4">Job</label>
                                        <div class="col-sm-8">
                                            <input name="dad_job" id="dad_job" class="form-control dad" type="text" readonly="">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <h5 class="text-center w-100">Mom's Data</h5>
                                    </div>
                                    <div class="form-group row border-left-div">
                                        <label class="col-form-label col-sm-4">Phone</label>
                                        <div class="col-sm-8">
                                            <input name="mom_phone" id="mom_phone" class="form-control numeric mom" type="text" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row border-left-div mom">
                                        <label class="col-form-label col-sm-4">Name</label>
                                        <div class="col-sm-8">
                                            <input name="mom_name" id="mom_name" class="form-control mom" type="text" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row border-left-div mom">
                                        <label class="col-form-label col-sm-4">Email</label>
                                        <div class="col-sm-8">
                                            <input name="mom_email" id="mom_email" class="form-control mom" type="email" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group row border-left-div mom">
                                        <label class="col-form-label col-sm-4">Job</label>
                                        <div class="col-sm-8">
                                            <input name="mom_job" id="mom_job" class="form-control mom" type="text" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Source</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="source" value="" readonly="">
                                </div>
                            </div>
                            <div class="form-group row" id="referral_div">
                                <label class="col-form-label col-sm-4">Referral Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="referral" value="" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Notes</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="remark" id="remark" readonly=""></textarea>
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

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css"/>
<link rel="stylesheet" href="<?= base_url(); ?>inc/select2/select2.min.css"/>
<script type="text/javascript" src="<?= base_url();?>inc/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>inc/select2/select2.min.js"></script>
<script>
    $(document).ready(function(){
        var type = "<?= $this->input->get('type')?>";
        if(type != ''){
            $('#type').val(type).change();
        }
        $('.js-example-basic-single').select2();
        $(document).ajaxStart(function(){
            $("#wait").css("display", "block");
        });
        $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
        });

        $('[data-toggle="tooltip"]').tooltip(); 
        $('#table1').DataTable({
            'scrollX':true,
            'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]
            ],
             'rowReorder': {
                'selector': 'td:nth-child(2)'
            },
            'responsive': true,
            'stateSave': true
        });

        $('.datepicker').datepicker({
            todayHighlight: !0,
            dateFormat: 'yy-mm-dd',
            autoclose: !0,
            maxDate: 0
        });

        $('#date_start').datepicker({
            todayHighlight: !0,
            dateFormat: 'yy-mm-dd',
            autoclose: !0,
            maxDate: "<?= date('y-m-d')?>"
        });
        init_date_end();
        init_batch();
    });

    $('#date_start').change(function(e){
        $('#date_end').datepicker('destroy').remove();
        $('#div_date_end').append('<input type="text" name="date_end" id="date_end" class="form-control">');
        $('#date_end').datepicker({
            todayHighlight: !0,
            dateFormat: 'yy-mm-dd',
            autoclose: !0,
            minDate: $('#date_start').val(),
            maxDate: 0
        })
    });

    $('#event').change(function(){
        init_batch();
    });

    $('#export').click(function(){
        var query   = "<?= $_SERVER['QUERY_STRING']?>";
        var url     = "<?= base_url('user/signup/export_data_transaction?')?>"+query;
        window.open(url, '_blank');
    });


    function init_batch(){
        var event = $('#event').val();
        var batch = "<?= $this->input->get('batch')?>";

        $('#batch').empty();
        if(event != 'all'){
            $.ajax({
                url: "<?= base_url('user/signup/json_get_batch_list')?>",
                type: "POST",
                dataType: "json",
                data:{'event': event},
                success:function(result){       
                    $('#batch').append('<option value="all" selected>All</option><option value="none">None</option>');          
                    $.each(result, function(index, item){
                        $('#batch').append('<option value="'+item.batch_id+'">'+item.batch_label+'</option>');
                    });
                    if(batch != ''){
                        $('#batch').val(batch).change();
                    }
                }, error: function(e){
                    console.log(e);
                }
            })
        }else{
            $('#batch').append('<option value="all">All</option><option value="none">None</option>');
        }
    }

    function init_date_end(){
        $('#date_end').datepicker({
            todayHighlight: !0,
            dateFormat: 'yy-mm-dd',
            autoclose: !0,
            minDate: $('#date_start').val(),
            maxDate: 0
        })
    }

    function detail_trx(id){
        $('#modal_participant').modal('show');
        $('#form_participant').trigger('reset');
        $.ajax({
            url: "<?= base_url('user/signup/json_master_get_detail_transaction')?>",
            type: "POST",
            dataType: "json",
            data:{'id': id},
            success:function(result){       
                $('#event_name').val(result.event_name);
                $('#signup_type').val(result.signup_type);
                $('#id_task').val(result.task);
                if(result.is_reattendance == 1){
                    $('#is_reattendance').val('Ya');
                }else{
                    $('#is_reattendance').val('Tidak');
                }
                $('#closing_type').val(result.closing_type);
                $('#payment_type').val(result.payment_type);
                $('#atas_nama').val(result.transfer_atas_nama);
                $('#paid_value').val(result.paid_value);
                $('#paid_date').val(result.paid_date);
                $('#sales').val(result.sales);
                $('#participant_name').val(result.participant_name);
                $('#birthdate').val(result.birthdate);
                $('#gender').val(result.gender);
                $('#phone').val(result.phone);
                $('#email').val(result.email);
                $('#source').val(result.source);
                $('#referral').val(result.referral);
                $('#remark').val(result.remark);
                $('#event_commision').empty().html(Number(result.event_commision).toLocaleString());
                if(result.dad_name != null || result.mom_name != null){
                    $('.parent').show();
                    $('#dad_name').val(result.dad_name);
                    $('#dad_phone').val(result.dad_phone);
                    $('#dad_email').val(result.dad_email);
                    $('#dad_job').val(result.dad_job);
                    $('#mom_name').val(result.mom_name);
                    $('#mom_phone').val(result.mom_phone);
                    $('#mom_email').val(result.mom_email);
                    $('#mom_job').val(result.mom_job);
                }else{
                    $('.dad, .mom').val('');
                    $('.parent').hide();
                }
            }, error: function(e){
                console.log(e);
            }
        })
    }

    function reload_page(){
        window.location.reload();
    }

    
</script>
