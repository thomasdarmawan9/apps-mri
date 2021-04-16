<style type="text/css">
.custom-control-label::before {
    margin-left: 20px;
}

.custom-control-label::after {
    margin-left: 20px;
}
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('rc/absensi?'.$url)?>">Absensi</a></li>
        <li class="breadcrumb-item active"><?= $periode['periode_name']?></li>
        <li class="breadcrumb-item active"><?= $class['branch_name']?></li>
        <li class="breadcrumb-item active"><?= $class['program']?></li>
        <li class="breadcrumb-item active"><?= $class['class_name']?></li>
        <li class="breadcrumb-item active" aria-current="page">Sesi - <?= $sesi?></li>
    </ol>
</nav>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halaman Absensi</b>
    </div>
    <div class="card-body">
        <a class="btn btn-elegant" id="showtambah"><i class="fa fa-user-plus"></i>&nbsp; Add Student</a>
        <a class="btn btn-info" id="showother"><i class="fa fa-search-plus"></i>&nbsp; From Other Class</a>
        <a class="btn pink" id="showrekap"><i class="fa fa-clipboard-list"></i>&nbsp; Summary</a>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
                        <th class="text-center" style="vertical-align: middle;">No</th>
                        <th style="vertical-align: middle">Student</th>
                        <th style="vertical-align: middle">Program</th>
                        <th style="vertical-align: middle">Class</th>
                        <th style="vertical-align: middle">Status</th>
                        <th style="vertical-align: middle">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php 
						$no = 1;
						foreach($absen as $row){
							echo "<tr style='font-size:0.9rem;'>";
							echo "<td class='text-center'>".$no++."</td>";
							echo "<td>".ucfirst($row['participant_name'])."</td>";
							echo "<td>".$row['program']."</td>";
							echo "<td>".$row['class_name']."</td>";
							if($row['is_attend'] == 1){
								if($row['is_change'] == 1){
                                    echo "
                                    <td>
                                        <label class='badge badge-success'>Hadir</label><br><label class='badge badge-warning'>Dari Kelas Lain</label><br>
                                        <label class='badge badge-default'>".$row['branch_from'].' - '.$row['class_from']."</label>
                                    </td>";
								}else{
									echo "<td><label class='badge badge-success'>Hadir</label></td>";
								}
							}else if($row['is_attend'] == 2){
                                echo "
                                <td>
                                    <label class='badge badge-warning'>Di Kelas Lain</label><br>
                                    <label class='badge badge-default'>".$row['branch_to'].' - '.$row['class_to']."</label>
                                </td>";
							}else{
								echo "<td><label class='badge badge-danger'>Tidak Hadir</label></td>";
							}

							if($row['is_attend'] != 2){
								echo "<td>
									<a onclick='remove(".$row['absen_id'].")' class='btn btn-danger' title='Hapus data ini?' data-toggle='tooltip' data-placement='top'>
										<i class='fa fa-trash'></i>
									</a>
								</td>";
							}else{
								echo "<td></td>";
							}
							
							echo "</tr>";

						}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_tambah" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('rc/absensi/add_presence')?>" method="post" id="form_data"
                class="form-horizontal" style="width:100%">
                <div class="modal-header" style="background-color:#0d4e6c;color:#fff">
                    <h4 class="modal-title" id="myModalLabel">Add Student</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="trainer_class_id" id="trainer_class_id"
                        value="<?= $class['trainer_class_id']?>">
                    <input type="hidden" name="sesi" id="sesi" value="<?= $sesi?>">
                    <input type="hidden" name="url" value="<?= $_SERVER['QUERY_STRING'];?>">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100" id="table2">
                            <thead>
                                <tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
                                    <th class="text-center" style="vertical-align: middle;">No</th>
                                    <th class="text-center" style="vertical-align: middle;">Student</th>
                                    <th class="text-center" style="vertical-align: middle;">Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
									$no = 1;
									$index = 0;
									foreach($student as $row){
										$match = false;
										foreach($absen as $row2){
											if($row['student_id'] == $row2['student_id']){
												$match = true;
											}
										}
										if(!$match){
											echo "<tr>";
											echo "<td class='text-center'>".$no++."</td>";
											echo "<td>".$row['participant_name']."</td>";
											echo "<td nowrap>
														<input type='hidden' name='student_id[]' value='".$row['student_id']."'>
														<div class='pl-5 custom-control custom-radio custom-control-inline'>
												    		<input type='radio' class='custom-control-input' name='attend[".$index."]' value='1' id='attend".$row['student_id']."'>
												   			<label class='custom-control-label w-100' for='attend".$row['student_id']."'>Hadir</label>
														</div>
														<div class='pl-5 custom-control custom-radio custom-control-inline'>
												   			<input type='radio' class='custom-control-input' name='attend[".$index."]' value='0' id='absent".$row['student_id']."'>
												   			<label class='custom-control-label w-100' for='absent".$row['student_id']."'>Tidak Hadir</label>
												   		</div>
													</td>";
											echo "</tr>";
											$index++;
										}
									}
								?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn unique-color"">Submit</button>
					<button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="modal fade" tabindex="-1" id="modal_rekap" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('rc/absensi/submit_rekap')?>" method="post" id="form_data"
                class="form-horizontal" style="width:100%">
                <div class="modal-header" style="background-color:#e91e63;color:#fff">
                    <h4 class="modal-title" id="myModalLabel">Summary Absen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="trainer_class_id" value="<?= $trainer_class?>">
                    <input type="hidden" name="url" value="">
                    <input type="hidden" name="recap_id" id="recap_id"
                        value="<?= (!empty($rekap['recap_id'])) ? $rekap['recap_id'] : '' ?>">
                    <input type="hidden" name="periode_detail_id" id="periode_detail_id"
                        value="<?= $rekap['periode_detail_id']?>">
                    <input type="hidden" name="branch_id" id="branch_id" value="<?= $rekap['branch_id']?>">
                    <input type="hidden" name="program_id" id="program_id" value="<?= $rekap['program_id']?>">
                    <input type="hidden" name="class_id" id="class_id" value="<?= $rekap['class_id']?>">
                    <input type="hidden" name="session" id="session" value="<?= $rekap['session']?>">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-6">Bonus*</label>
                        <div class="col-sm-6">
                            <input name="bonus_class" id="bonus_class" class="form-control numeric" required=""
                                type="text" placeholder="" autocomplete="off"
                                value="<?= (!empty($rekap['bonus_class'])) ? $rekap['bonus_class'] : '0' ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-6">From Other Class</label>
                        <div class="col-sm-6">
                            <input name="other_class" id="other_class" class="form-control numeric" required=""
                                type="text" placeholder="" autocomplete="off"
                                value="<?= (!empty($other)) ? $other : '0' ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-6">Attendance</label>
                        <div class="col-sm-6">
                            <input name="attendance" id="attendance" class="form-control numeric" required=""
                                type="text" placeholder="" autocomplete="off"
                                value="<?= (!empty($attendance)) ? $attendance : '0' ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-6">Total Attendance</label>
                        <div class="col-sm-6">
                            <input name="total_attendance" id="total_attendance" class="form-control numeric"
                                required="" type="text" placeholder="" autocomplete="off"
                                value="<?= (!empty($rekap['total_attendance'])) ? $rekap['total_attendance'] : '' ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-6">Additional Note</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="recap_notes"
                                id="recap_notes"><?= (!empty($rekap['recap_notes'])) ? $rekap['recap_notes'] : '' ?></textarea>
                        </div>
                    </div>
                    <small><i class="float-left text-muted">*Required</i></small>
                </div>

                <div class="modal-footer mt-2">
                    <button type="submit" class="btn pink"">Save</button>
					<button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_other" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('rc/absensi/submit_rekap')?>" method="post" id="form_data"
                class="form-horizontal" style="width:100%">
                <div class="modal-header" style="background-color:#33b5e5;color:#fff">
                    <h4 class="modal-title" id="myModalLabel">From Other Class</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <h4>Filter</h4>
                        <form method="get" action="<?= base_url('rc/student/manage?')?>">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Branch</label>
                                <div class="col-sm-8">
                                    <select class="form-control js-example-basic-single" name="branch" id="branch_other"
                                        required="">
                                        <option value="all">All</option>
                                        <?php 
											foreach($filter['branch'] as $row) {
												echo "<option value='".$row['branch_id']."'>".ucfirst($row['branch_name'])."</option>";
											} 
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Class</label>
                                <div class="col-sm-8">
                                    <select class="form-control js-example-basic-single" name="class" id="class_other"
                                        required="">
                                        <option value="all">All</option>
                                        <?php 
											foreach($filter['class'] as $row) {
												echo "<option value='".$row['class_id']."'>".ucfirst($row['class_name'])."</option>";
											} 
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <button type="button" class="btn btn-info" id="btn-search-other">Search</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="table-responsive">
                            <table class="table" id="table_other">
                                <thead>
                                    <tr style="background-color: #0d4e6c ;font-size:0.9rem;color:#fff;">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Program</th>
                                        <th>Class</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer mt-2">
                    <button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<script type="text/javascript" src="<?= base_url();?>inc/jquery-ui/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip()

    $(document).ajaxStart(function() {
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function() {
        $("#wait").css("display", "none");
    });

    $('#table1').DataTable({
        'scrollX': true,
        'lengthMenu': [
            [10, 15, 25, -1],
            [10, 15, 25, "All"]
        ],
         'rowReorder': {
                'selector': 'td:nth-child(2)'
            },
            'responsive': true,
            'stateSave': true
    });

    $('#table22').DataTable({
        'lengthMenu': [
            [10, 15, 25, -1],
            [10, 15, 25, "All"]
        ]
    });

    total_attendance();

    $('#bonus_class, #other_class').on('keyup', function() {
        total_attendance();
    });

});

function reload_page() {
    window.location.reload();
}

function total_attendance() {
    var attendance = $('#attendance').val();
    var other = $('#other_class').val();
    var bonus = $('#bonus_class').val();
    var total = parseInt(attendance) + parseInt(other) + parseInt(bonus);
    $('#total_attendance').val(total);
}

function remove(id) {
    $.ajax({
        url: "<?= base_url('rc/absensi/json_remove_absen')?>",
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

function add_to_class(student) {
    if (student != '') {
        swal({
            title: 'Konfirmasi',
            text: "Data peserta akan dimasukkan ke dalam absen kelas ini, lanjutkan?",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }, function(result) {
            if (result) {
                $.ajax({
                    url: "<?= base_url('rc/absensi/json_get_detail_student')?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'id': student,
                    },
                    success: function(response) {
                        $.ajax({
                            url: "<?= base_url('rc/absensi/add_to_class')?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                'student_id': response.student_id,
                                'periode_detail_id': <?= $periode['periode_detail_id']?>,
                                'branch_id': response.branch_id,
                                'program_id': response.program_id,
                                'class_id': response.class_id,
                                'session': <?= $sesi?>,
                                'branch_id_change': <?= $class['branch_id']?>,
                                'class_id_change': <?= $class['class_id']?>
                            },
                            success: function(result) {
                                reload_page();
                            },
                            error: function(e) {
                                console.log(e);
                            }
                        })
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

$('#showtambah').click(function() {
    $('#modal_tambah').modal('show');
});

$('#showrekap').click(function() {
    $('#modal_rekap').modal('show');
});
$('#showother').click(function() {
    $('#form_other').trigger('reset');
    $('#modal_other').modal('show');
});

$('#btn-search-other').click(function() {
    $.ajax({
        url: "<?= base_url('rc/absensi/json_get_other_class')?>",
        type: "POST",
        dataType: "json",
        data: {
            'branch_id': $('#branch_other').val(),
            'program_id': <?= $class['program_id']?>,
            'class_id': $('#class_other').val(),
            'periode_start_date': "<?= $periode['periode_start_date']?>",
            'periode_end_date': "<?= $periode['periode_end_date']?>",
            'is_adult_class': <?= $class['is_adult_class']?>
        },
        success: function(result) {
            $('#table_other').DataTable().destroy();
            $('#table_other').find('tbody').empty();
            var no = 1;
            $.each(result, function(index, element) {
                if (element.class_id == <?= $class['class_id']?> && element.branch_id ==
                    <?= $class['branch_id']?> && element.program_id ==
                    <?= $class['program_id']?>) {

                } else {
                    $('#table_other').find('tbody').append('<tr>\
					<td class="text-center">' + no + '</td>\
					<td>' + element.participant_name + '</td>\
					<td>' + element.branch_name + '</td>\
					<td>' + element.program + '</td>\
					<td nowrap>' + element.class_name + '</td>\
					<td><button type="button" class="btn btn-primary" onclick="add_to_class(' + element.student_id + ')" title="Add to this class?" data-toggle="tooltip" data-placement="top"><i class="fa fa-plus"></i></button></td>\
					</tr>\
					');
                    no += 1;
                }
            });
            $('#table_other').DataTable({
                'destroy': true,
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });
        },
        error: function(e) {
            console.log(e);
        }
    })
});
</script>