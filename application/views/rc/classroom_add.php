<style type="text/css">
.border-left-div {
    border-left: 2px solid #333;
}
</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add classroom</h3>
    </div>
    <div class="card-body">
        <a class="btn btn-dark" id="add_classroom"><i class="fa fa-plus"></i>&nbsp; Add classroom</a>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
                        <th class="text-center" style="vertical-align: middle;">No</th>
                        <th style="vertical-align: middle">Class Name</th>
                        <th style="vertical-align: middle">Description</th>
                        <th style="vertical-align: middle">Is Adult Class</th>
                        <th style="vertical-align: middle">Status</th>
                        <th style="vertical-align: middle;min-width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php 
					$no = 1;
					foreach($classroom as $row){
						echo "<tr>";
						echo "<td class='text-center'>".$no++."</td>";
						echo "<td><b>".$row['class_name']."</b></td>";
						echo "<td>".$row['class_desc']."</td>";
						
						if($row['is_adult_class'] == 1){
							echo "<td><label class='badge badge-primary'>Yes</label></td>";
						}else{
							echo "<td></td>";
						}

						if($row['class_status'] == 1){
							echo "<td><label class='badge badge-success'>Aktif</label></td>";
						}else{
							echo "<td><label class='badge badge-light'>Nonaktif</label></td>"; 
						}
				
						echo "<td nowrap><a class='btn btn-info' onclick='edit(".$row['class_id'].")' title='Edit Data' data-toggle='tooltip' data-placement='top'><i class='fa fa-edit'></i></a>&nbsp;";
						if($row['class_status'] == 1){
							echo "<a onclick='nonaktif(".$row['class_id'].")' class='btn btn-danger' title='Nonaktifkan kelas?' data-toggle='tooltip' data-placement='top'><i class='fa fa-ban'></i></a>";
						}else{
							echo "<a onclick='aktif(".$row['class_id'].")' class='btn btn-success' title='Aktifkan kelas?' data-toggle='tooltip' data-placement='top'><i class='fa fa-check'></i></a>";
						}
						
						echo "</td></tr>";

					}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_classroom" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('rc/classroom/submit_form')?>" method="post" id="form_data"
                class="form-horizontal" style="width:100%">
                <div class="modal-header" style="background-color:#0d4e6c;color:#fff">
                    <h4 class="modal-title" id="modal-title">Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="class_id" id="class_id" value="">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Class Name</label>
                        <div class="col-sm-8">
                            <input name="class_name" id="class_name" class="form-control" required="" type="text"
                                placeholder="" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Description</label>
                        <div class="col-sm-8">
                            <input name="class_desc" id="class_desc" class="form-control" type="text" placeholder=""
                                autocomplete="off">
                        </div>
                    </div>
					<div class="form-group row">
                        <label class="col-form-label col-sm-4"></label>
						<div class="col-sm-8">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="is_adult_class" name="is_adult_class">
								<label class="custom-control-label" for="is_adult_class">Adult Class</label>
							</div>
						</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"">Submit</button>
					<button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>


<script type="text/javascript" src="<?= base_url();?>inc/jquery-ui/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    $(document).ajaxStart(function() {
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function() {
        $("#wait").css("display", "none");
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('#table1').DataTable({
        'scrollX': true,
        'lengthMenu': [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        'rowReorder': {
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
    });
});

function reload_page() {
    window.location.reload();
}

function nonaktif(id) {
    if (id != '') {
        swal({
            title: 'Konfirmasi',
            text: "Nonaktifkan kelas, lanjutkan?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f35958',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }, function(result) {
            if (result) {
                $.ajax({
                    url: "<?= base_url('rc/classroom/nonaktif')?>",
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

function aktif(id) {
    if (id != '') {
        swal({
            title: 'Konfirmasi',
            text: "Aktifkan kelas, lanjutkan?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f35958',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }, function(result) {
            if (result) {
                $.ajax({
                    url: "<?= base_url('rc/classroom/aktif')?>",
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

function edit(id) {
    $('#form_data').trigger("reset");
    $.ajax({
        url: "<?= base_url('rc/classroom/json_get_detail_classroom')?>",
        type: "POST",
        dataType: "json",
        data: {
            'id': id
        },
        success: function(result) {
            $('#modal-title').html('FORM EDIT');
            $('#class_id').val(result.class_id);
            $('#class_name').val(result.class_name);
            $('#class_desc').val(result.class_desc);
			if(result.is_adult_class == 1){
				$('#is_adult_class').prop('checked', true);
			}else{
				$('#is_adult_class').prop('checked', false);
			}
            $('#modal_classroom').modal('show');
        },
        error: function(e) {
            console.log(e);
        }
    })
}

$('.numeric').keyup(function(e) {
    if (/\D/g.test(this.value)) {
        this.value = this.value.replace(/\D/g, '');
    }
});

$('#add_classroom').click(function() {
    $('#form_data').trigger('reset');
    $('#modal-title').html('FORM ADD');
    $('#modal_classroom').modal('show');
});
</script>