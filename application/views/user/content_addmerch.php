<link rel="stylesheet" href="<?= base_url('inc/fancybox/source/jquery.fancybox.css?v=2.1.7'); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url('inc/fancybox/source/jquery.fancybox.pack.js?v=2.1.7'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
</script>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <button data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-cons waves-effect waves-light" type="submit"><i class="icon-ok"></i><i class="fas fa-plus"></i> Add Product</button>
            <hr>
            <div class="table-responsive">
                <table class="table w-100" id="table1">
                    <thead class="text-center">
                        <tr style="background-color: #0d4e6c;color:#fff;">
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Overtime</th>
                            <th>Date</th>
                            <th style="min-width: 220px;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                        <?php $no = 1;
                        if (!empty($results)) {
                            foreach ($results as $r) { ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $no++; ?></td>
                                    <td class="align-middle"><?= $r->nama_product; ?></td>
                                    <td class="align-middle"><span class="badge badge-success"><?= number_format($r->ot); ?></span></td>
                                    <td class="align-middle"><span class="badge cyan"><?= date("d-m-Y", strtotime($r->timestamp)); ?></span></td>
                                    <td>
                                        <button onclick="push_data_update(<?= $r->id_product; ?>)" type="button" class="btn btn-warning" data-toggle="popover" data-placement="top" data-content="Update Product" data-trigger="hover"><i class="fas fa-edit"></i></button>
                                        <button onclick="hapus(<?= $r->id_product; ?>)" type="button" class="btn btn-danger" data-toggle="popover" data-placement="top" data-content="Delete Product" data-trigger="hover"><i class="fas fa-trash"></i></button>
                                </tr>
                        <?php }
                        } ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- END PAGE -->
</div>


<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <?php echo form_open_multipart('user/merchandise/add_product'); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="productname">Nama Produk<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="name" id="productname" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="productovertime">Jumlah Overtime<span style="color:red;">*</span></label>
                            <input type="number" class="form-control" name="overtime" id="productovertime" autocomplete="off" required>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
        </div>
    </div>
</div>


<!-- Modal Add Transaksi -->
<div class="modal fade" id="addTransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <?php echo form_open_multipart('logistic/product/add_stok_product'); ?>
            <input id="IdAddTransaction" name="id" style="display:none;" required>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Stok Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <img id="photoAddTransaction" src="http://via.placeholder.com/250x250" alt="placeholder" class="img-thumbnail">
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="alert alert-primary" role="alert">
                            Tambah Stok disini diartikan adanya penambahan jumlah, <b>bukan total jumlah saat ditambahkan</b>.
                        </div>
                        <div class="form-group">
                            <label for="productNameTransaction">Product name<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="name" id="productNameTransaction" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="addStokTransaction">Tambah Stok, Berapa ?<span style="color:red;">*</span></label>
                            <input type="number" min="1" name="qty" class="form-control" id="addStokTransaction" required>
                        </div>
                        <div class="form-group">
                            <label for="addTransactionRemark">Remark</label>
                            <textarea id="addTransactionRemark" name="remark" col="50" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <?php echo form_open_multipart('user/merchandise/update_product'); ?>
            <input id="idUpdate" name="id" style="display:none;" required>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nameUpdate">Product name<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="name" id="nameUpdate" required>
                        </div>
                        <div class="form-group">
                            <label for="priceUpdate">Overtime<span style="color:red;">*</span></label>
                            <input type="number" class="form-control" name="overtime" id="overtimeUpdate" required>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
        </div>
    </div>
</div>





<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover();
        $('#table1, #tabelDetail').DataTable({
            'scrollX': true,
            'lengthMenu': [
                [10, 15, 20, -1],
                [10, 15, 20, "All"]
            ],
            'rowReorder': {
                'selector': 'td:nth-child(2)'
            },
            'responsive': true,
            'stateSave': true
        });

    });

    function hapus(id) {
        if (id != '') {
            swal({
                title: 'Konfirmasi',
                text: "Product ini akan terhapus dari system dan segala log transaksi akan terhapus. \n\nApakah Anda yakin ?",
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#f35958',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }, function(result) {
                if (result) {
                    $.ajax({
                        url: "<?= base_url('logistic/product/delete_product'); ?>",
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


    function reload_page() {
        location.reload();
    }


    function push_data_update(id) {
        $.ajax({
            url: "<?= base_url('user/merchandise/push_data') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            },
            success: function(result) {
                if (result != null) {
                    console.log(result);
                    $('#idUpdate').val(result.id_product);
                    $('#nameUpdate').val(result.nama_product);
                    $('#overtimeUpdate').val(result.ot);
                    $('#updateModal').modal('show');
                } else {
                    swal("Not Found!", "Data produk tidak ditemukan.", "error");
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    function hapus(id) {
        if (id != '') {
            swal({
                title: 'Konfirmasi',
                text: "Product ini akan terhapus dari system . \n\nApakah Anda yakin ?",
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#f35958',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
            }, function(result) {
                if (result) {
                    $.ajax({
                        url: "<?= base_url('user/merchandise/delete_product'); ?>",
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

    function toDate(date) {
        var d = date;
        var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Des"];
        return d.getDate() + '-' + month[d.getMonth()] + '-' + d.getFullYear();
    }

    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
</script>