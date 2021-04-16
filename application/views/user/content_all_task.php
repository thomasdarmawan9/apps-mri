
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="background:url(/assets/image/event.jpg);color:white;background-size:100%;">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<br>
				<i class="fa fa-calendar fa-7x"></i>
				<h4 id="orderDetails" class="semi-bold" style="color:white;"></h4>
				<div class="slide-primary">
					<input checked="checked" class="ios" name="switch"  type="checkbox" id="my-checkbox" onchange="ChangeCheckboxLabel(this)" ><br>
					<span id="my-checkbox-checked" style="display:inline; font-style:italic;"><b>BERI</b> EVENT.</span>
					<span id="my-checkbox-unchecked" style="display:inline; font-style:italic;"><b>TUKAR</b> EVENT.</span>

				</div>
				<br>
			</div>
			<form name="userForm" id="userForm" action="display/event_digantikan" method="post">
				<div class="modal-body">
					<div class="row form-row">
						<div class="col-md-6 col-md-offset-3">
							<div id="beri">
								<div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									Info:&nbsp; <b>Beri Event</b> artinya kamu tidak perlu mengganti event yang ia miliki.
								</div>
							</div>
							<div id="tukar">
								<div class="alert alert-warning">
									<button class="close" data-dismiss="alert"></button>
									Info:&nbsp; <b>Tukar Event</b> artinya kamu kamu wajib untuk memilih salah satu event yang ia miliki.
								</div>
							</div>
							<div id="idevent"></div>
							<div id="idtask"></div>
							<select id="getname_task" name="getname" id="getname" class="form-control" style="padding:0;border:0px" required>
								<option value="">-Pilih Salah Satu-</option>
								<?php foreach($hasil as $gn){ ?>
								<?php if(($gn->username<>'admin')&&($gn->username<>$this->session->userdata('username'))){ ?>

								<option value="<?php echo $gn->username; ?>"><?php echo $gn->username; ?></option>
								<?php } ?>
								<?php } ?>
							</select>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button id="btn-checked" type="submit" class="btn btn-primary" >Terapkan</button>
					<button id="btn-unchecked" type="button" class="btn btn-primary" >Pilih Event</button>
				</div>
			</form> 
		</div>
	</div>
</div>


<div class="card">
	<div class="card-header">
		<h3 class="card-title">All Task Allocation</h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #0d4e6c;color:#fff;">
						<th>No</th>
						<th>Event</th>
						<th style="width:200px;">Lokasi</th>
						<th>Tanggal</th>
						<th>Tugas</th>
						<th style="text-align:center;">Closing DP | Lunas</th>
						<th>Aksi | Status</th>
						<th>Hadir</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php if(!empty($results)){ ?>
					<?php $no = 1; ?>
					<?php foreach($results as $r){ ?>
					<tr>
						<td style="vertical-align: middle;"><?php echo $no; ?></td>
						<td style="vertical-align: middle;"><b><?php echo $r->event; ?></b></td>
						<td style="vertical-align: middle;"><?php echo $r->location; ?></td>
						<td style="vertical-align: middle;">
							<label class="badge badge-light">
							<?php echo date('d-M-Y', strtotime($r->date)); ?>
							</label>
						</td>

						<?php if($r->id_pengganti == null){
							$pengganti= '<b>Saya Sendiri</b>';
							$disabled = '';
							$pgn = '<i class="fa fa-search"></i> Cari Pengganti';
						}elseif(($r->id_pengganti <> null) && ($r->persetujuan_pengganti == null)){
							$idp = $r->id_pengganti;
							$data['namapengganti'] = $this->model_task->get_username_penggantitask($idp);
							foreach ($data['namapengganti'] as $ganti){
								$pengganti = '<b>Menunggu Approve</b> - '.ucfirst($ganti->username).'';
							}

							$disabled = '';
							$pgn = '<i class="fa fa-search"></i> Cari Pengganti';
						}else{
							if($r->id_pengganti == $this->session->userdata('id')){
								$pengganti = '<b>Menggantikan</b> - '.ucfirst($r->username).'';
								$disabled = '';
								$pgn = '<i class="fa fa-search"></i> Cari Pengganti';
							}else{
								$idp = $r->id_pengganti;
								$data['namapengganti'] = $this->model_task->get_username_penggantitask($idp);
								foreach ($data['namapengganti'] as $ganti){
									$pengganti = '<b>Diganti oleh</b> - '.ucfirst($ganti->username).'';
								}
								$disabled = 'disabled';
								$pgn = 'Telah Digantikan';
							}
						}
						?>


						<?php if($r->tugas == null){
							$tugas = '<label data-toggle="popover" data-content="Menunggu Input PD" data-placement="top" data-trigger="hover" class="badge  badge-primary" data-original-title="" title=""> ? </label>';
						}elseif($r->tugas == 'pd'){
							$tugas = '<label data-toggle="popover" data-content="Berkewajiban untuk menentukan tugas dan membuat laporan hasil SP / Event" data-placement="top" data-trigger="hover" class="badge deep-orange" data-original-title="" title=""> PD </label>';
						}else{
							$tugas = '<label data-toggle="popover" data-content="" data-placement="top" data-trigger="hover" class="badge badge-info" style="cursor: auto;" data-original-title="" title="">'.$r->tugas.'</button>';
						}
						?>
						<td style="vertical-align: middle;"><?php echo $tugas; ?></td>
						<?php if($r->dp == null){
							$dp = '-';
						}else{
							$dp = $r->dp;
						}
						?>
						<?php if($r->lunas == null){
							$lunas = '-';
						}else{
							$lunas = $r->lunas;
						}
						?>
						<td style="text-align:center;">

							<?php if($disabled <> 'disabled'){ ?>
							<button type="button" class="btn  btn-info" style="cursor: auto;"> <?php echo $dp; ?> </button> 
							<button type="button" class="btn  btn-secondary" style="cursor: auto;"> <?php echo $lunas; ?> </button>
							<?php } ?>

						</td>



						<td style="vertical-align: middle;">
							<?php if($disabled <> 'disabled'){ ?>


							<?php }else{ ?> 

							<?php } ?>

							<?php if($r->id_pengganti<>null){ ?>

							<?php echo "<label class='badge teal'>".$pengganti."</label>"; ?>

							<?php }else{ ?>

							<?php echo "<label class='badge badge-light'>".$pengganti."</label>"; ?>

							<?php } ?>

						</td>
						<td>

							<?php if($r->hadir == null){ ?>
							<button type="button" class="btn btn-warning" style="cursor: auto;"><i class="fa fa-ellipsis-h"></i></button>
							<?php }elseif($r->hadir == 'ya'){ ?>
							<button type="button" class="btn btn-success" style="cursor: auto;"><span class="fa fa-check" aria-hidden="true"></span></button>
							<?php }else{ ?>

							<?php if($r->date < date("Y-m-d")){ ?>
							<button type="button" class="btn btn-danger" style="cursor: auto;"><span class="fa fa-times" aria-hidden="true"></span></button>
							<?php }else{ ?>
							<button type="button" class="btn btn-warning" style="cursor: auto;"><i class="fa fa-ellipsis-h"></i></button>
							<?php } ?>

							<?php } ?> 
						</td>
					</tr>
					<?php $no = $no + 1; ?>
					<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover(); 
		$('[data-toggle="tooltip"]').tooltip(); 
	});

	$('#table1').DataTable({
	    'scrollX':true,
	    'order':false,
	    'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]
	    ],
	    'rowReorder': {
			'selector': 'td:nth-child(2)'
		},
		'responsive': true,
		'stateSave': true
  	});

	$(function () {
		$('#myModal').modal({
			keyboard: true,
			backdrop: "static",
			show: false,

		}).on('show', function () {

		});

		$(".table-striped").find('button[data-id]').on('click', function () {
			debugger;

        //do all your operation populate the modal and open the modal now. DOnt need to use show event of modal again

        $('#orderDetails').html($('<b style="padding: 5px;background: #866e4c99;background: rgba(210, 180, 142, 0.55);">' + $(this).data('id') + ' | ' + $(this).data('tgl') + '</b>'));
        
        $('#idevent').html($('<input type="text" id="idevent" name="idevent" value="'+ $(this).data('idtask') +'"  style="display:none;" >'));

        $('#myModal').modal('show');
    });
	});

	function ChangeCheckboxLabel(ckbx){
		var d = ckbx.id;
		if( ckbx.checked )
		{
			document.getElementById(d+"-checked").style.display = "inline";
			document.getElementById("beri").style.display = "inline";
			document.getElementById("tukar").style.display = "none";
			document.getElementById("btn-checked").style.display = "inline";
			document.getElementById("btn-unchecked").style.display = "none";
			document.getElementById(d+"-unchecked").style.display = "none";
		}
		else
		{
			document.getElementById(d+"-checked").style.display = "none";
			document.getElementById("beri").style.display = "none";
			document.getElementById("tukar").style.display = "inline";
			document.getElementById("btn-checked").style.display = "none";
			document.getElementById("btn-unchecked").style.display = "inline";
			document.getElementById(d+"-unchecked").style.display = "inline";
		}
	}
</script>

<?php if($this->session->flashdata('msg')<>null ){ ?>
<?php if($this->session->flashdata('msg') == 'success'){ ?>
<script>
	function modal(){
		swal("Berhasil Ditambahkan", "Event ditambahkan di List", "success");
	};
	window.onload = modal;
</script>
<?php }else{ ?>
<script>
	function modal(){
		swal("Gagal ditambahkan", "", "error");
	};
	window.onload = modal;
</script>
<?php } ?>
<?php } ?>

<?php if($this->session->flashdata('gantiinfo')<>null ){ ?>
<?php if($this->session->flashdata('gantiinfo') == 'success'){ ?>
<script>
	function modal(){
		swal("Berhasil meminta Request", "Event telah berhasil di request", "success");
	};
	window.onload = modal;
</script>
<?php } ?>

<?php } ?>

<?php if($this->session->flashdata('gantiinfoy')<>null ){ ?>
<?php if($this->session->flashdata('gantiinfoy') == 'errors'){ ?>
<script>
	function modal(){
		swal("User sudah terdapat di Event Ini.", "Request gagal diproses", "error");
	};
	window.onload = modal;
</script>
<?php } ?>

<?php } ?>
<?php if($this->session->flashdata('gantiinfox')<>null ){ ?>
<?php if($this->session->flashdata('gantiinfox') == 'errors'){ ?>
<script>
	function modal(){
		swal("User sudah menggantikan orang lain / di Request orang lain.", "Pinta untuk user agar tolak request", "error");
	};
	window.onload = modal;
</script>
<?php } ?>

<?php } ?>

<?php if($this->session->flashdata('batalganti')<>null ){ ?>
<?php if($this->session->flashdata('batalganti') == 'success'){ ?>
<script>
	function modal(){
		swal("Pertukaran dibatalkan", "Berhasil dibatalkan", "success");
	};
	window.onload = modal;
</script>
<?php }else{ ?>
<script>
	function modal(){
		swal("Pertukaran gagal dibatalkan", "", "error");
	};
	window.onload = modal;
</script>
<?php } ?>
<?php } ?>

