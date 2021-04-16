<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Referror</h3>
    </div>
    <div class="card-body">

        <a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Referror</a>
        <p>Here You Can do <code>Create, Edit and Delete</code>.
        </p>

        <br>
        <?php if (!empty($results)) { ?>
            <table class="table table-striped w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c;color:#fff;">
                        <th>No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Jumlah Referral</th>
                        <th>Input By</th>
                        <th>Branch</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $no = 1;
                    foreach ($results as $row) {
                    
                    $this->db->select('list_referral.referral');
                    $this->db->join('list_referror', 'list_referror.id_referror = list_referral.referral', 'left');
                    $this->db->where('list_referral.referral', $row->id_referror);
                    $referral = $this->db->get('list_referral')->num_rows();
                    
                    ?>
                        <tr>

                            <td><?php echo $no++ ?></td>
                            <td><?php echo ucfirst($row->name) ?></td>
                            <td><?php echo $row->phone ?></td>
                            <td><?php echo $row->email ?></td>
                            <td><?php echo $referral ?> - Referral</td>
                            <td><?php echo ucfirst($row->username) ?></td>
                            <?php if($row->branchid == '0'){ ?>
                                <td><label class='badge grey'>-</label></td>
                            <?php }else{ ?>
                                <td><?php echo $row->branch_name ?></td>
                            <?php } ?>
                            <?php
                            echo " <td nowrap='nowrap'>
                                        <a class='btn btn-info' onclick='edit(" . $row->id_referror . ")' title='Edit Data' data-placement='top'><i class='fa fa-edit'></i> EDIT</a>
                                        <button type='button' class='btn  btn-danger' onclick='hapus(" . $row->id_referror . ")'><i class='fa fa-trash'></i> HAPUS</button>
                                    </td>";
                            ?>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        <?php } else {
            echo "<center><p>Data Not found</p></center>";
        } ?>

    </div>
</div>

<!-- MODAL REFERROR -->

<div class="modal fade" tabindex="-1" id="modal_tambah" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('user/referral/submit_form_referror') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Form Referror</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_referror" id="id_referror" value="">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input name="name" id="name" class="form-control" type="text" placeholder="Name" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Phone</label>
                        <div class="col-sm-8">
                            <input name="phone" id="phone" class="form-control numeric" type="text" placeholder="Phone" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">E-mail</label>
                        <div class="col-sm-8">
                            <input name="email" id="email" class="form-control" type="text" placeholder="E-mail" required="" autocomplete="off">
                        </div>
                    </div>
                    <?php if ($this->session->userdata('branch') == '0') { ?>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-4">Branch</label>
                            <div class="col-sm-8">
                                <select name="branch_id" id="branch_id" class="form-control">
                                    <option value="">Pilih Salah Satu</option>
                                    <?php foreach ($branch as $row) { ?>
                                        <option value="<?php echo $row->branch_id ?>"><?php echo $row->branch_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- END MODAL REFERROR -->




<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
            url: "<?= base_url('user/referral/json_get_referror_detail') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'id_referror': id
            },
            success: function(result) {
                $('#id_referror').val(result.id_referror);
                $('#name').val(result.name);
                $('#phone').val(result.phone);
                $('#email').val(result.email);
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
                text: "Jika Anda Menghapus Data Referror Maka Semua data Referral yang dipunya akan terhapus, Lanjutkan?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f35958',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }, function(result) {
                if (result) {
                    $.ajax({
                        url: "<?= base_url('user/referral/delete_referror') ?>",
                        type: "POST",
                        dataType: "json",
                        data: {
                            'id_referror': id
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