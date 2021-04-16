<style type="text/css">
.border-left-div {
    border-left: 2px solid #333;
}
</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />

<div class="row mb-3">
    <div class="col-md-12">
        <ul class="list-group inline" id="list-tab" role="tablist" style="flex-direction:row;list-style-type:none;">
            <li>
                <a class="list-group-item list-group-item-action <?= ($tab == 'regular')? 'active':'' ?>" href="<?= base_url('rc/student/manage')?>" role="tab" aria-controls="data">Regular Class</a>
            </li>
            <li>
                <a class="list-group-item list-group-item-action <?= ($tab == 'adult')? 'active':'' ?>" href="<?= base_url('rc/student/manage_adult')?>" role="tab" aria-controls="kode">Adult Class</a>
            </li>
        </ul>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Student | <small>Adult</small></h3></h3>
    </div>
    <div class="card-body">
        <h4>Filter Data</h4>
        <form method="get" action="<?= base_url('rc/student/manage_adult?')?>">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Branch</label>
                <div class="col-sm-8">
                    <select class="form-control js-example-basic-single" name="branch" id="branch" required="">
                        <option value="all">All</option>
                        <?php 
						foreach($list_branch as $row) {
							if(strtolower($row['branch_id']) == strtolower($this->input->get('branch'))){
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
                <label class="col-sm-4 col-form-label">Periode</label>
                <div class="col-sm-8">
                    <select class="form-control js-example-basic-single" name="periode" id="periode" required="">
                        <option value="all">All</option>
                        <?php 
						foreach($periode as $row) {
							if(strtolower($row['periode_id']) == strtolower($this->input->get('periode'))){
								echo "<option value='".$row['periode_id']."' selected>".ucfirst($row['periode_name'])."</option>";
							}else{
								echo "<option value='".$row['periode_id']."'>".ucfirst($row['periode_name'])."</option>";
							}
						} 
						?>

                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Program</label>
                <div class="col-sm-8">
                    <select class="form-control js-example-basic-single" name="school" id="school">
                        <option value="all">All</option>
                        <?php 
						foreach($school as $row) {
							if(strtolower($row['id']) == strtolower($this->input->get('school'))){
								echo "<option value='".$row['id']."' selected>".ucfirst($row['name'])."</option>";
							}else{
								echo "<option value='".$row['id']."'>".ucfirst($row['name'])."</option>";
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
							if(strtolower($row['class_id']) == strtolower($this->input->get('class'))){
								echo "<option value='".$row['class_id']."' selected>".ucfirst($row['class_name'])."</option>";
							}else{
								echo "<option value='".$row['class_id']."'>".ucfirst($row['class_name'])."</option>";
							}
						} 
						?>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select class="form-control js-example-basic-single" name="status">
                        <option value="all">All</option>
                        <?php 
						foreach($status as $row) {
							if($row == $this->input->get('status')){
								echo "<option value='".$row."' selected>".ucfirst($row)."</option>";
							}else{
								echo "<option value='".$row."'>".ucfirst($row)."</option>";
							}
						} 
						?>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Special</label>
                <div class="col-sm-8">
                    <select class="form-control js-example-basic-single" name="special">
                        <?php 
						foreach($special as $row) {
							if($row == $this->input->get('special')){
								echo "<option value='".$row."' selected>".ucfirst($row)."</option>";
							}else{
								echo "<option value='".$row."'>".ucfirst($row)."</option>";
							}
						} 
						?>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label"></label>
                <div class="col-sm-8">
                    <button type="submit" class="btn primary-color-dark"><i class="fa fa-search"></i>&nbsp;
                        FILTER</button>
                    <?php if(!empty($_SERVER['QUERY_STRING'])){?>
                    <button type="button" class="btn btn-success" id="export"><i class="fa fa-file-excel"></i>&nbsp;
                        EXPORT</button>
                    <?php }?>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <?php if(!empty($list)){?>
            <table class="table table-bordered w-100" id="table1">
                <thead class="text-center">
                    <tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
                        <th class="text-center" style="vertical-align: middle;">No</th>
                        <th style="vertical-align: middle">Student</th>
                        <th style="vertical-align: middle">Age</th>
                        <th style="vertical-align: middle">Type</th>
                        <th style="vertical-align: middle">Start Date</th>
                        <th style="vertical-align: middle">End Date</th>
                        <th style="vertical-align: middle">Branch</th>
                        <th style="vertical-align: middle">School</th>
                        <th style="vertical-align: middle">Class</th>
                        <th style="vertical-align: middle">Status</th>
                        <th style="vertical-align: middle">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php 
						$no = 1;
						foreach($list as $row){
							echo "<tr>";
							echo "<td class='text-center'>".$no++."</td>";
							echo "<td><b>".$row['participant_name']."</b></td>";
							echo "<td class='text-center'><b>".$row['age']."</b></td>";
							echo "<td>".ucwords($row['program_type'])."</td>";
							echo "<td nowrap>".$row['start_date']."</td>";
							echo "<td nowrap>".$row['end_date']."</td>";
							echo "<td>".$row['branch_name']."</td>";
							echo "<td>".$row['program']."</td>";
							echo "<td>".$row['class_name']."</td>";
							echo "<td>";
							if($row['status'] == 'Active'){
								echo "<label class='badge badge-success'>".ucfirst($row['status'])."</label>";
							}else if($row['status'] == 'Dropout'){
								echo "<label class='badge badge-danger'>".ucfirst($row['status'])."</label>";
							}else if($row['status'] == 'Need to upgrade'){
								echo "<label class='badge orange'>".ucfirst($row['status'])."</label>";
							}else if($row['status'] == 'Graduate soon'){
								echo "<label class='badge unique-color'>".ucfirst($row['status'])."</label>";
							}else{
								echo "<label class='badge unique-color-dark'>".ucfirst($row['status'])."</label>";
							}

							if($row['upgrade_to_newmodul'] == 1){
								echo "<br><label class='badge badge-dark'>New Modul</label>";
							}
							echo "</td>";
							echo "<td class='text-center' nowrap>
							<a class='btn btn-info' onclick='edit(".$row['student_id'].")' title='Edit' data-toggle='tooltip' data-placement='top'><i class='fa fa-edit'></i></a>&nbsp;
							<a class='btn btn-primary' onclick='history_trx(".$row['student_id'].")' title='Riwayat Transaksi' data-toggle='tooltip' data-placement='top'><i class='fa fa-history'></i></a>&nbsp;";
							if($row['status'] == 'Need to upgrade' || $row['status'] == 'Dropout'){
								echo "&nbsp;<a class='btn pink' onclick='upgrade(".$row['student_id'].")' title='Upgrade/ Modul baru' data-toggle='tooltip' data-placement='top'><i class='fa fa-cart-plus'></i></a>&nbsp;";
							}
							if($this->input->get('periode') != 'all'){
								echo "<a class='btn btn-warning' onclick='change(".$row['student_id'].")' title='Pindahkan Student' data-toggle='tooltip' data-placement='top'><i class='fa fa-sync'></i></a>
							";
							}
                            echo "<a class='btn btn-danger' onclick='delete_student(".$row['student_id'].")' title='Hapus Data Student' data-toggle='tooltip' data-placement='top'><i class='fa fa-trash'></i></a>&nbsp;";

							echo "</td></tr>";

						}
						?>
                </tbody>
            </table>
            <?php }else{
				echo "<div class='col-md-12 text-center'><hr><label class='text-red'>Not found</label></div>";
			}?>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_history" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">List Transaction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-stripped table-bordered" id="table_history">
                        <thead>
                            <tr style="background-color:#343a40;color:#fff">
                                <th style="vertical-align: middle;">No</th>
                                <th style="vertical-align: middle;">Participant</th>
                                <th style="vertical-align: middle;">Program</th>
                                <th style="vertical-align: middle;">Type</th>
                                <th style="vertical-align: middle;">Paid Value</th>
                                <th style="vertical-align: middle;">Paid Date</th>
                                <th style="vertical-align: middle;">Sales</th>
                                <th style="vertical-align: middle;">Remark</th>
                                <th style="vertical-align: middle;">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_detail" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('rc/student/submit_edit_form')?>" method="post" id="form_edit">
                <div class="modal-header" style="color:#fff;background-color: #33b5e5;">
                    <h4 class="modal-title" id="myModalLabel">FORM DATA STUDENT</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="participant_id" id="participant_id" value="">
                    <input type="hidden" name="student_id" id="student_id" value="">
                    <input type="hidden" name="redirect" id="redirect" value="<?= $_SERVER['QUERY_STRING'];?>">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Nama</label>
                        <div class="col-sm-8">
                            <input id="participant_name" name="participant_name" class="form-control" type="text"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Jenis Kelamin</label>
                        <div class="col-sm-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" name="gender" id="edit_inlineRadio1"
                                    value="L" required="">
                                <label class="custom-control-label" for="edit_inlineRadio1">Laki-laki</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" name="gender" id="edit_inlineRadio2"
                                    value="P" required="">
                                <label class="custom-control-label" for="edit_inlineRadio2">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Kontak</label>
                        <div class="col-sm-8">
                            <input id="phone" name="phone" class="form-control" type="text" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Email</label>
                        <div class="col-sm-8">
                            <input id="email" name="email" class="form-control" type="email" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Tgl Lahir</label>
                        <div class="col-sm-8">
                            <input name="birthdate" id="birthdate" class="form-control" type="text"
                                placeholder="Format: yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <h5 class="text-center w-100">DATA AYAH</h5>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Kontak</label>
                                <div class="col-sm-8">
                                    <input name="dad_phone" id="dad_phone" class="form-control numeric" type="text"
                                        placeholder="" autocomplete="off">
                                    <input name="dad_id" id="dad_id" class="dad" type="hidden">
                                </div>
                            </div>
                            <div class="form-group row dad">
                                <label class="col-form-label col-sm-4">Nama</label>
                                <div class="col-sm-8">
                                    <input name="dad_name" id="dad_name" class="form-control" type="text" placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row dad">
                                <label class="col-form-label col-sm-4">Email</label>
                                <div class="col-sm-8">
                                    <input name="dad_email" id="dad_email" class="form-control" type="email"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row dad">
                                <label class="col-form-label col-sm-4">Pekerjaan</label>
                                <div class="col-sm-8">
                                    <input name="dad_job" id="dad_job" class="form-control" type="text" placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12 text-right px-0">
                                <label class="blockquote-footer badge-light px-3" id="dad_message"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <h5 class="text-center w-100">DATA IBU</h5>
                            </div>
                            <div class="form-group row border-left-div">
                                <label class="col-form-label col-sm-4">Kontak</label>
                                <div class="col-sm-8">
                                    <input name="mom_phone" id="mom_phone" class="form-control numeric" type="text"
                                        placeholder="" autocomplete="off">
                                    <input name="mom_id" id="mom_id" type="hidden">
                                </div>
                            </div>
                            <div class="form-group row border-left-div mom">
                                <label class="col-form-label col-sm-4">Nama</label>
                                <div class="col-sm-8">
                                    <input name="mom_name" id="mom_name" class="form-control" type="text" placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row border-left-div mom">
                                <label class="col-form-label col-sm-4">Email</label>
                                <div class="col-sm-8">
                                    <input name="mom_email" id="mom_email" class="form-control" type="email"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row border-left-div mom">
                                <label class="col-form-label col-sm-4">Pekerjaan</label>
                                <div class="col-sm-8">
                                    <input name="mom_job" id="mom_job" class="form-control" type="text" placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12 text-right px-0">
                                <label class="blockquote-footer badge-light px-3" id="mom_message"></label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Cabang</label>
                        <div class="col-sm-8">
                            <input id="branch_name" name="branch_name" class="form-control" type="text"
                                autocomplete="off" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Program</label>
                        <div class="col-sm-8">
                            <input id="program" name="program" class="form-control" type="text" autocomplete="off"
                                readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Kelas</label>
                        <div class="col-sm-8">
                            <input id="class_name" name="class_name" class="form-control" type="text" autocomplete="off"
                                readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tipe Program</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="program_type" id="program_type" required="">
                                <option value="">- Pilih Tipe -</option>
                                <?php 
								foreach($type as $row) {
									echo "<option value='".$row."'>".ucfirst($row)."</option>";
								} 
								?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Tanggal Mulai</label>
                        <div class="col-sm-8">
                            <input name="start_date" id="start_date" class="form-control datepicker" type="text"
                                placeholder="Format: yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Tanggal Berakhir</label>
                        <div class="col-sm-8">
                            <input name="end_date" id="end_date" class="form-control datepicker" type="text"
                                placeholder="Format: yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Khusus</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="special_status" id="special_status" required="">
                                <?php 
								foreach($special as $row) {
									echo "<option value='".$row."'>".ucfirst($row)."</option>";
								} 
								?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Catatan Khusus</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="special_note" name="special_note">

							</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-info"">Update</button>
					<button type=" button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_branch" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('rc/student/change_student')?>" method="post" id="form_data"
                class="form-horizontal" style="width:100%">
                <div class="modal-header" style="background-color:#0d4e6c;color:#fff">
                    <h4 class="modal-title" id="modal-title">Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ch_redirect" id="ch_redirect" value="">
                    <input type="hidden" name="ch_student_id" id="ch_student_id" value="">
                    <input type="hidden" name="ch_periode_id" id="ch_periode_id" value="">
                    <input type="hidden" name="ch_branch_from" id="ch_branch_from" value="">
                    <input type="hidden" name="ch_program_from" id="ch_program_from" value="">
                    <input type="hidden" name="ch_class_from" id="ch_class_from" value="">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Student</label>
                        <div class="col-sm-8">
                            <input name="ch_student_name" id="ch_student_name" class="form-control" type="text"
                                readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control js-example-basic-single" name="ch_branch_to" id="ch_branch_to"
                                required="">
                                <option value="">- Pilih Cabang -</option>
                                <?php 
								foreach($list_branch as $row) {
									echo "<option value='".$row['branch_id']."'>".ucfirst($row['branch_name'])."</option>";
								} 
								?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">School</label>
                        <div class="col-sm-8">
                            <select class="form-control js-example-basic-single" name="ch_program_to" id="ch_program_to"
                                required="">
                                <option value="">- Pilih Program -</option>
                                <?php 
								foreach($school as $row) {
									echo "<option value='".$row['id']."'>".ucfirst($row['name'])."</option>";
								} 
								?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Class</label>
                        <div class="col-sm-8">
                            <select class="form-control js-example-basic-single" name="ch_class_to" id="ch_class_to"
                                required="">
                                <option value="">- Pilih Kelas -</option>
                                <?php 
								foreach($class as $row) {
									echo "<option value='".$row['class_id']."'>".ucfirst($row['class_name'])."</option>";
								} 
								?>

                            </select>
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

<div class="modal fade" tabindex="-1" id="modal_upgrade" data-backdrop="static" data-keyboard="false"
    style="overflow-y: auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('rc/student/submit_upgrade_student')?>" method="post" id="form_upgrade"
                style="padding-left:15px;padding-right: 15px;">
                <div class="modal-header" style="background-color:#ec407a ;color:#fff">
                    <h4 class="modal-title" id="header">FORM UPGRADE / MODUL BARU</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <input type="hidden" name="student_id" id="up_student_id" value="">
                        <input type="hidden" name="url" value="<?= $_SERVER['QUERY_STRING']?>">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Name</label>
                                <div class="col-sm-8">
                                    <input name="participant_name" id="up_participant_name" class="form-control"
                                        required="" type="text" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Program Name</label>
                                <div class="col-sm-8">
                                    <input name="program" id="up_program" class="form-control" type="text" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Branch</label>
                                <div class="col-sm-8">
                                    <input name="branch" id="up_branch" class="form-control" type="text" readonly="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Class</label>
                                <div class="col-sm-8">
                                    <input name="class" id="up_class" class="form-control" type="text" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">From</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="signup_type" id="signup_type" required="">
                                        <option value="">- Choose an option -</option>
                                        <?php 
										foreach($list_signup_type as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Upgrade/ Modul</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="closing_type" id="closing_type" required="">
                                        <option value="">- Choose an option -</option>
                                        <?php 
										foreach($list_closing_class as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row modul">
                                <label class="col-form-label col-sm-4">Total Modul</label>
                                <div class="col-sm-8">
                                    <input name="modul_class" id="modul_class" class="form-control numeric"
                                        type="number" min="1" placeholder="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row modul">
                                <label class="col-form-label col-sm-4">Start Date</label>
                                <div class="col-sm-8">
                                    <input name="full_program_startdate" id="full_program_startdate"
                                        class="form-control datepicker" type="text" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">End Date</label>
                                <div class="col-sm-8">
                                    <input name="full_program_enddate" id="full_program_enddate"
                                        class="form-control datepicker" type="text" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Payment Type</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="payment_type" id="payment_type" required="">
                                        <option value="">- Choose an option -</option>
                                        <?php 
										foreach($list_payment_type as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="atas_nama_div">
                                <label class="col-form-label col-sm-4">Atas Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="atas_nama" id="atas_nama"
                                        placeholder="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Amount Paid</label>
                                <div class="col-sm-8">
                                    <input name="paid_value" id="paid_value" class="form-control numeric" required=""
                                        type="text" placeholder="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Paid Date</label>
                                <div class="col-sm-8">
                                    <input name="paid_date" id="paid_date" class="form-control datepicker" required=""
                                        type="text" placeholder="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Sales</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="id_user_closing" id="id_user_closing"
                                        required="">
                                        <option value="">- Choose a Warrior -</option>
                                        <?php 
										foreach($list_warrior as $row){
											echo "<option value='".$row['id']."'>".ucfirst($row['username'])."</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Source</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="source" id="source" required="">
                                        <option value="">- Choose an option -</option>
                                        <?php 
										foreach($list_source as $row){
											echo "<option value='".$row."'>".ucfirst($row)."</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-4">Notes</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="remark" id="remark" placeholder=""
                                        autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submit_upgrade">Submit</button>
                    <button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
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

    $("#birthdate").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: '1930:' + new Date().getFullYear()
    });

    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
    });

    $('#dad_phone').on('change', function() {
        is_dad_phone_exist();
    });

    $('#mom_phone').on('change', function() {
        is_mom_phone_exist();
    });

    $('#closing_type').on('change', function() {
        closing_type();
    });

    $('#payment_type').on('change', function() {
        payment_type();
    });

    closing_type();
    payment_type();
});

function reload_page() {
    window.location.reload();
}

function closing_type() {
    var closing_type = $('#closing_type').val();
    if (closing_type == 'Full Program') {
        $('.full_program').show(500);
        $('.modul').hide(500);
    } else if (closing_type == 'Modul') {
        $('.modul').show(500);
        $('.full_program').hide(500);
    } else {
        $('.modul, .full_program').hide(500);
    }
}

function payment_type() {
    var payment_type = $('#payment_type').val();
    if (payment_type == 'Transfer') {
        $('#atas_nama_div').show(500);
    } else {
        $('#atas_nama_div').hide(500);
    }
}

function edit(id) {
    $('#form_edit').trigger("reset");
    $('#mom_message, #dad_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
    $('#modal_detail').modal('show');
    $.ajax({
        url: "<?= base_url('rc/student/json_get_data_participant_by_id')?>",
        type: "POST",
        dataType: "json",
        data: {
            'id': id
        },
        success: function(result) {
            $('#participant_id').val(result.participant_id);
            $('#student_id').val(result.student_id);
            $('#participant_name').val(result.participant_name);
            $('[name=gender][value="' + result.gender + '"]').prop('checked', true);
            $('#phone').val(result.phone);
            $('#email').val(result.email);
            $('#birthdate').val(result.birthdate);
            $('#dad_id').val(result.dad_id);
            $('#dad_name').val(result.dad_name);
            $('#dad_phone').val(result.dad_phone);
            $('#dad_email').val(result.dad_email);
            $('#dad_job').val(result.dad_job);
            $('#mom_id').val(result.mom_id);
            $('#mom_name').val(result.mom_name);
            $('#mom_phone').val(result.mom_phone);
            $('#mom_email').val(result.mom_email);
            $('#mom_job').val(result.mom_job);
            $('#participant_name').val(result.participant_name);
            $('#branch_name').val(result.branch_name);
            $('#program').val(result.program);
            $('#class_name').val(result.class_name);
            $('#program_type').val(result.program_type).change();
            $('#start_date').val(result.start_date);
            $('#end_date').val(result.end_date);
            $('#special_status').val(result.special_status).change();
            $('#special_note').val(result.special_note);
            $('#modal_detail').modal('show');
        },
        error: function(e) {
            console.log(e);
        }
    })
}

function history_trx(id) {
    $.ajax({
        url: "<?= base_url('rc/student/json_get_history_trx')?>",
        type: "POST",
        dataType: "json",
        data: {
            'id': id
        },
        success: function(result) {
            $('#table_history').DataTable().destroy();
            $('#table_history').find('tbody').empty();
            var no = 1;
            $.each(result, function(index, element) {
                if (element.is_paid_off == 1) {
                    var status = '<td><label class="badge badge-success">Approved</label></td>';
                } else {
                    var status = '<td><label class="badge blue-grey">Waiting</label></td>';
                }
                $('#table_history').find('tbody').append('<tr>\
						<td class="text-center">' + no + '</td>\
						<td>' + element.participant_name + '</td>\
						<td>' + element.event_name + '</td>\
						<td>' + element.closing_type + '</td>\
						<td>' + parseInt(element.paid_value).toLocaleString() + '</td>\
						<td nowrap>' + element.paid_date + '</td>\
						<td>' + element.sales + '</td>\
						<td>' + element.remark + '</td>' + status + '\
						</tr>\
						');
                no += 1;
            });

            // $('#table_history').DataTable({
            // 	'destroy' :true,
            // 	'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]]
            // });
            $('#modal_history').modal('show');
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

$('#export').click(function() {
    var query = "<?= $_SERVER['QUERY_STRING']?>";
    var url = "<?= base_url('rc/student/export_data_student_adult?')?>" + query;
    window.open(url, '_blank');
});

function is_dad_phone_exist() {
    var phone = $('#dad_phone').val();
    if (phone != '') {
        $.ajax({
            url: "<?= base_url('user/signup/json_phone_exist')?>",
            type: "POST",
            dataType: "json",
            data: {
                'phone': phone
            },
            success: function(result) {
                if (!result) {
                    $('#dad_message').empty().removeClass().addClass('blockquote-footer badge-info px-3')
                        .html('New Data').show('slide', {
                            direction: 'up'
                        }, 500);
                    $('.dad :input').val('').prop('readonly', false);
                } else {
                    $('#dad_name').val(result.participant_name);
                    $('#dad_id').val(result.participant_id);
                    $('#dad_job').val(result.job);
                    $('#dad_email').val(result.email);
                    $('#dad_message').empty().removeClass().addClass('blockquote-footer badge-success px-3')
                        .html('Found').show('slide', {
                            direction: 'up'
                        }, 500);
                }
                $('.dad').show(500);
            },
            error: function(e) {
                console.log(e);
            }
        });
    } else {
        $('.dad').hide();
        $('.dad :input').val('').prop('readonly', false);
        $('#dad_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
    }
}


function is_mom_phone_exist() {
    var phone = $('#mom_phone').val();
    if (phone != '') {
        $.ajax({
            url: "<?= base_url('user/signup/json_phone_exist')?>",
            type: "POST",
            dataType: "json",
            data: {
                'phone': phone
            },
            success: function(result) {
                if (!result) {
                    $('#mom_message').empty().removeClass().addClass('blockquote-footer badge-info px-3')
                        .html('New Data').show('slide', {
                            direction: 'up'
                        }, 500);
                    $('.mom :input').val('').prop('readonly', false);
                } else {
                    $('#mom_name').val(result.participant_name);
                    $('#mom_id').val(result.participant_id);
                    $('#mom_job').val(result.job);
                    $('#mom_email').val(result.email);
                    $('#mom_message').empty().removeClass().addClass('blockquote-footer badge-success px-3')
                        .html('Found').show('slide', {
                            direction: 'up'
                        }, 500);
                }
                $('.mom').show(500);
            },
            error: function(e) {
                console.log(e);
            }
        });
    } else {
        $('.mom').hide();
        $('.mom :input').val('').prop('readonly', false);
        $('#mom_message').empty().removeClass().addClass('blockquote-footer badge-light px-3');
    }
}

function change(id) {
    $('#form_data').trigger("reset");
    $.ajax({
        url: "<?= base_url('rc/student/json_get_detail_student')?>",
        type: "POST",
        dataType: "json",
        data: {
            'id': id
        },
        success: function(result) {
            $('#ch_student_id').val(id);
            $('#ch_redirect').val("<?= $_SERVER['QUERY_STRING']?>");
            $('#ch_periode_id').val($('#periode').val());
            $('#ch_student_name').val(result.participant_name);
            $('#ch_branch_from').val(result.branch_id);
            $('#ch_program_from').val(result.program_id);
            $('#ch_class_from').val(result.class_id);
            $('#ch_branch_to').val(result.branch_id).change();
            $('#ch_program_to').val(result.program_id).change();
            $('#ch_class_to').val(result.class_id).change();
            $('#modal_branch').modal('show');
        },
        error: function(e) {
            console.log(e);
        }
    })
}

function upgrade(id) {
    $('#form_upgrade').trigger("reset");
    $.ajax({
        url: "<?= base_url('rc/student/json_get_detail_student_upgrade')?>",
        type: "POST",
        dataType: "json",
        data: {
            'id': id
        },
        success: function(result) {
            console.log(result);
            $('#up_student_id').val(result.student_id);
            $('#up_participant_name').val(result.participant_name);
            $('#up_program').val(result.program);
            $('#up_branch').val(result.branch_name);
            $('#up_class').val(result.class_name);
            $('#modal_upgrade').modal('show');
        },
        error: function(e) {
            console.log(e);
        }
    })
}

function delete_student(id) {
    if (id != '') {
        swal({
            title: 'Konfirmasi',
            text: "Semua data yang berkaitan akan dihapus, lanjutkan?",
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ff3547',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }, function(result) {
            if (result) {
                $.ajax({
                    url: "<?= base_url('rc/student/delete_student')?>",
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
</script>