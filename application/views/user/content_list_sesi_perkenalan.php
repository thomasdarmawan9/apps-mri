<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Event</h3>
    </div>
    <div class="card-body">

        <a class="btn btn-primary float-right" id="showtambah"><i class="fa fa-plus"></i>&nbsp; Tambah Event</a>
        <p>Here You Can do <code>Create, Edit and Delete</code>.
        </p>

        <br>

        <?php if (!empty($results)) { ?>
            <div class="alert alert-info" style="letter-spacing:0px;font-weight:bold;margin-bottom:30px">
                <button class="close" data-dismiss="alert"></button>
                Info: Jadwal Ini akan selalu otomatis terhapus setelah H+1 Event Selesai.
            </div>
            <table class="table table-striped w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c;color:#fff;">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Event<</th> <th>Lokasi</th>
                        <th>Konfirmasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $no = 1;
                    foreach ($results as $row) {  ?>
                        <tr>

                            <td><?php echo $no++ ?></td>
                            <td><?php echo date('d F Y', strtotime($row->date_event)) ?></td>
                            <td><?php echo $row->event ?></td>

                            <td><?php
                                if ($row->location == "hb" || $row->location == "HB") {
                                    echo "<label class='badge purple lighten-1'>Home Base</label>";
                                } elseif ($row->location == "Puri" || $row->location == "pi") {
                                    echo "<label class='badge badge-danger'>Puri Indah</label>";
                                } elseif ($row->location == "BSD" || $row->location == "bsd") {
                                    echo "<label class='badge badge-info'>BSD</label>";
                                } elseif ($row->location == "KG" || $row->location == "kg") {
                                    echo "<label class='badge badge-warning'>Kelapa Gading</label>";
                                } elseif ($row->location == "PH" || $row->location == "ph") {
                                    echo "<label class='badge badge-success'>Permata Hijau</label>";
                                } elseif ($row->location == "Palem" || $row->location == "pl") {
                                    echo "<label class='badge secondary-color'>Taman Palem</label>";
                                } elseif ($row->location == "BW" || $row->location == "bw") {
                                    echo "<label class='badge pink'>Banjar Wijaya</label>";
                                } elseif ($row->location == "SBY" || $row->location == "sby") {
                                    echo "<label class='badge green darken-1'>Surabaya</label>";
                                } elseif ($row->location == "GdS" || $row->location == "gds") {
                                    echo "<label class='badge green darken-1'>Gading Serpong</label>";
                                } else {
                                    echo "<label class='badge black'>$row->location</label>";
                                } ?>
                            </td>
                            <td><?php echo $row->is_confirm ?></td>
                            <?php
                            echo " <td nowrap='nowrap'>
                                        <a class='btn btn-info' onclick='edit(" . $row->id . ")' title='Edit Data' data-placement='top'><i class='fa fa-edit'></i> EDIT</a>
                                        <button type='button' class='btn  btn-danger' onclick='hapus(" . $row->id . ")'><i class='fa fa-trash'></i> HAPUS</button>
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

<!-- MODAL EVENT -->

<div class="modal fade" tabindex="-1" id="modal_tambah" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('user/task/submit_form_sp') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Form Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Event</label>
                        <div class="col-sm-8">
                            <input name="event" id="event" class="form-control" type="text" placeholder="Event" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Date</label>
                        <div class="col-sm-8">
                            <input name="date_event" id="date_event" class="form-control datepicker" type="text" placeholder="Date" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Location</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="lokasi" id="lokasi" required="">
                                <option value="">-Pilih Salah Satu-</option>
                                 <option value="hb">Home Base</option>
                                <option value="pi">Puri Indah</option>
                                <option value="bsd">BSD</option>
                                <option value="kg">Kelapa Gading</option>
                                <option value="ph">Permata Hijau</option>
                                <option value="pl">Taman Palem</option>
                                <option value="bw">Banjar Wijaya</option>
                                <option value="gds">Gading Serpong</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="others_lokasi">
						<label class="col-form-label col-sm-4">Others</label>
						<div class="col-sm-8">
							<input name="location" id="location" class="form-control" placeholder="e.g. Ibis Style Hotel">
						</div>
					</div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Confirm</label>
                        <div class="col-sm-8">
                            <input name="is_confirm" id="is_confirm" class="form-control" type="text" placeholder="Confirm" required="" autocomplete="off">
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

<!-- END MODAL SESI PERKENALAN -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
        show_others_lokasi();
    });
    
    // show location
	$('#lokasi').change(function() {
		show_others_lokasi();
	});

	function show_others_lokasi() {
		var lokasi = $('#lokasi').val();
		if (lokasi == 'others') {
			$('#others_lokasi').show('slide', {
				direction: 'up'
			}, 500);
		} else {
			$('#others_lokasi').hide('slide', {
				direction: 'up'
			}, 500);
		}
	}
	// end show location


    $(".datepicker").datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
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
            url: "<?= base_url('user/task/json_get_sp_detail') ?>",
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            },
            success: function(result) {
                $('#id').val(result.id);
                $('#event').val(result.event);
                $('#date_event').val(result.date_event);
                var location = result.location;
				if((location == 'hb') || (location == 'pi') || (location == 'bsd') || (location == 'kg') || (location == 'ph') || (location == 'pl') || (location == 'bw') || (location == 'sby')){
					$('#lokasi').val(location).change();
                    $('#others_lokasi').hide();	
					$('#location').val('');
				}else{
					$('#lokasi').val('others');
					$('#others_lokasi').show();
					$('#location').val(location);
				}
                $('#is_confirm').val(result.is_confirm);
                $('#modal_tambah').modal('show');
            },
            error: function(e) {
                console.log(e);
            }
        })
    }
    
    // function edit(id) {
    //     $('#form_data').trigger("reset");
    //     $.ajax({
    //         url: "<?= base_url('user/task/json_get_sp_detail') ?>",
    //         type: "POST",
    //         dataType: "json",
    //         data: {
    //             'id': id
    //         },
    //         success: function(result) {
    //             $('#id').val(result.id);
    //             $('#id_task').val(result.id_task);
    //             $('#event').val(result.event);
    //             $('#date_event').val(result.date_event);
    //             var location = result.location;
				// if((location == 'hb') || (location == 'Puri') || (location == 'BSD') || (location == 'KG') || (location == 'PH') || (location == 'Palem') || (location == 'BW') || (location == 'SBY')){
				// 	$('#lokasi').val(location).change();
    //                 $('#others_lokasi').hide();	
				// 	$('#location').val('');
				// }else{
				// 	$('#lokasi').val('others');
				// 	$('#others_lokasi').show();
				// 	$('#location').val(location);
				// }
    //             $('#is_confirm').val(result.is_confirm);
    //             $('#modal_tambah').modal('show');
    //         },
    //         error: function(e) {
    //             console.log(e);
    //         }
    //     })
    // }

    function hapus(id) {
        if (id != '') {
            swal({
                title: 'Konfirmasi',
                text: "Data Akan Dihapus, Lanjutkan?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f35958',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }, function(result) {
                if (result) {
                    $.ajax({
                        url: "<?= base_url('user/task/delete_sp') ?>",
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

    $('.numeric').keyup(function(e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });
</script>