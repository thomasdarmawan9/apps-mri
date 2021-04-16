<style type="text/css">
	#wait{
		position: fixed;
		background-color: #ded9d978;
		top:0;
		left: 0;
		width: 100%;
		height: 100%;
		padding-top: 45vh;
		text-align: center;
		z-index: 1031;
	}
</style>
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Last Task Allocation</h3>
		</div>
		<div class="card-body">
		<div id="wait" style="display: none;">
			<img src="<?= base_url('inc/loading.gif')?>" width="30px"> <span style="color:#333;font-weight: 400;">Loading...</span>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered w-100" id="table1">
				<thead class="text-center">
					<tr style="background-color: #f44336 ;font-size:1rem;color:#fff;">
						<th class="text-center">No</th>
						<th style="width:100px;">Event</th>
						<th style="width:150px;">Lokasi</th>
						<th>Tanggal</th>
						<th style="text-align:center;min-width: 160px;">Warrior | PD</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php if(!empty($results)){ ?>
					<?php $no = 1; $loop = 1; $id_sblm = null; ?>

					<?php foreach($results as $r){ ?>


					<?php

					if($loop == 1){
						$event = $r->event;
							$location = $r->location;
							$tgl = date("d-M-Y", strtotime($r->date));
							$divisi = $r->id_divisi;
							$id = $r->idt;
							$user = $r->id_user;

							if ($r->tugas == 'pd') {
								$tugas = $r->username;
							}else{
							    $tugas = 0;
							}

							if ($user == null) {
								$war = 0;
								$tugas = 0;
							} else {
								$this->db->select("id_user");
								$this->db->from('task_user');
								$this->db->where('id_task', $id);
								$war = $this->db->get()->num_rows();
								
								$this->db->select("*, user.username");
								$this->db->from('task_user');
								$this->db->join('user', 'user.id = task_user.id_user', 'left');
								$this->db->where('task_user.id_task', $id);
								$this->db->where('task_user.tugas', 'pd');

								$query = $this->db->get()->result();

								foreach ($query as $k) {
									$tugas = $k->username;
								}
							} ?>



					<tr>
						<td class="text-center"><?php echo $no; ?></td>
						<td><?php echo $event;?></td>
						<td><?php echo $location;?></td>
						<td><?php echo $tgl; ?></td>
						<td style="text-align: center;">
							<a onclick="listwarrior(<?= $id?>)">
								<button type="button" class="btn btn-info" data-toggle="popover" data-placement="top" data-content="Jumlah Warriors" data-trigger="hover"> <?php echo str_pad($war, 3, ' ', STR_PAD_LEFT); ?> </button>
							</a> 
							<a onclick="choosepd(<?= $id?>)">
								<?php if(empty($tugas)) { ?>
								<button type="button" class="btn red" data-toggle="popover" data-placement="top" data-content="Siapa PD-nya ?" data-trigger="hover"> PD?</button>
								<?php }else{ ?>
								<button type="button" class="btn btn-teal" data-toggle="popover" data-placement="top" data-content="PD" data-trigger="hover"> <?php echo ucwords($tugas); ?></button>
								<?php } ?>
							</a>
						</td>
						<td nowrap="nowrap">
							<a href="<?= base_url('support/task/addtaskwarrior/'.$id)?>">
								<button type="button" class="btn  btn-primary" id="showtambah" data-toggle="popover" data-content="Tambah Warrior" data-placement="top" data-trigger="hover"><i class="fa fa-user-plus"></i> Warriors</button>
							</a> 
							<a onclick="edit(<?= $id?>)">
								<button type="button" class="btn  btn-warning" data-toggle="popover" data-content="Edit Event" data-placement="top" data-trigger="hover"><i class="fa fa-edit"></i> Edit</button>
							</a> 
							<a onclick="hapus(<?= $id?>)">
								<button type="button" class="btn  btn-danger" id="showtambah" data-toggle="popover" data-content="Delete Event" data-placement="top" data-trigger="hover"><i class="fa fa-trash"></i> Delete</button>
							</a> 
							<a href="<?= base_url('support/task/report/'.$id)?>">
								<button type="button" class="btn  btn-success" id="showtambah" data-toggle="popover" data-content="Report" data-placement="top" data-trigger="hover"><i class="fa fa-file"></i> </button>
							</a>
						</td>
					</tr>

					<?php
					$no = $no +1;
					$event = $r->event;
					$location = $r->location;
					$tgl = date("d-M-Y", strtotime($r->date));
					$id = $r->idt;
					$tugas = $r->tugas;

					if($r->id_user == null){
						$war = 0;
					}else{
						$war = 1;
					}

		            		//Check pd pada baris setelahnya
					if($r->tugas == 'pd'){
						$tugas = $r->username;
					}
				} else { ?>
                <tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $event;?></td>
					<td><?php echo $location;?></td>
					<td><?php echo $tgl; ?></td>
					<td>
						<a href="?auth=edittaskwarriors&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>">
							<button type="button" class="btn  btn-success" data-toggle="tooltip" data-placement="left" title="Jumlah Warriors"> <?php echo $war; ?> </button>
						</a> 
						<a href="?auth=choosepd&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>">
							<?php if(empty($tugas)) { ?>
							<button type="button" class="btn  btn-danger" data-toggle="tooltip" data-placement="right" title="Siapa PD-nya ?"> PD ? </button>
							<?php }else{ ?>
							<button type="button" class="btn  btn-info" data-toggle="tooltip" data-placement="right" title="PD"> <?php echo ucwords($tugas); ?></button>
							<?php } ?>
						</a>
					</td>
					<td>
						<a href="?auth=addtaskwarriors&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>">
							<button type="button" class="btn  btn-primary" id="showtambah"><i class="fa fa-plus"></i> Tambah Warriors</button>
						</a> 
						<a href="?auth=editevent&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>">
							<button type="button" class="btn  btn-warning"><i class="fa fa-edit"></i> Edit Event</button>
						</a>
						<a href="?auth=delevent&id=<?php echo $id; ?>&token=<?php echo md5($id); ?>">
							<button type="button" class="btn  btn-danger" id="showtambah"><i class="fa fa-trash"></i> Delete Event</button>
						</a> 
						<a href="?auth=report&id=<?php echo $id; ?>&eventname=<?php echo $event; ?>&tgl=<?php echo $tgl; ?>&token=<?php echo md5($id); ?>">
							<button type="button" class="btn  btn-success" id="showtambah">R</button>
						</a>
					</td>
				</tr>
				<?php } ?>
				<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_tambah" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('support/task/submit')?>" method="post" class="form-horizontal" style="width:100%">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" id="id_edit" value="">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Nama Event</label>
						<div class="col-sm-8">
							<input name="nama" id="nama" class="form-control" required="" type="text" placeholder="e.g. Event Life Mastery">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Lokasi</label>
						<div class="col-sm-8">
							<input name="lokasi" id="lokasi" class="form-control" required="" type="text" placeholder="e.g. Ibis Style Hotel">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Tanggal</label>
						<div class="col-sm-8">
							<input name="tgl" id="tgl" class="form-control" required="" type="date">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Komisi Lunas</label>
						<div class="col-sm-8">
							<input name="komisilunas" id="komisilunas" class="form-control" required="" type="number" placeholder="Komisi lunas">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Komisi DP</label>
						<div class="col-sm-8">
							<input name="komisidp" id="komisidp" class="form-control" required="" type="number" placeholder="Komisi DP">
						</div>
					</div>


				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"">Submit</button>
					<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
				</div>
			</form>				
		</div>

	</div>
</div>

<div class="modal fade" tabindex="-1" id="modal_list_warrior" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">List Warrior</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<h4 id="detail_list_warrior" style="text-align: center"></h4>
				<hr>
				<div class="table-responsive">
					<table class="table table-bordered w-100" id="table_list_warrior">
						<thead>
							<tr style="background-color: #0d4e6c ;font-size:1rem;color:#fff;">
								<th>No</th>
								<th>Username</th>
								<th>Aksi</th>
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

<div class="modal fade" tabindex="-1" id="modal_choosepd" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">

			<form method="post" action="<?= base_url('support/task/submit_pd')?>">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Choose PD</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<h4 id="detail_choosepd" style="text-align: center"></h4>
					<hr>
					<div class="form-group row">
						<input type="hidden" name="id" id="id_choosepd">
						<label class="col-form-label col-sm-4 text-right">Warrior</label>
						<div class="col-sm-8">
							<select class="form-control" name="getpd" id="select_choosepd" required="">
								
							</select>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn teal"">Jadikan PD</button>
					<button type="button" class="btn btn-blue-grey" data-dismiss="modal">Close</button>
				</div>
			</form>

		</div>

	</div>
</div>

<script>
	$(document).ready(function(){
		var open_modal = "<?= $this->session->flashdata('modal_active');?>";
		if(open_modal != ''){
			listwarrior(open_modal);
		}

		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});

		$('[data-toggle="tooltip"]').tooltip(); 
		$('#table1').DataTable({
			'scrollX':true,
			'order':false,
			'lengthMenu': [[10, 15, 25, -1], [10, 15, 25, "All"]
			],
			'rowReorder': {
				'selector': 'td:nth-child(2)'
			},
			'responsive': true,
			'stateSave': true
		});
	});

	function reload_page(){
		window.location.reload();
	}

	function reset_form_tambah(){
		$('#id_edit, #nama, #lokasi, #tgl, #komisilunas, #komisidp').val('');
	}

	function edit(id){
		reset_form_tambah();
		$.ajax({
			url: "<?= base_url('support/task/json_get_data_event')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				$('#id_edit').val(result.id);
				$('#nama').val(result.event);
				$('#lokasi').val(result.location);
				$('#tgl').val(result.date);
				$('#komisilunas').val(result.komisi_lunas);
				$('#komisidp').val(result.komisi_dp);
				$('#modal_tambah').modal('show');
			}, error: function(e){
				console.log(e);
			}
		})
	}

	function listwarrior(id){
		reset_form_tambah();
		$.ajax({
			url: "<?= base_url('support/task/json_get_data_task')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				$('#table_list_warrior').DataTable().destroy();
				$('#table_list_warrior').find('tbody').empty();
				var no = 1;
				$.each(result.list, function(index, element){

					$('#table_list_warrior').find('tbody').append('<tr>\
						<td>'+no+'</td>\
						<td>'+element.username+'</td>\
						<td><a class="btn btn-danger" onclick="hapus_warrior('+element.id_task+','+element.id_user+')"><i class="fa fa-trash"></i>&nbsp; Delete Warrior</a></td>\
						');
					no += 1;
				});
				$('#detail_list_warrior').empty().html('<label class="badge badge-info">'+result.event.event+'</label><br>\
					<small><b>'+result.event.location+'</b></small><br>\
					<small>'+result.event.date+'</small>\
					');
				$('#table_list_warrior').DataTable({
					'destroy' :true,
					'lengthMenu': [[10, 15, 25, -1], [10, 15, 25, "All"]]
				});
				$('#modal_list_warrior').modal('show');
			}, error: function(e){
				console.log(e);
			}
		})
	}

	function hapus(id){
		if(id != ''){
			swal({
				title: 'Konfirmasi',
				text: "Segala data baik dari sisi : Warriors yang bertugas, jumlah closingan, dan laporan Event serta segala bentuk data yang berhubungan dengan Event ini akan TERHAPUS dan tidak akan pernah kembali dikarenakan penghapusan bersifat permanen. \n\nLanjutkan?",
				type: 'error',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('support/task/delete')?>",
						type: "POST",
						dataType: "json",
						data:{'id': id},
						success:function(result){					
							reload_page();
						}, error: function(e){
							console.log(e);
						}
					})
				}
			});
		}
	}

	function hapus_warrior(id_task, id_user){
		if(id_task != '' && id_user != ''){
			swal({
				title: 'Konfirmasi',
				text: "Data Warrior untuk event ini akan dihapus. \n\nLanjutkan?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#f35958',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus'
			}, function(result){
				if (result) {				  
					$.ajax({
						url: "<?= base_url('support/task/delete_wartask')?>",
						type: "POST",
						dataType: "json",
						data:{'id_task': id_task, 'id_user': id_user},
						success:function(result){					
							reload_page();
						}, error: function(e){
							console.log(e);
						}
					})
				}
			});
		}
	}

	function choosepd(id){
		$.ajax({
			url: "<?= base_url('support/task/json_get_data_task')?>",
			type: "POST",
			dataType: "json",
			data:{'id': id},
			success:function(result){
				var pd = '';
				$('#select_choosepd').empty().append('<option value="">- Pilih Salah Satu -</option>');
				$.each(result.list, function(index, element){
					if(element.tugas == 'pd'){
						pd = element.username;
					}
					$('#select_choosepd').append('<option value="'+element.username+'">'+element.username+'</option>');
				});

				$('#detail_choosepd').empty().html('<label class="badge teal">'+result.event.event+'</label><br>\
					<small><b>'+result.event.location+'</b></small><br>\
					<small>'+result.event.date+'</small>\
					');
				$('#id_choosepd').val(result.event.id);
				$('#select_choosepd').val(pd).change();
				$('#modal_choosepd').modal('show');
			}, error: function(e){
				console.log(e);
			}
		})
	}

	$('#showtambah').click(function(){
		reset_form_tambah();
		$('#modal_tambah').modal('show');
	});


</script>
